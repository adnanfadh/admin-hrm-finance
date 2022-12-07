@extends('layouts.app_finance') @section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box bg-white rounded p-5 mb-3">
                <h6 class="text-secondary">Setting</h6>
                <h3 class="text-primary">Daftar Lainnya</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box p-3 bg-white rounded shadow-sm">
                <div class="row">
                    <div class="col-md-6 col-12 p-5">
                        <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded"  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="100">
                            <h2 class="text-primary">Metode Pembayaran</h2>
                            <p class="text-sm font-size-sm">Atur jenis metode pembayaran untuk seluruh transaksi.</p>
                            <a href="{{ route('metodepembayaran.index') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Show</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 p-5">
                        <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded "  data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="150">
                            <h2 class="text-primary">Syarat Pembayaran</h2>
                            <p class="text-sm font-size-sm">
                                Atur syarat pembayaran untuk seluaruh transaksi yang dilakukan.
                            </p>
                            <a href="{{ route('syaratpembayaran.index') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Show</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 p-5">
                        <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded" data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="200">
                            <h2 class="text-primary">Pajak</h2>
                            <p class="text-sm font-size-sm">
                                Atur pajak yang akan ditetapkan disetiap transaksi pada aplikasi ini.
                            </p>
                            <a href="{{ route('pajak.index') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Show</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 p-5">
                        <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded" data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="250">
                            <h2 class="text-primary">Category Account</h2>
                            <p class="text-sm font-size-sm">
                                Atur category akun yang akan dibuat dann digunakan pada saat transaksi.
                            </p>
                            <a href="{{ route('categoryaccount.index') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Show</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 p-5">
                        <div class="box bg-hover-secondary-o-10 bg-secondary-o-10 p-5 rounded" data-aos="fade-down" data-aos-easing="ease-in-sine" data-aos-delay="250">
                            <h2 class="text-primary">Rules Jurnal Input</h2>
                            <p class="text-sm font-size-sm">
                                Atur Jurnal Input setiap kondisi transaksi
                            </p>
                            <a href="{{ route('rulesJurnal.index') }}" class="btn border-primary text-hover-primary font-weight-bold btn-bg-white border-2">Show</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection