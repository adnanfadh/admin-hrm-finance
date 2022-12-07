<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\AccountBank;
use App\Models\Finance\JurnalEntry;
use App\Models\Finance\Penjualan;
use App\Models\Finance\TagihanPenjualan;
use Illuminate\Http\Request;

class PembayaranPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        $idPenjualan = $request->id_penjualan;
        $nominal_bayar = $request->nominal_bayar;
        
            $get_jurnal_hutang = JurnalEntry::query()->where('transaksi_id', $id)->where('account_id', 10)->where('category', 1)->where('tahapan', 2)->get();
            foreach ($get_jurnal_hutang as $jhutang) {
                $get_account_hutang = AccountBank::query()->where('id', 10)->get();
                foreach ($get_account_hutang as $ahutang) {
                    AccountBank::query()->where('id', 10)->update(['saldo'=>$ahutang->saldo + $jhutang->kredit]);
                }
            }

            $get_jurnal_bayar = JurnalEntry::query()->where('transaksi_id', $id)->where('account_id', $request->account_bayar)->where('category', 1)->where('tahapan', 2)->get();
            foreach ($get_jurnal_bayar as $jbayar) {
                $get_account_bayar = AccountBank::query()->where('id', $request->account_bayar)->get();
                foreach ($get_account_bayar as $abayar) {
                    AccountBank::query()->where('id', $request->account_bayar)->update(['saldo'=>$abayar->saldo + $jbayar->debit]);
                }
            }

            $get_pembelian = Penjualan::query()->where('id', $idPenjualan)->get();
            foreach ($get_pembelian as $gb) {
                Penjualan::query()->where('id', $idPenjualan)->update(['sisa_tagihan'=> $gb->sisa_tagihan + $nominal_bayar]);
            }

            JurnalEntry::query()->where('transaksi_id', $id)->where('category', 1)->where('tahapan', 2)->delete();
 
            $msg = TagihanPenjualan::where('id', $id)->delete();

            if ($msg) {
                return redirect()->route('penjualan.index')->with(['success' => 'Data Berhasil Dihapus']);
            }else {
                return redirect()->route('penjualan.index')->with(['error' => 'Data Gagal Dihapus']);
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
        
    }
}
