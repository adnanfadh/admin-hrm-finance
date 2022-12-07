@extends('layouts.app_finance')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="row">
            <div class="col-md-12">
              <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb shadow-sm bg-white p-5">
                  <li class="breadcrumb-item"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                </ol>
              </nav>
            </div>
          </div> 
          <div class="row">
              {{-- @php
              $data = date("m-d");
                  echo $data;
              @endphp --}}
            <div class="col-12 col-md-12 col-lg-12">
              @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong>{{ $message }}</strong>
                </div>
                <script>
                    Swal.fire({
                        type: 'success',
                        title: 'Success...',
                        text: '{{ $message }}'
                    });
                </script>
              @endif
  
              @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong>{{ $message }}</strong>
                </div>
                <script>
                    Swal.fire({
                        type: 'error',
                        title: 'Oops..',
                        text: '{{ $message }}'
                    });
                </script>
              @endif
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
                <div class="box bg-white rounded p-5">
                    <div class="row mb-2 d-flex flex-row">
                        <div class="col-md-4">
                            <div class="title d-flex flex-row justify-content-center justify-content-lg-start mt-3">
                                <span><h4>Keuntungan Penjualan</h4></span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="aksi d-flex flex-row justify-content-md-end">
                                {{-- <a href="{{ url('/fnc/showTagihan') }}" class="btn btn-primary btn-sm m-1"><i class="fas fa-book-open"> Catat Penagihan Penjualan</i></a> --}}
                                <a href="{{ route('penjualan.create') }}" class="btn btn-info btn-sm m-1"><i class="fas fa-book-open"> Catat Pemesanan Penjualan</i></a>
                                {{-- <a href="{{ route('syaratpembayaran.index') }}" class="btn btn-secondary btn-sm m-1"><i class="fas fa-cogs"> Manage Syarat Pembayaran</i></a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="card p-5 border-left-danger mt-3">
                                <div class="row">
                                    <div class="col-md-9 col-9">
                                        <h6>Seluruh Penjualan</h6>
                                        <h4 class="ml-2"><Strong>{{ "Rp. ".number_format($seluruh_penjualan,2,',','.'); }}</Strong></h4>
                                    </div>
                                    <div class="col-md-3 col-3">
                                        <span>
                                            <i class="fas fa-address-book icon-4x"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card p-5 border-left-info mt-3">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h6>Penjualan Bulan Ini</h6>
                                        <h4 class="ml-5"><strong>{{ "Rp. ".number_format($penjualan_bulan_ini,2,',','.'); }}</strong></h4>
                                    </div>
                                    <div class="col-md-3">
                                        <span>
                                            <i class="fas fa-address-book icon-4x"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card p-5 border-left-primary mt-3">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h6>Penjualan Hari Ini</h6>
                                        <h4 class="ml-5"><strong>{{ "Rp. ".number_format($penjualan_hari_ini,2,',','.'); }}</strong></h4>
                                    </div>
                                    <div class="col-md-3">
                                        <span>
                                            <i class="fas fa-address-book icon-4x"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">
          <div class="col-md-12">
            
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">List Penjualan</h3>
                  
                </div>
              </div>
              <div class="card-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills-barang-tab" data-toggle="pill" href="#pills-barang" role="tab" aria-controls="pills-barang" aria-selected="true">Penjualan Barang</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills-jasa-tab" data-toggle="pill" href="#pills-jasa" role="tab" aria-controls="pills-jasa" aria-selected="false">Penjualan Jasa</a>
                    </li>
                  </ul>
                  <div class="tab-content bg-dark-o-10 p-2 rounded" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-barang" role="tabpanel" aria-labelledby="pills-barang-tab">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                            <thead class="bg-secondary">
                                <tr>
                                    <th>No</th>
                                    <th>No Transaksi</th>
                                    <th>Nama Customer</th>
                                    <th>Tgl Transaksi</th>
                                    {{-- <th>Metode Pembayaran</th> --}}
                                    <th>Total Pembelian</th>
                                    <th>Sisa Tagihan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-jasa" role="tabpanel" aria-labelledby="pills-jasa-tab">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable_jasa">
                            <thead class="bg-secondary text-white">
                                <tr>
                                    <th>No</th>
                                    <th>No Transaksi</th>
                                    <th>Nama Customer</th>
                                    <th>Tgl Transaksi</th>
                                    {{-- <th>Metode Pembayaran</th> --}}
                                    <th>Total Pembelian</th>
                                    <th>Sisa Tagihan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
            
            
          

        </div>
        <!-- /.container-fluid -->

@endsection

@push('addon-script')

<script>
    // AJAX DataTable
    var datatable = $('#crudTable').DataTable({
        processing: true,
            serverSide: true,
            ordering: true,
            responsive: true,
            autoWidth : true,
        ajax: {
            url: '{!! url()->current() !!}',
        },
        columns: [
            { data: 'DT_RowIndex', name:'DT_RowIndex'},
            { data: 'no_transaksi', name: 'no_transaksi' },
            { data: 'customer.nama_customer', name: 'customer.nama_customer' },
            { data: 'tanggal_transaksi', name: 'tanggal_transaksi' },
            // { data: 'metode_pembayaran.nama_metode', name: 'metode_pembayaran.nama_metode' },
            { data: 'total', name: 'total' },
            { data: 'sisa_tagihan', name: 'sisa_tagihan'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '15%'
            },
        ]
    });
</script>

<script>
    // AJAX DataTable
    var datatable = $('#crudTable_jasa').DataTable({
        processing: true,
            serverSide: true,
            ordering: true,
            responsive: true,
            autoWidth : true,
        ajax: {
            url: '{!! route('index_jasa') !!}',
        },
        columns: [
            { data: 'DT_RowIndex', name:'DT_RowIndex'},
            { data: 'no_transaksi', name: 'no_transaksi' },
            { data: 'customer.nama_customer', name: 'customer.nama_customer' },
            { data: 'tanggal_transaksi', name: 'tanggal_transaksi' },
            // { data: 'metode_pembayaran.nama_metode', name: 'metode_pembayaran.nama_metode' },
            { data: 'total', name: 'total' },
            { data: 'sisa_tagihan', name: 'sisa_tagihan'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '15%'
            },
        ]
    });
</script>

@endpush