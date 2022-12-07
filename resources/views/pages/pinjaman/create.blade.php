@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Pinjaman</li>
            </ol>
          </nav>

          <div class="content">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="nav-wrapper">
                @include('pages.gaji.navigasi')
              </div>
            </div>
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Input Data Pinjaman</h3>
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
                  <form action="{{ route('pinjaman.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="pegawai_id">Pegawai:</label>
                          <select name="pegawai_id" id="pegawai_id" class="form-control">
                              @foreach ($data as $d)
                                  <option value="{{ $d['id'] }}">{{ $d['nama'] }}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-8 col-12">
                        <div class="form-group">
                          <label for="tanggal_pinjam">Tanggal Pinjam:</label>
                          <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam') }}"> 
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="jumlah_pinjam">Jumlah Pinjam:</label>
                            <input type="number" name="jumlah_pinjam" id="jumlah_pinjam" class="form-control" value="{{ old('jumlah_pinjam') }}"> 
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="angsuran">Angsuran:</label>
                            <input type="number" name="angsuran" id="angsuran" class="form-control" value="{{ old('angsuran') }}"> 
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="alasan">Alasan:</label>
                            <input type="text" name="alasan" id="alasan" class="form-control" value="{{ old('alasan') }}"> 
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="row p-3 justify-content-md-start">
                        <input type="submit" value="submit" class="btn btn-primary">
                        <input type="reset" value="Clear" class="btn btn-warning ml-2">
                        <a href="{{ route('pinjaman.index') }}" class="btn btn-dark ml-2"> <i class="fas fa-reply"></i>Back  </a>
                      </div>
                    </div>
                  </form>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection