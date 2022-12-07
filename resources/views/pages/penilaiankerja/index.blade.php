@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="col-12 col-md-12 col-lg-12">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
              <ol class="breadcrumb shadow-sm bg-white p-5">
                <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">List PenilaianKerja</li>
              </ol>
            </nav>

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

          <div class="content">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card card-custom gutter-b border-0 shadow">
                <div class="card-header">
                  <div class="card-title">
                    <h3 class="card-label text-gray-700">List Penilaian Kerja</h3>
                  </div>
                </div>
                <div class="card-body bg-white">
                  <a href="{{ route('penilaiankerja.create') }}" class="btn btn-primary mb-3"> <i class="fa fa-plus" aria-hidden="true"></i> Add Penilaian</a>
                  <div class="table-responsive">
                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>bulan</th>
                          <th>tahun</th>
                          <th>Nama Pegawai</th>
                          <th>Bidang</th>
                          <th>Jabatan</th>
                          <th>Bobot Nilai</th>
                          <th>Keterangan</th>
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
                { data: 'bulan', name:'bulan'},
                { data: 'tahun', name:'tahun'},
                { data: 'pegawai.nama', name: 'pegawai.nama' },
                { data: 'pegawai.bidang.nama', name: 'pegawai.bidang.nama' },
                { data: 'pegawai.jabatan.nama', name: 'pegawai.jabatan.nama' },
                { data: 'bobot_nilai', name: 'bobot_nilai' },
                { data: 'keterangan', name: 'keterangan' },
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