<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\CustomerRequest;
use App\Models\Finance\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete', ['only' => ['index','store']]);
         $this->middleware('permission:customer-create', ['only' => ['create','store']]);
         $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Customer::all();
            $query = Customer::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

            $pesan = 'apakah yakinmau menghapus!';
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
                                    <a class="dropdown-item" href="' . route('customer.edit', $item->id) . '">
                                        Show Detail
                                    </a>
                                    <form action="' . route('customer.destroy', $item->id) . '" method="POST">
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

        // return view('pages_finance.kontak.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Customer::max('id');
        return view('pages_finance.kontak.customer.create', [
            'data'  => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->all();
        $data['creat_by'] = Auth::user()->id; 
        $data['creat_by_company'] = Auth::user()->pegawai->company->id;

        $msg = Customer::create($data);

        if ($msg) {
            return redirect()->route('kontak.index')->with(['success' => 'Data Berhasil Diupload']);
        }else {
            return redirect()->route('kontak.index')->with(['error' => 'Data Gagal Diupload']);
        }
    }

    public function get_id_customers(){
        $data = Customer::count()+1;
        
            return response()->json(['data'=> $data,'success'=>'Data saved successfully!']);
            // return redirect()->route('metodepembayaran.index')->with(['success' => 'Data Berhasil Diupload']);
        // }else {
        //     return response()->json(['error'=>'Data saved failed!']);
        //     // return redirect()->route('metodepembayaran.index')->with(['error' => 'Data Gagal Diupload']);
        // }
    }

    public function store_ajax(CustomerRequest $request) 
    {
        // $data = Customer::max('id');
        // dd('$data');
        $dat_suc = $request->all();
        $msg = Customer::updateOrCreate(['id' => $request->Customer_id],
        ['kode_customer' => $request->kode_customer,'nama_customer' => $request->nama_customer, 'email' => $request->email, 'kontak' => $request->kontak, 'alamat' => $request->alamat, 'creat_by'=> Auth::user()->id, 'creat_by_company'=> Auth::user()->pegawai->company->id]);

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
        $data = Customer::findOrFail($id);

        return view('pages_finance.kontak.customer.edit', [
            'customer' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $data = $request->all();
        $data['creat_by'] = Auth::user()->id; 
        $data['creat_by_company'] = Auth::user()->pegawai->company->id;

        $item = Customer::findOrFail($id);

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
        $data = Customer::findOrFail($id);

        $msg = $data->delete();

        if ($msg) {
            return redirect()->route('kontak.index')->with(['success' => 'Data Berhasil Dihapus']);
        }else {
            return redirect()->route('kontak.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}