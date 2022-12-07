@extends('layouts.app')

@section('content')
@php
    $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
@endphp

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Pegawai</li>
            </ol>
          </nav>

          <div class="content">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="nav-wrapper">
                @include('pages.pegawai.navigasi')
              </div>
            </div>
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Add Data Pegawai</h3>
                </div>
              </div>
              <div class="card-body bg-white">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                  @endif
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
                                @foreach ($hari as $h)
                                <div class="col-md-4 col-6">
                                  <label><input type="checkbox" name="hari_kerja[]" value="{{ $h }}"> {{ $h }}</label>
                                </div>
                                @endforeach
                                 {{-- <div class="col-md-4 col-6">
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
                                 </div> --}}
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
        <!-- /.container-fluid -->

@endsection