<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Lembur;
use App\Models\Bpjs;

use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\GajiRequest;


class GajiController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:gaji-list|gaji-create|gaji-edit|gaji-delete', ['only' => ['index','store']]);
         $this->middleware('permission:gaji-create', ['only' => ['create','store']]);
         $this->middleware('permission:gaji-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:gaji-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Gaji::query()->with(['pegawai'])->get();
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
                                    <a class="dropdown-item" href="' . route('gaji.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('gaji.destroy', $item->id) . '" method="POST">
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

        // $gaji = Gaji::query()->with(['pegawai'])->get();
        // return response()->json($gaji);
        return view('pages.gaji.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pegawai = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();
        return view('pages.gaji.create', [
            'pegawai'    => $pegawai
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GajiRequest $request)
    {
        $data = $request->all();

        $id = $data['pegawai_id'];
        $from = $data['tanggal_awal'];
        $to = $data['tanggal_akhir'];

        $id_pegawai = pegawai::query()->where('id', $id)->get();
        foreach ($id_pegawai as $peg) {
            $id_pegawai = $peg->id;
            $jabatan_id = $peg->jabatan_id;

            $jabatan = Jabatan::query()->where('id', $jabatan_id)->get();

            foreach ($jabatan as $bid) {
                $gaji_pokok = $bid->gaji;
            }

            $jumlah_lembur = Lembur::query()->where('pegawai_id', $id_pegawai)->whereBetween('tanggal', [$from, $to])->count();
            // dd($id_lembur);

            $bpjs = Bpjs::query()->where('pegawai_id', $id_pegawai)->sum('jumlah_iuran');

            $gaji_perhari = $gaji_pokok / 20;
            $bonus_lembur = $gaji_perhari * $jumlah_lembur;
            $gaji_sementara = $gaji_pokok + $bonus_lembur;
            $gaji_total_pegawai = $gaji_sementara - $bpjs;

        }

        $gaji = new Gaji();

        $gaji->pegawai_id = $data['pegawai_id'];
        $gaji->tanggal_awal = $data['tanggal_awal'];
        $gaji->tanggal_akhir = $data['tanggal_akhir'];
        $gaji->jumlah_gaji = $gaji_pokok;
        $gaji->jumlah_lembur = $jumlah_lembur;
        $gaji->potongan_bpjs = $bpjs;
        $gaji->total_gaji = $gaji_total_pegawai;

        $gaji_message = $gaji->save();

        if ($gaji_message) {
            return redirect()->route('gaji.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('gaji.index')->with(['error' => 'Data Gagal Diupload']);
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
        // if (request()->ajax()) {
        //     $query = Gaji::query()->with(['pegawai'])->where('id', $id)->get();
        //     // dd($query);
        //     return DataTables::of($query)
        //         ->addColumn('action', function ($item) {
        //             return '
        //                 <div class="btn-group">
        //                 <a class="btn btn-info" href="' . route('gaji.view', $item->id) . '">
        //                         <i class="fas fa-print    "></i>
        //                     </a>
        //                 </div>';
        //         })
        //         ->rawColumns(['action'])
        //         ->addIndexColumn()
        //         ->make();
        // }

        $gaji = Gaji::query()->with(['pegawai'])->where('id', $id)->get();

        return view('pages.gaji.slip');
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
        $gaji = Gaji::findOrFail($id);
        return view('pages.gaji.edit', [
            'gaji'    => $gaji,
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
    public function update(GajiRequest $request, $id)
    {
        $data = $request->all();

        $uniq = $data['pegawai_id'];
        $from = $data['tanggal_awal'];
        $to = $data['tanggal_akhir'];
        // dd($from);

        $id_pegawai = pegawai::query()->where('id', $uniq)->get();
        foreach ($id_pegawai as $peg) {
            $jabatan_id = $peg->jabatan_id;

            $jabatan = Jabatan::query()->where('id', $jabatan_id)->get();


            foreach ($jabatan as $bid) {
                $gaji_pokok = $bid->gaji;
            }

            $jumlah_lembur = Lembur::query()->whereBetween('tanggal', [$from, $to])->where('id', $uniq)->count();
            // dd($jabatan);

            $bpjs = Bpjs::query()->where('pegawai_id', $uniq)->sum('jumlah_iuran');

            $gaji_perhari = $gaji_pokok / 20;
            $bonus_lembur = $gaji_perhari * $jumlah_lembur;
            $gaji_sementara = $gaji_pokok + $bonus_lembur;
            $gaji_total_pegawai = $gaji_sementara - $bpjs;
        }

        $item = Gaji::findOrFail($id);

        $array = [
            'pegawai_id'    => $data['pegawai_id'],
            'tanggal_awal'    => $data['tanggal_awal'],
            'tanggal_akhir'    => $data['tanggal_akhir'],
            'jumlah_gaji'    => $gaji_pokok,
            'jumlah_lembur'    => $jumlah_lembur,
            'potongan_bpjs'    => $bpjs,
            'total_gaji'    => $gaji_total_pegawai,
        ];



        $gajis = $item->update($array);

        if ($gajis) {
            return redirect()->route('gaji.index')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('gaji.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Gaji::findOrFail($id);
        $gaji = $item->delete();

        if ($gaji) {
            return redirect()->route('gaji.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('gaji.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }

    public function view(Request $request)
    {
        $pecah = explode("/", $request->tanggal);
        $pegawai = Pegawai::all();
        $gaji = Gaji::query()->with(['pegawai'])->whereBetween('tanggal_awal', [$pecah[0], $pecah[1]])->where('pegawai_id', $request->pegawai_id)->get();


        return view('pages.gaji.bukti', [
            'title'    => 'gaji',
            'gaji' => $gaji,
            'pegawai'   => $pegawai,
        ]);
    }



    public function filter(Request $request){

        if (request()->ajax()) {
            $query = Gaji::query()->with(['pegawai'])->where('tanggal_awal', 'like', "%" . $request->tanggal . "%")->where('pegawai_id', $request->pegawai_id)->get();
             dd($query);
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group">
                        <a class="btn-sm btn-primary" href="' . route('gaji.show', $item->id) . '">
                                <i class="fas fa-print icon-sm-1x text-white"></i>
                            </a>
                        </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make();
        }

        $gaji = Gaji::query()->with(['pegawai'])->get();
        // return response()->json($gaji);
        $pegawai = Pegawai::all();
        return view('pages.gaji.bukti', [
            'pegawai'   => $pegawai
        ]);
    }


}
