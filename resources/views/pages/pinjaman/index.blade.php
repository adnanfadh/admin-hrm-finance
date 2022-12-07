@extends('layouts.app')

@section('content')

    {{-- container --}}
    <div class="container-fluid">
        {{-- breadcump --}}
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5 mb-0">
                <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i>  Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pinjaman</li>
            </ol>
        </nav>
        {{-- end breadcump --}}
        {{-- notification --}}
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
        {{-- end notification --}}

        {{-- start content --}}
        <div class="content">
            {{-- start navigasi menu --}}
            <div class="col-12 col-md-12 col-lg-12">
              <div class="nav-wrapper">
                @include('pages.gaji.navigasi')
              </div>
            </div>
            {{-- end navigasi menu --}}
            {{-- start card content --}}
            <div class="card card-custom gutter-b border-0 shadow">
                <div class="card-header">
                    <div class="card-title justify-content-between w-100">
                        <h3 class="card-label text-gray-700">Pinjaman</h3>
                        <a href="{{ route('pinjaman.create') }}" class="btn btn-primary">Add Pinjaman</a>
                    </div>
                </div>
                <div class="card-body bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pegawai</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Jumlah Pinjam</th>
                                    <th>Angsuran</th>
                                    <th>Alasan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
  
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- end card content --}}
        </div>
        {{-- end content --}}
    </div>
    {{-- end container --}}
    
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
                { data: 'pegawai.nama', name: 'pegawai.nama' },
                { data: 'tanggal_pinjam', name: 'tanggal_pinjam' },
                { data: 'jumlah_pinjam', name: 'jumlah_pinjam' },
                { data: 'angsuran',  name: 'angsuran' },
                { data: 'alasan',  name: 'alasan' },
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