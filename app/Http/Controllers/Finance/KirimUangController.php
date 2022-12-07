<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\KirimUangRequest;
use App\Models\Finance\AccountBank;
use App\Models\Finance\DetailKirimUang;
use App\Models\Finance\jurnal_penyesuaian;
use App\Models\Finance\JurnalEntry;
use App\Models\Finance\KirimUang;
use App\Models\Finance\Pajak;
use App\Models\Finance\RulesJurnalInput;
use App\Models\Finance\Supplier;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class KirimUangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            // $query = KirimUang::query()->with(['account_bank', 'supplier', 'pegawais'])->get();
            $query = KirimUang::query()->with(['account_bank', 'supplier', 'pegawais'])->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

            // dd($query);
            return DataTables::of($query)
            ->addColumn('aksi', function($item){
                return '<a class="btn btn-primary" href="' . route('kirimuang.show', $item->id) . '">Detail</a>';
            })
            ->rawColumns(['aksi'])
            ->addIndexColumn()
            ->make();
        }

        return view('pages_finance.kas&bank.kirimuang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = KirimUang::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->count();
        $supplier = Supplier::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        // $pegawai = Pegawai::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

        $pegawai = Pegawai::all();

        $account_pembayar = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 2)->get();
        if ($data == 0) {
            $kode = '10001';
        }else{
            $max_kode = KirimUang::query()->max('no_transaksi');
            $kode = $max_kode+1;
        }

        return view('pages_finance.kas&bank.kirimuang.create', [
            'kode'                  => $kode,
            'account_pembayar'      => $account_pembayar,
            // 'account_pemotong'         => $account_pemotong,
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
    public function store(KirimUangRequest $request)
    {
        $data = $request->all();

        $update_saldo = AccountBank::query()->where('id', $request->account_pembayar)->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
            foreach ($update_saldo as $saldo) {
                if($saldo->saldo < $request->grand_total){
                    $akun = $saldo->nama;
                    return redirect()->back()->with(['error' => 'saldo akun ('. $akun .') tidak cukup']);
                }
            }

        if ($request->besar_potongan > 0) {
            $update_pemotong = AccountBank::query()->where('id', $request->akun_pemotong)->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
            foreach ($update_pemotong as $saldo_pemotong) {
                if($saldo_pemotong->saldo < $request->grand_total){
                    $akun_pemotong = $saldo_pemotong->nama;
                    return redirect()->back()->with(['error' => 'saldo akun ('. $akun_pemotong .') tidak cukup']);
                }
            }
        }

        if (!empty($request->lampiran)) {
            $msg = KirimUang::create([
                'account_pembayar'      => $request->account_pembayar,
                'penerima_supplier'     => $request->penerima_supplier,
                'penerima_pegawai'      => $request->penerima_pegawai,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'transaksi'             => 'Bank Withdrawal',
                'no_transaksi'          => $request->no_transaksi,
                'memo'                  => $request->memo,
                'lampiran'              => $request->file('lampiran')->store('assets/dokumen/kasBank/lampiranKirUang', 'public'),
                'sub_total'             => $request->sub_total,
                'total'                 => $request->total_global,
                'akun_pemotong'         => $request->akun_pemotong,
                'besar_potongan'        => $request->besar_potongan,
                'grand_total'           => $request->grand_total,
                'creat_by'                  => Auth::user()->id,
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }else{
            $msg = KirimUang::create([
                'account_pembayar'      => $request->account_pembayar,
                'penerima_supplier'     => $request->penerima_supplier,
                'penerima_pegawai'      => $request->penerima_pegawai,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'transaksi'             => 'Bank Withdrawal',
                'no_transaksi'          => $request->no_transaksi,
                'memo'                  => $request->memo,
                'sub_total'             => $request->sub_total,
                'total'                 => $request->total_global,
                'akun_pemotong'         => $request->akun_pemotong,
                'besar_potongan'        => $request->besar_potongan,
                'grand_total'           => $request->grand_total,
                'creat_by'                  => Auth::user()->id,
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }

        $idKirimUang = DB::getPdo()->lastInsertId();

        $jumlahRow = $request->hitung_row;

        if ($msg) {
            for ($i = 0; $i <= $jumlahRow ; $i++) {
                $kirim_uang = new DetailKirimUang();
                $kirim_uang->kirim_uangs_id       = $idKirimUang;
                $kirim_uang->akun_tujuan          = $request->akun_tujuan[$i];
                $kirim_uang->deskripsi           = $request->deskripsi[$i];
                $kirim_uang->pajak_id            = $request->pajak_id[$i];
                $kirim_uang->potongan_pajak      = $request->potongan_pajak[$i];
                $kirim_uang->jumlah              = $request->jumlah[$i];
                $kirim_uang->creat_by            = Auth::user()->id;
                $kirim_uang->creat_by_company    = Auth::user()->pegawai->company->id;
                $saveDetail = $kirim_uang->save();
            }
        }

        if ($saveDetail) {
            for ($j = 0; $j <= $jumlahRow ; $j++) {
                $akun_tujuan = new JurnalEntry();
                $akun_tujuan->transaksi_id       = $idKirimUang;
                $akun_tujuan->account_id         = $request->akun_tujuan[$j];
                $akun_tujuan->tanggal_transaksi  = $request->tanggal_transaksi;
                $akun_tujuan->debit              = $request->jumlah[$j];
                $akun_tujuan->kredit             = 0;
                $akun_tujuan->category           = 4;
                $akun_tujuan->tahapan            = 1;
                $akun_tujuan->keterangan         = NULL;
                $akun_tujuan->creat_by           = Auth::user()->id;
                $akun_tujuan->creat_by_company   = Auth::user()->pegawai->company->id;
                $saveJurnal = $akun_tujuan->save();

                $JE_L_1 = DB::getPdo()->lastInsertId();

                jurnal_penyesuaian::create([
                    'jurnal_entry_id' => $JE_L_1
                ]);

                $get_account_tujuan = AccountBank::query()->where('id', $request->akun_tujuan[$j])->get();
                foreach ($get_account_tujuan as $atujuan) {
                    AccountBank::query()->where('id', $request->akun_tujuan[$j])->update(['saldo'=>$atujuan->saldo + $request->jumlah[$j]]);
                }
            }

            if ($request->potongan_pajak_display > 0) {

                $get_rules_jurnal_entry_ppn = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 4)->where('rules_jurnal_category_2', 1)->get();
                foreach ($get_rules_jurnal_entry_ppn as $grjep) {
                    $id_akun_ppn = $grjep->rules_jurnal_akun_ppn;
                }

                $pajak = new JurnalEntry();
                $pajak->transaksi_id       = $idKirimUang;
                $pajak->account_id         = $id_akun_ppn;
                $pajak->tanggal_transaksi  = $request->tanggal_transaksi;
                $pajak->debit              = $request->potongan_pajak_display;
                $pajak->kredit             = 0;
                $pajak->category           = 4;
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
                $akun_pemotong = new JurnalEntry();
                $akun_pemotong->transaksi_id       = $idKirimUang;
                $akun_pemotong->account_id         = $request->akun_pemotong;
                $akun_pemotong->tanggal_transaksi  = $request->tanggal_transaksi;
                $akun_pemotong->debit              = 0;
                $akun_pemotong->kredit             = $request->besar_potongan;
                $akun_pemotong->category           = 4;
                $akun_pemotong->tahapan            = 1;
                $akun_pemotong->keterangan         = NULL;
                $akun_pemotong->creat_by           = Auth::user()->id;
                $akun_pemotong->creat_by_company   = Auth::user()->pegawai->company->id;
                $saveJurnal = $akun_pemotong->save();

                $JE_L_3 = DB::getPdo()->lastInsertId();

                jurnal_penyesuaian::create([
                    'jurnal_entry_id' => $JE_L_3
                ]);

                $get_account_pemotong = AccountBank::query()->where('id', $request->akun_pemotong)->get();
                foreach ($get_account_pemotong as $apemotong) {
                    AccountBank::query()->where('id', $request->akun_pemotong)->update(['saldo'=>$apemotong->saldo - $request->besar_potongan]);
                }
            }

            if ($request->besar_potongan > 0) {
                $kredit_akun = $request->grand_total;
            }else{
                $kredit_akun = $request->total_global;
            }

            $akun_pembayar = new JurnalEntry();
            $akun_pembayar->transaksi_id       = $idKirimUang;
            $akun_pembayar->account_id         = $request->account_pembayar;
            $akun_pembayar->tanggal_transaksi  = $request->tanggal_transaksi;
            $akun_pembayar->debit              = 0;
            $akun_pembayar->kredit             = $kredit_akun;
            $akun_pembayar->category           = 4;
            $akun_pembayar->tahapan            = 1;
            $akun_pembayar->keterangan         = NULL;
            $akun_pembayar->creat_by           = Auth::user()->id;
            $akun_pembayar->creat_by_company   = Auth::user()->pegawai->company->id;
            $saveJurnal = $akun_pembayar->save();

            $JE_L_4 = DB::getPdo()->lastInsertId();

                jurnal_penyesuaian::create([
                    'jurnal_entry_id' => $JE_L_4
                ]);

            $get_account_pembayar = AccountBank::query()->where('id', $request->account_pembayar)->get();
            foreach ($get_account_pembayar as $apembayar) {
                AccountBank::query()->where('id', $request->account_pembayar)->update(['saldo'=>$apembayar->saldo - $kredit_akun]);
            }


        }

        if ($saveJurnal) {
            $data = KirimUang::findOrFail($idKirimUang);
            return redirect()->route('kirimuang.show', $data)->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('kasbank.index')->with(['error' => 'Data Gagal Diupload']);
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
        $data = KirimUang::findOrFail($id);
        $data_detail = DetailKirimUang::query()->where('kirim_uangs_id', $data->id)->get();
        $pajak = DetailKirimUang::query()->where('kirim_uangs_id', $data->id)->sum('potongan_pajak');

        $jurnal_entry = JurnalEntry::query()->where('transaksi_id', $data->id)->where('category', 4)->where('tahapan', 1)->orderBy('id', 'asc')->get();
        $sum_jurnal_debit = JurnalEntry::query()->where('transaksi_id', $data->id)->where('category', 4)->where('tahapan', 1)->sum('debit');
        $sum_jurnal_kredit = JurnalEntry::query()->where('transaksi_id', $data->id)->where('category', 4)->where('tahapan', 1)->sum('kredit');
        return view('pages_finance.kas&bank.kirimuang.detail', [
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
        $data = KirimUang::findOrFail($id);
        $detail_kirim_uang = DetailKirimUang::query()->where('kirim_uangs_id', $id)->get();
        // dd($detail_biayas);
        $supplier = Supplier::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        // $pegawai = Pegawai::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $pegawai = Pegawai::all();
        $account_pembayars = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $pajak = Pajak::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

        $besar_potongan = DetailKirimUang::query()->where('kirim_uangs_id', $id)->sum('potongan_pajak');

        return view('pages_finance.kas&bank.kirimuang.edit', [
            'data'                  => $data,
            'account_pembayars'     => $account_pembayars,
            'supplier'              => $supplier,
            'pegawai'               => $pegawai,
            'besar_potongan'        => $besar_potongan,
            'detail_kirim_uang'     => $detail_kirim_uang,
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
    public function update(KirimUangRequest $request, $id)
    {
        $data = $request->all();
        $item = KirimUang::findOrFail($id);

        $update_saldo = AccountBank::query()->where('id', $request->account_pembayar)->get();
            foreach ($update_saldo as $saldo) {
                if($saldo->saldo < $request->grand_total){
                    $akun = $saldo->nama;
                    return redirect()->back()->with(['error' => 'saldo akun ('. $akun .') tidak cukup']);

                }
            }

        if ($request->besar_potongan > 0) {
            $update_pemotong = AccountBank::query()->where('id', $request->akun_pemotong)->get();
            foreach ($update_pemotong as $saldo_pemotong) {
                if($saldo_pemotong->saldo < $request->grand_total){
                    $akun_pemotong = $saldo_pemotong->nama;
                    return redirect()->back()->with(['error' => 'saldo akun ('. $akun_pemotong .') tidak cukup']);
                }
            }
        }


        if (!empty($request->lampiran)) {
            Storage::disk('local')->delete('public/'.$request->lampiran_old);
            $msg = $item->update([
                'account_pembayar'      => $request->account_pembayar,
                'penerima_supplier'     => $request->penerima_supplier,
                'penerima_pegawai'      => $request->penerima_pegawai,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'transaksi'             => 'Bank Withdrawal',
                'no_transaksi'          => $request->no_transaksi,
                'memo'                  => $request->memo,
                'lampiran'              => $request->file('lampiran')->store('assets/dokumen/kasBank/lampiranKirUang', 'public'),
                'sub_total'             => $request->sub_total,
                'total'                 => $request->total_global,
                'akun_pemotong'         => $request->akun_pemotong,
                'besar_potongan'        => $request->besar_potongan,
                'grand_total'           => $request->grand_total,
                'creat_by'                  => Auth::user()->id,
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }else{
            $msg = $item->update([
                'account_pembayar'      => $request->account_pembayar,
                'penerima_supplier'     => $request->penerima_supplier,
                'penerima_pegawai'      => $request->penerima_pegawai,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'transaksi'             => 'Bank Withdrawal',
                'no_transaksi'          => $request->no_transaksi,
                'memo'                  => $request->memo,
                'sub_total'             => $request->sub_total,
                'total'                 => $request->total_global,
                'akun_pemotong'         => $request->akun_pemotong,
                'besar_potongan'        => $request->besar_potongan,
                'grand_total'           => $request->grand_total,
                'creat_by'                  => Auth::user()->id,
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }


        $jumlahRow = $request->hitung_row;

        if ($msg) {
            $detailDel = DetailKirimUang::where('kirim_uangs_id', $id)->where('creat_by_company', Auth::user()->pegawai->company->id)->delete();
            if ($detailDel) {
                for ($i = 0; $i <= $jumlahRow ; $i++) {
                    $kirim_uang = new DetailKirimUang();
                    $kirim_uang->kirim_uangs_id       = $id;
                    $kirim_uang->akun_tujuan         = $request->akun_tujuan[$i];
                    $kirim_uang->deskripsi           = $request->deskripsi[$i];
                    $kirim_uang->pajak_id            = $request->pajak_id[$i];
                    $kirim_uang->potongan_pajak      = $request->potongan_pajak[$i];
                    $kirim_uang->jumlah              = $request->jumlah[$i];
                    $kirim_uang->creat_by            = Auth::user()->id;
                    $kirim_uang->creat_by_company    = Auth::user()->pegawai->company->id;
                    $saveDetail = $kirim_uang->save();
                }
                if ($saveDetail) {
                    // select jurnal debit by id transaksi
                    $jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 4)->where('tahapan', 1)->where('kredit', 0)->get();
                    foreach ($jurnal_debit as $j_deb) {
                        jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb->id)->delete();
                        $get_account_debit = AccountBank::query()->where('id', $j_deb->account_id)->get();
                        foreach ($get_account_debit as $ad) {
                            AccountBank::query()->where('id', $j_deb->account_id)->update(['saldo'=>$ad->saldo - $j_deb->debit]);
                        }
                    }
                    // select jurnal kredit by id transaksi
                    $jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 4)->where('tahapan', 1)->where('debit', 0)->get();
                    foreach ($jurnal_kredit as $j_kred) {
                        jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred->id)->delete();
                        $get_account_kredit = AccountBank::query()->where('id', $j_kred->account_id)->get();
                        foreach ($get_account_kredit as $ad) {
                            AccountBank::query()->where('id', $j_kred->account_id)->update(['saldo'=>$ad->saldo + $j_kred->kredit]);
                        }
                    }
                }

                $jurnalEnt = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 4)->delete();

                if ($jurnalEnt) {
                    for ($j = 0; $j <= $jumlahRow ; $j++) {
                        $akun_tujuan = new JurnalEntry();
                        $akun_tujuan->transaksi_id       = $id;
                        $akun_tujuan->account_id         = $request->akun_tujuan[$j];
                        $akun_tujuan->tanggal_transaksi  = $request->tanggal_transaksi;
                        $akun_tujuan->debit              = $request->jumlah[$j];
                        $akun_tujuan->kredit             = 0;
                        $akun_tujuan->category           = 4;
                        $akun_tujuan->tahapan            = 1;
                        $akun_tujuan->keterangan         = NULL;
                        $akun_tujuan->creat_by           = Auth::user()->id;
                        $akun_tujuan->creat_by_company   = Auth::user()->pegawai->company->id;
                        $saveJurnal = $akun_tujuan->save();

                        $JE_L_1 = DB::getPdo()->lastInsertId();

                        jurnal_penyesuaian::create([
                            'jurnal_entry_id' => $JE_L_1
                        ]);

                        $get_account_tujuan = AccountBank::query()->where('id', $request->akun_tujuan[$j])->get();
                        foreach ($get_account_tujuan as $atujuan) {
                            AccountBank::query()->where('id', $request->akun_tujuan[$j])->update(['saldo'=>$atujuan->saldo + $request->jumlah[$j]]);
                        }
                    }

                    if ($request->potongan_pajak_display > 0) {

                        $get_rules_jurnal_entry_ppn = RulesJurnalInput::query()->where('rules_jurnal_category', 4)->where('rules_jurnal_category_2', 1)->get();
                        foreach ($get_rules_jurnal_entry_ppn as $grjep) {
                            $id_akun_ppn = $grjep->rules_jurnal_akun_ppn;
                        }

                        $pajak = new JurnalEntry();
                        $pajak->transaksi_id       = $id;
                        $pajak->account_id         = $id_akun_ppn;
                        $pajak->tanggal_transaksi  = $request->tanggal_transaksi;
                        $pajak->debit              = $request->potongan_pajak_display;
                        $pajak->kredit             = 0;
                        $pajak->category           = 4;
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
                        $akun_pemotong = new JurnalEntry();
                        $akun_pemotong->transaksi_id       = $id;
                        $akun_pemotong->account_id         = $request->akun_pemotong;
                        $akun_pemotong->tanggal_transaksi  = $request->tanggal_transaksi;
                        $akun_pemotong->debit              = 0;
                        $akun_pemotong->kredit             = $request->besar_potongan;
                        $akun_pemotong->category           = 4;
                        $akun_pemotong->tahapan            = 1;
                        $akun_pemotong->keterangan         = NULL;
                        $akun_pemotong->creat_by           = Auth::user()->id;
                        $akun_pemotong->creat_by_company   = Auth::user()->pegawai->company->id;
                        $saveJurnal = $akun_pemotong->save();

                        $JE_L_3 = DB::getPdo()->lastInsertId();

                        jurnal_penyesuaian::create([
                            'jurnal_entry_id' => $JE_L_3
                        ]);

                        $get_account_pemotong = AccountBank::query()->where('id', $request->akun_pemotong)->get();
                        foreach ($get_account_pemotong as $apemotong) {
                            AccountBank::query()->where('id', $request->akun_pemotong)->update(['saldo'=>$apemotong->saldo - $request->besar_potongan]);
                        }
                    }

                    if ($request->besar_potongan > 0) {
                        $kredit_akun = $request->grand_total;
                    }else{
                        $kredit_akun = $request->total_global;
                    }

                    $akun_pembayar = new JurnalEntry();
                    $akun_pembayar->transaksi_id       = $id;
                    $akun_pembayar->account_id         = $request->account_pembayar;
                    $akun_pembayar->tanggal_transaksi  = $request->tanggal_transaksi;
                    $akun_pembayar->debit              = 0;
                    $akun_pembayar->kredit             = $kredit_akun;
                    $akun_pembayar->category           = 4;
                    $akun_pembayar->tahapan            = 1;
                    $akun_pembayar->keterangan         = NULL;
                    $akun_pembayar->creat_by           = Auth::user()->id;
                    $akun_pembayar->creat_by_company   = Auth::user()->pegawai->company->id;
                    $saveJurnal = $akun_pembayar->save();

                    $JE_L_4 = DB::getPdo()->lastInsertId();

                        jurnal_penyesuaian::create([
                            'jurnal_entry_id' => $JE_L_4
                        ]);

                    $get_account_pembayar = AccountBank::query()->where('id', $request->account_pembayar)->get();
                    foreach ($get_account_pembayar as $apembayar) {
                        AccountBank::query()->where('id', $request->account_pembayar)->update(['saldo'=>$apembayar->saldo - $kredit_akun]);
                    }
                }
            }
        }


        if ($saveJurnal) {
            $data = KirimUang::findOrFail($id);
            return redirect()->route('kirimuang.show', $data)->with(['success' => 'Data Berhasil Diupload']);
        } else {
            return redirect()->route('kasbank.index')->with(['error' => 'Data Gagal Diupload']);
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
        $data = KirimUang::findOrFail($id);

        $file = $data->lampiran;

        $detailDelete = DetailKirimUang::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('kirim_uangs_id', $id)->delete();

        if ($detailDelete) {
            // select jurnal debit by id transaksi
            $jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 4)->where('tahapan', 1)->where('kredit', 0)->get();
            foreach ($jurnal_debit as $j_deb) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb->id)->delete();
                $get_account_debit = AccountBank::query()->where('id', $j_deb->account_id)->get();
                foreach ($get_account_debit as $ad) {
                    AccountBank::query()->where('id', $j_deb->account_id)->update(['saldo'=>$ad->saldo - $j_deb->debit]);
                }
            }
            // select jurnal kredit by id transaksi
            $jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 4)->where('tahapan', 1)->where('debit', 0)->get();
            foreach ($jurnal_kredit as $j_kred) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred->id)->delete();
                $get_account_kredit = AccountBank::query()->where('id', $j_kred->account_id)->get();
                foreach ($get_account_kredit as $ad) {
                    AccountBank::query()->where('id', $j_kred->account_id)->update(['saldo'=>$ad->saldo + $j_kred->kredit]);
                }
            }
        }

        $jurnalDelete = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 4)->delete();


        if ($jurnalDelete) {
            if ($file == NULL) {
                $msg = $data->delete();
            }else{
                Storage::disk('local')->delete('public/'.$file);
                $msg = $data->delete();
            }
        }

        if ($msg) {
            return redirect()->route('kasbank.index')->with(['success' => 'Data Berhasil Dihapus']);
        }else {
            return redirect()->route('kasbank.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }

    public function get_akun_tujuan_kirim(){
        $akun_tujuan = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        return response()->json($akun_tujuan);
    }
}
