@extends('layouts.app')

@section('content')

  @php
    $months = ['January', 'February', 'March', 'April', 'Mei', 'June', 'July', 'August', 'September', 'Oktober', 'November', 'December'];
  @endphp

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Penilaian Kerja</li>
            </ol>
          </nav>

          <div class="content mb-4">
            <div class="card border-0 shadow">
              <div class="card-header p-3">
                <h3 class="h3 m-0 text-gray-700">Add Data Penilaian Kerja</h3>
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
                  <form action="{{ route('penilaiankerja.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="bulan">Bulan:</label>
                            <select name="bulan" class="form-control">
                                @foreach ($months as $i)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endforeach
                            </select>
                            <small id="bulan" class="text-muted">Tentukan bulan penilaian kerja</small>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="tahun">Tahun:</label>
                            <input type="text" name="tahun" id="tahun" class="form-control" value="{{ old('tahun') }}"> 
                            <small id="tahun" class="text-muted">Tentukan tahun penilaian kerja</small>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="pegawai_id">Nama Pegawai:</label>
                            <select name="pegawai_id" id="pegawai_id" class="form-control">
                              <option value="" selected>--Tentukan Pegawai--</option>
                                @foreach ($pegawai as $b)
                                  <option value="{{ $b->id }}">{{ $b->nama }}</option>
                                @endforeach
                            </select>
                            <small id="nama" class="text-muted">Tentukan pegawai yang melakukan penilaian kerja</small>
                          </div>
                        </div>
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="bidang_id">Nama Bidang:</label>
                            <select name="bidang_id" id="bidang_id" class="form-control">
                              <option value="" selected>--Tentukan bidang--</option>
                                @foreach ($bidang as $b)
                                  <option value="{{ $b->id }}">{{ $b->nama }}</option>
                                @endforeach
                            </select>
                            <small id="nama" class="text-muted">Tentukan pegawai yang melakukan penilaian kerja</small>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="bobot_nilai">Bobot Nilai:</label>
                        <input type="text" name="bobot_nilai" id="bobot_nilai" class="form-control" value="{{ old('bobot_nilai') }}"> 
                        <small id="bobot_nilai" class="text-muted">Tentukan bobot nilai</small>
                      </div>
                      <div class="form-group">
                            <label for="keterangan">Keterangan:</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ old('keterangan') }}"> 
                            <small id="keterangan" class="text-muted">Tentukan Keterangan melakukan penilaian kerja</small>
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
        <!-- /.container-fluid -->

@endsection