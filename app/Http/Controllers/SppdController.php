<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sppd;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Bidang;

use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\SppdRequest;


class SppdController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:sppd-list|sppd-create|sppd-edit|sppd-delete', ['only' => ['index','store']]);
        $this->middleware('permission:sppd-create', ['only' => ['create','store']]);
        $this->middleware('permission:sppd-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sppd-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Sppd::query()->with(['pegawai'])->get();
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
                                    <a class="dropdown-item" href="' . route('sppd.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <a class="dropdown-item" href="' . route('sppd.show', $item->id) . '">
                                        Print
                                    </a>
                                    <form action="' . route('sppd.destroy', $item->id) . '" method="POST">
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

        // $sp = Sppd::query()->with(['pegawai'])->get();
        // return response()->json($sp);
        return view('pages.sppd.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pegawai = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();
        return view('pages.sppd.create', [
            'pegawai'    => $pegawai
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SppdRequest $request)
    {
        $data = $request->all();

        $sppd = Sppd::create($data);

        if ($sppd) {
            return redirect()->route('sppd.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('sppd.index')->with(['error' => 'Data Gagal Diupload']);
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

        $relasi_sppd = Sppd::with(['pegawai.bidang', 'pegawai.jabatan'])->findOrFail($id);

        // $data = $relasi_sppd->pegawai->bidang->id;

        // $jabatan = Jabatan::query()->where('bidang_id', $data)->get();
        // dd($jabatan);
        // return response()->json($relasi_sppd);

        return view('pages.sppd.printsurat', [
            'relasi_sppd'    => $relasi_sppd
        ]);
        // dd($relasi_sppd);
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
        $sppd = Sppd::findOrFail($id);
        return view('pages.sppd.edit', [
            'sppd'    => $sppd,
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
    public function update(SppdRequest $request, $id)
    {
        $data = $request->all();
        $item = Sppd::findOrFail($id);

        $sppd = $item->update($data);

        if ($sppd) {
            return redirect()->route('sppd.index')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('sppd.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Sppd::findOrFail($id);
        $sppd = $item->delete();

        if ($sppd) {
            return redirect()->route('sppd.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('sppd.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
