<?php

namespace App\Http\Controllers;

use App\Models\Finance\GajiSecond;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class GajiSecondController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = GajiSecond::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->with(['pegawai'])->get();
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
                                    <a class="dropdown-item" href="' . route('gaji_second.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <a class="dropdown-item" href="' . route('gaji_second.show', $item->id) . '">
                                        Slip Gaji
                                    </a>
                                    <form action="' . route('gaji_second.destroy', $item->id) . '" method="POST">
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
        return view('pages.gaji_second.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$pegawai = Pegawai::query()->where('company_id', Auth::user()->pegawai->company->id)->get();
        $pegawai = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();

        return view('pages.gaji_second.create', [
            'pegawai'   => $pegawai
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id'               => 'required',
        ]);
        // $get_gaji_pegawai = Pegawai::query()->with('jabatan')->where('id', $request->pegawai_id)->get();
        // foreach ($get_gaji_pegawai as $ggp) {
        //     $gaji_pegawai = $ggp->jabatan->gaji;
        // }
        // $total_penerimaan = $gaji_pegawai + $request->tunjangan_makan + $request->tunjangan_kerajinan + $request->tunjangan_jabatan + $request->lembur_harian + $request->lembur_hari_libur + $request->lembur_event + $request->perjalanan_dinas + $request->tunjangan_keluarga;
        $total_penerimaan = $request->gaji_pokok + $request->tunjangan_makan + $request->tunjangan_kerajinan + $request->tunjangan_jabatan + $request->lembur_harian + $request->lembur_hari_libur + $request->lembur_event + $request->perjalanan_dinas + $request->tunjangan_keluarga;
        $total_potongan = $request->biaya_jabatan + $request->tabungan + $request->bpjs_kesehatan + $request->bpjs_ketenagakerjaan + $request->potongan_lain_lain;
        $gaji_bersih = $total_penerimaan - $total_potongan;

        $monthnum = explode("-",$request->periode);
        $periode = date("F Y", mktime(0,0,0,$monthnum[1],1,$monthnum[0]));



        $gaji_second = new GajiSecond();
        $gaji_second->pegawai_id        = $request->pegawai_id;
        $gaji_second->periode       = $periode;
        $gaji_second->gaji_pokok        = $request->gaji_pokok;
        $gaji_second->tunjangan_kerajinan       = $request->tunjangan_kerajinan;
        $gaji_second->tunjangan_makan       = $request->tunjangan_makan;
        $gaji_second->tunjangan_jabatan     = $request->tunjangan_jabatan;
        $gaji_second->lembur_harian     = $request->lembur_harian;
        $gaji_second->lembur_hari_libur     = $request->lembur_hari_libur;
        $gaji_second->lembur_event      = $request->lembur_event;
        $gaji_second->perjalanan_dinas      = $request->perjalanan_dinas;
        $gaji_second->tunjangan_keluarga        = $request->tunjangan_keluarga;
        $gaji_second->biaya_jabatan     = $request->biaya_jabatan;
        $gaji_second->tabungan      = $request->tabungan;
        $gaji_second->bpjs_kesehatan        = $request->bpjs_kesehatan;
        $gaji_second->bpjs_ketenagakerjaan      = $request->bpjs_ketenagakerjaan;
        $gaji_second->potongan_lain_lain        = $request->potongan_lain_lain;
        $gaji_second->total_penerimaan      = $total_penerimaan;
        $gaji_second->total_potongan        = $total_potongan;
        $gaji_second->total_gaji_bersih     = $gaji_bersih;
        $gaji_second->pajak_21     = $request->pajak_21;
        $gaji_second->catatan     = $request->catatan;
        $gaji_second->creat_by_company      = Auth::user()->pegawai->company->id;
        $save_gaji_second = $gaji_second->save();

        if ($save_gaji_second) {
            return redirect()->route('gaji_second.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('gaji_second.index')->with(['error' => 'Data Gagal Diupload']);
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
        $data = GajiSecond::findOrFail($id);
        return view('pages.gaji_second.slip', [
            'data'   => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = GajiSecond::findOrFail($id);
        $montharray = explode(" ",$data->periode);
        $monthnum = date('m', strtotime($montharray[0]));
        $periode = date("Y-m", mktime(0,0,0,$monthnum,1,$montharray[1]));
        // $pegawai = Pegawai::query()->where('company_id', Auth::user()->pegawai->company->id)->get();
        $pegawai = Pegawai::query()->where('kode_pegawai','<>','P#000')->get();

        return view('pages.gaji_second.edit', [
            'data'   => $data,
            'pegawai'=>$pegawai,
            'periode'=>$periode
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'pegawai_id'               => 'required',
        ]);
        // $get_gaji_pegawai = Pegawai::query()->with('jabatan')->where('id', $request->pegawai_id)->get();
        // foreach ($get_gaji_pegawai as $ggp) {
        //     $gaji_pegawai = $ggp->jabatan->gaji;
        // }
        // $total_penerimaan = $gaji_pegawai + $request->tunjangan_makan + $request->tunjangan_kerajinan + $request->tunjangan_jabatan + $request->lembur_harian + $request->lembur_hari_libur + $request->lembur_event + $request->perjalanan_dinas + $request->tunjangan_keluarga;
        $total_penerimaan = $request->gaji_pokok + $request->tunjangan_makan + $request->tunjangan_kerajinan + $request->tunjangan_jabatan + $request->lembur_harian + $request->lembur_hari_libur + $request->lembur_event + $request->perjalanan_dinas + $request->tunjangan_keluarga;
        $total_potongan = $request->biaya_jabatan + $request->tabungan + $request->bpjs_kesehatan + $request->bpjs_ketenagakerjaan + $request->potongan_lain_lain;
        $gaji_bersih = $total_penerimaan - $total_potongan;
        //dd($request->periode);
        $monthnum = explode("-",$request->periode);
        $periode = date("F Y", mktime(0,0,0,$monthnum[1],1,$monthnum[0]));

        $item = GajiSecond::findOrFail($id);

        $array = [
            'pegawai_id'        => $request->pegawai_id,
            'periode'       => $periode,
            'gaji_pokok'        => $request->gaji_pokok,
            'tunjangan_kerajinan'       => $request->tunjangan_kerajinan,
            'tunjangan_makan'       => $request->tunjangan_makan,
            'tunjangan_jabatan'     => $request->tunjangan_jabatan,
            'lembur_harian'     => $request->lembur_harian,
            'lembur_hari_libur'     => $request->lembur_hari_libur,
            'lembur_event'      => $request->lembur_event,
            'perjalanan_dinas'      => $request->perjalanan_dinas,
            'tunjangan_keluarga'        => $request->tunjangan_keluarga,
            'biaya_jabatan'     => $request->biaya_jabatan,
            'tabungan'      => $request->tabungan,
            'bpjs_kesehatan'        => $request->bpjs_kesehatan,
            'bpjs_ketenagakerjaan'      => $request->bpjs_ketenagakerjaan,
            'potongan_lain_lain'        => $request->potongan_lain_lain,
            'pajak_21'        => $request->pajak_21,
            'total_penerimaan'      => $total_penerimaan,
            'total_potongan'        => $total_potongan,
            'total_gaji_bersih'     => $gaji_bersih,
            'catatan'     => $request->catatan,
            'creat_by_company'      => Auth::user()->pegawai->company->id,
        ];
        $save_gaji_second = $item->update($array);

        if ($save_gaji_second) {
            return redirect()->route('gaji_second.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('gaji_second.index')->with(['error' => 'Data Gagal Diupload']);
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
        $item = GajiSecond::findOrFail($id);
        $gaji = $item->delete();

        if ($gaji) {
            return redirect()->route('gaji_second.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('gaji_second.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
