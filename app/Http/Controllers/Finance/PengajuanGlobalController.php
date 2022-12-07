<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Finance\DetailPengajuan;
use App\Models\Finance\Pengajuan;
use App\Models\Finance\TrackPengajuan;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PengajuanGlobalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {  
            if (Auth::user()->id == 1) {
                $query = Pengajuan::query()->where('status_pengajuan', 1)->orderBy('id', 'DESC')->get();
            }
            if (Auth::user()->id == 2) {
                $query = Pengajuan::query()->where('status_pengajuan', 2)->orderBy('id', 'DESC')->get();
            }
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    if (Auth::user()->id == 1) {
                        return ' 
                        <div class="btn-group">
                            <a class="btn btn-primary" href="' . route('pengajuan_head.show', $item->id) . '">
                                Show Detail
                            </a>
                        </div>';
                    }
                    if (Auth::user()->id == 2) {
                        return ' 
                        <div class="btn-group">
                            <a class="btn btn-primary" href="' . route('view_approved', $item->id) . '">
                                Show Detail
                            </a>
                        </div>';
                    }
                })
                ->addColumn('tanggal_pengajuan', function ($item) {
                    return date('d F Y', strtotime($item->tanggal_pengajuan));
                })
                ->addColumn('company', function ($item) {
                    $data_company = Company::findOrFail($item->creat_by_company);
                    return $data_company->nama_company;
                })
                ->addColumn('total_nominal_pengajuan', function ($item) {
                    return number_format($item->total_nominal_pengajuan,2,',','.');
                    // return 'hahah';
                })
                ->rawColumns(['action', 'tanggal_pengajuan', 'company', 'total_nominal_pengajuan'])
                ->addIndexColumn()
                ->make();
        }
        return view('pages_finance.pengajuan.head_office.index');
    }


    public function index_confirmed()
    {
        if (request()->ajax()) {  
            $query = Pengajuan::query()->where('status_pengajuan', 3)->orderBy('id', 'DESC')->get();
            return DataTables::of($query)
                ->addColumn('tanggal_pengajuan', function ($item) {
                    return date('d F Y', strtotime($item->tanggal_pengajuan));
                })
                ->addColumn('company', function ($item) {
                    $data_company = Company::findOrFail($item->creat_by_company);
                    return $data_company->nama_company;
                })
                ->addColumn('total_nominal_pengajuan', function ($item) {
                    return number_format($item->total_nominal_pengajuan,2,',','.');
                })
                ->rawColumns(['tanggal_pengajuan', 'company', 'total_nominal_pengajuan'])
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

        //$data = Pengajuan::query()->with(['creatby', 'creatbycompany'])->where('id', $id)->get();

        // dd($data->penerimaTo->nama);

        return view('pages_finance.pengajuan.head_office.surat_permohonan', [
            'data'  => $data
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

        return view('pages_finance.pengajuan.head_office.approved', [
            'data'  => $data,
            'penerima'  => $penerima
        ]);
    }


    public function view($id)
    {
        $data = Pengajuan::findOrFail($id);

        $penerima = Pegawai::query()->with(['jabatan', 'company'])->where('company_id', 1)->get();

        return view('pages_finance.pengajuan.head_office.approved_persetujuan', [
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
        // $request->validate([
        //     'jenis_pengajuan'               => 'required',
        //     'tanggal_pengajuan'             => 'required',
        //     'penerima'                      => 'required',
        //     'no_surat'                      => 'required',
        //     'perihal_surat'                 => 'required',
        //     'lampiran_surat'                => 'required',
        //     'total_nominal_pengajuan'       => 'required',
        // ]);


        $update_pengajuan = Pengajuan::findOrFail($id)->update([
            'status_pengajuan'  => 2,
            'total_nominal_approved'    => $request->total_nominal_approved,
            'mengetahui'                => Auth::user()->id
        ]);

        
        if ($update_pengajuan) {
            $del_detail_old = DetailPengajuan::query()->where('id_pengajuan', $id)->delete();
        }
        $parameter_detail = $request->hitung_row;
        
        if ($del_detail_old) {
            for ($i=0; $i <= $parameter_detail ; $i++) { 
                $detail_pengajuan = new DetailPengajuan();
                $detail_pengajuan->tanggal_pelaksanaan  = $request->tanggal_pelaksanaan[$i];
                $detail_pengajuan->item                 = $request->item[$i];
                $detail_pengajuan->jumlah_item          = $request->jumlah_item[$i];
                $detail_pengajuan->jumlah_item_approved = $request->jumlah_item_approved[$i];
                $detail_pengajuan->budget               = $request->budget[$i];
                $detail_pengajuan->budget_approved      = $request->budget_approved[$i];
                $detail_pengajuan->keterangan           = $request->keterangan[$i];
                $detail_pengajuan->status               = $request->status_detail_approv[$i];
                $detail_pengajuan->harga                = $request->harga[$i];
                $detail_pengajuan->vendor               = $request->vendor[$i];
                $detail_pengajuan->id_pengajuan         = $id;
                $save_detail_pengajuan = $detail_pengajuan->save();
            }
        }

        if ($save_detail_pengajuan) {
            $save_track_pengajuan = TrackPengajuan::create([
                'id_pengajuan'      => $id,
                'tanggal_action'    => Carbon::now()->format('Y-m-d H:i:m'),
                'user_action'       => Auth::user()->id,
                'keterangan_track'  => "Diketahui oleh ". Auth::user()->pegawai->nama
            ]);
        }

        if ($save_detail_pengajuan) {
            return redirect()->route('pengajuan_head.index')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return redirect()->route('pengajuan_head.index')->with(['error' => 'Data Gagal Diupdate']);
        }

        
    }

    public function update_persetujuan(Request $request, $id){
        $update_pengajuan = Pengajuan::findOrFail($id)->update([
            'status_pengajuan'  => 3,
            'total_nominal_approved'    => $request->total_nominal_approved,
            'menyetujui'                => Auth::user()->id
        ]);

        
        if ($update_pengajuan) {
            $del_detail_old = DetailPengajuan::query()->where('id_pengajuan', $id)->delete();
        }
        $parameter_detail = $request->hitung_row;
        
        if ($del_detail_old) {
            for ($i=0; $i <= $parameter_detail ; $i++) { 
                $detail_pengajuan = new DetailPengajuan();
                $detail_pengajuan->tanggal_pelaksanaan  = $request->tanggal_pelaksanaan[$i];
                $detail_pengajuan->item                 = $request->item[$i];
                $detail_pengajuan->jumlah_item          = $request->jumlah_item[$i];
                $detail_pengajuan->jumlah_item_approved = $request->jumlah_item_approved[$i];
                $detail_pengajuan->budget               = $request->budget[$i];
                $detail_pengajuan->budget_approved      = $request->budget_approved[$i];
                $detail_pengajuan->keterangan           = $request->keterangan[$i];
                $detail_pengajuan->status               = $request->status_detail_approv[$i];
                $detail_pengajuan->harga                = $request->harga[$i];
                $detail_pengajuan->vendor               = $request->vendor[$i];
                $detail_pengajuan->id_pengajuan         = $id;
                $save_detail_pengajuan = $detail_pengajuan->save();
            }
        }

        if ($save_detail_pengajuan) {
            $save_track_pengajuan = TrackPengajuan::create([
                'id_pengajuan'      => $id,
                'tanggal_action'    => Carbon::now()->format('Y-m-d H:i:m'),
                'user_action'       => Auth::user()->id,
                'keterangan_track'  => "Diketahui oleh ". Auth::user()->pegawai->nama
            ]);
        }

        if ($save_detail_pengajuan) {
            return redirect()->route('pengajuan_head.index')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return redirect()->route('pengajuan_head.index')->with(['error' => 'Data Gagal Diupdate']);
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
        //
    }


}
