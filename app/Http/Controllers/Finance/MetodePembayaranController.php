<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\MetodePembayaranRequest;
use App\Models\Finance\AccountBank;
use App\Models\Finance\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MetodePembayaranController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:metodepembayaran-list|metodepembayaran-create|metodepembayaran-edit|metodepembayaran-delete', ['only' => ['index','store']]);
         $this->middleware('permission:metodepembayaran-create', ['only' => ['create','store', 'store_ajax']]);
         $this->middleware('permission:metodepembayaran-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:metodepembayaran-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MetodePembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
            // $query = MetodePembayaran::all();

            // dd($query);
            // $pesan = 'apakah yakinmau menghapus!';
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editMetode">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteMetode">Delete</a>';

                    return $btn;;
                })
                ->addColumn('account', function($row){
                    return $row->account->nama ?? '--';
                })
                ->rawColumns(['action', 'account'])
                ->addIndexColumn()
                ->make(true);
        }

        $account_bank = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

        return view('pages_finance.pembayaran.metode.index',[
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
        return view('pages_finance.metode_pembayaran.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MetodePembayaranRequest $request)
    {
        $data = $request->all();

        $msg = MetodePembayaran::updateOrCreate(['id' => $request->Metode_id],
        ['nama_metode' => $request->nama_metode, 'account_bank' => $request->account_bank, 'creat_by'=> Auth::user()->id, 'creat_by_company'=> Auth::user()->pegawai->company->id]);

        if ($msg) {
            return response()->json(['success'=>'Data saved successfully!']);
            // return redirect()->route('metodepembayaran.index')->with(['success' => 'Data Berhasil Diupload']);
        }else {
            return response()->json(['error'=>'Data saved failed!']);
            // return redirect()->route('metodepembayaran.index')->with(['error' => 'Data Gagal Diupload']);
        }
    }

    public function store_ajax(MetodePembayaranRequest $request)
    {
        $data = $request->all();

        $msg = MetodePembayaran::updateOrCreate(['id' => $request->Metode_id],
        ['nama_metode' => $request->nama_metode, 'account_bank' => $request->account_bank, 'creat_by'=> Auth::user()->id, 'creat_by_company'=> Auth::user()->pegawai->company->id]);

        $dataId = DB::getPdo()->lastInsertId(); 

        if ($msg) {
            return response()->json(['data'=>$data,'dataId'=>$dataId,'success'=>'Data saved successfully!']);
            // return redirect()->route('metodepembayaran.index')->with(['success' => 'Data Berhasil Diupload']);
        }else {
            return response()->json(['error'=>'Data saved failed!']);
            // return redirect()->route('metodepembayaran.index')->with(['error' => 'Data Gagal Diupload']);
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
        $metodepembayaran = MetodePembayaran::findOrFail($id);
        // return view('pages_finance.metode_pembayaran.edit', [
        //     'metodepembayaran'  => $metodepembayaran
        // ]);
        return response()->json($metodepembayaran);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MetodePembayaranRequest $request, $id)
    {
        $data = $request->all();

        $item = MetodePembayaran::findOrFail($id);

        $msg = $item->update($data);

        if ($msg) {
            return response()->json(['success'=>'Customer deleted!']);
            // return redirect()->route('metodepembayaran.index')->with(['success' => 'Data Berhasil Diupdate']);
        }else {
            return response()->json(['error'=>'Customer deleted!']);
            // return redirect()->route('metodepembayaran.index')->with(['error' => 'Data Gagal Diupdate']);
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
        $data = MetodePembayaran::findOrFail($id);

        $msg = $data->delete();

        if ($msg) {
            return response()->json(['success'=>'Customer deleted!']);
            // return redirect()->route('metodepembayaran.index')->with(['success' => 'Data Berhasil Dihapus']);
        }else {
            return response()->json(['error'=>'Customer deleted!']);
            // return redirect()->route('metodepembayaran.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
