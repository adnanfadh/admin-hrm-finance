<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\AccountBankRequest;
use App\Models\Finance\AccountBank;
use App\Models\Finance\CategoryAccount;
use App\Models\Finance\JurnalEntry;
use App\Models\Finance\Pajak;
use App\Models\Finance\SaldoAwal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AccountBankController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:accountbank-list|accountbank-create|accountbank-edit|accountbank-delete', ['only' => ['index','store']]);
         $this->middleware('permission:accountbank-create', ['only' => ['create','store']]);
         $this->middleware('permission:accountbank-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:accountbank-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = AccountBank::query()->with(['category_account'])->get();
            
            // $query = AccountBank::query()->with(['category_account'])->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
            return DataTables::of($query)
                ->addColumn('action', function ($item) { 
                    return '
                        <div class="btn-group dropleft">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1" 
                                    type="button" id="action' .  $item->id . '"
                                        data-toggle="dropdown" 
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        Aksi
                                </button>
                                <div class="dropdown-menu" aria-labelledby="action' .  $item->id . '" style="border-radius:10px 0px 10px 10px; margin:10px;">
                                    <a class="dropdown-item" href="' . route('accountbank.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <a class="dropdown-item" href="' . route('accountbank.show', $item->id) . '">
                                        Atur saldo awal
                                    </a>
                                    <form action="' . route('accountbank.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                        </div>';
                })
                ->addColumn('saldo', function ($item) {
                    $saldo_rupiah = "Rp. " . number_format($item->saldo,2,',','.');
                    return $saldo_rupiah;
                })
                ->addColumn('nomor_account', function ($item) {
                    if ($item->status == 1) {
                        return '<i class="fa fa-lock mr-2 text-dark" aria-hidden="true"></i>'.$item->nomor;
                    }else{
                        return $item->nomor;
                    }
                })
                ->rawColumns(['action','saldo', 'nomor_account'])
                ->addIndexColumn()
                ->make();
        }


        return view('pages_finance.akun.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = AccountBank::max('id');
        $pajak = Pajak::all();
        $category = CategoryAccount::all();
        $account_parent = AccountBank::where('parent_account', NULL)->get();
        // dd($pajak);
        return view('pages_finance.akun.create',[
            'data'  => $data,
            'pajak' => $pajak,
            'category' => $category,
            'account_parent' => $account_parent
        ]);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountBankRequest $request)
    {
        $this->validate($request, [
            'nomor' => 'required',
            'nama' => 'required',
            'details' => 'required',
            'pajak_id' => 'required',
            'saldo' => 'required',
            'deskripsi' => 'required',
            'status'    => 'required'
        ]);
        
        $data = $request->all();
        $data['creat_by'] = Auth::user()->id; 
        $data['creat_by_company'] = Auth::user()->pegawai->company->id;

        $key = $request->category;
        $category_account = CategoryAccount::findOrFail($key);
        $category_account_nama = CategoryAccount::findOrFail($key)->nama_category_account;

        $get_account = AccountBank::query()->where('category', $category_account->id)->count();
        $get_last_account = AccountBank::query()->where('category', $category_account->id)->max('nomor');

        
        // dd($get_last_account);

        if ($get_account == 0) {
            // dd($get_account);
            $msg = Accountbank::create($data);
        }else{
            $dataku = explode('-', $get_last_account);
            $int = intval($dataku[1]);
            // dd($int+1);
            $data['nomor'] = $dataku[0].'-'.$int+1;
            // dd($dataku[0].'-'.$int+1);
            $msg = Accountbank::create($data);
        }

        if ($msg) {
            return redirect()->route('accountbank.index')->with(['success' => 'Data Berhasil Diupload']);
        }else {
            return redirect()->route('accountbank.index')->with(['error' => 'Data Gagal Diupload']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = AccountBank::findOrFail($id);

        return view('pages_finance.akun.saldo_awal', [
            'data'  => $data
        ]);
    }

    public function saldo_awal(Request $request, $id){
        if (!empty($request->debit && $request->kredit)) {
            return redirect()->back()->with(['error' => 'Isi hanya pada salah satu Debit/Kredit']);
        }
        elseif (empty($request->debit || $request->kredit)){
            return redirect()->back()->with(['error' => 'Pastikan mengisi antara Debit/Kredit']);
        }
        else {

            $saldo_awal = new SaldoAwal();
            $saldo_awal->transaksi          = 'Saldo Awal';
            $saldo_awal->account            = $id;
            $saldo_awal->tanggal_transaksi  = Carbon::now()->format('Y-m-d');
            $saldo_awal->debit              = $request->debit;
            $saldo_awal->kredit             = $request->kredit;
            $saldo_awal->creat_by           = Auth::user()->id; 
            $saldo_awal->creat_by_company   = Auth::user()->pegawai->company->id;
            $save_saldo_awal = $saldo_awal->save();

            $idSaldoAwal = DB::getPdo()->lastInsertId();

            $data_old_saldo = AccountBank::findOrFail($id);
            if (!empty($request->debit)) {
                AccountBank::where('id', $id)->update(['saldo'=> $data_old_saldo->saldo + $request->debit]);
                JurnalEntry::create([
                    'transaksi_id'       => $idSaldoAwal,
                    'account_id'         => $id,
                    'tanggal_transaksi'  => Carbon::now()->format('Y-m-d'),
                    'debit'              => $request->debit,
                    'kredit'             => 0,
                    'category'           => 7,
                    'tahapan'            => 1,
                    'keterangan'         => NULL,
                    'creat_by'           => Auth::user()->id,
                    'creat_by_company'   => Auth::user()->pegawai->company->id,
                ]);
            }else{
                AccountBank::where('id', $id)->update(['saldo'=> $data_old_saldo->saldo - $request->kredit]);
                JurnalEntry::create([
                    'transaksi_id'       => $idSaldoAwal,
                    'account_id'         => $id,
                    'tanggal_transaksi'  => Carbon::now()->format('Y-m-d'),
                    'debit'              => 0,
                    'kredit'             => $request->kredit,
                    'category'           => 7,
                    'tahapan'            => 1,
                    'keterangan'         => NULL,
                    'creat_by'           => Auth::user()->id,
                    'creat_by_company'   => Auth::user()->pegawai->company->id,
                ]);
            }
            AccountBank::where('id', $id)->update([
                'debit'     => $request->debit,
                'kredit'    => $request->kredit,
            ]);

            return redirect()->route('accountbank.index')->with(['success' => 'Saldo telah ditetapkan']);
        }
    }

    public function get_account_by_id($id){
        $data = AccountBank::findOrFail($id);

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Accountbank::findOrFail($id);
        $pajak = Pajak::all();
        $account_parent = AccountBank::where('parent_account', NULL)->get();
        $category = CategoryAccount::all();

        return view('pages_finance.akun.edit', [
            'accountbank' => $data,
            'pajak'         => $pajak,
            'account_parent' => $account_parent,
            'category'      => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nomor' => 'required',
            'nama' => 'required',
            'details' => 'required',
            'pajak_id' => 'required',
            'saldo' => 'required',
            'deskripsi' => 'required',
            'status'    => 'required'
        ]);

        
        $key = $request->category;
        $category_account = CategoryAccount::findOrFail($key);
        $category_account_nama = CategoryAccount::findOrFail($key)->nama_category_account;
        
        $get_account = AccountBank::query()->where('category', $category_account->id)->count();
        $get_last_account = AccountBank::query()->where('category', $category_account->id)->max('nomor');
        
        $data = $request->all();
        $data['creat_by'] = Auth::user()->id; 
        $data['creat_by_company'] = Auth::user()->pegawai->company->id;
        
        $item = Accountbank::findOrFail($id);

        if ($get_account == 0) {
            // dd($get_account);
            $msg = $item->update($data);
        }else{
            $dataku = explode('-', $get_last_account);
            $int = intval($dataku[1]);
            // dd($int+1);
            $data['nomor'] = $dataku[0].'-'.$int+1;
            // dd($dataku[0].'-'.$int+1);
            $msg = $item->update($data);
        }


        if ($msg) {
            return redirect()->route('accountbank.index')->with(['success' => 'Data Berhasil Diupdate']);
        }else {
            return redirect()->route('accountbank.index')->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Accountbank::findOrFail($id);

        if ($data->status == 1) {
            return redirect()->route('accountbank.index')->with(['error' => 'Akun ini tidak dapat dihapus']);
        }else{
            $msg = $data->delete();

            if ($msg) {
                return redirect()->route('accountbank.index')->with(['success' => 'Data Berhasil Dihapus']);
            }else {
                return redirect()->route('accountbank.index')->with(['error' => 'Data Gagal Dihapus']);
            }
        }


    }
}

