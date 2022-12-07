@extends('layouts.app_finance')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Page Heading -->
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb shadow-sm bg-white p-5">
                    <li class="breadcrumb-item"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('penjualan.index') }}" style="text-decoration: none"> Penjualan</a></li>
                    <li class="breadcrumb-item " aria-current="page">Kwitansi Pembayaran</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="kwitansi bg-white p-5" id="print-kwitansi">
            <div class="row">
                <div class="col-md-2 col-2">
                    <div class="widger-logo bg-dark-o-50 p-3 rounded d-flex justify-content-center" style="overflow: hidden">
                        <img src="{{ asset('assets/image/logo-dzawani-group.png') }}" alt="" class="mr-2" style="max-height: 7em;">
                    </div>
                </div>
                <div class="col-md-10 col-10 p-0">
                    <h2 class="m-0">{{ $data->penjualan->user_create->pegawai->company->nama_company }}</h2>
                    <p class="m-0">{{ $data->penjualan->user_create->pegawai->company->alamat_company }}</p>
                    <p class="m-0">{{ $data->penjualan->user_create->pegawai->company->email_company }}, {{ $data->penjualan->user_create->pegawai->company->telpon_company }}</p>
                    <p class="m-0"><a href="{{ $data->penjualan->user_create->pegawai->company->website_company }}">{{ $data->penjualan->user_create->pegawai->company->website_company }}</a></p>
                </div>
            </div>
            <hr class="m-0 mt-5">
            <hr class="m-0 mt-1">
            <div class="row mt-5">
                <div class="col-md-8 col-8"></div>
                <div class="col-md-4 col-4">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <table>
                                @php
                                        $nama_company = $data->penjualan->user_create->pegawai->company->nama_company;
                                        $pecah_nama_company = explode(' ', $nama_company);
                                        $array_nama = [];
                                        for ($i=0; $i < count($pecah_nama_company) ; $i++) { 
                                            array_push($array_nama, substr($pecah_nama_company[$i], 0,1) );
                                        }
                                 @endphp
                                <tr>
                                    <td>No. Invoice</td>
                                    <td>:</td>
                                    <td>{{ $data->no_pembayaran }}/@php for ($i=0; $i < count($array_nama) ; $i++) echo $array_nama[$i]   @endphp/{{ date('d-m', strtotime($data->tanggal_bayar)) }}/{{ date('Y', strtotime($data->tanggal_bayar)) }}</td>
                                </tr>
                                <tr>
                                    <td>No. Kwitansi</td>
                                    <td>:</td>
                                    <td>{{ $data->no_pembayaran }}/@php for ($i=0; $i < count($array_nama) ; $i++) echo $array_nama[$i]   @endphp/{{ date('d-m', strtotime($data->tanggal_bayar)) }}/{{ date('Y', strtotime($data->tanggal_bayar)) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <table class="w-100 ">
                        <tr height="80px">
                            <td width="20%">
                                Telah diterima dari
                                <hr class="m-0">
                                Received from
                            </td>
                            <td width="10%" class="text-center">:</td>
                            <td width="70%">{{$data->penjualan->customer->nama_customer}}</td>
                        </tr>
                        <tr height="80px">
                            <td width="20%">
                                Sejumlah uang
                                <hr class="m-0">
                                Amount received
                            </td>
                            <td width="10%" class="text-center">:</td>
                            <td width="70%">{{ "Rp. ".number_format($data->nominal_pembayaran,2,',','.'); }}</td>
                        </tr>
                        <tr height="80px">
                            <td width="20%">
                                Untuk Pembayaran
                                <hr class="m-0">
                                In payment of
                            </td>
                            <td width="10%" class="text-center">:</td>
                            <td width="70%">{{$data->penjualan->customer->nama_customer}}</td>
                        </tr>
                        <tr height="80px">
                            <td width="20%">
                                Keterangan
                            </td>
                            <td width="10%" class="text-center">:</td>
                            <td width="70%">{{$data->keterangan ?? '-'}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-8 col-8">

                </div>
                <div class="col-md-4 col-4 d-flex flex-column justify-content-between">
                    <div class="header_place mb-5 text-center">
                        <p>Bandung, {{ date('d-F-Y', strtotime($data->tanggal_bayar)) }}</p>
                    </div>
                    <div class="signature_peaople mt-5 text-center">
                        <p class="m-0">{{ $data->penjualan->user_create->pegawai->company->pemberi_wewenang1 }}</p>
                        <p class="m-0">{{ $data->penjualan->user_create->pegawai->jabatan->nama }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="button-print">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button onclick="printContent('print-kwitansi')" class="btn btn-primary mt-3"> <i class="fa fa-print" aria-hidden="true"> Print</i></button>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
    </div>

@endsection

@push('addon-script')
<script>
    function printContent(el){
      var restorepage = document.body.innerHTML;
      var printcontent = document.getElementById(el).innerHTML;
      // document.body.style.width="48mm";
      document.body.innerHTML = printcontent;
      window.print();
      document.body.innerHTML = restorepage;
    }
  </script>

@endpush