@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5 m-0">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Absen</li>
            </ol>
          </nav>

          <div class="content">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="nav-wrapper">
                @include('pages.absen.navigasi')
              </div>
            </div>
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Edit Data Absen</h3>
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
                  <form action="{{ route('absen.update', $absen->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                      <div class="form-group">
                        <label for="pegawai_id">Nama pegawai:</label>
                        <select name="pegawai_id" id="pegawai_id" class="form-control">
                          <option value="" selected>--Tentukan Pegawai--</option>
                            @foreach ($pegawai as $b)
                              <option value="{{ $b->id }}" {{ old('pegawai_id', $absen->pegawai_id) == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                            @endforeach
                        </select>
                        <small id="nama" class="text-muted">Tentukan pegawai yang melakukan absen</small>
                      </div>
                      <div class="form-group">
                        <label for="tanggal">Tanggal:</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $absen->tanggal }}"> 
                        <small id="tanggal" class="text-muted">Tentukan tanggal absen</small>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="jam_masuk">Jam Masuk:</label>
                            <input type="text" name="jam_masuk" id="jam_masuk" class="form-control" value="{{ $absen->jam_masuk }}"> 
                            <small id="jam_masuk" class="text-muted">Tentukan tanggal mulai absen</small>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="jam_keluar">Tanggal Selesai:</label>
                            <input type="text" name="jam_keluar" id="jam_keluar" class="form-control" value="{{ $absen->jam_keluar }}"> 
                            <small id="jam_keluar" class="text-muted">Tentukan tanggal selesai absen</small>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                            <label for="keterangan">Keterangan:</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ $absen->keterangan }}"> 
                            <small id="keterangan" class="text-muted">Tentukan Keterangan Absen</small>
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