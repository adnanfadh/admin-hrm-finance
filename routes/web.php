<?php

use App\Http\Controllers\BidangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\SpController;
use App\Http\Controllers\SppdController;
use App\Http\Controllers\PenilaianKerjaController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\BpjsController;
use App\Http\Controllers\GajiController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KebijakanhrController;
use App\Http\Controllers\PegawaiexitController;
use App\Http\Controllers\PengumumanhrController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\OvertimeRequestController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskProjectController;


// use finance middleware
use App\Http\Controllers\Finance\DashboardFinanceController;
use App\Http\Controllers\Finance\UserFinanceController;
use App\Http\Controllers\Finance\PenjualanController;
use App\Http\Controllers\Finance\PembelianController;
use App\Http\Controllers\Finance\ProductController;
use App\Http\Controllers\Finance\SupplierController;
use App\Http\Controllers\Finance\PajakController;
use App\Http\Controllers\Finance\CustomerController;
use App\Http\Controllers\Finance\MetodePembayaranController;
use App\Http\Controllers\Finance\SyaratPembayaranController;
use App\Http\Controllers\Finance\AccountBankController;
use App\Http\Controllers\Finance\BiayaController;
use App\Http\Controllers\Finance\CategoryAccountController;
use App\Http\Controllers\Finance\DaftarLainnyaController;
use App\Http\Controllers\Finance\JurnalPenyesuaianController;
use App\Http\Controllers\Finance\KasBankController;
use App\Http\Controllers\Finance\KirimUangController;
use App\Http\Controllers\Finance\KontakController;
use App\Http\Controllers\Finance\LaporanController;
use App\Http\Controllers\Finance\PembayaranController;
use App\Http\Controllers\Finance\PembayaranPenjualanController;
use App\Http\Controllers\Finance\PengajuanController;
use App\Http\Controllers\Finance\PengajuanGlobalController;
use App\Http\Controllers\Finance\RulesJurnalController;
use App\Http\Controllers\Finance\TerimaUangController;
use App\Http\Controllers\Finance\TransferController;
use App\Http\Controllers\GajiSecondController;
use App\Http\Controllers\RoleManagement\RoleController;
use App\Http\Controllers\RoleManagement\UserRolesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/error', function () {
    return view('commingSoon');
});
    //Auth::routes(['register' => false]);

 Route::post('/absensi', [AbsenController::class, 'absensi']);
// Route::get('e-ticket/{id}', [PesertaController::class, 'eticket'])->name('eticket.peserta');
Route::resource('user', UserController::class);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    Route::post('/changePassword',[UserController::class, 'changePassword'])->name('changePassword');




    Route::resource('company', CompanyController::class);
    Route::resource('departement', BidangController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('overtime', OvertimeRequestController::class);
    Route::resource('lembur', LemburController::class);
    Route::resource('cuti', CutiController::class);
    Route::resource('absen', AbsenController::class);
    Route::get('/report', [AbsenController::class, 'view'])->name('report');
    Route::get('/result', [AbsenController::class, 'resultSearch'])->name('result');
    Route::resource('sp', SpController::class);
    Route::resource('sppd', SppdController::class);
    Route::resource('penilaiankerja', PenilaianKerjaController::class);
    Route::resource('asset', AssetController::class);
    Route::resource('bpjs', BpjsController::class);
    Route::resource('gaji', GajiController::class);
    Route::resource('gaji_second', GajiSecondController::class);
    Route::get('/bukti', [GajiController::class, 'view'])->name('buktinya');
    Route::get('/filter', [GajiController::class, 'filter'])->name('filter');

    // Route::resource('kebijakanhr', KebijakanhrController::class);
    // Route::resource('pengumumanhr', PengumumanhrController::class);
    Route::resource('pinjaman', PinjamanController::class);
    Route::resource('shift', ShiftController::class);
    Route::resource('pegawaiexit', PegawaiexitController::class);

    // menu hr
    Route::resource('pengumumanhr', PengumumanhrController::class);
    Route::resource('kebijakanhr', KebijakanhrController::class);

    // Route::resource('peserta', PesertaController::class);
    // Route::put('/verifikasi/{id}', [PesertaController::class, 'verifikasi'])->name('verifikasi-peserta');


    // client
    Route::resource('client', ClientController::class);
    Route::resource('company', CompanyController::class);

    // Poject with client
    Route::resource('project', ProjectController::class);
    Route::resource('taskproject', TaskProjectController::class);
    // Route::get('/taskprojected', [TaskProjectController::class, 'edit'])->name('taskprojected');

    Route::get('/logout', [DashboardController::class, 'signout']);

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserRolesController::class);
});


