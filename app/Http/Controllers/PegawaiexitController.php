<?php

namespace App\Http\Controllers;

use App\Http\Requests\PegawaiexitRequest;
use App\Models\Pegawai;
use App\Models\Pegawaiexit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PegawaiexitController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pegawaiexit-list|pegawaiexit-create|pegawaiexit-edit|pegawaiexit-delete', ['only' => ['index','store']]);
        $this->middleware('permission:pegawaiexit-create', ['only' => ['create','store']]);
        $this->middleware('permission:pegawaiexit-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:pegawaiexit-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Pegawaiexit::query()->with(['pegawai'])->get();
            // dd($query);
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
                                    <a class="dropdown-item" href="' . route('pegawaiexit.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('pegawaiexit.destroy', $item->id) . '" method="POST">
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
        return view('pages.pegawai.pegawaiexit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pegawai = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();
        return view('pages.pegawai.pegawaiexit.create', [
            'pegawai'    => $pegawai
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PegawaiexitRequest $request)
    {
        $data = $request->all();
        $data['dokumen_pendukung'] = $request->file('dokumen_pendukung')->store('assets/dokumen/pegawaiexit', 'public');

        $pegawaiexit = Pegawaiexit::create($data);

        if ($pegawaiexit) {
            return redirect()->route('pegawaiexit.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('pegawaiexit.index')->with(['error' => 'Data Gagal Diupload']);
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
        $pegawaiexit = Pegawaiexit::findOrFail($id);
        return view('pages.pegawai.pegawaiexit.edit', [
            'pegawaiexit'    => $pegawaiexit,
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
    public function update(PegawaiexitRequest $request, $id)
    {
        $data = $request->all();

        // dd($request->dokumen_pendukung_lawas);



        if (!empty($request->dokumen_pendukung)) {

            Storage::disk('local')->delete('public/'. $request->dokumen_pendukung_lawas);

            $data['dokumen_pendukung'] = $request->file('dokumen_pendukung')->store('assets/dokumen/pegawaiexit', 'public');
            $item = Pegawaiexit::findOrFail($id);

            $pegawaiexit = $item->update($data);
            if ($pegawaiexit) {
                return redirect()->route('pegawaiexit.index')->with(['success' => 'Data Berhasil Dirubah']);
            } else {
                return redirect()->route('pegawaiexit.index')->with(['error' => 'Data Gagal Dirubah']);
            }
        }else{
            $item = Pegawaiexit::findOrFail($id);

            $pegawaiexit = $item->update($data);

            if ($pegawaiexit) {
                return redirect()->route('pegawaiexit.index')->with(['success' => 'Data Berhasil Dirubah']);
            } else {
                return redirect()->route('pegawaiexit.index')->with(['error' => 'Data Gagal Dirubah']);
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

        $item = Pegawaiexit::findOrFail($id);
        $file = $item->dokumen_pendukung;
        // dd($file);
        $hay = Storage::disk('local')->delete('public/'.$file);
        // dd($hay);
        $pegawaiexit = $item->delete();

        if ($pegawaiexit) {
            return redirect()->route('pegawaiexit.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('pegawaiexit.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
