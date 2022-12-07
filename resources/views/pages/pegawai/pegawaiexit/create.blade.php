@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Pegawai Exit</li>
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
                  <h3 class="card-label text-gray-700">Add Pegawai Exit</h3>
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
                  <form action="{{ route('pegawaiexit.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="pegawai_id">Pegawai:</label>
                          <select name="pegawai_id" id="pegawai_id" class="form-control">
                            <option value="" selected>--Tentukan Pegawai--</option>
                                @foreach ($pegawai as $b)
                                <option value="{{ $b->id }}">{{ $b->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="col-md-8 col-12">
                        <div class="form-group">
                          <label for="exit_date">Tanggal Keluar:</label>
                          <input type="date" name="exit_date" id="exit_date" class="form-control" value="{{ old('exit_date') }}"> 
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="exit_type">Tempat Lahir:</label>
                            <select name="exit_type" id="exit_type" class="form-control">
                                <option value="" selected>--Tentukan Exit Type--</option>
                                <option value="1">Mengundurkan Diri</option>
                                <option value="2">PHK</option>
                                <option value="3">Habis Kontrak</option>
                                <option value="4">Meninggal</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="dokumen_pendukung">Lampiran Dokumen:</label><br>
                            <input type="file" name="dokumen_pendukung" id="dokumen_pendukung" value="{{ old('dokumen_pendukung') }}"> 
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="description">Descriptions:</label>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
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