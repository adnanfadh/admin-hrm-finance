@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
              <ol class="breadcrumb shadow-sm bg-white p-5">
                <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i>  Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Shift</li>
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
          

          <div class="content">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="nav-wrapper">
                @include('pages.pegawai.navigasi')
              </div>
            </div>

            {{-- <div class="card card-custom gutter-b border-0 shadow p-0">
              <div class="card-body pl-8 pr-8 pb-0 pt-0">

                <div class="row">
                  <div class="col-12 col-md-12">
                      <div class="accordion accordion-toggle-arrow d-flex flex-row justify-content-between p-3" id="accordionExample1">
                        <h3 class="text-gray-700 mt-2">Form add shift kerja baru</h3>
                          <a class="btn btn-primary" data-toggle="collapse" data-target="#collapseOne1">
                            Add Shift
                          </a>
                      </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12 col-md-12">
                    <div id="collapseOne1" class="collapse p-10" data-parent="#accordionExample1">
                    <div class="form bg-gray-300 p-5 shadow rounded">
                      <form action="{{ route('shift.store') }}" method="post"  enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="shift_name">Shift Name:</label>
                            <input type="text" name="shift_name" id="shift_name" class="form-control" value="{{ old('shift_name') }}"> 
                          </div>
                          <div class="form-group">
                            <label>Hari Kerja:</label><br>
                            <div class="col-md-6">
                              <div class="row">
                                <div class="col-md-4 col-6">
                                  <label><input type="checkbox" name="hari_kerja[]" value="Senin"> Senin</label>
                                 </div>
                                 <div class="col-md-4 col-6">
                                   <label><input type="checkbox" name="hari_kerja[]" value="Selasa"> Selasa</label>
                                 </div>
                                 <div class="col-md-4 col-6">
                                   <label><input type="checkbox" name="hari_kerja[]" value="Rabu"> Rabu</label>
                                 </div>
                                 <div class="col-md-4 col-6">
                                   <label><input type="checkbox" name="hari_kerja[]" value="Kamis"> Kamis</label>
                                 </div>
                                 <div class="col-md-4 col-6">
                                   <label><input type="checkbox" name="hari_kerja[]" value="Jumat"> Jumat</label>
                                 </div>
                              </div>
                            </div>
                          </div>
                          
                          <div class="form-group">
                              <div class="row p-3 justify-content-md-start">
                                  <input type="submit" value="submit" class="btn btn-primary">
                              </div>
                        </div>
                      </form>
                    </div>
                     </div>
                  </div>
                </div>
              </div>
            </div> --}}


              <div class="card card-custom gutter-b border-0 shadow">
                <div class="card-header">
                  <div class="card-title d-flex w-100 justify-content-between">
                    <h3 class="card-label text-gray-700">List Shift</h3>
                    <a href="{{ route('shift.create') }}" class="btn btn-primary">Add Shift</a>
                    {{-- <a class="btn btn-primary" data-toggle="collapse" data-target="#collapseOne1">
                            Add Shift
                          </a> --}}
                  </div>
                </div>
                <div class="card-body bg-white">
                  <div class="table-responsive">
                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Shift Name</th>
                          <th>Hari Kerja</th>
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
                { data: 'shift_name', name: 'shift_name' },
                { data: 'hari_kerja', name: 'hari_kerja' },
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