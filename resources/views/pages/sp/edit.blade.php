@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Sp</li>
            </ol>
          </nav>

          <div class="content mb-4">
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Edit Data Sp</h3>
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
                  <form action="{{ route('sp.update', $sp->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                            <label for="no_surat">No Surat:</label>
                            <input type="text" name="no_surat" id="no_surat" class="form-control" value="{{ $sp->no_surat }}"> 
                            <small id="no_surat" class="text-muted">Tentukan no_surat sp</small>
                    </div>
                      <div class="row">
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="pegawai_id">Nama Pegawai:</label>
                          <select name="pegawai_id" id="pegawai_id" class="form-control">
                            <option value="" selected>--Tentukan Pegawai--</option>
                              @foreach ($pegawai as $b)
                              <option value="{{ $b->id }}" {{ old('pegawai_id', $sp->pegawai_id) == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                              @endforeach
                          </select>
                          <small id="nama" class="text-muted">Tentukan pegawai yang melakukan sp</small>
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="tanggal">Tanggal:</label>
                          <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $sp->tanggal }}"> 
                          <small id="tanggal" class="text-muted">Tentukan tanggal mulai sp</small>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                            <label for="pelanggaran">Pelanggaran:</label>
                            <input type="text" name="pelanggaran" id="pelanggaran" class="form-control" value="{{ $sp->pelanggaran }}"> 
                            <small id="pelanggaran" class="text-muted">Tentukan pelanggaran melakukan sp</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="sangsi">Sangsi:</label>
                            <input type="text" name="sangsi" id="sangsi" class="form-control" value="{{ $sp->sangsi }}"> 
                            <small id="nama" class="text-muted">Tentukan sangsi</small>
                          </div>
                        </div>
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="masa_berlaku">Masa Berlaku:</label>
                            <input type="number" name="masa_berlaku" id="masa_berlaku" class="form-control" value="{{ $sp->masa_berlaku }}"> 
                            <small id="masa_berlaku" class="text-muted">Tentukan masa berlaku sp</small>
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