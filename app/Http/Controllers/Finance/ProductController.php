<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\ProductRequest;
use App\Models\Finance\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','store']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_penjualan = Product::query()->where('category', 1)->count();
        $product_pembelian = Product::query()->where('category', 2)->count();
        $product_asset = Product::query()->where('category', 3)->count();

        if (request()->ajax()) {
            // $query = Product::all();
            $query = Product::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
            
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
                                    <a class="dropdown-item" href="' . route('product.edit', $item->id) . '">
                                        Show Detail
                                    </a>
                                    <form action="' . route('product.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                    </div>';
                })
                ->addColumn('gambar', function ($item) {
                    return '
                    <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-info" 
                                    type="button" id="action' .  $item->id . '"
                                        data-toggle="dropdown" 
                                        aria-haspopup="true"
                                        aria-expanded="false" title="Lihat Gambar">
                                        <i class="fas fa-eye"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="action' .  $item->id . '" style="border-radius:10px; padding:10px; width: 200px;">
                                <img src="' . Storage::url($item->gambar) . '" alt="" class="w-100" >
                                </div>
                            </div>
                    </div>
                    ';
                })
                ->addColumn('category', function ($item) {
                    if ($item->category == 1) {
                        $code = 'Penjualan';
                    }elseif($item->category == 2){
                        $code = 'Pembelian';
                    }else{
                        $code = 'Asset Kantor';
                    }
                    return $code;
                })
                ->rawColumns(['action', 'gambar', 'category'])
                ->addIndexColumn()
                ->make();
        }

        return view('pages_finance.product.index', [
            'product_penjualan' => $product_penjualan,
            'product_pembelian' => $product_pembelian,
            'product_asset' => $product_asset,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages_finance.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        if (!empty($request->gambar)) {
            $data['gambar'] = $request->file('gambar')->store('assets/dokumen/product', 'public');
        }
        $data['creat_by'] = Auth::user()->id; 
        $data['creat_by_company'] = Auth::user()->pegawai->company->id;

        $msg = Product::create($data);

        if ($msg) {
            return redirect()->route('product.index')->with(['success' => 'Data Berhasil Diupload']);
        }else {
            return redirect()->route('product.index')->with(['error' => 'Data Gagal Diupload']);
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
        $data = Product::findOrFail($id);

        return view('pages_finance.product.edit', [
            'product' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();

        $data['creat_by'] = Auth::user()->id; 
        $data['creat_by_company'] = Auth::user()->pegawai->company->id;

        if (!empty($request->gambar)) {
            Storage::disk('local')->delete('public/'. $request->photo);

            $data['gambar'] = $request->file('gambar')->store('assets/dokumen/product', 'public');
            
            $item = Product::findOrFail($id);
    
            $msg = $item->update($data);
            
            if ($msg) {
                return redirect()->route('product.index')->with(['success' => 'Data Berhasil Diupdate']);
            }else {
                return redirect()->route('product.index')->with(['error' => 'Data Gagal Diupdate']);
            }
        } else {
            $item = Product::findOrFail($id);
            
    
            $msg = $item->update($data);
            
            if ($msg) {
                return redirect()->route('product.index')->with(['success' => 'Data Berhasil Diupdate']);
            }else {
                return redirect()->route('product.index')->with(['error' => 'Data Gagal Diupdate']);
            }
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
        $data = Product::findOrFail($id);

        $file = $data->gambar;

        Storage::disk('local')->delete('public/'.$file);

        $msg = $data->delete();

        if ($msg) {
            return redirect()->route('product.index')->with(['success' => 'Data Berhasil Dihapus']);
        }else {
            return redirect()->route('product.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
