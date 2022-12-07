<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\SyaratPembayaranRequest;
use App\Models\Finance\AccountBank;
use App\Models\Finance\SyaratPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SyaratPembayaranController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:syaratpembayaran-list|syaratpembayaran-create|syaratpembayaran-edit|syaratpembayaran-delete', ['only' => ['index','store']]);
         $this->middleware('permission:syaratpembayaran-create', ['only' => ['create','store']]);
         $this->middleware('permission:syaratpembayaran-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:syaratpembayaran-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        if ($request->ajax()) {
            // $query = SyaratPembayaran::with('account')->get();
            $query = SyaratPembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
            // dd($query);
            // $pesan = 'apakah yakinmau menghapus!';
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editSyarat">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteSyarat">Delete</a>';

                    return $btn;
                })
                ->addColumn('jangka_waktu', function($row){
                    $hari = $row->jangka_waktu . ' Hari';
                    return $hari;
                })
                ->addColumn('account', function($row){
                    return $row->account->nama ?? '--';
                })
                ->rawColumns(['action', 'jangka_waktu', 'account'])
                ->addIndexColumn()
                ->make(true);
        }

        $account_bank = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();


        return view('pages_finance.pembayaran.syarat.index', [
            'account_bank' => $account_bank
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages_finance.syarat_pembayaran.create');
    }

    public function get_account_bank_syarat(){
        $data = AccountBank::all();
        // $data = AccountBank::all();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SyaratPembayaranRequest $request)
    {
        $data = $request->all();

        $msg = SyaratPembayaran::updateOrCreate(['id' => $request->Syarat_id],
        ['nama_syarat' => $request->nama_syarat, 'jangka_waktu' => $request->jangka_waktu, 'account_bank' => $request->account_bank, 'creat_by'=> Auth::user()->id, 'creat_by_company'=> Auth::user()->pegawai->company->id]);

        if ($msg) {
            return response()->json(['success'=>'Data saved successfully!']);
        }else {
            return response()->json(['error'=>'Data saved failed!']);
        }
    }

    public function store_ajax(SyaratPembayaranRequest $request)
    {
        $data = $request->all();

        $msg = SyaratPembayaran::updateOrCreate(['id' => $request->Syarat_id],
        ['nama_syarat' => $request->nama_syarat, 'jangka_waktu' => $request->jangka_waktu, 'account_bank' => $request->account_bank, 'creat_by'=> Auth::user()->id, 'creat_by_company'=> Auth::user()->pegawai->company->id]);

        $dataId = DB::getPdo()->lastInsertId();

        if ($msg) {
            return response()->json(['data'=>$data,'dataId'=>$dataId,'success'=>'Data saved successfully!']);
        }else {
            return response()->json(['error'=>'Data saved failed!']);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = SyaratPembayaran::findOrFail($id);
        return response()->json($data);

        // return view('pages_finance.syarat_pembayaran.edit', [
        //     'syaratpembayaran'  => $data
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SyaratPembayaranRequest $request, $id)
    {
        $data = $request->all();

        $item = SyaratPembayaran::findOrFail($id);

        $msg = $item->update($data);

        if ($msg) {
            return redirect()->route('syaratpembayaran.index')->with(['success' => 'Data Berhasil Diupdate']);
        }else {
            return redirect()->route('syaratpembayaran.index')->with(['error' => 'Data Gagal Diupdate']);
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
        $data = SyaratPembayaran::findOrFail($id);

        $msg = $data->delete();

        if ($msg) {
            return response()->json(['success'=>'Customer deleted!']);
        }else {
            return response()->json(['error'=>'Customer deleted!']);
        }
    }
}
