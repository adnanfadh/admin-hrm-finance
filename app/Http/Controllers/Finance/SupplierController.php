<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\SupplierRequest;
use App\Models\Finance\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:supplier-list|supplier-create|supplier-edit|supplier-delete', ['only' => ['index','store']]);
         $this->middleware('permission:supplier-create', ['only' => ['create','store']]);
         $this->middleware('permission:supplier-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            // $query = Supplier::all();
            $query = Supplier::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
            
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1" 
                                    type="button" id="action' .  $item->id . '"
                                        data-toggle="dropdown" 
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        Aksi
                                </button>
                                <div class="dropdown-menu" aria-labelledby="action' .  $item->id . '" style="border-radius:10px 0px 10px 10px; margin:10px;">
                                    <a class="dropdown-item" href="' . route('supplier.edit', $item->id) . '">
                                        Show Detail
                                    </a>
                                    <form action="' . route('supplier.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                    </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Supplier::max('id');
        // dd($data);
        return view('pages_finance.kontak.supplier.create',[
            'data' => $data 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        $data = $request->all();
        $data['creat_by'] = Auth::user()->id; 
        $data['creat_by_company'] = Auth::user()->pegawai->company->id;

        $msg = Supplier::create($data);

        if ($msg) {
            return redirect()->route('kontak.index')->with(['success' => 'Data Berhasil Diupload']);
        }else {
            return redirect()->route('kontak.index')->with(['error' => 'Data Gagal Diupload']);
        }
    }

    public function get_id_suppliers_pembelian(){
        $data = Supplier::count()+1;
        
            return response()->json(['data'=> $data,'success'=>'Data saved successfully!']);
            // return redirect()->route('metodepembayaran.index')->with(['success' => 'Data Berhasil Diupload']);
        // }else {
        //     return response()->json(['error'=>'Data saved failed!']);
        //     // return redirect()->route('metodepembayaran.index')->with(['error' => 'Data Gagal Diupload']);
        // }
    }

    public function store_ajax_pembelian(SupplierRequest $request) 
    {
        // $data = Customer::max('id');
        // dd('$data');
        $dat_suc = $request->all();
        $msg = Supplier::updateOrCreate(['id' => $request->Supplier_id],
        ['kode_supplier' => $request->kode_supplier,'nama_supplier' => $request->nama_supplier, 'email_supplier' => $request->email_supplier, 'kontak_supplier' => $request->kontak_supplier, 'alamat_supplier' => $request->alamat_supplier , 'creat_by'=> Auth::user()->id, 'creat_by_company'=> Auth::user()->pegawai->company->id]);

        $dataId = DB::getPdo()->lastInsertId();
        
        if ($msg) {
            return response()->json(['data'=>$dat_suc,'dataId'=>$dataId,'success'=>'Data saved successfully!']);
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
        $data = Supplier::findOrFail($id);

        return view('pages_finance.kontak.supplier.edit', [
            'supplier' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, $id)
    {
        $data = $request->all();
        $data['creat_by'] = Auth::user()->id; 
        $data['creat_by_company'] = Auth::user()->pegawai->company->id;

        $item = Supplier::findOrFail($id);

        $msg = $item->update($data);

        if ($msg) {
            return redirect()->route('kontak.index')->with(['success' => 'Data Berhasil Diupdate']);
        }else {
            return redirect()->route('kontak.index')->with(['error' => 'Data Gagal Diupdate']);
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
        $data = Supplier::findOrFail($id);

        $msg = $data->delete();

        if ($msg) {
            return redirect()->route('kontak.index')->with(['success' => 'Data Berhasil Dihapus']);
        }else {
            return redirect()->route('kontak.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
