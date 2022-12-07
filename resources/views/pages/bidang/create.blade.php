@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Departemen</li>
            </ol>
          </nav>

          <div class="content">
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Add Data Departemen</h3>
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
                  <form action="{{ route('departement.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="nama">Kode Departemen:</label>
                      <input type="text" name="kode_bidang" id="kode_bidang" class="form-control rol @error('kode_bidang') is-invalid @enderror col-12 col-md-4" value="{{ $kode }}" readonly>
                      <small id="kode_bidang" class="text-muted">Kode departemen otomatis di generate oleh sistem</small>
                      @error('name')
                        <div class="alert alert-danger mt-1">
                          {{ $message }}
                        </div>
                      @enderror
                    </div>
                      <div class="form-group">
                        <label for="nama">Nama Departement:</label>
                        <input type="text" name="nama" id="nama" class="form-control rol @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                        <small id="nama" class="text-muted">Tentukan nama untuk departemen yang baru</small>
                        @error('name')
                          <div class="alert alert-danger mt-1">
                            {{ $message }}
                          </div>
                        @enderror
                      </div>
                      <div class="form-group">
                          <div class="row p-3 justify-content-md-start">
                              <input type="submit" value="submit" class="btn btn-primary">
                              <input type="reset" value="Clear" class="btn btn-warning ml-2">
                              <a href="{{ route('departement.index') }}" class="btn btn-dark ml-2"> <i class="fas fa-reply"></i>Back  </a>
                          </div>
                      </div>
                  </form>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection
