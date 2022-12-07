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

        <div class="kwitansi bg-white p-5" id="print-invoice">
            <div class="row">
                <div class="col-md-2 col-2">
                    <div class="widger-logo bg-dark-o-50 p-3 rounded d-flex justify-content-center" style="overflow: hidden">
                        <img src="{{ asset('assets/image/logo-dzawani-group.png') }}" alt="" class="mr-2" style="max-height: 7em;">
                    </div>
                </div>
                <div class="col-md-10 col-10 p-0 text-center">
                    <h2 class="m-0">{{ $data->user_create->pegawai->company->nama_company }}</h2>
                    <p class="m-0">{{ $data->user_create->pegawai->company->alamat_company }}</p>
                    <p class="m-0">{{ $data->user_create->pegawai->company->email_company }}, {{ $data->user_create->pegawai->company->telpon_company }}</p>
                    <p class="m-0"><a href="{{ $data->user_create->pegawai->company->website_company }}">{{ $data->user_create->pegawai->company->website_company }}</a></p>
                </div>
            </div>
            <hr class="m-0 mt-5">
            <hr class="m-0 mt-1">
            <div class="row mt-5">
                <div class="col-md-12 col-12 text-center my-5">
                    <h3 class="font-weight-bolder mb-5">Invoice</h3>
                </div>
                <div class="col-md-7 col-7">
                    <table class="w-100 pr-5">
                        <tr class="d-flex flex-row">
                            <td width="30%" class="d-flex flex-column">Tagihan Kepada</td>
                            <td width="10%" >:</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="font-weight-bolder pl-5" width="50%">{{$data->customer->nama_customer}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-5 col-5">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <table>
                                <tr>
                                    @php
                                        $nama_company = $data->user_create->pegawai->company->nama_company;
                                        $pecah_nama_company = explode(' ', $nama_company);
                                        $array_nama = [];
                                        for ($i=0; $i < count($pecah_nama_company) ; $i++) { 
                                            array_push($array_nama, substr($pecah_nama_company[$i], 0,1) );
                                        }
                                        
                                    @endphp
                                    <td>No. Invoice/Faktur</td>
                                    <td>:</td>
                                    <td>{{ $data->no_transaksi }}/@php for ($i=0; $i < count($array_nama) ; $i++) echo $array_nama[$i]   @endphp/{{ date('d-m', strtotime($data->tanggal_transaksi)) }}/{{ date('Y', strtotime($data->tanggal_transaksi)) }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Pesanan</td>
                                    <td>:</td>
                                    <td> {{ $data_detail_count }} Pesanan</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Invoice/Faktur</td>
                                    <td>:</td>
                                    <td>{{ date('d-F-Y', strtotime($data->tanggal_transaksi)) }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pembayaran</td>
                                    <td>:</td>
                                    <td>{{ date('d-F-Y', strtotime($data->tanggal_transaksi)) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <table class="table table-hover mt-5">
                        <thead class="bg-primary-o-45">
                            <tr class="font-weight-bolder">
                                <th>
                                    @if ($data->type_penjualan == "Jasa")
                                        Jasa
                                    @else
                                        Product
                                    @endif
                                </th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Diskon</th>
                                <th>Pajak</th>
                                <th class="text-right">Total (dalam IDR)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data_detail as $item)
                                <tr>
                                    <td>
                                        @if ($item->product_id !== null)
                                            {{ $item->product2->nama_product }}
                                        @else
                                            {{ $item->nama_jasa }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item->qty_pembelian }}
                                    </td>
                                    <td>
                                        @if ($item->product_id == null)
                                            {{ number_format($item->harga_jasa,2,',','.'); }}
                                        @else
                                            {{ number_format($item->product2->harga_satuan,2,',','.'); }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->discount !== NULL)
                                            {{ number_format($item->besar_discount,2,',','.'); }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->pajak_id !== NULL)
                                            {{ number_format($item->potongan_pajak,2,',','.');  }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($item->total,2,',','.'); }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        data tidak ada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-8 col-8">
                    <table class="w-100">
                        <tr>
                            <td>
                                Keterangan
                            </td>
                            <td>:</td>
                            <td>{{ $data->pesan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 col-4">
                        <table class="w-100">
                            <tr>
                                <td>
                                    Sub Total
                                </td>
                                <td>:</td>
                                <td>{{ number_format($data->sub_total,2,',','.'); }}</td>
                            </tr>
                            <tr>
                                <td>
                                    Dibayar
                                </td>
                                <td>:</td>
                                <td>{{ number_format($data->total,2,',','.'); }}</td>
                            </tr>
                            <tr>
                                <td>
                                    Total
                                </td>
                                <td>:</td>
                                <td>{{ number_format($data->total,2,',','.'); }}</td>
                            </tr>
                        </table>
                </div>
            </div>
        </div>
        <div class="button-print">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button onclick="printContent('print-invoice')" class="btn btn-primary mt-3"> <i class="fa fa-print" aria-hidden="true"> Print</i></button>
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