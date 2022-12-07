@extends('layouts.app_finance') 

@push('addon-style')
<style>
    .nav .active{
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb shadow-sm bg-white p-5">
                    <li class="breadcrumb-item"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kontak</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
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
            <div class="box bg-white rounded p-5">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-customer-tab" data-toggle="tab" href="#nav-customer" role="tab" aria-controls="nav-customer" aria-selected="true">Customer</a>
                        <a class="nav-item nav-link" id="nav-supplier-tab" data-toggle="tab" href="#nav-supplier" role="tab" aria-controls="nav-supplier" aria-selected="false">Supplier</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    {{-- start tab customer --}}
                    <div class="tab-pane fade show active" id="nav-customer" role="tabpanel" aria-labelledby="nav-customer-tab">
                        <div class="row mt-5">
                            <div class="col-md-12 d-flex flex-row justify-content-between">
                                <h3>Total Transaksi</h3>
                                <a href="{{ route('customer.create') }}" class="btn btn-primary">Add Customer</a>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 col-12 mt-3">
                                <div class="card p-5 border-left-danger">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h5>Piutang Belum Dibayar</h5>
                                            <h4>Rp. 2.500.000</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <span>
                                                <i class="fas fa-address-book icon-4x"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12 mt-3">
                                <div class="card p-5 border-left-info">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h5>Piutang Jatuh Tempo</h5>
                                            <h4>Rp. 2.500.000</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <span>
                                                <i class="fas fa-address-book icon-4x"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12 mt-3">
                                <div class="card p-5 border-left-warning">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h5>Kredit Memo</h5>
                                            <h4>Rp. 2.500.000</h4>
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
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                    <thead class="bg-secondary text-white">
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Customer</th>
                                            <th>Nama Customer</th>
                                            <th>Email</th>
                                            <th>Kontak</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- end tab customer --}} 
                    {{-- start tab supplier --}}
                    <div class="tab-pane fade" id="nav-supplier" role="tabpanel" aria-labelledby="nav-supplier-tab">
                        <div class="row mt-5">
                            <div class="col-md-12 d-flex flex-row justify-content-between">
                                <h3>Total Transaksi</h3>
                                <a href="{{ route('supplier.create') }}" class="btn btn-primary">Add Supplier</a>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 col-12 mt-3">
                                <div class="card p-5 border-left-danger">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h5>Hutang Belum Dibayar</h5>
                                            <h4>Rp. 2.500.000</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <span>
                                                <i class="fas fa-address-book icon-4x"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12 mt-3">
                                <div class="card p-5 border-left-info">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h5>Hutang Jatuh Tempo</h5>
                                            <h4>Rp. 2.500.000</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <span>
                                                <i class="fas fa-address-book icon-4x"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12 mt-3">
                                <div class="card p-5 border-left-warning">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h5>Kredit Memo</h5>
                                            <h4>Rp. 2.500.000</h4>
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
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTableSupplier">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Supplier</th>
                                            <th>Nama Supplier</th>
                                            <th>Email</th>
                                            <th>Kontak</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- end tab supplier --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('addon-script')

    <script>
        // AJAX DataTable
        var datatable = $('#crudTableSupplier').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            responsive: true,
            autoWidth : true,
            ajax: {
                url: '{{ route('supplier.index') }}',
            },
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'kode_supplier', name: 'kode_supplier' },
                { data: 'nama_supplier', name: 'nama_supplier' },
                { data: 'email_supplier', name: 'email_supplier' },
                { data: 'kontak_supplier', name: 'kontak_supplier' },
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
        var datatable = $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            responsive: true,
            autoWidth : true,
            ajax: {
                url: '{{ route('customer.index') }}',
            },
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'kode_customer', name: 'kode_customer' },
                { data: 'nama_customer', name: 'nama_customer' },
                { data: 'email', name: 'email' },
                { data: 'kontak', name: 'kontak' },
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