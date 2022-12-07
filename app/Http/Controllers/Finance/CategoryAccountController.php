<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\CategoryAccountRequest;
use App\Models\Finance\AccountBank;
use App\Models\Finance\CategoryAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CategoryAccountController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:categoryaccount-list|categoryaccount-create|categoryaccount-edit|categoryaccount-delete', ['only' => ['index','store']]);
         $this->middleware('permission:categoryaccount-create', ['only' => ['create','store']]);
         $this->middleware('permission:categoryaccount-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:categoryaccount-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request){
        if ($request->ajax()) {
            // $query = CategoryAccount::all();
            $query = CategoryAccount::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
            // dd($query);
            // $pesan = 'apakah yakinmau menghapus!';
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editCategoryaccount">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteCategoryaccount">Delete</a>';

                    return $btn;;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages_finance.akun.category_account.index');
    }

    public function get_category_id($id){
        $cek_account = AccountBank::query()->where('category', $id)->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        // dd($cek_account);
        if (count($cek_account) > 0) {
            $data = AccountBank::query()->where('category', $id)->orderBy('id', 'desc')->first();
            $dataku = $data->nomor;
            return response()->json($dataku); 
        } else {
            $data = CategoryAccount::where('id', $id)->get();
            foreach ($data as $d) {
                $dataku = $d->nomor_category_account;
            } 
            return response()->json($dataku); 
        }
        
    }

    public function edit($id)
    {
        $data = CategoryAccount::findOrFail($id);
        return response()->json($data);

        // return view('pages_finance.pajak.edit', [
        //     'pajak' => $data
        // ]);
    }

    public function store(CategoryAccountRequest $request)
    {
        // dd('hay');
        $msg = CategoryAccount::updateOrCreate(['id' => $request->Categoryaccount_id],
        ['nomor_category_account' => $request->nomor_category_account, 'nama_category_account' => $request->nama_category_account, 'creat_by'=> Auth::user()->id, 'creat_by_company'=> Auth::user()->pegawai->company->id]);

        $data = $request->all();
        $dataId = DB::getPdo()->lastInsertId();
        if ($msg) {
            return response()->json(['data'=>$data,'dataId'=>$dataId, 'success'=>'Data saved successfully!']);
            // return redirect()->route('metodepembayaran.index')->with(['success' => 'Data Berhasil Diupload']);
        }else {
            return response()->json(['error'=>'Data saved failed!']);
            // return redirect()->route('metodepembayaran.index')->with(['error' => 'Data Gagal Diupload']);
        }
    }


    public function destroy($id)
    {
        $data = CategoryAccount::findOrFail($id);

        $msg = $data->delete();

        if ($msg) {
            return response()->json(['success'=>'Customer deleted!']);
        }else {
            return response()->json(['error'=>'Customer deleted!']);
        }
    }
}
