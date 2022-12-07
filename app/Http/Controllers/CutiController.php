<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuti;
use App\Models\Pegawai;

use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\CutiRequest;


class CutiController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:cuti-list|cuti-create|cuti-edit|cuti-delete', ['only' => ['index','store']]);
         $this->middleware('permission:cuti-create', ['only' => ['create','store']]);
         $this->middleware('permission:cuti-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cuti-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Cuti::query()->with(['pegawai'])->get();
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
                                    <a class="dropdown-item" href="' . route('cuti.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('cuti.destroy', $item->id) . '" method="POST">
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

        // $cuti = Cuti::query()->with(['pegawai'])->get();
        // return response()->json($cuti);
        return view('pages.cuti.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pegawai = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();
        return view('pages.cuti.create', [
            'pegawai'    => $pegawai
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CutiRequest $request)
    {
        $data = $request->all();

        $cuti = Cuti::create($data);

        if ($cuti) {
            return redirect()->route('cuti.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('cuti.index')->with(['error' => 'Data Gagal Diupload']);
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
        $cuti = Cuti::findOrFail($id);
        return view('pages.cuti.edit', [
            'cuti'    => $cuti,
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
    public function update(CutiRequest $request, $id)
    {
        $data = $request->all();
        $item = Cuti::findOrFail($id);

        $cuti = $item->update($data);

        if ($cuti) {
            return redirect()->route('cuti.index')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('cuti.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Cuti::findOrFail($id);
        $cuti = $item->delete();

        if ($cuti) {
            return redirect()->route('cuti.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('cuti.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
