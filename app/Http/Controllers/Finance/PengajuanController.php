<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\DetailBiaya;
use App\Models\Finance\DetailPengajuan;
use App\Models\Finance\Pengajuan;
use App\Models\Finance\TrackPengajuan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {  
            $query = Pengajuan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('status_pengajuan', 0)->orderBy('id', 'DESC')->get();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return ' 
                    <div class="btn-group dropleft">
                    
                        <button class="btn btn-primary dropdown-toggle mr-1 mb-1" 
                            type="button" id="action' .  $item->id . '"
                                data-toggle="dropdown" 
                                aria-haspopup="true"
                                aria-expanded="false">
                                Aksi
                        </button>
                        <div class="dropdown-menu" aria-labelledby="action' .  $item->id . '" style="border-radius:10px 0px 10px 10px; margin:10px;">
                            <a class="dropdown-item" href="' . route('pengajuan.edit', $item->id) . '">
                                Edit
                            </a>
                            <a class="dropdown-item" href="' . route('kirim_pengajuan', $item->id) . '">
                                Kirim
                            </a>
                            <form action="' . route('pengajuan.destroy', $item->id) . '" method="POST">
                                ' . method_field('delete') . csrf_field() . '
                                <button type="submit" class="dropdown-item text-danger">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>';
                })
                ->addColumn('jenis_pengajuan', function ($item) {
                    if ($item->jenis_pengajuan == 1) {
                        return '<span class="badge badge-success">Pengajuan RAB</span>';
                    } else {
                        return '<span class="badge badge-success">Pengajuan Langsung</span>';
                    }
                    
                })
                ->rawColumns(['action', 'jenis_pengajuan'])
                ->addIndexColumn()
                ->make();
        }
        return view('pages_finance.pengajuan.index');
    }

    public function index_waiting_confirmed()
    {
        if (request()->ajax()) {  
            $query = Pengajuan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('status_pengajuan', 1)->orWhere('status_pengajuan', 2)->orderBy('id', 'DESC')->get();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return ' 
                    <div class="btn-group dropleft">
                    
                        <button class="btn btn-primary dropdown-toggle mr-1 mb-1" 
                            type="button" id="action' .  $item->id . '"
                                data-toggle="dropdown" 
                                aria-haspopup="true"
                                aria-expanded="false">
                                Aksi
                        </button>
                        <div class="dropdown-menu" aria-labelledby="action' .  $item->id . '" style="border-radius:10px 0px 10px 10px; margin:10px;">
                            <a class="dropdown-item" href="' . route('track_pengajuan', $item->id) . '">
                                Track Pengajuan
                            </a>
                        </div>
                    </div>';
                })
                ->addColumn('jenis_pengajuan', function ($item) {
                    if ($item->jenis_pengajuan == 1) {
                        return '<span class="badge badge-success">Pengajuan RAB</span>';
                    } else {
                        return '<span class="badge badge-success">Pengajuan Langsung</span>';
                    }
                    
                })
                ->rawColumns(['action','jenis_pengajuan'])
                ->addIndexColumn()
                ->make();
        }
    }

    public function index_confirmed()
    {
        if (request()->ajax()) {  
            $query = Pengajuan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('status_pengajuan', 3)->orderBy('id', 'DESC')->get();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return ' 
                    <div class="btn-group dropleft">
                        <button class="btn btn-primary dropdown-toggle mr-1 mb-1" 
                            type="button" id="action' .  $item->id . '"
                                data-toggle="dropdown" 
                                aria-haspopup="true"
                                aria-expanded="false">
                                Aksi
                        </button>
                        <div class="dropdown-menu" aria-labelledby="action' .  $item->id . '" style="border-radius:10px 0px 10px 10px; margin:10px;">
                            <a class="dropdown-item" href="' . route('pengajuan.show', $item->id) . '">
                                Detail
                            </a>
                        </div>
                    </div>';
                })
                ->addColumn('jenis_pengajuan', function ($item) {
                    if ($item->jenis_pengajuan == 1) {
                        return '<span class="badge badge-success">Pengajuan RAB</span>';
                    } else {
                        return '<span class="badge badge-success">Pengajuan Langsung</span>';
                    }
                    
                })
                ->rawColumns(['action','jenis_pengajuan'])
                ->addIndexColumn()
                ->make();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $penerima = Pegawai::query()->with(['jabatan', 'company'])->where('company_id', 1)->get();

        return view('pages_finance.pengajuan.create', [
            'penerima'  => $penerima
        ]);
    }

    public function kirim_pengajuan($id){
        $kirim_pengajuan = Pengajuan::query()->where('id', $id)->update(['status_pengajuan' => 1]);

        if ($kirim_pengajuan) {
            $save_track_pengajuan = TrackPengajuan::create([
                'id_pengajuan'      => $id,
                'tanggal_action'    => Carbon::now()->format('Y-m-d H:i:m'),
                'user_action'       => Auth::user()->id,
                'keterangan_track'  => "Dikirim oleh ". Auth::user()->pegawai->nama
            ]);
        }


        if ($save_track_pengajuan) {
            return redirect()->route('pengajuan.index')->with(['success' => 'Pengajuan Berhasil Dikirim']);
        } else {
            return redirect()->route('pengajuan.index')->with(['error' => 'Pengajuan Gagal Terkirim']);
        }
    }

    public function track_pengajuan($id){
        $data = TrackPengajuan::query()->with(['pengajuan', 'user_action'])->where('id_pengajuan', $id)->get();

        return view('pages_finance.pengajuan.track_pengajuan', [
            'data'      =>$data
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
            'jenis_pengajuan'          => 'required',
            'tanggal_pengajuan'           => 'required',
            'penerima'     => 'required',
            'no_surat'  => 'required',
            'perihal_surat'   => 'required',
            'lampiran_surat'      => 'required',
            'total_nominal_pengajuan'             => 'required',
        ]);

        $save_pengajuan = Pengajuan::create([
            'jenis_pengajuan'   => $request->jenis_pengajuan,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'penerima'          => $request->penerima,
            'no_surat'          => $request->no_surat,
            'perihal_surat'     => $request->perihal_surat,
            'lampiran_surat'    => $request->lampiran_surat,
            'total_nominal_pengajuan' => $request->total_nominal_pengajuan,
            'status_pengajuan'  => 0,
            'creat_by'          => Auth::user()->id,
            'creat_by_company'  => Auth::user()->pegawai->company->id
        ]);

        $parameter_detail = $request->hitung_row;
        $idpengajuan = DB::getPdo()->lastInsertId();

        if ($save_pengajuan) {
            for ($i=0; $i <= $parameter_detail ; $i++) { 
                $detail_pengajuan = new DetailPengajuan();
                $detail_pengajuan->tanggal_pelaksanaan  = $request->tanggal_pelaksanaan[$i];
                $detail_pengajuan->item                 = $request->item[$i];
                $detail_pengajuan->jumlah_item          = $request->jumlah_item[$i];
                $detail_pengajuan->jumlah_item_approved = null;
                $detail_pengajuan->budget               = $request->budget[$i];
                $detail_pengajuan->budget_approved      = null;
                $detail_pengajuan->keterangan           = null;
                $detail_pengajuan->status               = 0;
                $detail_pengajuan->harga                = $request->harga[$i];
                $detail_pengajuan->vendor               = $request->vendor[$i];    
                $detail_pengajuan->id_pengajuan = $idpengajuan;
                $save_detail_pengajuan = $detail_pengajuan->save();
            }
        }

        if ($save_detail_pengajuan) {
            $save_track_pengajuan = TrackPengajuan::create([
                'id_pengajuan'      => $idpengajuan,
                'tanggal_action'    => Carbon::now()->format('Y-m-d H:i:m'),
                'user_action'       => Auth::user()->id,
                'keterangan_track'  => "Dibuat oleh ". Auth::user()->pegawai->nama
            ]);
        }

        if ($save_track_pengajuan) {
            return redirect()->route('pengajuan.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('pengajuan.index')->with(['error' => 'Data Gagal Diupload']);
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
        $data = Pengajuan::findOrFail($id);

        return view('pages_finance.pengajuan.head_office.surat_permohonan', [
            'data' => $data
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
        $data = Pengajuan::findOrFail($id);

        $penerima = Pegawai::query()->with(['jabatan', 'company'])->where('company_id', 1)->get();

        return view('pages_finance.pengajuan.edit', [
            'data'  => $data,
            'penerima'  => $penerima
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
            'jenis_pengajuan'          => 'required',
            'tanggal_pengajuan'           => 'required',
            'penerima'     => 'required',
            'no_surat'  => 'required',
            'perihal_surat'   => 'required',
            'lampiran_surat'      => 'required',
            'total_nominal_pengajuan'             => 'required',
        ]);

        $save_pengajuan = Pengajuan::findOrFail($id)->update([
            'jenis_pengajuan'   => $request->jenis_pengajuan,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'penerima'          => $request->penerima,
            'no_surat'          => $request->no_surat,
            'perihal_surat'     => $request->perihal_surat,
            'lampiran_surat'    => $request->lampiran_surat,
            'total_nominal_pengajuan' => $request->total_nominal_pengajuan,
            'status_pengajuan'  => 0,
            'creat_by'          => Auth::user()->id,
            'creat_by_company'  => Auth::user()->pegawai->company->id
        ]);

        $parameter_detail = $request->hitung_row;

        if ($save_pengajuan) {
            $del_detail_old = DetailPengajuan::query()->where('id_pengajuan', $id)->delete();
        }

        if ($del_detail_old) {
            for ($i=0; $i <= $parameter_detail ; $i++) { 
                $detail_pengajuan = new DetailPengajuan();
                $detail_pengajuan->tanggal_pelaksanaan  = $request->tanggal_pelaksanaan[$i];
                $detail_pengajuan->item                 = $request->item[$i];
                $detail_pengajuan->jumlah_item          = $request->jumlah_item[$i];
                $detail_pengajuan->jumlah_item_approved = null;
                $detail_pengajuan->budget               = $request->budget[$i];
                $detail_pengajuan->budget_approved      = null;
                $detail_pengajuan->keterangan           = null;
                $detail_pengajuan->status               = 0;
                $detail_pengajuan->harga                = $request->harga[$i];
                $detail_pengajuan->vendor               = $request->vendor[$i];
                $detail_pengajuan->id_pengajuan         = $id;
                $save_detail_pengajuan = $detail_pengajuan->save();
            }
        }

        if ($save_detail_pengajuan) {
            $del_track_old = TrackPengajuan::query()->where('id_pengajuan', $id)->delete();

            if ($del_track_old) {
                $save_track_pengajuan = TrackPengajuan::create([
                    'id_pengajuan'      => $id,
                    'tanggal_action'    => Carbon::now()->format('Y-m-d H:i:m'),
                    'user_action'       => Auth::user()->id,
                    'keterangan_track'  => "Dibuat oleh ". Auth::user()->pegawai->nama
                ]);
            }

        }

        if ($save_track_pengajuan) {
            return redirect()->route('pengajuan.index')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return redirect()->route('pengajuan.index')->with(['error' => 'Data Gagal Diupdate']);
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
        $item = Pengajuan::findOrFail($id);

        $del_detail_old = DetailPengajuan::query()->where('id_pengajuan', $id)->delete();

        $del_track_old = TrackPengajuan::query()->where('id_pengajuan', $id)->delete();

        $delete_pengajuan = $item->delete();

        if ($delete_pengajuan) {
            return redirect()->route('pengajuan.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('pengajuan.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
