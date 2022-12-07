<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bpjs;
use App\Models\Pegawai;

use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\BpjsRequest;


class BpjsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:bpjs-list|bpjs-create|bpjs-edit|bpjs-delete', ['only' => ['index','store']]);
         $this->middleware('permission:bpjs-create', ['only' => ['create','store']]);
         $this->middleware('permission:bpjs-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:bpjs-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Bpjs::query()->with(['pegawai'])->get();
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
                                    <a class="dropdown-item" href="' . route('bpjs.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('bpjs.destroy', $item->id) . '" method="POST">
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

        // $bpjs = Bpjs::query()->with(['pegawai'])->get();
        // return response()->json($bpjs);
        return view('pages.bpjs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pegawai = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();
        return view('pages.bpjs.create', [
            'pegawai'    => $pegawai
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BpjsRequest $request)
    {
        $data = $request->all();

        $bpjs = Bpjs::create($data);

        if ($bpjs) {
            return redirect()->route('bpjs.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('bpjs.index')->with(['error' => 'Data Gagal Diupload']);
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
        $pegawai = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();
        $bpjs = Bpjs::findOrFail($id);
        return view('pages.bpjs.edit', [
            'bpjs'    => $bpjs,
            'pegawai'    => $pegawai
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BpjsRequest $request, $id)
    {
        $data = $request->all();
        $item = Bpjs::findOrFail($id);

        $bpjs = $item->update($data);

        if ($bpjs) {
            return redirect()->route('bpjs.index')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('bpjs.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Bpjs::findOrFail($id);
        $bpjs = $item->delete();

        if ($bpjs) {
            return redirect()->route('bpjs.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('bpjs.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
