@extends('layouts.app_finance')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb shadow-sm bg-white p-5">
                        <li class="breadcrumb-item active"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true">Dashboard</i></a></li>
                        <li class="breadcrumb-item" aria-current="page">Account Bank</li>
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
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box bg-white p-5 rounded">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-row justify-content-between">
                            <h3>List Account</h3>
                            <a href="{{ route('accountbank.create') }}" class="btn btn-primary"> <i class="fas fa-plus "></i> Add Account</a>
                        </div>
                    </div>
                    <hr class="bg-dark-o-50">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                <thead class="bg-secondary text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor</th>
                                        <th>Nama</th>
                                        {{-- <th>Nama Bank</th> --}}
                                        <th>Kategori Akun</th>
                                        <th>Saldo(dalam IDR)</th>
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

    
@endsection


@push('addon-script')
    <script>
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
                { data: 'nomor_account', name: 'nomor_account' },
                { data: 'nama', name: 'nama' },
                // { data: 'nama_bank', name: 'nama_bank' },
                { data: 'category_account.nama_category_account', name: 'category_account.nama_category_account' },
                { data: 'saldo', name: 'saldo' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '15%'
                },
            ]
        })
    </script>
@endpush