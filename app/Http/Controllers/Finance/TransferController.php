<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\AccountBank;
use App\Models\Finance\jurnal_penyesuaian;
use App\Models\Finance\JurnalEntry;
use App\Models\Finance\TransferUang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        if (request()->ajax()) {
            // $query = TransferUang::query()->with(['account_bank_transfer', 'account_bank_setor'])->get();
            $query = TransferUang::query()->with(['account_bank_transfer', 'account_bank_setor'])->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

            // dd($query);
            return DataTables::of($query)
            ->addColumn('aksi', function($item){
                return '<a class="btn btn-primary" href="' . route('transferuang.show', $item->id) . '">Detail</a>';
            })
            ->rawColumns(['aksi'])
            ->addIndexColumn()
            ->make();
        }

        return view('pages_finance.kas&bank.transferuang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = TransferUang::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->count();
        // $account_setor = AccountBank::all();
        
        $account_setor = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 2)->get();
        // $account_transfer = AccountBank::all();

        if ($data == 0) {
            $kode = '10001';
        }else{
            $max_kode = TransferUang::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->max('no_transaksi');
            $kode = $max_kode+1;
        }
        
        return view('pages_finance.kas&bank.transferuang.create', [
            'kode' => $kode,
            'account_setor' => $account_setor
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
        $update_saldo = AccountBank::query()->where('id', $request->account_transper)->get();
            foreach ($update_saldo as $saldo) {
                if($saldo->saldo < $request->jumlah){
                    $akun = $saldo->nama;
                    return redirect()->back()->with(['error' => 'saldo akun ('. $akun .') tidak cukup']);
                }
            }

        if (!empty($request->lampiran)) {
            $msg = TransferUang::create([
                'account_transper'          => $request->account_transper,
                'account_setor'             => $request->account_setor,
                'tanggal_transaksi'         => $request->tanggal_transaksi,
                'transaksi'                 => 'Bank Withdrawal',
                'no_transaksi'              => $request->no_transaksi,
                'memo'                      => $request->memo,
                'lampiran'                  => $request->file('lampiran')->store('assets/dokumen/kasBank/lampiranTransferUang', 'public'),
                'jumlah'                    => $request->jumlah,
                'creat_by'                  => Auth::user()->id, 
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }else{
            $msg = TransferUang::create([
                'account_transper'          => $request->account_transper,
                'account_setor'             => $request->account_setor,
                'tanggal_transaksi'         => $request->tanggal_transaksi,
                'transaksi'                 => 'Bank Withdrawal',
                'no_transaksi'              => $request->no_transaksi,
                'memo'                      => $request->memo,
                'jumlah'                    => $request->jumlah,
                'creat_by'                  => Auth::user()->id, 
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }

        $idTransferUang = DB::getPdo()->lastInsertId();

        if ($msg) {
                $transfer = new JurnalEntry();
                $transfer->transaksi_id       = $idTransferUang;
                $transfer->account_id         = $request->account_transper;
                $transfer->tanggal_transaksi  = $request->tanggal_transaksi;
                $transfer->debit              = 0;
                $transfer->kredit             = $request->jumlah;
                $transfer->category           = 6;
                $transfer->tahapan            = 1;
                $transfer->keterangan         = NULL;
                $transfer->creat_by           = Auth::user()->id;
                $transfer->creat_by_company   = Auth::user()->pegawai->company->id;
                $saveJurnal = $transfer->save();

                $JE_L_1 = DB::getPdo()->lastInsertId();

                jurnal_penyesuaian::create([
                    'jurnal_entry_id' => $JE_L_1
                ]);

                $get_account_transfer = AccountBank::query()->where('id', $request->account_transper)->get();
                foreach ($get_account_transfer as $atransfer) {
                    AccountBank::query()->where('id', $request->account_transper)->update(['saldo'=>$atransfer->saldo + $request->jumlah]);
                }


                $setor = new JurnalEntry();
                $setor->transaksi_id       = $idTransferUang;
                $setor->account_id         = $request->account_setor;
                $setor->tanggal_transaksi  = $request->tanggal_transaksi;
                $setor->debit              = $request->jumlah;
                $setor->kredit             = 0;
                $setor->category           = 6;
                $setor->tahapan            = 1;
                $setor->keterangan         = NULL;
                $setor->creat_by           = Auth::user()->id;
                $setor->creat_by_company   = Auth::user()->pegawai->company->id;
                $saveJurnal = $setor->save();

                $JE_L_2 = DB::getPdo()->lastInsertId();

                jurnal_penyesuaian::create([
                    'jurnal_entry_id' => $JE_L_2
                ]);

                $get_account_setor = AccountBank::query()->where('id', $request->account_setor)->get();
                foreach ($get_account_setor as $asetor) {
                    AccountBank::query()->where('id', $request->account_setor)->update(['saldo'=>$asetor->saldo + $request->jumlah]);
                }
        }
        

        if ($saveJurnal) {
            $data = TransferUang::findOrFail($idTransferUang);
            return redirect()->route('transferuang.show', $data)->with(['success' => 'Data Berhasil Diupload']);
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
        $data = TransferUang::findOrFail($id);

        $jurnal_entry = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 6)->where('tahapan', 1)->orderBy('id', 'desc')->get();
        $sum_jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 6)->where('tahapan', 1)->sum('debit');
        $sum_jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $data->id)->where('category', 6)->where('tahapan', 1)->sum('kredit');

        return view('pages_finance.kas&bank.transferuang.detail', [
            'data'                  => $data,
            'jurnal_entry'          => $jurnal_entry,
            'sum_jurnal_debit'      => $sum_jurnal_debit,
            'sum_jurnal_kredit'     => $sum_jurnal_kredit
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
        $data = TransferUang::findOrFail($id);
        $account_setor = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 2)->get();

        return view('pages_finance.kas&bank.transferuang.edit', [
            'data'                  => $data,
            'account_setor'         => $account_setor
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
        $item = TransferUang::findOrFail($id);

        $update_saldo = AccountBank::query()->where('id', $request->account_transper)->get();
            foreach ($update_saldo as $saldo) {
                if($saldo->saldo < $request->jumlah){
                    $akun = $saldo->nama;
                    return redirect()->back()->with(['error' => 'saldo akun ('. $akun .') tidak cukup']);
                }
            }

        if (!empty($request->lampiran)) {
            Storage::disk('local')->delete('public/'.$request->lampiran_old);
            $msg = $item->update([
                'account_transper'          => $request->account_transper,
                'account_setor'             => $request->account_setor,
                'tanggal_transaksi'         => $request->tanggal_transaksi,
                'transaksi'                 => 'Bank Withdrawal',
                'no_transaksi'              => $request->no_transaksi,
                'memo'                      => $request->memo,
                'lampiran'                  => $request->file('lampiran')->store('assets/dokumen/kasBank/lampiranTransferUang', 'public'),
                'jumlah'                    => $request->jumlah,
                'creat_by'                  => Auth::user()->id, 
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }else{
            $msg = $item->update([
                'account_transper'          => $request->account_transper,
                'account_setor'             => $request->account_setor,
                'tanggal_transaksi'         => $request->tanggal_transaksi,
                'transaksi'                 => 'Bank Withdrawal',
                'no_transaksi'              => $request->no_transaksi,
                'memo'                      => $request->memo,
                'jumlah'                    => $request->jumlah,
                'creat_by'                  => Auth::user()->id, 
                'creat_by_company'          => Auth::user()->pegawai->company->id
            ]);
        }

        if ($msg) {
            // select jurnal debit by id transaksi
            $jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 6)->where('tahapan', 1)->where('kredit', 0)->get();
            foreach ($jurnal_debit as $j_deb) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb->id)->delete();
                $get_account_debit = AccountBank::query()->where('id', $j_deb->account_id)->get();
                foreach ($get_account_debit as $ad) {
                    AccountBank::query()->where('id', $j_deb->account_id)->update(['saldo'=>$ad->saldo - $j_deb->debit]);
                }
            }
            // select jurnal kredit by id transaksi
            $jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 6)->where('tahapan', 1)->where('debit', 0)->get();
            foreach ($jurnal_kredit as $j_kred) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred->id)->delete();
                $get_account_kredit = AccountBank::query()->where('id', $j_kred->account_id)->get();
                foreach ($get_account_kredit as $ad) {
                    AccountBank::query()->where('id', $j_kred->account_id)->update(['saldo'=>$ad->saldo + $j_kred->kredit]);
                }
            }
        }

        $jurnalEnt = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 6)->delete();

        if ($jurnalEnt) {
            $transfer = new JurnalEntry();
            $transfer->transaksi_id       = $id;
            $transfer->account_id         = $request->account_transper;
            $transfer->tanggal_transaksi  = $request->tanggal_transaksi;
            $transfer->debit              = 0;
            $transfer->kredit             = $request->jumlah;
            $transfer->category           = 6;
            $transfer->tahapan            = 1;
            $transfer->keterangan         = NULL;
            $transfer->creat_by           = Auth::user()->id;
            $transfer->creat_by_company   = Auth::user()->pegawai->company->id;
            $saveJurnal = $transfer->save();

            $JE_L_1 = DB::getPdo()->lastInsertId();

            jurnal_penyesuaian::create([
                'jurnal_entry_id' => $JE_L_1
            ]);

            $get_account_transfer = AccountBank::query()->where('id', $request->account_transper)->get();
            foreach ($get_account_transfer as $atransfer) {
                AccountBank::query()->where('id', $request->account_transper)->update(['saldo'=>$atransfer->saldo + $request->jumlah]);
            }


            $setor = new JurnalEntry();
            $setor->transaksi_id       = $id;
            $setor->account_id         = $request->account_setor;
            $setor->tanggal_transaksi  = $request->tanggal_transaksi;
            $setor->debit              = $request->jumlah;
            $setor->kredit             = 0;
            $setor->category           = 6;
            $setor->tahapan            = 1;
            $setor->keterangan         = NULL;
            $setor->creat_by           = Auth::user()->id;
            $setor->creat_by_company   = Auth::user()->pegawai->company->id;
            $saveJurnal = $setor->save();

            $JE_L_2 = DB::getPdo()->lastInsertId();

            jurnal_penyesuaian::create([
                'jurnal_entry_id' => $JE_L_2
            ]);

            $get_account_setor = AccountBank::query()->where('id', $request->account_setor)->get();
            foreach ($get_account_setor as $asetor) {
                AccountBank::query()->where('id', $request->account_setor)->update(['saldo'=>$asetor->saldo + $request->jumlah]);
            }
        }

        if ($saveJurnal) {
            $data = TransferUang::findOrFail($id);
            return redirect()->route('transferuang.show', $data)->with(['success' => 'Data Berhasil Diupload']);
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
        $data = TransferUang::finOrFail($id);

        
            // select jurnal debit by id transaksi
            $jurnal_debit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 6)->where('tahapan', 1)->where('kredit', 0)->get();
            foreach ($jurnal_debit as $j_deb) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_deb->id)->delete();
                $get_account_debit = AccountBank::query()->where('id', $j_deb->account_id)->get();
                foreach ($get_account_debit as $ad) {
                    AccountBank::query()->where('id', $j_deb->account_id)->update(['saldo'=>$ad->saldo - $j_deb->debit]);
                }
            }
            // select jurnal kredit by id transaksi
            $jurnal_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 6)->where('tahapan', 1)->where('debit', 0)->get();
            foreach ($jurnal_kredit as $j_kred) {
                jurnal_penyesuaian::query()->where('jurnal_entry_id', $j_kred->id)->delete();
                $get_account_kredit = AccountBank::query()->where('id', $j_kred->account_id)->get();
                foreach ($get_account_kredit as $ad) {
                    AccountBank::query()->where('id', $j_kred->account_id)->update(['saldo'=>$ad->saldo + $j_kred->kredit]);
                }
            }
        

        JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $id)->where('category', 6)->delete();


        $msg = $data->delete();

        if ($msg) {
            return redirect()->route('kasbank.index')->with(['success' => 'Data Berhasil Dihapus']);
        }else {
            return redirect()->route('kasbank.index')->with(['error' => 'Data Gagal Dihapus']);
        }
    }
}
