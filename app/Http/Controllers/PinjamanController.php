<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Pinjaman;
use App\Http\Requests\PinjamanRequest;
use Yajra\DataTables\Facades\DataTables;

class PinjamanController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pinjaman-list|pinjaman-create|pinjaman-edit|pinjaman-delete', ['only' => ['index','store']]);
        $this->middleware('permission:pinjaman-create', ['only' => ['create','store']]);
        $this->middleware('permission:pinjaman-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:pinjaman-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Pinjaman::query()->with(['pegawai'])->get();
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
                                    <a class="dropdown-item" href="' . route('pinjaman.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('pinjaman.destroy', $item->id) . '" method="POST">
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

        // $lembur = Lembur::query()->with(['pegawai'])->get();
        // return response()->json($lembur);
        return view('pages.pinjaman.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pegawai = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();
        foreach ($pegawai as $peg) {
            $data[] = [
                'id'             => $peg->id,
                'nama'           => $peg->nama,
            ];
        }
        return view('pages.pinjaman.create', [
            'data'  => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PinjamanRequest $request)
    {
        $data = $request->all();

        $msg = Pinjaman::create($data);

        if ($msg) {
            return redirect()->route('pinjaman.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('pinjaman.index')->with(['error' => 'Data Gagal Diupload']);
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
        $pinjaman = Pinjaman::findOrFail($id);
        foreach ($pegawai as $peg) {
            $data[] = [
                'id'             => $peg->id,
                'nama'           => $peg->nama,
            ];
        }
        return view('pages.pinjaman.edit', [
            'data'  => $data,
            'pinjaman' => $pinjaman
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PinjamanRequest $request, $id)
    {
        $data = $request->all();
        $item = Pinjaman::findOrFail($id);

        $pinjaman = $item->update($data);

        if ($pinjaman) {
            return redirect()->route('pinjaman.index')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('pinjaman.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Pinjaman::findOrFail($id);
        $pinjaman = $item->delete();

        if ($pinjaman) {
            return redirect()->route('pinjaman.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('pinjaman.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