// Route untuk finance
Route::prefix('fnc')->middleware(['auth'])->group(function () {
    Route::get('dashboard_finance', [DashboardFinanceController::class, 'index']);
    Route::get('/dashboard_content',[DashboardFinanceController::class, 'dashboard_content'])->name('dashboard_content');

    Route::resource('user_finance', UserFinanceController::class);
    Route::post('/changePasswordFinance',[UserController::class, 'changePasswordFinance'])->name('changePasswordFinance');

    Route::get('index_jasa', [PenjualanController::class, 'index_jasa'])->name('index_jasa');

    // Pengajuan
    Route::resource('pengajuan', PengajuanController::class);
    Route::get('index_confirmed', [PengajuanController::class, 'index_confirmed'])->name('index_confirmed');
    Route::get('kirim_pengajuan/{id}', [PengajuanController::class, 'kirim_pengajuan'])->name('kirim_pengajuan');
    Route::get('track_pengajuan/{id}', [PengajuanController::class, 'track_pengajuan'])->name('track_pengajuan');

    Route::get('index_waiting_confirmed', [PengajuanController::class, 'index_waiting_confirmed'])->name('index_waiting_confirmed');

    
    
    Route::resource('pengajuan_head', PengajuanGlobalController::class);
    Route::PUT('setejui_pengajuan/{id}', [PengajuanGlobalController::class, 'update_persetujuan'])->name('update_persetujuan');
    Route::get('index_confirmed_head', [PengajuanGlobalController::class, 'index_confirmed'])->name('index_confirmed_head');
    Route::get('view_approved/{id}', [PengajuanGlobalController::class, 'view'])->name('view_approved');

    

    // route untuk sistem penjualan
    Route::resource('penjualan', PenjualanController::class);
    Route::post('storeAjaxCustomer', [CustomerController::class, 'store_ajax'])->name('storeAjaxCustomer');
    Route::get('getAjaxCustomer', [CustomerController::class, 'get_id_customers'])->name('getAjaxCustomer');
    Route::post('storeAjaxMetode', [MetodePembayaranController::class, 'store_ajax'])->name('storeAjaxMetode');
    Route::post('storeAjaxSyarat', [SyaratPembayaranController::class, 'store_ajax'])->name('storeAjaxSyarat');
    Route::get('get_product', [PenjualanController::class, 'get_product'])->name('get_product');
    Route::get('get_customers', [PenjualanController::class, 'get_customers'])->name('get_customers');
    Route::get('customers_id/{id}', [PenjualanController::class, 'get_customers_id'])->name('customers_id');
    Route::get('products_id/{id}', [PenjualanController::class, 'get_products_id'])->name('products_id');
    Route::get('get_pajak_ajax', [PenjualanController::class, 'get_pajaks'])->name('get_pajak_ajax');
    Route::get('pajak_id/{id}', [PenjualanController::class, 'get_pajak_id'])->name('pajak_id');
    Route::get('get_metode', [PenjualanController::class, 'get_metode'])->name('get_metode');
    Route::get('get_syarat', [PenjualanController::class, 'get_syarat'])->name('get_syarat');
    Route::get('get_account_bank_syarat', [SyaratPembayaranController::class, 'get_account_bank_syarat'])->name('get_account_bank_syarat');

    Route::get('get_account_bank', [PenjualanController::class, 'get_account_bank'])->name('get_account_bank');

    // route tagihan penjualan
    Route::resource('pembayaranPenjualan', PembayaranPenjualanController::class);
    Route::get('showTagihanPenjualan/{id}', [PenjualanController::class, 'showBayar']);
    Route::get('invoice_penjualan/{id}', [PenjualanController::class, 'invoice_penjualan'])->name('invoice_penjualan');
    Route::get('faktur_penjualan/{id}', [PenjualanController::class, 'faktur_penjualan'])->name('faktur_penjualan');

    Route::get('kwitansi_penjualan/{id}', [PenjualanController::class, 'kwitansi_penjualan'])->name('kwitansi_penjualan');
    Route::get('penjualan_id/{id}', [PenjualanController::class, 'get_penjualan_id'])->name('penjualan_id');
    Route::post('bayar_cicilan_penjualan', [PenjualanController::class, 'bayar_cicilan_penjualan'])->name('bayar_cicilan_penjualan');
    Route::get('lacak_pembayaran_penjualan/{id}', [PenjualanController::class, 'lacak_pembayaran'])->name('lacak_pembayaran_penjualan');
    Route::get('showjurnal_penjualan/{id}', [PenjualanController::class, 'show_jurnal_penjualan'])->name('showjurnal_penjualan');




    // route untuk sistem pembelian
    Route::resource('pembelian', PembelianController::class);
    Route::get('index_rab', [PembelianController::class, 'index_rab'])->name('index_rab');
    Route::post('storeAjaxSupplierPembelian', [SupplierController::class, 'store_ajax_pembelian'])->name('storeAjaxSupplierPembelian');
    Route::get('getAjaxSupplierPembelian', [SupplierController::class, 'get_id_suppliers_pembelian'])->name('getAjaxSupplierPembelian');
    Route::post('storeAjaxMetodePembelian', [MetodePembayaranController::class, 'store_ajax_pembelian'])->name('storeAjaxMetodePembelian');
    Route::post('storeAjaxSyaratPembelian', [SyaratPembayaranController::class, 'store_ajax_pembelian'])->name('storeAjaxSyaratPembelian');
    Route::get('get_product_pembelian', [PembelianController::class, 'get_product_pembelian'])->name('get_product_pembelian');
    Route::get('get_pengajuan_pembelian', [PembelianController::class, 'get_pengajuan_pembelian'])->name('get_pengajuan_pembelian');
    
    
    Route::get('get_suppliers_pembelian', [PembelianController::class, 'get_suppliers_pembelian'])->name('get_suppliers_pembelian');
    Route::get('suppliers_id_pembelian/{id}', [PembelianController::class, 'get_suppliers_id_pembelian'])->name('suppliers_id_pembelian');
    Route::get('products_id_pembelian/{id}', [PembelianController::class, 'get_products_id_pembelian'])->name('products_id_pembelian');
    Route::get('pengajuan_id_pembelian/{id}', [PembelianController::class, 'get_pengajuan_id_pembelian'])->name('pengajuan_id_pembelian');

    Route::get('get_pajak_ajax_pembelian', [PembelianController::class, 'get_pajaks_pembelian'])->name('get_pajak_ajax_pembelian');
    Route::get('pajak_id_pembelian/{id}', [PembelianController::class, 'get_pajak_id_pembelian'])->name('pajak_id_pembelian');
    Route::get('get_metode_pembelian', [PembelianController::class, 'get_metode_pembelian'])->name('get_metode_pembelian');
    Route::get('get_syarat_pembelian', [PembelianController::class, 'get_syarat_pembelian'])->name('get_syarat_pembelian');
    Route::get('get_account_bank_pembelian', [PembelianController::class, 'get_account_bank_pembelian'])->name('get_account_bank_pembelian');

    // route tagihan pembelian
    // Route::resource('pembayaranPembelian', PembayaranPembelianController::class);
    Route::post('pembayaranPembelian/{id}', [PembelianController::class, 'delete_pembayaran_pembelian']);
    Route::get('showTagihanPembelian/{id}', [PembelianController::class, 'showBayar']);
    Route::get('pembelian_id/{id}', [PembelianController::class, 'get_pembelian_id_pembelian'])->name('pembelian_id');
    Route::post('bayar_cicilan_pembelian', [PembelianController::class, 'bayar_cicilan_pembelian'])->name('bayar_cicilan_pembelian');
    Route::get('lacak_pembayaran_pembelian/{id}', [PembelianController::class, 'lacak_pembayaran_pembelian'])->name('lacak_pembayaran_pembelian');
    Route::get('showjurnal_pembelian/{id}', [PembelianController::class, 'show_jurnal_pembelian'])->name('showjurnal_pembelian');


    Route::resource('product', ProductController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('pajak', PajakController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('accountbank', AccountBankController::class);
    Route::resource('metodepembayaran', MetodePembayaranController::class);
    Route::resource('syaratpembayaran', SyaratPembayaranController::class);
    Route::resource('jurnal_penyesuaian', JurnalPenyesuaianController::class);


    Route::resource('laporan', LaporanController::class);

    Route::resource('kontak', KontakController::class);
    Route::resource('pembayaran', PembayaranController::class);

    // daftar lainnya
    Route::resource('daftarlainnya', DaftarLainnyaController::class);
    Route::resource('categoryaccount', CategoryAccountController::class);
    Route::get('category_id/{id}', [CategoryAccountController::class, 'get_category_id'])->name('category_id');

    // route untuk manage fitur biaya
    Route::resource('biaya', BiayaController::class);
    Route::post('pembayaranBiaya/{id}', [BiayaController::class, 'delete_pembayaran_biaya']);
    Route::get('get_akun_biaya', [BiayaController::class, 'get_akun_biaya'])->name('get_akun_biaya');
    Route::get('index_verify', [BiayaController::class, 'index_verify'])->name('index_verify');
    Route::get('verify_biaya/{id}', [BiayaController::class, 'verify_biaya'])->name('verify_biaya');

    Route::get('cetak_pdf', [BiayaController::class, 'cetak_pdf'])->name('cetak_pdf');
    Route::get('showBayar/{id}', [BiayaController::class, 'showBayar'])->name('showBayar');
    Route::post('bayar_cicilan_biaya', [BiayaController::class, 'bayar_cicilan_biaya'])->name('bayar_cicilan_biaya');
    Route::get('showjurnal/{id}', [BiayaController::class, 'show_jurnal'])->name('showjurnal');
    Route::get('lacak_pembayaran_biaya/{id}', [BiayaController::class, 'lacak_pembayaran_biaya'])->name('lacak_pembayaran_biaya');





    // Kas & Bank
    Route::resource('kasbank', KasBankController::class);
    Route::get('account_bank', [KasBankController::class, 'bank'])->name('account_bank');
    Route::resource('kirimuang', KirimUangController::class);
    Route::get('get_akun_tujuan_kirim', [KirimUangController::class, 'get_akun_tujuan_kirim'])->name('get_akun_tujuan_kirim');
    Route::resource('terimauang', TerimaUangController::class);
    Route::get('get_akun_pengirim', [TerimaUangController::class, 'get_akun_pengirim'])->name('get_akun_pengirim');
    Route::resource('transferuang', TransferController::class);




    // route laporan
    // penjualan per pelanggan
    Route::get('show_penjualan_per_pelanggan', [LaporanController::class, 'show_penjualan_per_pelanggan'])->name('show_penjualan_per_pelanggan');
    Route::post('result_penjualan_per_pelanggan', [LaporanController::class, 'result_penjualan_per_pelanggan'])->name('result_penjualan_per_pelanggan');
    // daftar penjualan
    Route::get('show_daftar_penjualan', [LaporanController::class, 'show_daftar_penjualan'])->name('show_daftar_penjualan');
    Route::post('daftar_penjualan', [LaporanController::class, 'daftar_penjualan'])->name('daftar_penjualan');
    // penjualan selesai
    Route::get('show_penjualan_selesai', [LaporanController::class, 'show_penjualan_selesai'])->name('show_penjualan_selesai');
    Route::post('result_penjualan_selesai', [LaporanController::class, 'result_penjualan_selesai'])->name('result_penjualan_selesai');
    // piutang pelanggan
    Route::get('show_piutang_pelanggan', [LaporanController::class, 'show_piutang_pelanggan'])->name('show_piutang_pelanggan');
    Route::post('result_piutang_pelanggan', [LaporanController::class, 'result_piutang_pelanggan'])->name('result_piutang_pelanggan');
    // pengiriman penjualan
    Route::get('show_pengiriman_penjualan', [LaporanController::class, 'show_pengiriman_penjualan'])->name('show_pengiriman_penjualan');
    Route::post('result_pengiriman_penjualan', [LaporanController::class, 'result_pengiriman_penjualan'])->name('result_pengiriman_penjualan');
    // penjualan per product
    Route::get('show_penjualan_per_product', [LaporanController::class, 'show_penjualan_per_product'])->name('show_penjualan_per_product');
    Route::post('result_penjualan_per_product', [LaporanController::class, 'result_penjualan_per_product'])->name('result_penjualan_per_product');



    // route laporan pembelian
    // daftar pembelian
    Route::get('show_daftar_pembelian', [LaporanController::class, 'show_daftar_pembelian'])->name('show_daftar_pembelian');
    Route::post('result_daftar_pembelian', [LaporanController::class, 'result_daftar_pembelian'])->name('result_daftar_pembelian');
    // pembelian per supplier
    Route::get('show_pembelian_per_supplier', [LaporanController::class, 'show_pembelian_per_supplier'])->name('show_pembelian_per_supplier');
    Route::post('result_pembelian_per_supplier', [LaporanController::class, 'result_pembelian_per_supplier'])->name('result_pembelian_per_supplier');
    // hutang supplier
    Route::get('show_hutang_supplier', [LaporanController::class, 'show_hutang_supplier'])->name('show_hutang_supplier');
    Route::post('result_hutang_supplier', [LaporanController::class, 'result_hutang_supplier'])->name('result_hutang_supplier');
    // daftar pembelian selesai
    Route::get('show_pembelian_selesai', [LaporanController::class, 'show_pembelian_selesai'])->name('show_pembelian_selesai');
    Route::post('result_pembelian_selesai', [LaporanController::class, 'result_pembelian_selesai'])->name('result_pembelian_selesai');
    // daftar pengeluaran
    Route::get('show_daftar_pengeluaran', [LaporanController::class, 'show_daftar_pengeluaran'])->name('show_daftar_pengeluaran');
    Route::post('result_daftar_pengeluaran', [LaporanController::class, 'result_daftar_pengeluaran'])->name('result_daftar_pengeluaran');
    // pembelian per product
    Route::get('show_pembelian_per_product', [LaporanController::class, 'show_pembelian_per_product'])->name('show_pembelian_per_product');
    Route::post('result_pembelian_per_product', [LaporanController::class, 'result_pembelian_per_product'])->name('result_pembelian_per_product');




    // pajak
    // laporan pajak pemotongan
    Route::get('show_laporan_pajak_pemotongan', [LaporanController::class, 'show_laporan_pajak_pemotongan'])->name('show_laporan_pajak_pemotongan');
    Route::post('result_laporan_pajak_pemotongan', [LaporanController::class, 'result_laporan_pajak_pemotongan'])->name('result_laporan_pajak_pemotongan');
    // laporan pajak penjualan
    Route::get('show_laporan_pajak', [LaporanController::class, 'show_laporan_pajak'])->name('show_laporan_pajak');
    Route::post('result_laporan_pajak', [LaporanController::class, 'result_laporan_pajak'])->name('result_laporan_pajak');


    // barang
    // ringkasan persediaan barang
    Route::get('show_ringkasan_persediaan_barang', [LaporanController::class, 'show_ringkasan_persediaan_barang'])->name('show_ringkasan_persediaan_barang');
    Route::post('result_ringkasan_persediaan_barang', [LaporanController::class, 'result_ringkasan_persediaan_barang'])->name('result_ringkasan_persediaan_barang');
    // nilai persediaan barang
    Route::get('show_nilai_persediaan_barang', [LaporanController::class, 'show_nilai_persediaan_barang'])->name('show_nilai_persediaan_barang');
    Route::post('result_nilai_persediaan_barang', [LaporanController::class, 'result_nilai_persediaan_barang'])->name('result_nilai_persediaan_barang');
    // nilai persediaan barang
    Route::get('show_rincian_persediaan_barang', [LaporanController::class, 'show_rincian_persediaan_barang'])->name('show_rincian_persediaan_barang');
    Route::post('result_rincian_persediaan_barang', [LaporanController::class, 'result_rincian_persediaan_barang'])->name('result_rincian_persediaan_barang');


    // Bank
    // Saldo seluruh
    Route::get('show_ringkasan_persediaan_barang', [LaporanController::class, 'show_ringkasan_persediaan_barang'])->name('show_ringkasan_persediaan_barang');
    Route::post('result_ringkasan_persediaan_barang', [LaporanController::class, 'result_ringkasan_persediaan_barang'])->name('result_ringkasan_persediaan_barang');
    Route::get('show_saldo_account', [LaporanController::class, 'show_saldo_account'])->name('show_saldo_account');
    // mutasi rekening
    Route::get('show_mutasi_rekening', [LaporanController::class, 'show_mutasi_rekening'])->name('show_mutasi_rekening');
    Route::post('result_mutasi_rekening', [LaporanController::class, 'result_mutasi_rekening'])->name('result_mutasi_rekening');


    // Bisnis
    // buku besar
    Route::get('show_buku_besar', [LaporanController::class, 'show_buku_besar'])->name('show_buku_besar');
    Route::post('result_buku_besar', [LaporanController::class, 'result_buku_besar'])->name('result_buku_besar');
    // buku besar
    Route::get('show_jurnal', [LaporanController::class, 'show_jurnal'])->name('show_jurnal');
    Route::post('result_jurnal', [LaporanController::class, 'result_jurnal'])->name('result_jurnal');
    // Laba rugi
    Route::get('show_laba_rugi', [LaporanController::class, 'show_laba_rugi'])->name('show_laba_rugi');
    Route::post('result_laba_rugi', [LaporanController::class, 'result_laba_rugi'])->name('result_laba_rugi');
    // neraca
    Route::get('show_neraca', [LaporanController::class, 'show_neraca'])->name('show_neraca');
    Route::post('result_neraca', [LaporanController::class, 'result_neraca'])->name('result_neraca');

    //jurnal penyesuaian
    Route::get('show_jurnal_penyesuaian', [LaporanController::class, 'show_jurnal_penyesuaian'])->name('show_jurnal_penyesuaian');
    Route::post('result_jurnal_penyesuaian', [LaporanController::class, 'result_jurnal_penyesuaian'])->name('result_jurnal_penyesuaian');


    // api syarat pembayaran id
    Route::get('get_syarat_pembayaran_id/{id}', [PembelianController::class, 'get_syarat_pembayaran_id'])->name('get_syarat_pembayaran_id');
    Route::get('get_account_by_id/{id}', [PembelianController::class, 'get_account_by_id'])->name('get_account_by_id');


    Route::post('saldo_awal/{id}', [AccountBankController::class, 'saldo_awal'])->name('saldo_awal');


    Route::resource('rulesJurnal', RulesJurnalController::class);
});
