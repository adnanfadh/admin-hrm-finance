<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\TerimaUangRequest;
use App\Models\Finance\AccountBank;
use App\Models\Finance\Customer;
use App\Models\Finance\DetailTerimaUang;
use App\Models\Finance\jurnal_penyesuaian;
use App\Models\Finance\JurnalEntry;
use App\Models\Finance\Pajak;
use App\Models\Finance\RulesJurnalInput;
use App\Models\Finance\Supplier;
use App\Models\Finance\TerimaUang;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TerimaUangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            // $query = TerimaUang::query()->with(['account_bank', 'customer', 'pegawai'])->get();

            $query = TerimaUang::query()->with(['account_bank', 'customer', 'pegawai'])->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

            // dd($query);
            return DataTables::of($query)
            ->addColumn('aksi', function($item){
                return '<a class="btn btn-primary" href="' . route('terimauang.show', $item->id) . '">Detail</a>';
            })
            ->rawColumns(['aksi'])
            ->addIndexColumn()
            ->make();
        }

        return view('pages_finance.kas&bank.terimauang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = TerimaUang::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->count();
        $customer = Customer::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $pegawai = Pegawai::all();

        $account_setor = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 12)->get();
        $account_pengirim = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        if ($data == 0) {
            $kode = '10001';
        }else{
            $max_kode = TerimaUang::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->max('no_transaksi');
            $kode = $max_kode+1;
        }

        return view('pages_finance.kas&bank.terimauang.create', [
            'kode'                  => $kode,
            'account_setor'      => $account_setor,
            'account_pengirim'      => $account_pengirim,
            'customer'              => $customer,
            'pegawai'               => $pegawai
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TerimaUangRequest $request)
    {
        $data = $request->all();

        $update_saldo = AccountBank::query()->where('id', $request->account_setor)->get();
            foreach ($update_saldo as $saldo) {
                if($saldo->saldo < $request->grand_total){
                    $akun = $saldo->nama;
                    return redirect()->back()->with(['error' => 'saldo akun ('. $akun .') tidak cukup']);
                }
            }

        if (!empty($request->lampiran)) {
            $msg = TerimaUang::create([
                'account_setor'         => $request->account_setor,
                'pengirim_customer'     => $request->pengirim_customer,
                'pengirim_pegawai'      => $request->pengirim_pegawai,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'transaksi'             => 'Bank Withdrawal',
                'no_transaksi'          => $request->no_transaksi,
                'memo'                  => $request->memo,
                'lampiran'              => $request->file('lampiran')->store('assets/dokumen/kasBank/lampiranTerimaUang', 'public'),
                'sub_total'             => $request->sub_total,
                'total'                 => $request->total_global,
                'creat_by'                  => Auth::user()->id,
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }else{
            $msg = TerimaUang::create([
                'account_setor'         => $request->account_setor,
                'pengirim_customer'     => $request->pengirim_customer,
                'pengirim_pegawai'      => $request->pengirim_pegawai,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'transaksi'             => 'Bank Withdrawal',
                'no_transaksi'          => $request->no_transaksi,
                'memo'                  => $request->memo,
                'sub_total'             => $request->sub_total,
                'total'                 => $request->total_global,
                'creat_by'                  => Auth::user()->id,
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }

        $idTerimaUang = DB::getPdo()->lastInsertId();

        $jumlahRow = $request->hitung_row;

        if ($msg) {
            for ($i = 0; $i <= $jumlahRow ; $i++) {
                $terima_uang = new DetailTerimaUang();
                $terima_uang->terima_uangs_id     = $idTerimaUang;
                $terima_uang->akun_pengirim       = $request->akun_pengirim[$i];
                $terima_uang->deskripsi           = $request->deskripsi[$i];
                $terima_uang->pajak_id            = $request->pajak_id[$i];
                $terima_uang->potongan_pajak      = $request->potongan_pajak[$i];
                $terima_uang->jumlah              = $request->jumlah[$i];
                $terima_uang->creat_by            = Auth::user()->id;
                $terima_uang->creat_by_company    = Auth::user()->pegawai->company->id;
                $saveDetail = $terima_uang->save();
            }
        }

        if ($saveDetail) {
            for ($j = 0; $j <= $jumlahRow ; $j++) {
                $akun_pengirim = new JurnalEntry();
                $akun_pengirim->transaksi_id       = $idTerimaUang;
                $akun_pengirim->account_id         = $request->akun_pengirim[$j];
                $akun_pengirim->tanggal_transaksi  = $request->tanggal_transaksi;
                $akun_pengirim->debit              = 0;
                $akun_pengirim->kredit             = $request->jumlah[$j];
                $akun_pengirim->category           = 5;
                $akun_pengirim->tahapan            = 1;
                $akun_pengirim->keterangan         = NULL;
                $akun_pengirim->creat_by           = Auth::user()->id;
                $akun_pengirim->creat_by_company   = Auth::user()->pegawai->company->id;
                $saveJurnal = $akun_pengirim->save();

                $JE_L_1 = DB::getPdo()->lastInsertId();

                jurnal_penyesuaian::create([
                    'jurnal_entry_id' => $JE_L_1
                ]);

                $get_account_tujuan = AccountBank::query()->where('id', $request->akun_pengirim[$j])->get();
                foreach ($get_account_tujuan as $atujuan) {
                    AccountBank::query()->where('id', $request->akun_pengirim[$j])->update(['saldo'=>$atujuan->saldo + $request->jumlah[$j]]);
                }
            }

            if ($request->potongan_pajak_display > 0) {

                $get_rules_jurnal_entry_ppn = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 5)->where('rules_jurnal_category_2', 1)->get();
                    foreach ($get_rules_jurnal_entry_ppn as $grjep) {
                        $id_akun_ppn = $grjep->rules_jurnal_akun_ppn;
                }

                $pajak = new JurnalEntry();
                $pajak->transaksi_id       = $idTerimaUang;
                $pajak->account_id         = $id_akun_ppn;
                $pajak->tanggal_transaksi  = $request->tanggal_transaksi;
                $pajak->debit              = 0;
                $pajak->kredit             = $request->potongan_pajak_display;
                $pajak->category           = 5;
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

            $akun_setor = new JurnalEntry();
            $akun_setor->transaksi_id       = $idTerimaUang;
            $akun_setor->account_id         = $request->account_setor;
            $akun_setor->tanggal_transaksi  = $request->tanggal_transaksi;
            $akun_setor->debit              = $kredit_akun = $request->total_global;
            $akun_setor->kredit             = 0;
            $akun_setor->category           = 5;
            $akun_setor->tahapan            = 1;
            $akun_setor->keterangan         = NULL;
            $akun_setor->creat_by           = Auth::user()->id;
            $akun_setor->creat_by_company   = Auth::user()->pegawai->company->id;
            $saveJurnal = $akun_setor->save();

            $JE_L_3 = DB::getPdo()->lastInsertId();

            jurnal_penyesuaian::create([
                'jurnal_entry_id' => $JE_L_3
            ]);

            $get_account_pembayar = AccountBank::query()->where('id', $request->account_setor)->get();
            foreach ($get_account_pembayar as $apembayar) {
                AccountBank::query()->where('id', $request->account_setor)->update(['saldo'=>$apembayar->saldo - $kredit_akun]);
            }
        }

        if ($saveJurnal) {
            $data = TerimaUang::findOrFail($idTerimaUang);
            return redirect()->route('terimauang.show', $data)->with(['success' => 'Data Berhasil Diupload']);
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
        // $data = TerimaUang::query()->where('id', $id)->with(['pegawais','customer','account_bank'])->get();
        $data = TerimaUang::findOrFail($id);
        // return response()->json($data);
        $data_detail = DetailTerimaUang::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('terima_uangs_id', $data->id)->get();
        $pajak = DetailTerimaUang::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('terima_uangs_id', $data->id)->sum('potongan_pajak');

        $jurnal_entry = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 5)->where('tahapan', 1)->orderBy('id', 'desc')->get();
        $sum_jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 5)->where('tahapan', 1)->sum('debit');
        $sum_jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 5)->where('tahapan', 1)->sum('kredit');
        return view('pages_finance.kas&bank.terimauang.detail', [
            'data'              => $data,
            'data_detail'       => $data_detail,
            'pajak'             => $pajak,
            'jurnal_entry'      => $jurnal_entry,
            'sum_jurnal_debit'  => $sum_jurnal_debit,
            'sum_jurnal_kredit' => $sum_jurnal_kredit
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
        $data = TerimaUang::findOrFail($id);
        $detail_terima_uang = DetailTerimaUang::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('terima_uangs_id', $id)->get();
        $customer = Customer::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $pegawai = Pegawai::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $account_setor = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 12)->get();
        $account_pengirim = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        $pajak = Pajak::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

        $besar_potongan = DetailTerimaUang::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('terima_uangs_id', $id)->sum('potongan_pajak');

        return view('pages_finance.kas&bank.terimauang.edit', [
            'data'                  => $data,
            'account_setor'         => $account_setor,
            'account_pengirim'      => $account_pengirim,
            'customer'              => $customer,
            'pegawai'               => $pegawai,
            'besar_potongan'        => $besar_potongan,
            'detail_terima_uang'     => $detail_terima_uang,
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
    public function update(TerimaUangRequest $request, $id)
    {
        $data = $request->all();
        $item = TerimaUang::findOrFail($id);

        if (!empty($request->lampiran)) {
            Storage::disk('local')->delete('public/'.$request->lampiran_old);
            $msg = $item->update([
                'account_setor'         => $request->account_setor,
                'pengirim_customer'     => $request->pengirim_customer,
                'pengirim_pegawai'      => $request->pengirim_pegawai,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'transaksi'             => 'Bank Withdrawal',
                'no_transaksi'          => $request->no_transaksi,
                'memo'                  => $request->memo,
                'lampiran'              => $request->file('lampiran')->store('assets/dokumen/kasBank/lampiranTerimaUang', 'public'),
                'sub_total'             => $request->sub_total,
                'total'                 => $request->total_global,
                'creat_by'                  => Auth::user()->id,
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }else{
            $msg = $item->update([
                'account_setor'         => $request->account_setor,
                'pengirim_customer'     => $request->pengirim_customer,
                'pengirim_pegawai'      => $request->pengirim_pegawai,
                'tanggal_transaksi'     => $request->tanggal_transaksi,
                'transaksi'             => 'Bank Withdrawal',
                'no_transaksi'          => $request->no_transaksi,
                'memo'                  => $request->memo,
                'sub_total'             => $request->sub_total,
                'total'                 => $request->total_global,
                'creat_by'                  => Auth::user()->id,
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }

        $jumlahRow = $request->hitung_row;

        if ($msg) {
            $detailDel = DetailTerimaUang::where('terima_uangs_id', $id)->delete();
            if ($detailDel) {
                for ($i = 0; $i <= $jumlahRow ; $i++) {
                    $terima_uang = new DetailTerimaUang();
                    $terima_uang->terima_uangs_id     = $id;
                    $terima_uang->akun_pengirim       = $request->akun_pengirim[$i];
                    $terima_uang->deskripsi           = $request->deskripsi[$i];
                    $terima_uang->pajak_id            = $request->pajak_id[$i];
                    $terima_uang->potongan_pajak      = $request->potongan_pajak[$i];
                    $terima_uang->jumlah              = $request->jumlah[$i];
                    $terima_uang->creat_by            = Auth::user()->id;
                    $terima_uang->creat_by_company    = Auth::user()->pegawai->company->id;
                    $saveDetail = $terima_uang->save();
                }

                if ($saveDetail) {
                    // select jurnal debit by id transaksi
                    $jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 5)->where('tahapan', 1)->where('kredit', 0)->get();
                    foreach ($jurnal_debit as $j_deb) {
                        jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb->id)->delete();
                        $get_account_debit = AccountBank::query()->where('id', $j_deb->account_id)->get();
                        foreach ($get_account_debit as $ad) {
                            AccountBank::query()->where('id', $j_deb->account_id)->update(['saldo'=>$ad->saldo - $j_deb->debit]);
                        }
                    }
                    // select jurnal kredit by id transaksi
                    $jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 5)->where('tahapan', 1)->where('debit', 0)->get();
                    foreach ($jurnal_kredit as $j_kred) {
                        jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred->id)->delete();
                        $get_account_kredit = AccountBank::query()->where('id', $j_kred->account_id)->get();
                        foreach ($get_account_kredit as $ad) {
                            AccountBank::query()->where('id', $j_kred->account_id)->update(['saldo'=>$ad->saldo + $j_kred->kredit]);
                        }
                    }
                }

                $jurnalEnt = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 5)->delete();

                if ($jurnalEnt) {
                    for ($j = 0; $j <= $jumlahRow ; $j++) {
                        $akun_pengirim = new JurnalEntry();
                        $akun_pengirim->transaksi_id       = $id;
                        $akun_pengirim->account_id         = $request->akun_pengirim[$j];
                        $akun_pengirim->tanggal_transaksi  = $request->tanggal_transaksi;
                        $akun_pengirim->debit              = 0;
                        $akun_pengirim->kredit             = $request->jumlah[$j];
                        $akun_pengirim->category           = 5;
                        $akun_pengirim->tahapan            = 1;
                        $akun_pengirim->keterangan         = NULL;
                        $akun_pengirim->creat_by           = Auth::user()->id;
                        $akun_pengirim->creat_by_company   = Auth::user()->pegawai->company->id;
                        $saveJurnal = $akun_pengirim->save();

                        $JE_L_1 = DB::getPdo()->lastInsertId();

                        jurnal_penyesuaian::create([
                            'jurnal_entry_id' => $JE_L_1
                        ]);

                        $get_account_tujuan = AccountBank::query()->where('id', $request->akun_pengirim[$j])->get();
                        foreach ($get_account_tujuan as $atujuan) {
                            AccountBank::query()->where('id', $request->akun_pengirim[$j])->update(['saldo'=>$atujuan->saldo + $request->jumlah[$j]]);
                        }
                    }

                    if ($request->potongan_pajak_display > 0) {

                        $get_rules_jurnal_entry_ppn = RulesJurnalInput::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('rules_jurnal_category', 5)->where('rules_jurnal_category_2', 1)->get();
                            foreach ($get_rules_jurnal_entry_ppn as $grjep) {
                                $id_akun_ppn = $grjep->rules_jurnal_akun_ppn;
                        }

                        $pajak = new JurnalEntry();
                        $pajak->transaksi_id       = $id;
                        $pajak->account_id         = $id_akun_ppn;
                        $pajak->tanggal_transaksi  = $request->tanggal_transaksi;
                        $pajak->debit              = 0;
                        $pajak->kredit             = $request->potongan_pajak_display;
                        $pajak->category           = 5;
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

                    $akun_setor = new JurnalEntry();
                    $akun_setor->transaksi_id       = $id;
                    $akun_setor->account_id         = $request->account_setor;
                    $akun_setor->tanggal_transaksi  = $request->tanggal_transaksi;
                    $akun_setor->debit              = $kredit_akun = $request->total_global;
                    $akun_setor->kredit             = 0;
                    $akun_setor->category           = 5;
                    $akun_setor->tahapan            = 1;
                    $akun_setor->keterangan         = NULL;
                    $akun_setor->creat_by           = Auth::user()->id;
                    $akun_setor->creat_by_company   = Auth::user()->pegawai->company->id;
                    $saveJurnal = $akun_setor->save();

                    $JE_L_3 = DB::getPdo()->lastInsertId();

                    jurnal_penyesuaian::create([
                        'jurnal_entry_id' => $JE_L_3
                    ]);

                    $get_account_pembayar = AccountBank::query()->where('id', $request->account_setor)->get();
                    foreach ($get_account_pembayar as $apembayar) {
                        AccountBank::query()->where('id', $request->account_setor)->update(['saldo'=>$apembayar->saldo - $kredit_akun]);
                    }
                }
            }
        }

        if ($saveDetail) {
            $data = TerimaUang::findOrFail($id);
            return redirect()->route('terimauang.show', $data)->with(['success' => 'Data Berhasil Diupload']);
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
        $data = TerimaUang::findOrFail($id);

        $file = $data->lampiran;

        $detailDelete = DetailTerimaUang::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('terima_uangs_id', $id)->delete();

        if ($detailDelete) {
            // select jurnal debit by id transaksi
            $jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 5)->where('tahapan', 1)->where('kredit', 0)->get();
            foreach ($jurnal_debit as $j_deb) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb->id)->delete();
                $get_account_debit = AccountBank::query()->where('id', $j_deb->account_id)->get();
                foreach ($get_account_debit as $ad) {
                    AccountBank::query()->where('id', $j_deb->account_id)->update(['saldo'=>$ad->saldo - $j_deb->debit]);
                }
            }
            // select jurnal kredit by id transaksi
            $jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 5)->where('tahapan', 1)->where('debit', 0)->get();
            foreach ($jurnal_kredit as $j_kred) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred->id)->delete();
                $get_account_kredit = AccountBank::query()->where('id', $j_kred->account_id)->get();
                foreach ($get_account_kredit as $ad) {
                    AccountBank::query()->where('id', $j_kred->account_id)->update(['saldo'=>$ad->saldo + $j_kred->kredit]);
                }
            }
        }

        $jurnalDelete = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 5)->delete();


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

    public function get_akun_pengirim(){
        $akun_pengirim = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();
        return response()->json($akun_pengirim);
    }
}
