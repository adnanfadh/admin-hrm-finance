@extends('layouts.app_finance') @section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box p-5 bg-white rounded shadow-sm">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-bisnis-tab" data-toggle="tab" href="#nav-bisnis" role="tab" aria-controls="nav-bisnis" aria-selected="true">Bisnis</a>
                        <a class="nav-item nav-link" id="nav-penjualan-tab" data-toggle="tab" href="#nav-penjualan" role="tab" aria-controls="nav-penjualan" aria-selected="false">Penjualan</a>
                        <a class="nav-item nav-link" id="nav-pembelian-tab" data-toggle="tab" href="#nav-pembelian" role="tab" aria-controls="nav-pembelian" aria-selected="false">Pembelian</a>
                        <a class="nav-item nav-link" id="nav-product-tab" data-toggle="tab" href="#nav-product" role="tab" aria-controls="nav-product" aria-selected="false">Product</a>
                        <a class="nav-item nav-link" id="nav-bank-tab" data-toggle="tab" href="#nav-bank" role="tab" aria-controls="nav-bank" aria-selected="false">Bank</a>
                        <a class="nav-item nav-link" id="nav-pajak-tab" data-toggle="tab" href="#nav-pajak" role="tab" aria-controls="nav-pajak" aria-selected="false">Pajak</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    {{-- start tab laporan bisnis --}}
                    <div class="tab-pane fade show active" id="nav-bisnis" role="tabpanel" aria-labelledby="nav-bisnis-tab">
                        <div class="row">
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="100">
                                    <h2 class="text-primary">Jurnal Penyesuaian</h2>
                                    <p class="text-sm font-size-sm">Merupakan fitur yang memiliki fungsi utama untuk menyesuaikan laporan jurnal dari jurnal entry tiap transaksi</p>
                                    <a href="{{ route('show_jurnal_penyesuaian') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lakukan Penyesuaian</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="100">
                                    <h2 class="text-primary">Neraca</h2>
                                    <p class="text-sm font-size-sm">Menampilan apa yang anda miliki (aset), apa yang anda hutang (liabilitas), dan apa yang anda sudah investasikan pada perusahaan anda (ekuitas).</p>
                                    <a href="{{ route('show_neraca') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded "  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="150">
                                    <h2 class="text-primary">Buku Besar</h2>
                                    <p class="text-sm font-size-sm">
                                        Laporan ini menampilkan semua transaksi yang telah dilakukan untuk suatu periode. Laporan ini bermanfaat jika Anda memerlukan daftar kronologis untuk semua transaksi yang telah dilakukan oleh perusahaan Anda.
                                    </p>
                                    <a href="{{ route('show_buku_besar') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded" data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="200">
                                    <h2 class="text-primary">Jurnal</h2>
                                    <p class="text-sm font-size-sm">
                                        Daftar semua jurnal per transaksi yang terjadi dalam periode waktu. Hal ini berguna untuk melacak di mana transaksi Anda masuk ke masing-masing rekening
                                    </p>
                                    <a href="{{ route('show_jurnal') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded" data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="250">
                                    <h2 class="text-primary">Arus Kas</h2>
                                    <p class="text-sm font-size-sm">
                                        Laporan ini mengukur kas yang telah dihasilkan atau digunakan oleh suatu perusahaan dan menunjukkan detail pergerakannya dalam suatu periode.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded" data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="300">
                                    <h2 class="text-primary">Laporan Laba-Rugi</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan setiap tipe transaksi dan jumlah total untuk pendapatan dan pengeluaran anda.
                                    </p>
                                    <a href="{{ route('show_laba_rugi') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded" data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="350">
                                    <h2 class="text-primary">Trial Balance</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan saldo dari setiap akun, termasuk saldo awal, pergerakan, dan saldo akhir dari periode yang ditentukan.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded" data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="400">
                                    <h2 class="text-primary">Perubahan Modal</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan perubahan atau pergerakan dalam ekuitas pemilik yang terjadi dalam periode tertentu.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded" data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="450">
                                    <h2 class="text-primary">Ringkasan Bisnis</h2>
                                    <p class="text-sm font-size-sm">
                                        Laporan Ringkasan Bisnis Menampilkan ringkasan dari laporan keuangan standar beserta wawasannya.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end tab laporan bisnis --}}
                    {{-- start tab laporan penjualan --}}
                    <div class="tab-pane fade" id="nav-penjualan" role="tabpanel" aria-labelledby="nav-penjualan-tab">
                        <div class="row">
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="100">
                                    <h2 class="text-primary">Daftar Penjualan</h2>
                                    <p class="text-sm font-size-sm">
                                        Menunjukkan daftar kronologis dari semua faktur, pemesanan, penawaran, dan pembayaran Anda untuk rentang tanggal yang dipilih.
                                    </p>
                                    <a href="{{ route('show_daftar_penjualan') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="150">
                                    <h2 class="text-primary">Penjualan Per Pelanggan</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan setiap transaksi penjualan untuk setiap pelanggan, termasuk tanggal, tipe, jumlah dan total.
                                    </p>
                                    <a href="{{ route('show_penjualan_per_pelanggan') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="200">
                                    <h2 class="text-primary">Laporan Piutang Pelanggan</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan tagihan yang belum dibayar untuk setiap pelanggan, termasuk nomor & tanggal faktur, tanggal jatuh tempo, jumlah nilai, dan sisa tagihan yang terhutang pada Anda.
                                    </p>
                                    <a href="{{ route('show_piutang_pelanggan') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="250">
                                    <h2 class="text-primary">Penjualan Selesai</h2>
                                    <p class="text-sm font-size-sm">
                                        Laporan ini menampilkan penjualan dengan status selesai atau lunas.
                                    </p>
                                    <a href="{{ route('show_penjualan_selesai') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="300">
                                    <h2 class="text-primary">Laporan Pengiriman Penjualan</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan semua produk yang dicatat terkirim untuk transaksi penjualan dalam suatu periode, dikelompok per pelanggan.
                                    </p>
                                    <a href="{{ route('show_pengiriman_penjualan') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div> --}}
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="350">
                                    <h2 class="text-primary">Penjualan Per Product</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan daftar kuantitas penjualan per produk, termasuk jumlah retur, net penjualan, dan harga penjualan rata-rata.
                                    </p>
                                    <a href="{{ route('show_penjualan_per_product') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="250">
                                    <h2 class="text-primary">Usia Piutang</h2>
                                    <p class="text-sm font-size-sm">
                                        Laporan ini memberikan ringkasan piutang Anda, yang menunjukkan setiap pelanggan karena Anda secara bulanan, serta jumlah total dari waktu ke waktu. Hal ini praktis untuk membantu melacak piutang Anda.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="400">
                                    <h2 class="text-primary">Penyelsaian Pemesanan Penjualan</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan ringkasan dari proses bisnis Anda, dari penawaran, pemesanan, pengiriman, penagihan, dan pembayaran per proses, agar Anda dapat melihat penawaran/pemesanan mana yang berlanjut ke penagihan.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="450">
                                    <h2 class="text-primary">Profitabilitas Product</h2>
                                    <p class="text-sm font-size-sm">
                                        Melihat keuntungan total yang diperoleh dari produk tertentu
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    {{-- end tab laporan penjualan --}}
                    {{-- start tab laporan pembelian --}}
                    <div class="tab-pane fade" id="nav-pembelian" role="tabpanel" aria-labelledby="nav-pembelian-tab">
                        <div class="row">
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="100">
                                    <h2 class="text-primary">Daftar Pembelian</h2>
                                    <p class="text-sm font-size-sm">
                                        Menunjukkan daftar kronologis dari semua pembelian, pemesanan, penawaran, dan pembayaran Anda untuk rentang tanggal yang dipilih.
                                    </p>
                                    <a href="{{ route('show_daftar_pembelian') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="250">
                                    <h2 class="text-primary">Pembelian Selesai</h2>
                                    <p class="text-sm font-size-sm">
                                        Laporan ini menampilkan pembelian dengan status selesai atau lunas.
                                    </p>
                                    <a href="{{ route('show_pembelian_selesai') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="150">
                                    <h2 class="text-primary">Pembelian Per Supplier</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan setiap pembelian dan jumlah untuk setiap Supplier.
                                    </p>
                                    <a href="{{ route('show_pembelian_per_supplier') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="200">
                                    <h2 class="text-primary">Laporan Hutang Supplier</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan jumlah nilai yang Anda hutang pada setiap Supplier.
                                    </p>
                                    <a href="{{ route('show_hutang_supplier') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="250">
                                    <h2 class="text-primary">Daftar Pengeluaran</h2>
                                    <p class="text-sm font-size-sm">
                                        Daftar seluruh pengeluaran dengan keterangannya untuk kurung waktu yg ditentukan.
                                    </p>
                                    <a href="{{ route('show_daftar_pengeluaran') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="450">
                                    <h2 class="text-primary">Pembelian Per Product</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan daftar kuantitas pembelian per produk, termasuk jumlah retur, net pembelian, dan harga pembelian rata-rata.
                                    </p>
                                    <a href="{{ route('show_pembelian_per_product') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="300">
                                    <h2 class="text-primary">Rincian Pengeluaran</h2>
                                    <p class="text-sm font-size-sm">
                                        Laporan ini merincikan pengeluaran-2, dan dikelompokan dalam kategori masing2 dalam jangka waktu yg Anda tentukan.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="350">
                                    <h2 class="text-primary">Usia Hutang</h2>
                                    <p class="text-sm font-size-sm">
                                        Laporan ini memberikan ringkasan hutang Anda, menunjukkan setiap vendor Anda secara bulanan, serta jumlah total dari waktu ke waktu. Hal ini praktis untuk membantu melacak hutang Anda.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="400">
                                    <h2 class="text-primary">Laporan Pengiriman Pembelian</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan semua produk yang dicatat terkirim untuk transaksi pembelian dalam suatu periode, dikelompok per supplier.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div> --}}
                            
                            {{-- <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="450">
                                    <h2 class="text-primary">Penyelesaian Pemesanan Product</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan ringkasan dari proses bisnis Anda, dari penawaran, pemesanan, pengiriman, penagihan, dan pembayaran per proses, agar Anda dapat melihat penawaran/pemesanan mana yang berlanjut ke penagihan.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    {{-- end tab laporan pembelian --}}
                    {{-- start tab laporan product --}}
                    <div class="tab-pane fade" id="nav-product" role="tabpanel" aria-labelledby="nav-product-tab">
                        <div class="row">
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="100">
                                    <h2 class="text-primary">Ringkasan Persedian Barang</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan daftar kuantitas dan nilai seluruh barang persediaan berdasarkan category yg ditentukan.
                                    </p>
                                    <a href="{{ route('show_ringkasan_persediaan_barang') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="150">
                                    <h2 class="text-primary">Kuantitas Stok Gudang</h2>
                                    <p class="text-sm font-size-sm">
                                        Laporan ini menampilkan kuantitas stok di setiap gudang untuk semua produk.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div> --}}
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="200">
                                    <h2 class="text-primary">Nilai Persediaan Barang</h2>
                                    <p class="text-sm font-size-sm">
                                        Rangkuman informasi penting seperti sisa stok yg tersedia, nilai, dan biaya rata-rata, untuk setiap barang persediaan.
                                    </p>
                                    <a href="{{ route('show_nilai_persediaan_barang') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="250">
                                    <h2 class="text-primary">Nilai Stok Gudang</h2>
                                    <p class="text-sm font-size-sm">
                                        Laporan ini menampilkan penilaian persediaan per gudang untuk semua produk.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div> --}}
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="300">
                                    <h2 class="text-primary">Rincian Persediaan Barang</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan daftar transaksi yg terkait dengan setiap Barang dan Jasa, dan menjelaskan bagaimana transaksi tersebut mempengaruhi jumlah stok barang, nilai, dan harga biaya nya.
                                    </p>
                                    <a href="{{ route('show_rincian_persediaan_barang') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            {{-- <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="350">
                                    <h2 class="text-primary">Pergerakan Barang Gudang</h2>
                                    <p class="text-sm font-size-sm">
                                        Laporan ini menampilkan pergerakan stok per gudang dan merincikan transaksi yg menghasilkan pergerakan stok per gudang untuk semua produk atau stok per produk untuk semua gudang dalam suatu periode.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    {{-- end tab lapora product --}}
                    {{-- start tab lapran bank --}}
                    <div class="tab-pane fade" id="nav-bank" role="tabpanel" aria-labelledby="nav-bank-tab">
                        <div class="row">
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="100">
                                    <h2 class="text-primary">Daftar Saldo semua Account</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan semua saldo dari semua account yang ada.
                                    </p>
                                    <a href="{{ route('show_saldo_account') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="100">
                                    <h2 class="text-primary">Laporan Rekonsiliasi</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan ringkasan rekonsiliasi bank yang sudah tercatat, dan juga perubahan saldo yang belum di catat atau identifikasi.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="150">
                                    <h2 class="text-primary">Mutasi Rekening</h2>
                                    <p class="text-sm font-size-sm">
                                        Daftar seluruh transaksi rekening bank dalam suatu periode.
                                    </p>
                                    <a href="{{ route('show_mutasi_rekening') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end tab laporan bank --}}
                    {{-- start tab laporan pajak --}}
                    <div class="tab-pane fade" id="nav-pajak" role="tabpanel" aria-labelledby="nav-pajak-tab">
                        <div class="row">
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="100">
                                    <h2 class="text-primary">Laporan Pajak Pemotongan</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan ringkasan perhitungan pajak dengan tipe pemotongan yang digunakan pada transaksi Anda berdasarkan objek pajak.
                                    </p>
                                    <a href="/error" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 p-5">
                                <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="150">
                                    <h2 class="text-primary">Laporan Pajak</h2>
                                    <p class="text-sm font-size-sm">
                                        Menampilkan ringkasan perhitungan pajak dengan tipe penambahan yang digunakan pada transaksi Anda.
                                    </p>
                                    <a href="{{ route('show_laporan_pajak') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Lihat Laporan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end tab laporan pajak --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection