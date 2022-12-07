<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\AccountBank;
use App\Models\Finance\Biaya;
use App\Models\Finance\Customer;
use App\Models\Finance\DetailPenjualan;
use App\Models\Finance\JurnalEntry;
use App\Models\Finance\KirimUang;
use App\Models\Finance\Pajak;
use App\Models\Finance\Pembelian;
use App\Models\Finance\Penjualan;
use App\Models\Finance\Product;
use App\Models\Finance\Supplier;
use App\Models\Finance\TerimaUang;
use App\Models\Finance\TransferUang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:laporan-list', ['only' => ['index']]);
    }
    public function index(){
        return view('pages_finance.laporan.index');
    }

    // laporan penjualan
    // daftar penjualan
    public function show_daftar_penjualan(){
        return view('pages_finance.laporan.penjualan.show_daftar_penjualan');
    }

    // Pajak
    public function daftar_penjualan(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $get_total = Penjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->with(['customer'])->sum('total');
        $penjualan = Penjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->with(['customer'])->get();


        return view('pages_finance.laporan.penjualan.result_daftar_penjualan', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'penjualan'     => $penjualan,
            'get_total'     => $get_total
        ]);
    }
    // penjualan selesai
    public function show_penjualan_selesai(){
        return view('pages_finance.laporan.penjualan.show_penjualan_selesai');
    }
    public function result_penjualan_selesai(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $get_total = Penjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->where('status', 2)->with(['customer'])->sum('total');
        $get_sisa_tagihan = Penjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->where('status', 2)->with(['customer'])->sum('sisa_tagihan');
        $penjualan = Penjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->where('status', 2)->with(['customer'])->get();


        return view('pages_finance.laporan.penjualan.result_penjualan_selesai', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'penjualan'     => $penjualan,
            'get_total'     => $get_total,
            'get_sisa_tagihan' => $get_sisa_tagihan
        ]);
    }
    // penjualan per pelanggan
    public function show_penjualan_per_pelanggan(){
        return view('pages_finance.laporan.penjualan.show_penjualan_per_pelanggan');
    }
    public function result_penjualan_per_pelanggan(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $penjualan = Customer::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

        return view('pages_finance.laporan.penjualan.result_penjualan_per_pelanggan', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'penjualan'     => $penjualan
        ]);
    }
    // Laporan piutang pelanggan
    public function show_piutang_pelanggan(){
        return view('pages_finance.laporan.penjualan.show_piutang_pelanggan');
    }
    public function result_piutang_pelanggan(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $penjualan = Customer::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('creat_by_company', Auth::user()->pegawai->company->id);

        return view('pages_finance.laporan.penjualan.result_piutang_pelanggan', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'penjualan'     => $penjualan
        ]);
    }
    // Pengiriman Penjualan
    public function show_pengiriman_penjualan(){
        return view('pages_finance.laporan.penjualan.show_pengiriman_penjualan');
    }
    public function result_pengiriman_penjualan(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $customer = Customer::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

        return view('pages_finance.laporan.penjualan.result_pengiriman_penjualan', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'customer'     => $customer
        ]);
    }
    // Penjualan per product
    public function show_penjualan_per_product(){
        return view('pages_finance.laporan.penjualan.show_penjualan_per_product');
    }
    public function result_penjualan_per_product(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $product = Product::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 1)->get();
        $penjualan2 = Penjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->count();

        return view('pages_finance.laporan.penjualan.result_penjualan_per_product', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'product'     => $product,
            'penjualan2' =>$penjualan2,
        ]);
    }


    // laporan pajak
    public function show_laporan_pajak_pemotongan(){
        return view('pages_finance.laporan.pajak.show_laporan_pajak_pemotongan');
    }

    public function result_laporan_pajak_pemotongan(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');


        return view('pages_finance.laporan.pajak.result_laporan_pajak_pemotongan', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function show_laporan_pajak(){
        return view('pages_finance.laporan.pajak.show_laporan_pajak');
    }

    public function result_laporan_pajak(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $pajak = Pajak::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('id', 1)->get();
        foreach ($pajak as $p) {
            $pajak_persentase = $p->persentase;
        }

        $jurnal_pajak_penjualan = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('account_id', 13)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('kredit');
        $jurnal_pajak_pembelian = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('account_id', 8)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('debit');
        // dd($pajak_persentase);

        $parameter = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('account_id', 13)->orWhere('account_id', 8)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->count();

        if ($jurnal_pajak_penjualan > 0) {
            $DPP_penjualan = ($jurnal_pajak_penjualan / $pajak_persentase)*100;
            
        }
        if ($jurnal_pajak_penjualan > 0) {
            $DPP_pembelian = ($jurnal_pajak_pembelian / $pajak_persentase)*100;
        }




        return view('pages_finance.laporan.pajak.result_laporan_pajak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'pajak_persentase'  => $pajak_persentase,
            'jurnal_pajak_penjualan' => $jurnal_pajak_penjualan,
            'jurnal_pajak_pembelian' => $jurnal_pajak_pembelian,
            'DPP_penjualan' => $DPP_penjualan,
            'DPP_pembelian' => $DPP_pembelian,
            'parameter' => $parameter
        ]);
    }


    // laporan pembelian
    // daftar pembelian
    public function show_daftar_pembelian(){
        return view('pages_finance.laporan.pembelian.show_daftar_pembelian');
    }
    public function result_daftar_pembelian(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $get_total = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->with(['supplier'])->sum('total');
        $pembelian = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->with(['supplier'])->get();


        return view('pages_finance.laporan.pembelian.result_daftar_pembelian', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'pembelian'     => $pembelian,
            'get_total'     => $get_total
        ]);
    }
    // pembelian per supplier
    public function show_pembelian_per_supplier(){
        return view('pages_finance.laporan.pembelian.show_pembelian_per_supplier');
    }
    public function result_pembelian_per_supplier(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $pembelian = Supplier::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

        return view('pages_finance.laporan.pembelian.result_pembelian_per_supplier', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'pembelian'     => $pembelian
        ]);
    }
    // Laporan hutang supplier
    public function show_hutang_supplier(){
        return view('pages_finance.laporan.pembelian.show_hutang_supplier');
    }
    public function result_hutang_supplier(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $pembelian = Supplier::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();

        return view('pages_finance.laporan.pembelian.result_hutang_supplier', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'pembelian'     => $pembelian
        ]);
    }
    // daftar pembelian selesai
    public function show_pembelian_selesai(){
        return view('pages_finance.laporan.pembelian.show_pembelian_selesai');
    }
    public function result_pembelian_selesai(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $get_total = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->with(['supplier'])->where('status', 2)->sum('total');
        $pembelian = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->with(['supplier'])->where('status', 2)->get();
        $get_sisa_tagihan = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->with(['supplier'])->where('status', 2)->sum('sisa_tagihan');

        return view('pages_finance.laporan.pembelian.result_pembelian_selesai', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'pembelian'     => $pembelian,
            'get_total'     => $get_total,
            'get_sisa_tagihan' => $get_sisa_tagihan
        ]);
    }
    // daftar pengeluaran
    public function show_daftar_pengeluaran(){
        return view('pages_finance.laporan.pembelian.show_daftar_pengeluaran');
    }
    public function result_daftar_pengeluaran(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $jurnal = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('debit', 0)->with(['account_bank'])->get();

        foreach ($jurnal as $j) {
            if ($j->category == 1) {
                $transaksi = Penjualan::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->get();
            }elseif ($j->category == 2) {
                $transaksi = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->get();
            }elseif ($j->category == 3) {
                $transaksi = Biaya::query()->where('company_id', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->get();
            }elseif ($j->categoty == 4) {
                $transaksi = KirimUang::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->get();
            }elseif ($j->categoty == 5) {
                $transaksi = TerimaUang::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->get();
            }else{
                $transaksi = TransferUang::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->get();
            }

            foreach ($transaksi as $t) {
                $jurnal_post = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $t->id)->where('debit', 0)->with(['account_bank'])->get();
                $jumlah_kredit = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('transaksi_id', $t->id)->where('debit', 0)->with(['account_bank'])->sum('kredit');
            }
        }

        return view('pages_finance.laporan.pembelian.result_daftar_pengeluaran', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'jurnal_post'        => $jurnal_post,
            'jumlah_kredit'     => $jumlah_kredit
        ]);
    }

    // Pembelian per product
    public function show_pembelian_per_product(){
        return view('pages_finance.laporan.pembelian.show_pembelian_per_product');
    }
    public function result_pembelian_per_product(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $product = Product::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 2)->get();
        $pembelian2 = Pembelian::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->count();

        return view('pages_finance.laporan.pembelian.result_pembelian_per_product', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'product'     => $product,
            'pembelian2' =>$pembelian2,
        ]);
    }






    // laporan product
    // ringkasan persediaan barang
    public function show_ringkasan_persediaan_barang(){
        return view('pages_finance.laporan.product.show_ringkasan_persediaan_barang');
    }
    public function result_ringkasan_persediaan_barang(Request $request){
        $category = $request->input('category');

        $product = Product::qury()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', $category)->get();
        $product_harga_satuan = Product::qury()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', $category)->sum('harga_satuan');
        $product_qty = Product::qury()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', $category)->sum('qty');
        $total_nilai = $product_harga_satuan * $product_qty;

        return view('pages_finance.laporan.product.result_ringkasan_persediaan_barang', [
            'category' => $category,
            'product'     => $product,
            'total_nilai' => $total_nilai
        ]);
    }

    // nilai persediaan barang
    public function show_nilai_persediaan_barang(){
        return view('pages_finance.laporan.product.show_nilai_persediaan_barang');
    }
    public function result_nilai_persediaan_barang(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $product = Product::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();


        return view('pages_finance.laporan.product.result_nilai_persediaan_barang', [
            'tanggal_awal'      => $tanggal_awal,
            'tanggal_akhir'     => $tanggal_akhir,
            'product'      => $product
        ]);
    }
    // nilai persediaan barang
    public function show_rincian_persediaan_barang(){
        return view('pages_finance.laporan.product.show_rincian_persediaan_barang');
    }
    public function result_rincian_persediaan_barang(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $product = Product::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->get();


        return view('pages_finance.laporan.product.result_rincian_persediaan_barang', [
            'tanggal_awal'      => $tanggal_awal,
            'tanggal_akhir'     => $tanggal_akhir,
            'product'      => $product
        ]);
    }



    // laporan Bank
    // laporan rekonsiliasi bank
    public function show_laporan_rekonsiliasi(){
        return view('pages_finance.laporan.bank.show_laporan_rekonsiliasi');
    }
    public function result_laporan_rekonsiliasi(Request $request){
        $category = $request->input('category');

        $product = Product::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', $category)->get();
        $product_harga_satuan = Product::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', $category)->sum('harga_satuan');
        $product_qty = Product::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', $category)->sum('qty');
        $total_nilai = $product_harga_satuan * $product_qty;

        return view('pages_finance.laporan.bank.result_show_laporan_rekonsiliasi', [
            'category'      => $category,
            'product'       => $product,
            'total_nilai'   => $total_nilai
        ]);
    }
    // laporan saldo bank
    public function show_saldo_account(){
        $bank = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->with(['category_account'])->get();
        return view('pages_finance.laporan.bank.show_saldo_account', [
            'bank'  => $bank
        ]);
    }
    // mutasi rekening
    public function show_mutasi_rekening(){
        return view('pages_finance.laporan.bank.show_mutasi_rekening');
    }
    public function result_mutasi_rekening(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $account_bank = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('category', 3)->get();

        return view('pages_finance.laporan.bank.result_mutasi_rekening', [
            'tanggal_awal'      => $tanggal_awal,
            'tanggal_akhir'     => $tanggal_akhir,
            'account_bank'      => $account_bank
        ]);
    }



    // Bisnis......................................................
    // Buku besar
    public function show_buku_besar(){
        return view('pages_finance.laporan.bisnis.show_buku_besar');
    }
    public function result_buku_besar(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        // $account_bank = AccountBank::all();
        $account_bank = AccountBank::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->where('saldo', '!=', 0)->get();


        return view('pages_finance.laporan.bisnis.result_buku_besar', [
            'tanggal_awal'      => $tanggal_awal,
            'tanggal_akhir'     => $tanggal_akhir,
            'account_bank'      => $account_bank
        ]);
    }


    public function show_jurnal(){
        return view('pages_finance.laporan.bisnis.show_jurnal');
    }
    public function result_jurnal(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $jurnal_entry = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->select('transaksi_id','category')->distinct('category','transaksi_id')->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->get();
        // $jurnal_entry = JurnalEntry::all();
        $data = array();
        foreach ($jurnal_entry as $dat) {
            array_push($data, $dat->transaksi_id);
        }
        // return response()->json($jurnal_entry);

        return view('pages_finance.laporan.bisnis.result_jurnal', [
            'tanggal_awal'      => $tanggal_awal,
            'tanggal_akhir'     => $tanggal_akhir,
            'jurnal_entry'      => $jurnal_entry,
            'data'              => $data
        ]);
    }


    // laporan laba rugi
    public function show_laba_rugi(){
        return view('pages_finance.laporan.bisnis.show_laba_rugi');
    }
    public function result_laba_rugi(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $pendapatan_penjualan = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->select('account_id')->with(['account_bank'])->distinct('account_id')->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 13);})->get();
        $harga_pokok_penjualan = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->select('account_id')->with(['account_bank'])->distinct('account_id')->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 15);})->get();
        $biaya_oprasional = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->select('account_id')->with(['account_bank'])->distinct('account_id')->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 16);})->get();
        $pendapatan_lainnya = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->select('account_id')->with(['account_bank'])->distinct('account_id')->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 14);})->get();
        $biaya_lainnya = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->select('account_id')->with(['account_bank'])->distinct('account_id')->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 17);})->get();
        
        // dd($pendapatan_penjualan);
        return view('pages_finance.laporan.bisnis.result_laba_rugi', [
            'tanggal_awal'      => $tanggal_awal,
            'tanggal_akhir'     => $tanggal_akhir,
            'pendapatan_penjualan' => $pendapatan_penjualan,
            'harga_pokok_penjualan' => $harga_pokok_penjualan,
            'biaya_operasional'     => $biaya_oprasional,
            'pendapatan_lainnya'    => $pendapatan_lainnya,
            'biaya_lainnya'         => $biaya_lainnya
        ]);
    }

        // laporan neraca
        public function show_neraca(){
            return view('pages_finance.laporan.bisnis.show_neraca');
        }
        public function result_neraca(Request $request){
            $tanggal_awal = $request->input('tanggal_awal');
            $tanggal_akhir = $request->input('tanggal_akhir');
    
            $aktiva_lancar = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->select('account_id')->with(['account_bank'])->distinct('account_id')->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 2);})->get();
            $aktiva_tetap = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->select('account_id')->with(['account_bank'])->distinct('account_id')->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 5);})->get();
            $depresiasi_amortisasi = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->select('account_id')->with(['account_bank'])->distinct('account_id')->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 7);})->get();
            $kewajiban_lancar = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->select('account_id')->with(['account_bank'])->distinct('account_id')->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 10);})->get();
            $modal_pemilik = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->select('account_id')->with(['account_bank'])->distinct('account_id')->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 12);})->get();
            
            // dd($pendapatan_penjualan);
            return view('pages_finance.laporan.bisnis.result_neraca', [
                'tanggal_awal'      => $tanggal_awal,
                'tanggal_akhir'     => $tanggal_akhir,
                'aktiva_lancar'     => $aktiva_lancar,
                'aktiva_tetap'      => $aktiva_tetap,
                'depresiasi_amortisasi'     => $depresiasi_amortisasi,
                'kewajiban_lancar'          => $kewajiban_lancar,
                'modal_pemilik'             => $modal_pemilik
            ]);
        }

    // laporan neraca
    public function show_jurnal_penyesuaian(){
        return view('pages_finance.laporan.bisnis.show_jurnal_penyesuaian');
    }
    public function result_jurnal_penyesuaian(Request $request){
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $jurnal_entry = JurnalEntry::query()->where('creat_by_company', Auth::user()->pegawai->company->id)->select('transaksi_id','category')->distinct('category','transaksi_id')->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->get();
        // $jurnal_entry = JurnalEntry::all();
        $data = array();
        foreach ($jurnal_entry as $dat) {
            array_push($data, $dat->transaksi_id);
        }
        // return response()->json($jurnal_entry);

        $account_bank = AccountBank::all();

        return view('pages_finance.laporan.bisnis.result_jurnal_penyesuaian', [
            'tanggal_awal'      => $tanggal_awal,
            'tanggal_akhir'     => $tanggal_akhir,
            'jurnal_entry'      => $jurnal_entry,
            'data'              => $data,
            'account_bank'      => $account_bank
        ]);
    }



}
