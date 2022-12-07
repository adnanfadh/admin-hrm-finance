@extends('layouts.app_finance')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb shadow-sm bg-white p-5">
                        <li class="breadcrumb-item active"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true">Dashboard</i></a></li>
                        <li class="breadcrumb-item" aria-current="page">Pembayaran</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12" >
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
                @endif @if ($message = Session::get('error'))
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
                                <span><h4>Pemabayaran</h4></span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="aksi d-flex flex-row justify-content-md-end">
                                <a href="{{ route('metodepembayaran.index') }}" class="btn btn-secondary btn-sm m-1"><i class="fas fa-cogs"> Manage Metode Pembayaran</i></a>
                                <a href="{{ route('syaratpembayaran.index') }}" class="btn btn-secondary btn-sm m-1"><i class="fas fa-cogs"> Manage Syarat Pembayaran</i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="card p-5 border-left-danger mt-3">
                                <div class="row">
                                    <div class="col-md-9 col-9">
                                        <h6>Pembayaran Selesai</h6>
                                        <h4 class="ml-2"><Strong>Rp. 200.000.000.00</Strong></h4>
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
                                        <h6>Bulan Ini <sup><span class="badge badge-success font-size-sm" style="font-size: 0.7rem">Selesai</span></sup></h6>
                                        <h4 class="ml-5"><strong>Rp. 20.000.000.00</strong></h4>
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
                                        <h6>Bulan Ini <sup><span class="badge badge-danger font-size-sm" style="font-size: 0.7rem">Tunggakan</span></sup></h6>
                                        <h4 class="ml-5"><strong>Rp. 20.000.000.00</strong></h4>
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
                <div class="box bg-white p-5 rounded">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-row justify-content-between">
                            <h3>List Pembayaran</h3>
                            <div class="btn-group dropleft">
                            <button type="button" class="btn btn-success btn-sm" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                                <i class="fas fa-plus"></i>Add Pembayaran
                              </button>
                              <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuOffset" style="border-radius: 10px 0px 10px 10px">
                                <a class="dropdown-item" href="#">Pembayaran Pembelian</a>
                                <a class="dropdown-item" href="#">Pembayaran Penjualan</a>
                              </div>
                            </div>
                            {{-- <a href="{{ route('product.create') }}" class="btn btn-primary"> <i class="fas fa-plus "></i> Add Pembayaran</a> --}}
                        </div>
                    </div>
                    <hr class="bg-dark-o-50">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                    <thead class="bg-secondary text-white">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Product</th>
                                            <th>Qty</th>
                                            <th>Satuan</th>
                                            <th>Harga Satuan</th>
                                            <th>Category</th>
                                            <th>Gambar</th>
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
@endsection


@push('addon-script')
    {{-- <script>
        // ajax datatable
        var datatable = $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            responsive: true,
            autoWidth : true,
            ajax: {
                url: '{!! url()->current() !!}'
            },
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'nama_product', name: 'nama_product' },
                { data: 'qty', name: 'qty' },
                { data: 'satuan', name: 'satuan' },
                { data: 'harga_satuan', name: 'harga_satuan' },
                { data: 'category', name: 'category' },
                { data: 'gambar', name: 'gambar' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '15%'
                },
            ]
        })
    </script> --}}
@endpush