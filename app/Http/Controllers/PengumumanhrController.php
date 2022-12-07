<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengumumanhrRequest;
use App\Models\Pegawai;
use App\Models\Pengumumanhr;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PengumumanhrController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pengumumanhr-list|pengumumanhr-create|pengumumanhr-edit|pengumumanhr-delete', ['only' => ['index','store']]);
        $this->middleware('permission:pengumumanhr-create', ['only' => ['create','store']]);
        $this->middleware('permission:pengumumanhr-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:pengumumanhr-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Pengumumanhr::query()->with(['pegawai'])->get();
            // dd($query);
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn d-flex flex-row">
                            <a class="btn btn-primary" href="' . route('pengumumanhr.edit', $item->id) . '">
                                Detail
                            </a>
                            <form action="' . route('pengumumanhr.destroy', $item->id) . '" method="POST">
                                ' . method_field('delete') . csrf_field() . '
                                    <button type="submit" class="btn btn-danger ml-2">
                                        Hapus
                                    </button>
                            </form>
                    </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make();
        }
        return view('pages.hr.pengumuman.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pegawai = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();
        return view('pages.hr.pengumuman.create', [
            'pegawai'    => $pegawai
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PengumumanhrRequest $request)
    {
        $data = $request->all();
        $data['pegawai_id'] = json_encode($request->input('pegawai_id'));
        // $dataku = json_decode($datas);
        $pengumumanhr = Pengumumanhr::create($data);

        if ($pengumumanhr) {
            return redirect()->route('pengumumanhr.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('pengumumanhr.index')->with(['error' => 'Data Gagal Diupload']);
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
        $pengumumanhr = Pengumumanhr::findOrFail($id);
        $datas = $pengumumanhr->pegawai_id;
        $dataku = json_decode($datas);
        // $dataku.lenght()->get();
        // return response()->json($dataku);
        // dd($dataku);
        // $data = [];
        // foreach ($dataku as $phr) {
        //     $data[] = [
        //         'pegawai_id'   => $phr
        //     ];
        //     dd($data);
        // }


        return view('pages.hr.pengumuman.edit', [
            'pengumumanhr'    => $pengumumanhr,
            'pegawai'    => $pegawai,
            'dataku'      => $dataku
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PengumumanhrRequest $request, $id)
    {
        $data = $request->all();
        $item = Pengumumanhr::findOrFail($id);

        $msg = $item->update($data);

        if ($msg) {
            return redirect()->route('pengumumanhr.index')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('pengumumanhr.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Pengumumanhr::findOrFail($id);
        $pengumumanhr = $item->delete();

        if ($pengumumanhr) {
            return redirect()->route('pengumumanhr.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('pengumumanhr.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
