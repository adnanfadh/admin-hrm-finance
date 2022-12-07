@extends('layouts.app')

@section('content')

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
                  <form action="{{ route('pegawai.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="kode_pegawai">Kode Pegawai:</label>
                          <input type="text" name="kode_pegawai" id="kode_pegawai" class="form-control bg-secondary" value="{{ $kode }}" readonly>
                          <small id="kode_pegawai" class="text-muted">Kode pegawai digenerate otomatis oleh sistem</small>
                        </div>
                      </div>
                      <div class="col-md-8 col-12">
                        <div class="form-group">
                          <label for="nama">Nama Pegawai:</label>
                          <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}">
                          <small id="nama" class="text-muted">Tentukan nama untuk pegawai yang baru</small>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir:</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}">
                            <small id="tempat_lahir" class="text-muted">Tentukan tempat_lahir untuk pegawai yang baru</small>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir:</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                            <small id="tanggal_lahir" class="text-muted">Tentukan tanggal_lahir untuk pegawai yang baru</small>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin:</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                              <option value="" selected>--Tentukan jenis kelamin--</option>
                              <option value="laki-laki">Laki-laki</option>
                              <option value="perempuan">Perempuan</option>
                            </select>
                            <small id="nama" class="text-muted">Tentukan jenis kelamin pegawai baru</small>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="status">Status:</label>
                            <select name="status" id="status" class="form-control">
                              <option value="" selected>--Tentukan Status--</option>
                              <option value="Menikah">Menikah</option>
                              <option value="Belum">Belum Menikah</option>
                            </select>
                            <small id="status" class="text-muted">Tentukan status untuk pegawai baru</small>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="shift_id">Shift:</label>
                            <select name="shift_id" id="shift_id" class="form-control">
                              <option value="" selected>--Tentukan Shift Kerja--</option>
                              {{-- @foreach ($shift as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                              @endforeach --}}
                              @foreach ($shift as $s)
                                <option value="{{ $s->id }}">{{ $s->shift_name }}</option>
                              @endforeach
                            </select>
                            <small id="status" class="text-muted">Tentukan shift kerja pegawai baru</small>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat:</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat') }}">
                        <small id="alamat" class="text-muted">Berikan alamat untuk pegawai yang baru</small>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="company_id">Company:</label>
                          <select name="company_id" id="company_id" class="form-control">
                            <option value="" selected>--Tentukan Company--</option>
                              @foreach ($company as $b)
                              @if (Auth::user()->pegawai->company->nama_company == "Panca Wibawa Global")
                                    <option value="{{ $b->id }}">{{ $b->nama_company }}</option>
                              @else
                                @if (Auth::user()->pegawai->company->nama_company == $b->nama_company)
                                    <option value="{{ $b->id }}" selected>{{ $b->nama_company }}</option>
                                @endif
                              @endif
                              @endforeach
                          </select>
                          <small id="nama" class="text-muted">Tentukan Company untuk pegawai baru</small>
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="bidang_id">Departemen:</label>
                          <select name="bidang_id" id="bidang_id" class="form-control">
                            <option value="" selected>--Tentukan Departemen--</option>
                              @foreach ($bidang as $b)
                              @if (Auth::user()->pegawai->company->nama_company == "Panca Wibawa Global")
                                    <option value="{{ $b->id }}">{{ $b->nama }}</option>
                              @else
                                @if ($b->nama != "Head Office")
                                    <option value="{{ $b->id }}">{{ $b->nama }}</option>
                                @endif
                              @endif
                              @endforeach
                          </select>
                          <small id="nama" class="text-muted">Tentukan departemen untuk pegawai baru</small>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="jabatan_id">Jabatan:</label>
                          <select name="jabatan_id" id="jabatan_id" class="form-control">
                            <option value="" selected>--Tentukan Jabatan--</option>
                              @foreach ($jabatan as $b)
                                <option value="{{ $b->id }}">{{ $b->nama }}</option>
                              @endforeach
                          </select>
                          <small id="nama" class="text-muted">Tentukan jabatan untuk pegawai baru</small>
                        </div>
                      </div>
                      <div class="col-md-6 col-12">
                        <div class="form-group">
                          <label for="tlp">Telepon:</label>
                          <input type="text" name="tlp" id="tlp" class="form-control" value="{{ old('tlp') }}">
                          <small id="tlp" class="text-muted">Tentukan telp untuk pegawai baru</small>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="ttd">TTD</label>
                          <input type="file" name="ttd" id="ttd" class="form-control">
                          <small id="helpId" class="text-muted">*Boleh Kosong</small>
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
