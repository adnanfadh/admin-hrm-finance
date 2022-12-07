<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Bidang;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;

use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\PegawaiRequest;
use App\Models\Company;
use App\Models\Shift;
use Illuminate\Support\Facades\Storage;
// use \Milon\Barcode\DNS1D;
use Milon\Barcode\DNS1D;

class PegawaiController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pegawai-list|pegawai-create|pegawai-edit|pegawai-delete', ['only' => ['index','store']]);
        $this->middleware('permission:pegawai-create', ['only' => ['create','store']]);
        $this->middleware('permission:pegawai-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:pegawai-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Auth::user()->pegawai->company);
        if (request()->ajax()) {
            if(Auth::user()->pegawai->company->nama_company == "Panca Wibawa Global"){
                $query = Pegawai::query()->where('kode_pegawai','<>','P#000')->with(['company','bidang', 'jabatan'])->get();
            }else{
                $query = Pegawai::query()->where('company_id', Auth::user()->pegawai->company->id)->with(['company','bidang', 'jabatan'])->get();
            }
            //dd($query);
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
                                    <a class="dropdown-item" href="' . route('pegawai.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <a class="dropdown-item" href="' . route('pegawai.show', $item->id) . '">
                                        Show Detail
                                    </a>
                                    <form action="' . route('pegawai.destroy', $item->id) . '" method="POST">
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

        // $pegawai = Pegawai::query()->with(['bidang'])->get();
        // return response()->json($pegawai);

        return view('pages.pegawai.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Pegawai::count();
        $kode = 'P#'.str_pad($data,3,'0',STR_PAD_LEFT);
        // if ($data == 0) {
        //     $kode = 'P#001';
        // }else{
        //     $max_kode = Pegawai::query()->max('kode_pegawai');
        //     $pecah_kode = explode('#', $max_kode);
        //     $convertInt = intval($pecah_kode[1]);
        //     if ($convertInt < 10) {
        //         $kode = $pecah_kode[0].'#00'.$pecah_kode[1]+1;
        //     }elseif($convertInt > 9 && $convertInt < 100){
        //         $kode = $pecah_kode[0].'#0'.$pecah_kode[1]+1;
        //     }else{
        //         $kode = $pecah_kode[0].'#'.$pecah_kode[1]+1;
        //     }
        // }
        $company = Company::all();
        $jabatan = Jabatan::all();
        $bidang = Bidang::all();
        $shift = Shift::all();
        return view('pages.pegawai.create', [
            'bidang'    => $bidang,
            'jabatan'   => $jabatan,
            'shift'     => $shift,
            'kode'      => $kode,
            'company'   => $company
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
        // dd(file($request->ttd));
        $data = $request->all();
        // get code departement
        $get_kode_departement = Bidang::where('id', $request->bidang_id)->get('kode_bidang');
        foreach ($get_kode_departement as $r) {
            $resultFor = $r->kode_bidang;
        }
        $pecah_kode_departement = explode('#', $resultFor);

        // pecah kode pegawai
        $pecah_kode_pegawai = explode('#', $request->kode_pegawai);
        $get_company = Company::findOrFail($request->company_id);

        $data['nip'] = $get_company->kode_company.' '.$pecah_kode_departement[1].' '.$pecah_kode_pegawai[1];
        // dd($get_company->kode_company);

        if (!empty($request->ttd)) {
            $data['ttd'] = $request->file('ttd')->store('assets/dokumen/pegawai', 'public');
        }

        $pegawai = Pegawai::create($data);

        if ($pegawai) {
            return redirect()->route('pegawai.index')->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('pegawai.index')->with(['error' => 'Data Gagal Diupload']);
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
        $pegawai = Pegawai::findOrFail($id);

        return view('pages.pegawai.detail', [
            'pegawai'   => $pegawai
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
        $company = Company::all();
        $jabatan = Jabatan::all();
        $bidang = Bidang::all();
        $shift = Shift::all();
        $pegawai = Pegawai::findOrFail($id);
        return view('pages.pegawai.edit', [
            'pegawai'    => $pegawai,
            'bidang'    => $bidang,
            'jabatan'   => $jabatan,
            'shift'     => $shift,
            'company'   => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PegawaiRequest $request, $id)
    {
        $data = $request->all();
        // get code departement
        $get_kode_departement = Bidang::where('id', $request->bidang_id)->get('kode_bidang');
        foreach ($get_kode_departement as $r) {
            $resultFor = $r->kode_bidang;
        }
        $pecah_kode_departement = explode('#', $resultFor);

        // pecah kode pegawai
        $pecah_kode_pegawai = explode('#', $request->kode_pegawai);
        $get_company = Company::findOrFail($request->company_id);

        $data['nip'] = $get_company->kode_company.' '.$pecah_kode_departement[1].' '.$pecah_kode_pegawai[1];
        if (!empty($request->ttd)) {
            Storage::disk('local')->delete('public/'. $request->ttd_old);
            $data['ttd'] = $request->file('ttd')->store('assets/dokumen/pegawai', 'public');
        }
        $item = Pegawai::findOrFail($id);



        $pegawai = $item->update($data);

        if ($pegawai) {
            return redirect()->route('pegawai.index')->with(['success' => 'Data Berhasil Dirubah']);
        } else {
            return redirect()->route('pegawai.index')->with(['error' => 'Data Gagal Dirubah']);
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
        $item = Pegawai::findOrFail($id);
        Storage::disk('local')->delete('public/'. $item->ttd);
        $pegawai = $item->delete();

        if ($pegawai) {
            return redirect()->route('pegawai.index')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect()->route('pegawai.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
