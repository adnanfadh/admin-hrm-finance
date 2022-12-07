<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\AccountBank;
use App\Models\Finance\Biaya;
use App\Models\Finance\DetailBiaya;
use App\Models\Finance\KirimUang;
use App\Models\Finance\Pembelian;
use App\Models\Finance\Penjualan;
use App\Models\Finance\Product;
use App\Models\Finance\TagihanBiaya;
use App\Models\Finance\TagihanPembelian;
use App\Models\Finance\TagihanPenjualan;
use App\Models\Finance\TerimaUang;
use App\Models\Finance\TransferUang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardFinanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:finance-list', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tangkap_bulan_1 = date('Y-m-01', strtotime(date('Y').date('m').'01'));
        $tangkap_bulan_2 = date('Y-m-t', strtotime(date('Y').date('m').'01'));

        // dd($tangkap_bulan_1);
    


        $kasbon1 = DetailBiaya::query()->where('akun_biaya', 9)->whereHas('biaya', function($biaya){$biaya->whereBetween('tanggal_transaksi', [date('Y-m-01', strtotime(date('Y').date('m').'05')), date('Y-m-t', strtotime(date('Y').date('m').'05'))]);})->sum('potongan_pajak');
        $kasbon2 = DetailBiaya::query()->where('akun_biaya', 9)->whereHas('biaya', function($biaya){$biaya->whereBetween('tanggal_transaksi', [date('Y-m-01', strtotime(date('Y').date('m').'05')), date('Y-m-t', strtotime(date('Y').date('m').'05'))]);})->sum('jumlah');

        $sum_tagihan_penjualan = TagihanPenjualan::query()->whereBetween("tanggal_bayar", [$tangkap_bulan_1, $tangkap_bulan_2])->sum('nominal_pembayaran');
        $sum_tagihan_Biaya = TagihanBiaya::query()->whereBetween("tanggal_bayar", [$tangkap_bulan_1, $tangkap_bulan_2])->sum('nominal_bayar');
        $sum_tagihan_Pembelian = TagihanPembelian::query()->whereBetween("tanggal_bayar", [$tangkap_bulan_1, $tangkap_bulan_2])->sum('nominal_pembayaran');


        $array_zero_uang_masuk = [];
        $array_zero_uang_keluar = [];


        // get data uang keluar
        $uang_pembelian = TagihanPembelian::query()->whereBetween("tanggal_bayar", [$tangkap_bulan_1, $tangkap_bulan_2])->get();
        $uang_biaya = TagihanBiaya::query()->whereBetween("tanggal_bayar", [$tangkap_bulan_1, $tangkap_bulan_2])->get();
        $uang_transfer = TransferUang::query()->whereBetween("tanggal_transaksi", [$tangkap_bulan_1, $tangkap_bulan_2])->get();
        $uang_kirim = KirimUang::query()->whereBetween("tanggal_transaksi", [$tangkap_bulan_1, $tangkap_bulan_2])->get();

        // get data uang masuk
        $uang_penjualan = TagihanPenjualan::query()->whereBetween("tanggal_bayar", [$tangkap_bulan_1, $tangkap_bulan_2])->get();
        $uang_terima = TerimaUang::query()->whereBetween("tanggal_transaksi", [$tangkap_bulan_1, $tangkap_bulan_2])->get();

        // get total saldo dari category account bank 
        $total_saldo = AccountBank::query()->where('category', 3)->sum('saldo');

        // foreach to push array data uang masuk
        foreach ($uang_penjualan as $up) {
            array_push($array_zero_uang_masuk,['tanggal'=>$up->tanggal_bayar,'data'=>$up->nominal_pembayaran]);
        }
        foreach ($uang_terima as $ut) {
            array_push($array_zero_uang_masuk,['tanggal'=>$ut->tanggal_transaksi,'data'=>$ut->total]);
        }

        // foreach to push array data uang masuk
        foreach ($uang_pembelian as $upe) {
            array_push($array_zero_uang_keluar,['tanggal'=>$upe->tanggal_bayar,'data'=>$upe->nominal_pembayaran]);
        }
        foreach ($uang_biaya as $ub) {
            array_push($array_zero_uang_keluar,['tanggal'=>$ub->tanggal_bayar,'data'=>$ub->nominal_bayar]);
        }
        foreach ($uang_transfer as $utr) {
            array_push($array_zero_uang_keluar,['tanggal'=>$utr->tanggal_transaksi,'data'=>$utr->jumlah]);
        }
        foreach ($uang_kirim as $uk) {
            array_push($array_zero_uang_keluar,['tanggal'=>$uk->tanggal_transaksi,'data'=>$uk->grand_total]);
        }

        $date_king = [];
        for ($i=1; $i <= date('t') ; $i++) { 
            array_push($date_king, date('Y-m-'.$i));
        }
        
        // dd($array_zero_uang_keluar[1]);
        foreach ($array_zero_uang_keluar as $az => $val) {
            foreach ($az = $val as $ky) {
                // dd($val);
            }
            // foreach ($date_king as $dk) {
            // }
        }

        $penjualan_piutang = Penjualan::query()->where('status', 1)->sum('sisa_tagihan');
        $pembelian_hutang = Pembelian::query()->where('status', 1)->sum('sisa_tagihan');
        $biaya_hutang = Biaya::query()->where('status', 1)->sum('sisa_tagihan');

        $get_product = Product::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

        $nominal_asset = 0;
        foreach ($get_product as $gp) {
            $nominal_asset += ($gp->qty * $gp->harga_satuan);
        }


        $data_store = 
        [
            'sum_uang_masuk' => $sum_tagihan_penjualan,
            'sum_uang_keluar' => $sum_tagihan_Biaya+$sum_tagihan_Pembelian
        ];

        // dd($array_zero_uang_masuk);
        // superadmin@pancanarasidigital.com  hrd031100

            return view('pages_finance.dashboard', [
                'sum_uang_masuk' => $sum_tagihan_penjualan,
                'sum_uang_keluar' => $sum_tagihan_Biaya+$sum_tagihan_Pembelian,
                'piutang'       => $penjualan_piutang,
                'hutang'        => $pembelian_hutang + $biaya_hutang,
                'kasbon'        => $kasbon2 - $kasbon1,
                'total_saldo'   => $total_saldo,
                'nominal_asset' => $nominal_asset
            ]);
    } 

    public function dashboard_content(Request $request){
        $tangkap_bulan_1 = date('Y-m-01', strtotime(date('Y').date('m').'05'));
        $tangkap_bulan_2 = date('Y-m-t', strtotime(date('Y').date('m').'05'));


        $sum_tagihan_penjualan = TagihanPenjualan::query()->whereBetween("tanggal_bayar", [$tangkap_bulan_1, $tangkap_bulan_2])->sum('nominal_pembayaran');
        $sum_tagihan_Biaya = TagihanBiaya::query()->whereBetween("tanggal_bayar", [$tangkap_bulan_1, $tangkap_bulan_2])->sum('nominal_bayar');
        $sum_tagihan_Pembelian = TagihanPembelian::query()->whereBetween("tanggal_bayar", [$tangkap_bulan_1, $tangkap_bulan_2])->sum('nominal_pembayaran');


        $array_zero_uang_masuk = array();
        $array_zero_uang_keluar = array();


        // get data uang keluar
        $uang_pembelian = TagihanPembelian::query()->whereBetween("tanggal_bayar", [$tangkap_bulan_1, $tangkap_bulan_2])->get();
        $uang_biaya = TagihanBiaya::query()->whereBetween("tanggal_bayar", [$tangkap_bulan_1, $tangkap_bulan_2])->get();
        $uang_transfer = TransferUang::query()->whereBetween("tanggal_transaksi", [$tangkap_bulan_1, $tangkap_bulan_2])->get();
        $uang_kirim = KirimUang::query()->whereBetween("tanggal_transaksi", [$tangkap_bulan_1, $tangkap_bulan_2])->get();

        // get data uang masuk
        $uang_penjualan = TagihanPenjualan::query()->whereBetween("tanggal_bayar", [$tangkap_bulan_1, $tangkap_bulan_2])->get();
        $uang_terima = TerimaUang::query()->whereBetween("tanggal_transaksi", [$tangkap_bulan_1, $tangkap_bulan_2])->get();


        // foreach to push array data uang masuk
        foreach ($uang_penjualan as $up) {
            array_push($array_zero_uang_masuk,['tanggal'=>$up->tanggal_bayar,'data'=>$up->nominal_pembayaran]);
        }
        foreach ($uang_terima as $ut) {
            array_push($array_zero_uang_masuk,['tanggal'=>$ut->tanggal_transaksi,'data'=>$ut->total]);
        }

        // foreach to push array data uang masuk
        foreach ($uang_pembelian as $upe) {
            array_push($array_zero_uang_keluar,['tanggal'=>$upe->tanggal_bayar,'data'=>$upe->nominal_pembayaran]);
        }
        foreach ($uang_biaya as $ub) {
            array_push($array_zero_uang_keluar,['tanggal'=>$ub->tanggal_bayar,'data'=>$ub->nominal_bayar]);
        }
        foreach ($uang_transfer as $utr) {
            array_push($array_zero_uang_keluar,['tanggal'=>$utr->tanggal_transaksi,'data'=>$utr->jumlah]);
        }
        foreach ($uang_kirim as $uk) {
            array_push($array_zero_uang_keluar,['tanggal'=>$uk->tanggal_transaksi,'data'=>$uk->grand_total]);
        }


        $data_store = 
        [
            'sum_uang_masuk' => $sum_tagihan_penjualan,
            'sum_uang_keluar' => $sum_tagihan_Biaya+$sum_tagihan_Pembelian
        ];

        return response()->json($data_store);
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
        //
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
