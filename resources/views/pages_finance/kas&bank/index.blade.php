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
                  <li class="breadcrumb-item active" aria-current="page">Kas & Bank</li>
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
                                <span><h4>Kas & Bank</h4></span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="aksi d-flex flex-row justify-content-md-end">
                                <div class="btn-group mr-3">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                      History Transaksi
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                      <a class="dropdown-item" type="button" href="{{ route('transferuang.index') }}"> <i class="fas fa-plus mr-1"></i>History Transfer Uang</a>
                                      <a class="dropdown-item" type="button" href="{{ route('kirimuang.index') }}"> <i class="fas fa-plus mr-1"></i>History Kirim Uang</a>
                                      <a class="dropdown-item" type="button" href="{{ route('terimauang.index') }}"> <i class="fas fa-plus mr-1"></i>History Terima Uang</a>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                      Lakukan Aksi
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                      <a class="dropdown-item" type="button" href="{{ route('transferuang.create') }}"> <i class="fas fa-plus mr-1"></i> Transfer Uang</a>
                                      <a class="dropdown-item" type="button" href="{{ route('kirimuang.create') }}"> <i class="fas fa-plus mr-1"></i> Kirim Uang</a>
                                      <a class="dropdown-item" type="button" href="{{ route('terimauang.create') }}"> <i class="fas fa-plus mr-1"></i> Terima Uang</a>
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="card p-5 border-left-danger mt-3">
                                <div class="row">
                                    <div class="col-md-9 col-9">
                                        <h6>Seluruh Biaya</h6>
                                        <h4 class="ml-2"><Strong>20000.00</Strong></h4>
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
                                        <h6>Biaya Bulan Ini</h6>
                                        <h4 class="ml-5"><strong>30000.00</strong></h4>
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
                                        <h6>Biaya Hari Ini</h6>
                                        <h4 class="ml-5"><strong>40000.00</strong></h4>
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
                  <h3 class="card-label text-gray-700">Daftar Kas & Bank</h3>
                </div>
              </div>
              <div class="card-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="pills-kas-tab" data-toggle="pill" href="#pills-kas" role="tab" aria-controls="pills-kas" aria-selected="true">Kas</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-bank-tab" data-toggle="pill" href="#pills-bank" role="tab" aria-controls="pills-bank" aria-selected="false">Bank</a>
                  </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-kas" role="tabpanel" aria-labelledby="pills-kas-tab">
                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable2">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>No</th>
                                <th>Nama Account</th>
                                <th>Nomor Account</th>
                                <th>Category</th>
                                <th>Nama Bank</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                  </div>
                  <div class="tab-pane fade" id="pills-bank" role="tabpanel" aria-labelledby="pills-bank-tab">
                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable3">
                      <thead class="bg-secondary text-white">
                          <tr>
                              <th>No</th>
                              <th>Nama Account</th>
                              <th>Nomor Account</th>
                              <th>Category</th>
                              <th>Nama Bank</th>
                              <th>Saldo</th>
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
            { data: 'nama', name: 'nama' },
            { data: 'nomor', name: 'nomor' },
            { data: 'category_account.nama_category_account', name: 'category_account.nama_category_account' },
            { data: 'nama_bank', name: 'nama_bank' },
            { data: 'saldo', name: 'saldo' },
        ]
    });


    var datatable = $('#crudTable3').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            responsive: true,
            autoWidth : true,
        ajax: {
            url: '{!! route('account_bank') !!}',
        },
        columns: [
            { data: 'DT_RowIndex', name:'DT_RowIndex'},
            { data: 'nama', name: 'nama' },
            { data: 'nomor', name: 'nomor' },
            { data: 'category_account.nama_category_account', name: 'category_account.nama_category_account' },
            { data: 'nama_bank', name: 'nama_bank' },
            { data: 'saldo', name: 'saldo' },
        ]
    });
</script>

@endpush