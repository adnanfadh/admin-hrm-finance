<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\BiayaRequest;
use App\Models\Finance\AccountBank;
use App\Models\Finance\Biaya;
use App\Models\Finance\DetailBiaya;
use App\Models\Finance\jurnal_penyesuaian;
use App\Models\Finance\JurnalEntry;
use App\Models\Finance\MetodePembayaran;
use App\Models\Finance\Pajak;
use App\Models\Finance\RulesJurnalInput;
use App\Models\Finance\Supplier;
use App\Models\Finance\SyaratPembayaran;
use App\Models\Finance\TagihanBiaya;
use App\Models\Finance\TagihanPembelian;
use App\Models\Pegawai;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade as PDF;
// use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Validator;
use phpDocumentor\Reflection\DocBlock\Tag;

class BiayaController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:biaya-list|biaya-create|biaya-edit|biaya-delete', ['only' => ['index','store']]);
         $this->middleware('permission:biaya-create', ['only' => ['create','store']]);
         $this->middleware('permission:biaya-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:biaya-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $month = date("Y-m");
        $day = date("m-d");
        $seluruh_biaya = Biaya::query()->where('company_id', Auth::user()->pegawai->company->id)->sum('total');
        $biaya_bulan_ini = Biaya::query()->where('company_id', Auth::user()->pegawai->company->id)->where('tanggal_transaksi', 'like', '%'. $month .'%' )->sum('grand_total');
        $biaya_hari_ini = Biaya::query()->where('company_id', Auth::user()->pegawai->company->id)->where('tanggal_transaksi', 'like', '%'. $day .'%' )->sum('grand_total');

        if (request()->ajax()) {
            $query = Biaya::query()->where('company_id', Auth::user()->pegawai->company->id)->with(['account_bank', 'metode_pembayarans', 'syarat_pembayarans', 'pegawai', 'supplier', 'detail_biaya', 'tagihan_biaya'])->where('verifikasi', 1)->get();
            // dd($query);
            return DataTables::of($query)
            ->addColumn('aksi', function($item){
                return '<a class="btn btn-primary" href="' . route('biaya.show', $item->id) . '">Detail</a>';
            })
            ->addColumn('status', function($cat){
                if ($cat->status == 1) {
                    return '<div class="text-warning">Open</div>';
                }else{
                    return '<div class="text-success">Paid</div>';
                }
            })
            ->addColumn('penerima', function($pen){
                if ($pen->penerima_pegawai == 0) {
                    $data = $pen->supplier->nama_supplier;
                }else{
                    $data = $pen->pegawai->nama;
                }
                return $data;
            })
            ->addColumn('categori', function($category){
                if ($category->category == '-Terbagi-') {
                    return '<div class="text-dark">-Terbagi-</div>';
                }else{
                    $nama_bank = AccountBank::query()->where('id', $category->category)->get('nama');
                    foreach ($nama_bank as $nam) {
                        $bank = $nam->nama;
                    }
                    return '<div class="text-dark">'. $bank .'</div>';
                }
            })
            ->rawColumns(['status','penerima', 'aksi', 'categori'])
            ->addIndexColumn()
            ->make();
        }

        return view('pages_finance.biaya.index', [
            'seluruh_biaya'     => $seluruh_biaya,
            'biaya_bulan_ini'   => $biaya_bulan_ini,
            'biaya_hari_ini'    => $biaya_hari_ini
        ]);
    }

    public function index_verify()
    {
        // $month = date("Y-m");
        // $day = date("m-d");
        // $seluruh_biaya = Biaya::query()->sum('total');
        // $biaya_bulan_ini = Biaya::query()->where('tanggal_transaksi', 'like', '%'. $month .'%' )->sum('grand_total');
        // $biaya_hari_ini = Biaya::query()->where('tanggal_transaksi', 'like', '%'. $day .'%' )->sum('grand_total');

        if (request()->ajax()) {
            $query = Biaya::query()->where('company_id', Auth::user()->pegawai->company->id)->with(['account_bank', 'metode_pembayarans', 'syarat_pembayarans', 'pegawai', 'supplier', 'detail_biaya', 'tagihan_biaya'])->where('verifikasi', 0)->get();
            // dd($query);
            return DataTables::of($query)
            ->addColumn('aksi', function($item){
                return '
                <div class="button-group d-flex flex-row">
                    <a class="btn btn-primary" href="' . route('biaya.show', $item->id) . '">Detail</a>
                    <a class="btn btn-success ml-2" href="' . route('verify_biaya', $item->id) . '">Verify</a>
                </div>
                ';
            })
            ->addColumn('status', function($cat){
                if ($cat->status == 1) {
                    return '<div class="text-warning">Open</div>';
                }else{
                    return '<div class="text-success">Paid</div>';
                }
            })
            ->addColumn('penerima', function($pen){
                if ($pen->penerima_pegawai == 0) {
                    $data = $pen->supplier->nama_supplier;
                }else{
                    $data = $pen->pegawai->nama;
                }
                return $data;
            })
            ->addColumn('categori', function($category){
                if ($category->category == '-Terbagi-') {
                    return '<div class="text-dark">-Terbagi-</div>';
                }else{
                    $nama_bank = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('id', $category->category)->get('nama');
                    foreach ($nama_bank as $nam) {
                        $bank = $nam->nama;
                    }
                    return '<div class="text-dark">'. $bank .'</div>';
                }
            })
            ->rawColumns(['status','penerima', 'aksi', 'categori'])
            ->addIndexColumn()
            ->make();
        }
    }

    public function verify_biaya($id){
        $update = Biaya::query()->where('id', $id)->update(['varifikasi' => true]);

        if ($update) {
            return redirect()->route('biaya.index')->with(['success' => 'Verifikasi Success']);
        } else {
            return redirect()->route('biaya.index')->with(['error' => 'Verifikasi Gagal']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Biaya::query()->where('company_id', Auth::user()->pegawai->company->id)->count();
        $supplier = Supplier::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $pegawai = Pegawai::all();
        $metode_pembayaran = MetodePembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $syarat_pembayaran = SyaratPembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        // dd($syarat_pembayaran);
        $account_pembayar = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 2)->get();
        $account_biaya = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 15)->orWhere('category', 16)->orWhere('category', 17)->get();
        // dd($account_biaya);
        if ($data == 0) {
            $kode = '10001';
        }else{
            $max_kode = Biaya::query()->where('company_id', Auth::user()->pegawai->company->id)->max('no_biaya');
            $kode = $max_kode+1;
        }

        return view('pages_finance.biaya.create', [
            'kode'                  => $kode,
            'account_pembayar'      => $account_pembayar,
            'account_biaya'         => $account_biaya,
            'metode_pembayaran'     => $metode_pembayaran,
            'syarat_pembayaran'     => $syarat_pembayaran,
            'supplier'              => $supplier,
            'pegawai'               => $pegawai
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // BiayaRequest
    public function store(BiayaRequest $request)
    {
        $data = $request->all();
        $parameter_detail = intVal($request->hitung_row);


        $jumlahRow = $request->hitung_row;

        $array_account = [];
        for ($i = 0; $i <= $jumlahRow ; $i++) {
            $find_account = AccountBank::findOrFail($request->akun_biaya[$i]);

            if ($find_account->reimburse == 1) {
                array_push($array_account, $request->akun_biaya[$i]);
            }
        }

        if (count($array_account) > 0) {
            $verifikasi = false;
        } else {
            $verifikasi = true;
        }

        // kondisi untuk category
        // status 1 untuk open
        // status 2 untuk paid
        if ($parameter_detail > 0) {
            $category = '-Terbagi-';
        }else{
            $category = $request->akun_biaya[0];
        }
        // dd($category);

        // kondisi jika pembayaran dengan cara berhutang
        if ($request->bayar_nanti == "bayar nanti") {
            $status = 1;
            $sisa_tagihan = $request->sisa_tagihan;
        }else{
            $status = 2;
            $sisa_tagihan = 0;

            // update saldo akun
            $update_saldo = AccountBank::query()->where('id', $request->account_pembayar)->get();
            foreach ($update_saldo as $saldo) {
                if($saldo->saldo < $request->grand_total){
                    $akun = $saldo->nama;
                    return redirect()->back()->with(['success' => 'saldo akun ('. $akun .') tidak cukup']);
                }else{
                    AccountBank::where('id', $request->account_pembayar)->update(['saldo'=>$saldo->saldo - $request->grand_total]);
                }
            }
        }

            if (!empty($request->lampiran)) {
                $msg = Biaya::create([
                    'account_pembayar'      => $request->account_pembayar,
                    'bayar_nanti'           => $request->bayar_nanti,
                    'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                    'syarat_pembayaran'     => $request->syarat_pembayaran,
                    'penerima_supplier'     => $request->penerima_supplier,
                    'penerima_pegawai'      => $request->penerima_pegawai,
                    'tanggal_transaksi'     => $request->tanggal_transaksi,
                    'transaksi'             => 'Expense',
                    'no_biaya'              => $request->no_biaya,
                    'metode_pembayaran'     => $request->metode_pembayaran,
                    'alamat_penagihan'      => $request->alamat_penagihan,
                    'memo'                  => $request->memo,
                    'lampiran'              => $request->file('lampiran')->store('assets/dokumen/lampiranBiaya', 'public'),
                    'sub_total'             => $request->sub_total,
                    'total'                 => $request->total_global,
                    'akun_pemotong'         => $request->akun_pemotong,
                    'besar_potongan'        => $request->besar_potongan,
                    'grand_total'           => $request->grand_total,
                    'sisa_tagihan'          => $sisa_tagihan,
                    'category'              => $category,
                    'status'                => $status,
                    'verifikasi'            => $verifikasi,
                    'company_id'            => Auth::user()->pegawai->company->id,
                    'creat_by'                  => Auth::user()->id,
                ]);
            }else{
                $msg = Biaya::create([
                    'account_pembayar'      => $request->account_pembayar,
                    'bayar_nanti'           => $request->bayar_nanti,
                    'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                    'syarat_pembayaran'     => $request->syarat_pembayaran,
                    'penerima_supplier'     => $request->penerima_supplier,
                    'penerima_pegawai'      => $request->penerima_pegawai,
                    'tanggal_transaksi'     => $request->tanggal_transaksi,
                    'transaksi'             => 'Expense',
                    'no_biaya'              => $request->no_biaya,
                    'metode_pembayaran'     => $request->metode_pembayaran,
                    'alamat_penagihan'      => $request->alamat_penagihan,
                    'memo'                  => $request->memo,
                    'sub_total'             => $request->sub_total,
                    'total'                 => $request->total_global,
                    'akun_pemotong'         => $request->akun_pemotong,
                    'besar_potongan'        => $request->besar_potongan,
                    'grand_total'           => $request->grand_total,
                    'sisa_tagihan'          => $sisa_tagihan,
                    'category'              => $category,
                    'status'                => $status,
                    'verifikasi'            => $verifikasi,
                    'company_id'            => Auth::user()->pegawai->company->id,
                    'creat_by'                  => Auth::user()->id,
                ]);
            }

        // get last id inserted
        $idbiaya = DB::getPdo()->lastInsertId();


        // dd($idbiaya);
        if ($msg) {
            for ($i = 0; $i <= $jumlahRow ; $i++) {
                // dd($i);
                $biaya = new DetailBiaya();
                $biaya->biaya_id            = $idbiaya;
                $biaya->akun_biaya          = $request->akun_biaya[$i];
                $biaya->deskripsi           = $request->deskripsi[$i];
                $biaya->pajak_id            = $request->pajak_id[$i];
                $biaya->potongan_pajak      = $request->potongan_pajak[$i];
                $biaya->jumlah              = $request->jumlah[$i];
                $biaya->creat_by            = Auth::user()->id;
                $biaya->creat_by_company    = Auth::user()->pegawai->company->id;
                $saveDetail = $biaya->save();
            }
        }


        if ($saveDetail) {
            for ($j = 0; $j <= $jumlahRow ; $j++) {
                $jurnal = new JurnalEntry();
                $jurnal->transaksi_id           = $idbiaya;
                $jurnal->account_id         = $request->akun_biaya[$j];
                $jurnal->tanggal_transaksi  = $request->tanggal_transaksi;
                $jurnal->debit              = $request->jumlah[$j];
                $jurnal->kredit             = 0;
                $jurnal->category           = 3;
                $jurnal->tahapan            = 1;
                $jurnal->keterangan         = NULL;
                $jurnal->creat_by           = Auth::user()->id;
                $jurnal->creat_by_company   = Auth::user()->pegawai->company->id;
                $saveJurnal = $jurnal->save();

                $JE_L_1 = DB::getPdo()->lastInsertId();

                jurnal_penyesuaian::create([
                    'jurnal_entry_id' => $JE_L_1
                ]);

                $get_account_beban = AccountBank::query()->where('id', $request->akun_biaya[$j])->get();
                foreach ($get_account_beban as $abeban) {
                    AccountBank::query()->where('id', $request->akun_biaya[$j])->update(['saldo'=>$abeban->saldo + $request->jumlah[$j]]);
                }
            }

            if ($request->bayar_nanti == "bayar nanti") {
                $get_rules_jurnal_entry_kredit = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 3)->where('rules_jurnal_category_2', 2)->get();
                foreach ($get_rules_jurnal_entry_kredit as $grjek) {
                    $account_id = $grjek->rules_jurnal_akun_kredit;
                }

                $get_rules_jurnal_entry_ppn = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 3)->where('rules_jurnal_category_2', 2)->get();
                foreach ($get_rules_jurnal_entry_ppn as $grjep) {
                    $id_akun_ppn = $grjep->rules_jurnal_akun_ppn;
                }
            }else{
                $get_rules_jurnal_entry_ppn = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 3)->where('rules_jurnal_category_2', 1)->get();
                foreach ($get_rules_jurnal_entry_ppn as $grjep) {
                    $id_akun_ppn = $grjep->rules_jurnal_akun_ppn;
                }
                $account_id = $request->account_pembayar;
            }

            if ($request->potongan_pajak_display > 0) {
                $pajak = new JurnalEntry();
                $pajak->transaksi_id       = $idbiaya;
                $pajak->account_id         = $id_akun_ppn;
                $pajak->tanggal_transaksi  = $request->tanggal_transaksi;
                $pajak->debit              = $request->potongan_pajak_display;
                $pajak->kredit             = 0;
                $pajak->category           = 3;
                $pajak->tahapan            = 1;
                $pajak->keterangan         = NULL;
                $pajak->creat_by           = Auth::user()->id;
                $pajak->creat_by_company   = Auth::user()->pegawai->company->id;
                $saveJurnal = $pajak->save();

                $JE_L_2 = DB::getPdo()->lastInsertId();

                jurnal_penyesuaian::create([
                    'jurnal_entry_id' => $JE_L_2
                ]);

                $get_account_pajak = AccountBank::query()->where('id', $id_akun_ppn)->get();
                foreach ($get_account_pajak as $apajak) {
                    AccountBank::query()->where('id', $id_akun_ppn)->update(['saldo'=>$apajak->saldo + $request->potongan_pajak_display]);
                }
            }



            if ($request->besar_potongan > 0) {
                $kredit_akun = $request->grand_total;
            }else{
                $kredit_akun = $request->total_global;
            }

            if ($request->besar_potongan > 0) {
                $akun_cabang = new JurnalEntry();
                $akun_cabang->transaksi_id       = $idbiaya;
                $akun_cabang->account_id         = $request->akun_pemotong;
                $akun_cabang->tanggal_transaksi  = $request->tanggal_transaksi;
                $akun_cabang->debit              = 0;
                $akun_cabang->kredit             = $request->besar_potongan;
                $akun_cabang->category           = 3;
                $akun_cabang->tahapan            = 1;
                $akun_cabang->keterangan         = NULL;
                $akun_cabang->creat_by           = Auth::user()->id;
                $akun_cabang->creat_by_company   = Auth::user()->pegawai->company->id;
                $saveJurnal = $akun_cabang->save();

                $JE_L_3 = DB::getPdo()->lastInsertId();

                jurnal_penyesuaian::create([
                    'jurnal_entry_id' => $JE_L_3
                ]);

                $get_account_pemotong = AccountBank::query()->where('id', $request->akun_pemotong)->get();
                foreach ($get_account_pemotong as $apemotong) {
                    AccountBank::query()->where('id', $request->akun_pemotong)->update(['saldo'=>$apemotong->saldo - $request->besar_potongan]);
                }
            }

            $hutang_usaha = new JurnalEntry();
            $hutang_usaha->transaksi_id       = $idbiaya;
            $hutang_usaha->account_id         = $account_id;
            $hutang_usaha->tanggal_transaksi  = $request->tanggal_transaksi;
            $hutang_usaha->debit              = 0;
            $hutang_usaha->kredit             = $kredit_akun;
            $hutang_usaha->category           = 3;
            $hutang_usaha->tahapan            = 1;
            $hutang_usaha->keterangan         = NULL;
            $hutang_usaha->creat_by           = Auth::user()->id;
            $hutang_usaha->creat_by_company   = Auth::user()->pegawai->company->id;
            $saveJurnal = $hutang_usaha->save();

            $JE_L_4 = DB::getPdo()->lastInsertId();

            jurnal_penyesuaian::create([
                'jurnal_entry_id' => $JE_L_4
            ]);

            $get_account_hutang = AccountBank::query()->where('id', $account_id)->get();
                foreach ($get_account_hutang as $ahutang) {
                    AccountBank::query()->where('id', $account_id)->update(['saldo'=>$ahutang->saldo - $kredit_akun]);
                }
        }

        if ($saveJurnal) {
            $data = Biaya::findOrFail($idbiaya);
            return redirect()->route('biaya.show', $data)->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('biaya.index')->with(['error' => 'Data Gagal Diupload']);
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
        $data = Biaya::findOrFail($id);
        // dd($data->id);
        $data_detail = DetailBiaya::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('biaya_id', $data->id)->get();
        $pajak = DetailBiaya::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('biaya_id', $data->id)->sum('potongan_pajak');

        $jurnal_entry = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 3)->where('tahapan', 1)->get();
        $sum_jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 3)->where('tahapan', 1)->sum('debit');
        $sum_jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 3)->where('tahapan', 1)->sum('kredit');
        return view('pages_finance.biaya.detail', [
            'data'=> $data,
            'data_detail'=> $data_detail,
            'pajak' => $pajak,
            'jurnal_entry'=> $jurnal_entry,
            'sum_jurnal_debit'=> $sum_jurnal_debit,
            'sum_jurnal_kredit'=> $sum_jurnal_kredit
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
        $data = Biaya::findOrFail($id);
        $detail_biayas = DetailBiaya::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('biaya_id', $id)->get();
        // dd($detail_biayas);
        $supplier = Supplier::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $pegawai = Pegawai::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $metode_pembayaran = MetodePembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $syarat_pembayaran = SyaratPembayaran::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $account_pembayars = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 2)->get();
        $pajak = Pajak::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $account_biaya = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 15)->orWhere('category', 16)->orWhere('category', 17)->get();
        $besar_potongan = DetailBiaya::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('biaya_id', $id)->sum('potongan_pajak');

        return view('pages_finance.biaya.edit', [
            'data'                  => $data,
            'account_pembayars'      => $account_pembayars,
            'account_biaya'         => $account_biaya,
            'metode_pembayaran'     => $metode_pembayaran,
            'syarat_pembayaran'     => $syarat_pembayaran,
            'supplier'              => $supplier,
            'pegawai'               => $pegawai,
            'besar_potongan'        => $besar_potongan,
            'detail_biayas'          => $detail_biayas,
            'pajak'                 => $pajak
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
        $data = $request->all();
        $item = Biaya::findOrFail($id);
        $parameter_detail = $request->hitung_row;

        $jumlahRow = $request->hitung_row;

        $array_account = [];
        for ($i = 0; $i <= $jumlahRow ; $i++) {
            $find_account = AccountBank::findOrFail($request->akun_biaya[$i]);

            if ($find_account->reimburse == 1) {
                array_push($array_account, $request->akun_biaya[$i]);
            }
        }

        if (count($array_account) > 0) {
            $verifikasi = false;
        } else {
            $verifikasi = true;
        }
        // dd('duka atu');
        if ($parameter_detail >= 0) {
            $category = '-Terbagi-';
            // dd('naha');
        }else{
            // dd('duka atu');
            $category = $request->akun_biaya[0];
        }

        // kondisi jika pembayaran dengan cara berhutang
        if ($request->bayar_nanti == "bayar nanti") {
            $status = 1;
            $sisa_tagihan = $request->sisa_tagihan;
        }else{
            $status = 2;
            $sisa_tagihan = 0;

            $get_data_old = Biaya::query()->where('id', $id)->get();
            foreach ($get_data_old as $old) {
                if ($old->account_pembayar == $request->account_pembayar) {
                    $update_saldo_old = AccountBank::query()->where('id', $old->account_pembayar)->get();
                    foreach ($update_saldo_old as $saldo_old) {
                        // AccountBank::where('id', $saldo_old->account_pembayar)->update(['saldo'=>$saldo_old->saldo + $request->grand_total]);
                    }

                    $update_saldo = AccountBank::query()->where('id', $request->account_pembayar)->get();
                    foreach ($update_saldo as $saldo) {
                        if($saldo->saldo < $request->grand_total){
                            $akun = $saldo->nama;
                            return redirect()->back()->with(['success' => 'saldo akun ('. $akun .') tidak cukup']);
                        }else{
                            AccountBank::where('id', $request->account_pembayar)->update(['saldo'=>$saldo_old->saldo + $old->grand_total - $request->grand_total]);
                            dd($saldo_old->saldo + $old->grand_total - $request->grand_total);
                        }
                    }
                }else{
                    $update_saldo_old = AccountBank::query()->where('id', $old->account_pembayar)->get();
                    foreach ($update_saldo_old as $saldo_old) {
                        AccountBank::where('id', $saldo_old->account_pembayar)->update(['saldo'=>$saldo_old->saldo + $request->grand_total]);
                    }

                    $update_saldo = AccountBank::query()->where('id', $request->account_pembayar)->get();
                    foreach ($update_saldo as $saldo) {
                        if($saldo->saldo < $request->grand_total){
                            $akun = $saldo->nama;
                            return redirect()->back()->with(['success' => 'saldo akun ('. $akun .') tidak cukup']);
                        }else{
                            dd($saldo->saldo - $request->grand_total);
                            AccountBank::where('id', $request->account_pembayar)->update(['saldo'=>$saldo->saldo - $request->grand_total]);
                        }
                    }
                }


            }
        }

            if (!empty($request->lampiran)) {
                Storage::disk('local')->delete('public/'.$request->lampiran_old);
                $msg = $item->update([
                    'account_pembayar'      => $request->account_pembayar,
                    'bayar_nanti'           => $request->bayar_nanti,
                    'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                    'syarat_pembayaran'     => $request->syarat_pembayaran,
                    'penerima_supplier'     => $request->penerima_supplier,
                    'penerima_pegawai'      => $request->penerima_pegawai,
                    'tanggal_transaksi'     => $request->tanggal_transaksi,
                    'transaksi'             => 'Expense',
                    'no_biaya'              => $request->no_biaya,
                    'metode_pembayaran'     => $request->metode_pembayaran,
                    'alamat_penagihan'      => $request->alamat_penagihan,
                    'memo'                  => $request->memo,
                    'lampiran'              => $request->file('lampiran')->store('assets/dokumen/lampiranBiaya', 'public'),
                    'sub_total'             => $request->sub_total,
                    'total'                 => $request->total_global,
                    'akun_pemotong'         => $request->akun_pemotong,
                    'besar_potongan'        => $request->besar_potongan,
                    'grand_total'           => $request->grand_total,
                    'sisa_tagihan'          => $sisa_tagihan,
                    'category'              => $category,
                    'status'                => $status,
                    'verifikasi'            => $verifikasi,
                    'company_id'            => Auth::user()->pegawai->company->id,
                    'creat_by'                  => Auth::user()->id,
                ]);
            }else{
                $msg = $item->update([
                    'account_pembayar'      => $request->account_pembayar,
                    'bayar_nanti'           => $request->bayar_nanti,
                    'tanggal_jatuh_tempo'   => $request->tanggal_jatuh_tempo,
                    'syarat_pembayaran'     => $request->syarat_pembayaran,
                    'penerima_supplier'     => $request->penerima_supplier,
                    'penerima_pegawai'      => $request->penerima_pegawai,
                    'tanggal_transaksi'     => $request->tanggal_transaksi,
                    'transaksi'             => 'Expense',
                    'no_biaya'              => $request->no_biaya,
                    'metode_pembayaran'     => $request->metode_pembayaran,
                    'alamat_penagihan'      => $request->alamat_penagihan,
                    'memo'                  => $request->memo,
                    'sub_total'             => $request->sub_total,
                    'total'                 => $request->total_global,
                    'akun_pemotong'         => $request->akun_pemotong,
                    'besar_potongan'        => $request->besar_potongan,
                    'grand_total'           => $request->grand_total,
                    'sisa_tagihan'          => $sisa_tagihan,
                    'category'              => $category,
                    'status'                => $status,
                    'verifikasi'            => $verifikasi,
                    'company_id'            => Auth::user()->pegawai->company->id,
                    'creat_by'                  => Auth::user()->id,
                ]);
            }


        // $idbiaya = DB::getPdo()->lastInsertId();

        if ($msg) {
            $detailDel = DetailBiaya::where('biaya_id', $id)->delete();
            if ($detailDel) {

                for ($i=0; $i < $parameter_detail+1 ; $i++) {
                    $biaya = new DetailBiaya();
                    $biaya->biaya_id          = $id;
                    $biaya->akun_biaya          = $request->akun_biaya[$i];
                    $biaya->deskripsi           = $request->deskripsi[$i];
                    $biaya->pajak_id            = $request->pajak_id[$i];
                    $biaya->potongan_pajak      = $request->potongan_pajak[$i];
                    $biaya->jumlah              = $request->jumlah[$i];
                    $biaya->creat_by            = Auth::user()->id;
                    $biaya->creat_by_company    = Auth::user()->pegawai->company->id;
                    $saveDetail = $biaya->save();
                }

                if ($saveDetail) {
                    // select jurnal debit by id transaksi
                    $jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 3)->where('tahapan', 1)->where('kredit', 0)->get();
                    foreach ($jurnal_debit as $j_deb) {
                        jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb->id)->delete();
                        $get_account_debit = AccountBank::query()->where('id', $j_deb->account_id)->get();
                        foreach ($get_account_debit as $ad) {
                            AccountBank::query()->where('id', $j_deb->account_id)->update(['saldo'=>$ad->saldo - $j_deb->debit]);
                        }
                    }
                    // select jurnal kredit by id transaksi
                    $jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 3)->where('tahapan', 1)->where('debit', 0)->get();
                    foreach ($jurnal_kredit as $j_kred) {
                        jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred->id)->delete();
                        $get_account_kredit = AccountBank::query()->where('id', $j_kred->account_id)->get();
                        foreach ($get_account_kredit as $ad) {
                            AccountBank::query()->where('id', $j_kred->account_id)->update(['saldo'=>$ad->saldo + $j_kred->kredit]);
                        }
                    }

                    $jurnalEnt = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 3)->delete();
                    if ($jurnalEnt) {
                        for ($j = 0; $j < $parameter_detail+1 ; $j++) {
                            $jurnal = new JurnalEntry();
                            $jurnal->transaksi_id       = $id;
                            $jurnal->account_id         = $request->akun_biaya[$j];
                            $jurnal->tanggal_transaksi  = $request->tanggal_transaksi;
                            $jurnal->debit              = $request->jumlah[$j];
                            $jurnal->kredit             = 0;
                            $jurnal->category           = 3;
                            $jurnal->tahapan            = 1;
                            $jurnal->keterangan         = NULL;
                            $jurnal->creat_by           = Auth::user()->id;
                            $jurnal->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveJurnal = $jurnal->save();

                            $JE_L_1 = DB::getPdo()->lastInsertId();

                            jurnal_penyesuaian::create([
                                'jurnal_entry_id' => $JE_L_1
                            ]);

                            $get_account_beban = AccountBank::query()->where('id', $request->akun_biaya[$j])->get();
                            foreach ($get_account_beban as $abeban) {
                                AccountBank::query()->where('id', $request->akun_biaya[$j])->update(['saldo'=>$abeban->saldo + $request->jumlah[$j]]);
                            }

                        }

                        if ($request->bayar_nanti == "bayar nanti") {
                            $get_rules_jurnal_entry_kredit = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 3)->where('rules_jurnal_category_2', 2)->get();
                            foreach ($get_rules_jurnal_entry_kredit as $grjek) {
                                $account_id = $grjek->rules_jurnal_akun_kredit;
                            }

                            $get_rules_jurnal_entry_ppn = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 3)->where('rules_jurnal_category_2', 2)->get();
                            foreach ($get_rules_jurnal_entry_ppn as $grjep) {
                                $id_akun_ppn = $grjep->rules_jurnal_akun_ppn;
                            }
                        }else{
                            $get_rules_jurnal_entry_ppn = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 3)->where('rules_jurnal_category_2', 1)->get();
                            foreach ($get_rules_jurnal_entry_ppn as $grjep) {
                                $id_akun_ppn = $grjep->rules_jurnal_akun_ppn;
                            }
                            $account_id = $request->account_pembayar;
                        }

                        if ($request->potongan_pajak_display > 0) {
                            $pajak = new JurnalEntry();
                            $pajak->transaksi_id       = $id;
                            $pajak->account_id         = $id_akun_ppn;
                            $pajak->tanggal_transaksi  = $request->tanggal_transaksi;
                            $pajak->debit              = $request->potongan_pajak_display;
                            $pajak->kredit             = 0;
                            $pajak->category           = 3;
                            $pajak->tahapan            = 1;
                            $pajak->keterangan         = NULL;
                            $pajak->creat_by           = Auth::user()->id;
                            $pajak->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveJurnal = $pajak->save();

                            $JE_L_2 = DB::getPdo()->lastInsertId();

                            jurnal_penyesuaian::create([
                                'jurnal_entry_id' => $JE_L_2
                            ]);

                            $get_account_pajak = AccountBank::query()->where('id', $id_akun_ppn)->get();
                            foreach ($get_account_pajak as $apajak) {
                                AccountBank::query()->where('id', $id_akun_ppn)->update(['saldo'=>$apajak->saldo + $request->potongan_pajak_display]);
                            }
                        }

                        if ($request->besar_potongan > 0) {
                            $kredit_akun = $request->grand_total;
                        }else{
                            $kredit_akun = $request->total_global;
                        }

                        if ($request->besar_potongan > 0) {
                            $akun_cabang = new JurnalEntry();
                            $akun_cabang->transaksi_id       = $id;
                            $akun_cabang->account_id         = $request->akun_pemotong;
                            $akun_cabang->tanggal_transaksi  = $request->tanggal_transaksi;
                            $akun_cabang->debit              = 0;
                            $akun_cabang->kredit             = $request->besar_potongan;
                            $akun_cabang->category           = 3;
                            $akun_cabang->tahapan            = 1;
                            $akun_cabang->keterangan         = NULL;
                            $akun_cabang->creat_by           = Auth::user()->id;
                            $akun_cabang->creat_by_company   = Auth::user()->pegawai->company->id;
                            $saveJurnal = $akun_cabang->save();

                            $JE_L_3 = DB::getPdo()->lastInsertId();

                            jurnal_penyesuaian::create([
                                'jurnal_entry_id' => $JE_L_3
                            ]);

                            $get_account_pemotong = AccountBank::query()->where('id', $request->akun_pemotong)->get();
                            foreach ($get_account_pemotong as $apemotong) {
                                AccountBank::query()->where('id', $request->akun_pemotong)->update(['saldo'=>$apemotong->saldo - $request->besar_potongan]);
                            }

                        }

                        $hutang_usaha = new JurnalEntry();
                        $hutang_usaha->transaksi_id       = $id;
                        $hutang_usaha->account_id         = $account_id;
                        $hutang_usaha->tanggal_transaksi  = $request->tanggal_transaksi;
                        $hutang_usaha->debit              = 0;
                        $hutang_usaha->kredit             = $kredit_akun;
                        $hutang_usaha->category           = 3;
                        $hutang_usaha->tahapan            = 1;
                        $hutang_usaha->keterangan         = NULL;
                        $hutang_usaha->creat_by           = Auth::user()->id;
                        $hutang_usaha->creat_by_company   = Auth::user()->pegawai->company->id;
                        $saveJurnal = $hutang_usaha->save();

                        $JE_L_4 = DB::getPdo()->lastInsertId();

                        jurnal_penyesuaian::create([
                            'jurnal_entry_id' => $JE_L_4
                        ]);

                        $get_account_hutang = AccountBank::query()->where('id', $account_id)->get();
                        foreach ($get_account_hutang as $ahutang) {
                            AccountBank::query()->where('id', $account_id)->update(['saldo'=>$ahutang->saldo - $kredit_akun]);
                        }

                    }
                }
            }

        }

        if ($saveJurnal) {
            $data = Biaya::findOrFail($id);
            return redirect()->route('biaya.show', $data)->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('biaya.index')->with(['error' => 'Data Gagal Diupload']);
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
        $data = Biaya::findOrFail($id);

        $file = $data->lampiran;
        // dd($file);

        $detailDelete = DetailBiaya::where('biaya_id', $id)->delete();

        if ($detailDelete) {
            // select jurnal debit by id transaksi
            $jurnal_debit = JurnalEntry::query()->where('transaksi_id', $id)->where('category', 3)->where('tahapan', 1)->where('kredit', 0)->get();
            foreach ($jurnal_debit as $j_deb) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb->id)->delete();
                $get_account_debit = AccountBank::query()->where('id', $j_deb->account_id)->get();
                foreach ($get_account_debit as $ad) {
                    AccountBank::query()->where('id', $j_deb->account_id)->update(['saldo'=>$ad->saldo - $j_deb->debit]);
                }
            }
            // select jurnal kredit by id transaksi
            $jurnal_kredit = JurnalEntry::query()->where('transaksi_id', $id)->where('category', 3)->where('tahapan', 1)->where('debit', 0)->get();
            foreach ($jurnal_kredit as $j_kred) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred->id)->delete();
                $get_account_kredit = AccountBank::query()->where('id', $j_kred->account_id)->get();
                foreach ($get_account_kredit as $ad) {
                    AccountBank::query()->where('id', $j_kred->account_id)->update(['saldo'=>$ad->saldo + $j_kred->kredit]);
                }
            }
            $jurnalDelete = JurnalEntry::query()->where('transaksi_id', $id)->where('category', 3)->delete();
        }

        if ($jurnalDelete) {
            if ($file == NULL) {
                $msg = $data->delete();
            }else{
                Storage::disk('local')->delete('public/'.$file);
                $msg = $data->delete();
            }
        }

        if ($msg) {
            return redirect()->route('biaya.index')->with(['success' => 'Data Berhasil Dihapus']);
        }else {
            return redirect()->route('biaya.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }


    public function get_akun_biaya(){
        $akun_biaya = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 15)->orWhere('category', 16)->orWhere('category', 17)->get();
        return response()->json($akun_biaya);
    }

    public function showBayar($id){
        $data = Biaya::findOrFail($id);
        // dd($data);
        $bank = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 2)->get();
        return view('pages_finance.biaya.showTagihan', [
            'data'  => $data,
            'bank'  => $bank
        ]);
    }

    public function show_jurnal($id)
    {
        $data = TagihanBiaya::findOrFail($id);

        $data_detail = TagihanBiaya::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('id', $id)->get();
        $pajak = DetailBiaya::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('biaya_id', $id)->sum('potongan_pajak');

        $jurnal_entry = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 3)->where('tahapan', 2)->get();
        $sum_jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 3)->where('tahapan', 2)->sum('debit');
        $sum_jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 3)->where('tahapan', 2)->sum('kredit');
        return view('pages_finance.biaya.show_jurnal', [
            'data'=> $data,
            'data_detail'=> $data_detail,
            'pajak' => $pajak,
            'jurnal_entry'=> $jurnal_entry,
            'sum_jurnal_debit'=> $sum_jurnal_debit,
            'sum_jurnal_kredit'=> $sum_jurnal_kredit,
        ]);
    }

    public function bayar_cicilan_biaya(Request $request){
        $request->validate([
            'nominal_bayar' => 'required',
            'tanggal_bayar' => 'required|date',
        ]);

        $data = TagihanBiaya::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->count();
        if ($data == 0) {
            $kode = '10001';
        }else{
            $max_kode = TagihanBiaya::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->max('no_pembayaran');
            $kode = $max_kode+1;
        }


        $bayar_biaya = new TagihanBiaya();
        $bayar_biaya->biaya_id            = $request->id_biaya;
        $bayar_biaya->tanggal_bayar          = $request->tanggal_bayar;
        $bayar_biaya->account_pembayar      = $request->account_pembayar;
        $bayar_biaya->nominal_bayar           = $request->nominal_bayar;
        $bayar_biaya->transaksi            = 'Bank Withdrawal';
        $bayar_biaya->no_pembayaran      = $kode;
        $bayar_biaya->keterangan      = $request->keterangan;
        $bayar_biaya->creat_by           = Auth::user()->id;
        $bayar_biaya->creat_by_company   = Auth::user()->pegawai->company->id;
        $savePembayaran = $bayar_biaya->save();

        $id_last = DB::getPdo()->lastInsertId();

        if ($savePembayaran) {
            $idPembelian = $request->id_biaya;
            $potongan = $request->sisa_tagihan2 - $request->nominal_bayar;
            // dd($potongan);
            if ($potongan > 0) {
                $update_Biaya = Biaya::where('id', $idPembelian)->update(['sisa_tagihan'=>$potongan]);
            }else{
                $update_Biaya = Biaya::where('id', $idPembelian)->update(['sisa_tagihan'=>0, 'status'=>2]);
            }
        }

        if ($update_Biaya) {

            $get_rules_jurnal_entry_debit = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 3)->where('rules_jurnal_category_2', 3)->get();
            foreach ($get_rules_jurnal_entry_debit as $grjed) {
                $account_id = $grjed->rules_jurnal_akun_debit;
            }

            // update saldo hutang usaha
            $bank_hut_usaha = AccountBank::query()->where('id', $account_id)->get('saldo');
            foreach ($bank_hut_usaha as $h) {
                $pengurangan_saldo_hutang = $h->saldo + $request->nominal_bayar;
                AccountBank::query()->where('id', $account_id)->update(['saldo'=>$pengurangan_saldo_hutang]);
            }
            $jurnal_entri1 = new JurnalEntry();
            $jurnal_entri1->transaksi_id       = $id_last;
            $jurnal_entri1->account_id         = $account_id;
            $jurnal_entri1->tanggal_transaksi  = $request->tanggal_bayar;
            $jurnal_entri1->debit              = $request->nominal_bayar;
            $jurnal_entri1->kredit             = 0;
            $jurnal_entri1->category           = 3;
            $jurnal_entri1->tahapan            = 2;
            $jurnal_entri1->keterangan         = NULL;
            $jurnal_entri1->creat_by           = Auth::user()->id;
            $jurnal_entri1->creat_by_company   = Auth::user()->pegawai->company->id;
            $saveJurnal = $jurnal_entri1->save();

            $JE_L_1 = DB::getPdo()->lastInsertId();

            jurnal_penyesuaian::create([
                'jurnal_entry_id' => $JE_L_1
            ]);

            $data_bank_pembayar = AccountBank::query()->where('id', $request->account_pembayar)->get('saldo');
            foreach ($data_bank_pembayar as $b) {
                $pengurangan_saldo = $b->saldo - $request->nominal_bayar;
                AccountBank::query()->where('id', $request->account_pembayar)->update(['saldo'=>$pengurangan_saldo]);
            }
            $jurnal_entri = new JurnalEntry();
            $jurnal_entri->transaksi_id           = $id_last;
            $jurnal_entri->account_id         = $request->account_pembayar;
            $jurnal_entri->tanggal_transaksi  = $request->tanggal_bayar;
            $jurnal_entri->debit              = 0;
            $jurnal_entri->kredit             = $request->nominal_bayar;
            $jurnal_entri->category           = 3;
            $jurnal_entri->tahapan            = 2;
            $jurnal_entri->keterangan         = NULL;
            $jurnal_entri->creat_by           = Auth::user()->id;
            $jurnal_entri->creat_by_company   = Auth::user()->pegawai->company->id;
            $saveJurnal = $jurnal_entri->save();

            $JE_L_2 = DB::getPdo()->lastInsertId();

            jurnal_penyesuaian::create([
                'jurnal_entry_id' => $JE_L_2
            ]);
        }

        if ($saveJurnal) {
            $data = TagihanBiaya::findOrFail($id_last);
            return redirect()->route('showjurnal', $data)->with(['success' => 'Pembayaran Berhasil']);
        } else {
            return redirect()->route('biaya.index')->with(['error' => 'Pembayaran Gagal']);
        }

    }

    public function cetak_pdf()
    {
    	$data = Biaya::query()->with(['account_bank', 'metode_pembayarans', 'syarat_pembayarans', 'pegawai', 'supplier', 'detail_biaya'])->get();

    	$pdf = PDF::loadview('pages_finance.biaya.cetak_pdf',['data'=>$data])->setOptions(['defaultFont' => 'sans-serif', 'debugCss'=> true]);
    	return $pdf->stream('cetakPDFbiaya.pdf');
    }

    public function lacak_pembayaran_biaya($id){
        $data = TagihanBiaya::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('biaya_id', $id)->with(['biaya'])->get();

        return view('pages_finance.biaya.lacakPembayaran', [
            'data'  => $data,
            'idData'    => $id
        ]);
    }

    public function delete_pembayaran_biaya(Request $request, $id){
        $idBiaya = $request->id_biaya;
        $nominal_bayar = $request->nominal_bayar;

        $get_rules_jurnal_entry_debit = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 3)->where('rules_jurnal_category_2', 3)->get();
        foreach ($get_rules_jurnal_entry_debit as $grjed) {
            $account_id = $grjed->rules_jurnal_akun_debit;
        }

            // update saldo akun hutang usaha
            $get_jurnal_hutang = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $idBiaya)->where('account_id', $account_id)->where('category', 3)->where('tahapan', 2)->get();
            foreach ($get_jurnal_hutang as $jhutang) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $jhutang->id)->delete();
                $get_account_hutang = AccountBank::query()->where('id', $account_id)->get();
                foreach ($get_account_hutang as $ahutang) {
                    AccountBank::query()->where('id', $account_id)->update(['saldo'=>$ahutang->saldo - $jhutang->debit]);
                }
            }

            // update saldo account pembayar
            $get_jurnal_bayar = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $idBiaya)->where('account_id', $request->account_bayar)->where('category', 3)->where('tahapan', 2)->get();
            foreach ($get_jurnal_bayar as $jbayar) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $jbayar->id)->delete();
                $get_account_bayar = AccountBank::query()->where('id', $request->account_bayar)->get();
                foreach ($get_account_bayar as $abayar) {
                    AccountBank::query()->where('id', $request->account_bayar)->update(['saldo'=>$abayar->saldo + $jbayar->kredit]);
                }
            }

            // delete jurnall entry
            JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $idBiaya)->where('category', 3)->where('tahapan', 2)->delete();

            // update sisa tagihan
            $get_data_biaya = Biaya::query()->where('company_id', Auth::user()->pegawai->company->id)->where('id', $idBiaya)->get();
            foreach ($get_data_biaya as $idb) {
                $penyesuaian = $idb->sisa_tagihan + $nominal_bayar;
                // dd($penyesuaian);
                if ($penyesuaian > 0) {
                    Biaya::query()->where('id', $idBiaya)->update(['sisa_tagihan'=>$penyesuaian, 'status'=>1]);
                }else{
                    Biaya::query()->where('id', $idBiaya)->update(['sisa_tagihan'=>0, 'status'=>2]);
                }
            }

            // delete pembyaran
            $msg = TagihanBiaya::where('id', $id)->delete();

            if ($msg) {
                return redirect()->route('lacak_pembayaran_biaya', $idBiaya)->with(['success' => 'Data Berhasil Dihapus']);
            }else {
                return redirect()->route('lacak_pembayaran_biaya', $idBiaya)->with(['error' => 'Data Gagal Dihapus']);
            }
    }
}
