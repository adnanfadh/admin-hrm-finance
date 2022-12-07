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
                  <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('kasbank.index') }}" style="text-decoration: none">Kas & Bank</a></li>
                  <li class="breadcrumb-item active" aria-current="page">History Transfer</li>
                </ol>
              </nav>
            </div>
          </div>
          <div class="row">
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
                                <span><h4>History Transfer</h4></span>
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
                  <h3 class="card-label text-gray-700">History Transfer Uang</h3>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable2">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>No</th>
                            <th>Tgl Transaksi</th>
                            <th>No Transaksi</th>
                            <th>Account Transfer</th>
                            <th>Account Setor</th>
                            <th>Jumlah</th>
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
        <!-- /.container-fluid -->

@endsection

@push('addon-script')

<script>
    // AJAX DataTable
    var datatable = $('#crudTable2').DataTable({
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
            { data: 'tanggal_transaksi', name: 'tanggal_transaksi' },
            { data: 'no_transaksi', name: 'no_transaksi' },
            { data: 'account_bank_transfer.nama', name: 'account_bank_transfer.nama' },
            { data: 'account_bank_setor.nama', name: 'account_bank_setor.nama' },
            { data: 'jumlah', name: 'jumlah' },
            {data: 'aksi', name: 'aksi', orderable: false, searchable: false, class: 'text-center'},
        ]
    });
</script>

@endpush