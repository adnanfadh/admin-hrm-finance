@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Sppd</li>
            </ol>
          </nav>

          <div class="content mb-4">
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Edit Data Sppd</h3>
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
                  <form action="{{ route('sppd.update', $sppd->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="pegawai_id">Nama Pegawai:</label>
                            <select name="pegawai_id" id="pegawai_id" class="form-control">
                              <option value="" selected>--Tentukan Pegawai--</option>
                                @foreach ($pegawai as $b)
                                <option value="{{ $b->id }}" {{ old('pegawai_id', $sppd->pegawai_id) == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                                @endforeach
                            </select>
                            <small id="nama" class="text-muted">Tentukan pegawai yang melakukan sp</small>
                          </div>
                        </div>
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="no_surat">No Surat:</label>
                            <input type="text" name="no_surat" id="no_surat" class="form-control" value="{{ $sppd->no_surat }}"> 
                            <small id="no_surat" class="text-muted">Tentukan no_surat sppd</small>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="tujuan">Tujuan:</label>
                            <input type="text" name="tujuan" id="tujuan" class="form-control" value="{{ $sppd->tujuan }}"> 
                            <small id="tujuan" class="text-muted">Tentukan tujuan dinas</small>
                          </div>
                        </div>
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                              <label for="perihal">Perihal:</label>
                              <input type="text" name="perihal" id="perihal" class="form-control" value="{{ $sppd->perihal }}"> 
                              <small id="perihal" class="text-muted">Tentukan perihal sppd</small>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="kendaraan">Kendaraan:</label>
                            <input type="text" name="kendaraan" id="kendaraan" class="form-control" value="{{ $sppd->kendaraan }}"> 
                            <small id="kendaraan" class="text-muted">Tentukan kendaraan dinas</small>
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="akomodasi">Akomodasi:</label>
                            <input type="text" name="akomodasi" id="akomodasi" class="form-control" value="{{ $sppd->akomodasi }}"> 
                            <small id="akomodasi" class="text-muted">Tentukan akomodasi dinas</small>
                        </div>
                      </div>
                    </div>
                      <div class="row">
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="tanggal_tugas">Tanggal tugas:</label>
                            <input type="date" name="tanggal_tugas" id="tanggal_tugas" class="form-control" value="{{ $sppd->tanggal_tugas }}"> 
                            <small id="tanggal_tugas" class="text-muted">Tentukan tanggal tugas sppd</small>
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                              <label for="tanggal_selesai">Tanggal selesai:</label>
                              <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ $sppd->tanggal_selesai }}"> 
                              <small id="tanggal_selesai" class="text-muted">Tentukan tanggal selesai sppd</small>
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                              <label for="tanggal_surat">Tanggal surat:</label>
                              <input type="date" name="tanggal_surat" id="tanggal_surat" class="form-control" value="{{ $sppd->tanggal_surat }}"> 
                              <small id="tanggal_surat" class="text-muted">Tentukan tanggal surat dinas</small>
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
        <!-- /.container-fluid -->

@endsection