@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Bpjs</li>
            </ol>
          </nav>

          <div class="content">
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Edit Data Bpjs</h3>
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
                  <form action="{{ route('bpjs.update', $bpjs->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                      <div class="form-group">
                        <label for="pegawai_id">Nama pegawai:</label>
                        <select name="pegawai_id" id="pegawai_id" class="form-control">
                          <option value="" selected>--Tentukan Pegawai--</option>
                            @foreach ($pegawai as $b)
                              <option value="{{ $b->id }}" {{ old('pegawai_id', $bpjs->pegawai_id) == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                            @endforeach
                        </select>
                        <small id="nama" class="text-muted">Tentukan pegawai yang melakukan bpjs</small>
                      </div>
                      <div class="form-group">
                        <label for="kode_bpjs">Kode BPJS:</label>
                        <input type="text" name="kode_bpjs" id="kode_bpjs" class="form-control" value="{{ $bpjs->kode_bpjs }}"> 
                        <small id="kode_bpjs" class="text-muted">Tentukan kode bpjs</small>
                      </div>
                      <div class="form-group">
                        <label for="jumlah_iuran">Jumlah Tagihan:</label>
                        <input type="number" name="jumlah_iuran" id="jumlah_iuran" class="form-control" value="{{ $bpjs->jumlah_iuran }}"> 
                        <small id="jumlah_iuran" class="text-muted">Tentukan jumlah tagihan bpjs</small>
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