@extends('layouts.app')

@section('content')

  @php
    $months = ['January', 'February', 'March', 'April', 'Mei', 'June', 'July', 'August', 'September', 'Oktober', 'November', 'December'];
  @endphp

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Penilaian Kerja</li>
            </ol>
          </nav>

          <div class="content mb-4">
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Edit Data Penilaian Kerja</h3>
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
                  <form action="{{ route('penilaiankerja.update', $penilaiankerja->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="bulan">Bulan:</label>
                            <select name="bulan" class="form-control">
                                @foreach ($months as $i)
                                    <option value="{{ $i }}" {{ old('bulan', $penilaiankerja->bulan) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endforeach
                            </select>
                            <small id="bulan" class="text-muted">Tentukan bulan penilaian kerja</small>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="tahun">Tahun:</label>
                            <input type="text" name="tahun" id="tahun" class="form-control" value="{{ $penilaiankerja->tahun }}"> 
                            <small id="tahun" class="text-muted">Tentukan tahun penilaian kerja</small>
                          </div>
                        </div>
                      </div>
                      
                          <div class="form-group">
                            <label for="pegawai_id">Nama Pegawai:</label>
                            <select name="pegawai_id" id="pegawai_id" class="form-control">
                              <option value="" selected>--Tentukan Pegawai--</option>
                                @foreach ($pegawai as $b)
                                <option value="{{ $b->id }}" {{ old('pegawai_id', $penilaiankerja->pegawai_id) == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                                @endforeach
                            </select>
                            <small id="nama" class="text-muted">Tentukan pegawai yang melakukan penilaian kerja</small>
                          </div>
                        
                      <div class="form-group">
                        <label for="bobot_nilai">Bobot Nilai:</label>
                        <input type="text" name="bobot_nilai" id="bobot_nilai" class="form-control" value="{{ $penilaiankerja->bobot_nilai }}"> 
                        <small id="bobot_nilai" class="text-muted">Tentukan bobot nilai</small>
                      </div>
                      <div class="form-group">
                            <label for="keterangan">Keterangan:</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ $penilaiankerja->keterangan }}"> 
                            <small id="keterangan" class="text-muted">Tentukan Keterangan melakukan cuti</small>
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