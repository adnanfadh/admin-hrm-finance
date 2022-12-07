<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembur;
use App\Models\Pegawai;

use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\LemburRequest;
use Illuminate\Support\Facades\Auth;

class LemburController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:lembur-list|lembur-create|lembur-edit|lembur-delete', ['only' => ['index','store']]);
         $this->middleware('permission:lembur-create', ['only' => ['create','store']]);
         $this->middleware('permission:lembur-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:lembur-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            // $query = Kebijakanhr::with(['pegawai'])->get();
            $query = Lembur::query()->with(['pegawai'])->where('pegawai_id', Auth::user()->pegawai->id)->get();
            // dd($query);
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn d-flex flex-row">
                                    <a class="btn btn-primary mr-2" href="' . route('lembur.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('lembur.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                    </div>';
                })->addColumn('status', function ($item) {
                    if ($item->status_lembur == 0) {
                        // $show_data = "not verified";
                        $show_data = '<span class="badge bg-danger text-white">not verified</span>';
                    }elseif ($item->status_lembur == 1) {
                        // $show_data = "verified";
                        $show_data = '<span class="badge bg-warning text-white"> verified</span>';
                    }else{
                        // $show_data = "finished";
                        $show_data = '<span class="badge bg-success text-white"> finished</span>';
                    }
                    return '
                        <div class="btn d-flex flex-row">
                            ' . $show_data . '
                        </div>';
                })
                ->rawColumns(['action', 'status'])
                ->addIndexColumn()
                ->make();
        }
        return view('pages.lembur.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pegawai = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();
        return view('pages.lembur.create', [
            'pegawai'    => $pegawai
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LemburRequest $request)
    {
        $data = $request->all();

        $lembur = Lembur::create($data);

        if ($lembur) {
            return redirect()->route('lembur.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('lembur.index')->with(['error' => 'Data Gagal Diupload']);
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
        $lembur = Lembur::findOrFail($id);
        return view('pages.lembur.edit', [
            'lembur'    => $lembur,
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
    public function update(LemburRequest $request, $id)
    {
        $data = $request->all();
        $item = Lembur::findOrFail($id);

        $lembur = $item->update($data);

        if ($lembur) {
            return redirect()->route('lembur.index')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('lembur.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Lembur::findOrFail($id);
        $lembur = $item->delete();

        if ($lembur) {
            return redirect()->route('lembur.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('lembur.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
