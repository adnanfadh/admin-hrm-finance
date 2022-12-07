<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Bidang;

use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\AssetRequest;


class AssetController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:asset-list|asset-create|asset-edit|asset-delete', ['only' => ['index','store']]);
         $this->middleware('permission:asset-create', ['only' => ['create','store']]);
         $this->middleware('permission:asset-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:asset-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Asset::query()->with(['bidang'])->get();
            // dd($query);
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
                                    <a class="dropdown-item" href="' . route('asset.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('asset.destroy', $item->id) . '" method="POST">
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

        // $asset = Asset::query()->with(['bidang'])->get();
        // return response()->json($asset);
        return view('pages.asset.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bidang = Bidang::all();
        return view('pages.asset.create', [
            'bidang'    => $bidang
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetRequest $request)
    {
        $data = $request->all();

        $asset = Asset::create($data);

        if ($asset) {
            return redirect()->route('asset.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('asset.index')->with(['error' => 'Data Gagal Diupload']);
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
        $bidang = Bidang::all();
        $asset = Asset::findOrFail($id);
        return view('pages.asset.edit', [
            'asset'    => $asset,
            'bidang'    => $bidang
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetRequest $request, $id)
    {
        $data = $request->all();
        $item = Asset::findOrFail($id);

        $asset = $item->update($data);

        if ($asset) {
            return redirect()->route('asset.index')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('asset.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Asset::findOrFail($id);
        $asset = $item->delete();

        if ($asset) {
            return redirect()->route('asset.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('asset.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
