@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Company</li>
            </ol>
          </nav>

          <div class="content">
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Add Data Company</h3>
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
                  <form action="{{ route('company.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="kode_company">Kode Company*</label>
                          <input type="text" name="kode_company" id="kode_company" class="form-control rol @error('kode_company') is-invalid @enderror" value="{{ $data->kode_company }}">
                          @error('kode_company')
                            <div class="alert alert-danger mt-1">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="nama_company">Nama Company:</label>
                          <input type="text" name="nama_company" id="nama_company" class="form-control rol @error('nama_company') is-invalid @enderror" value="{{ $data->nama_company }}">
                          @error('nama_company')
                            <div class="alert alert-danger mt-1">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="email_company">Email Company:</label>
                          <input type="text" name="email_company" id="email_company" class="form-control rol @error('email_company') is-invalid @enderror" value="{{ $data->email_company }}">
                          @error('email_company')
                            <div class="alert alert-danger mt-1">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="npwp_company">NPWP Company:</label>
                          <input type="text" name="npwp_company" id="npwp_company" class="form-control rol @error('npwp_company') is-invalid @enderror" value="{{ $data->npwp_company }}">
                          @error('npwp_company')
                            <div class="alert alert-danger mt-1">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="telpon_company">Telpon Company:</label>
                          <input type="text" name="telpon_company" id="telpon_company" class="form-control rol @error('telpon_company') is-invalid @enderror" value="{{ $data->telpon_company }}">
                          @error('telpon_company')
                            <div class="alert alert-danger mt-1">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="logo_company">Logo Company:</label>
                          <input type="file" name="logo_company" id="logo_company" class="form-control">
                          <input type="hidden" name="logo_company_old" id="logo_company_old" class="form-control" value="{{$data->logo_company}}">
                          @error('logo_company')
                            <div class="alert alert-danger mt-1">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="alamat_company">Alamat Company:</label>
                          <textarea name="alamat_company" id="alamat_company" class="form-control @error('alamat_company') is-invalid @enderror" cols="30" rows="10">{{ $data->alamat_company }}</textarea>
                          @error('alamat_company')
                            <div class="alert alert-danger mt-1">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="website_company">Website Company:</label>
                          <input type="text" name="website_company" id="website_company" class="form-control" value="{{ $data->website_company }}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="pemberi_wewenang1">Pemegang Wewenang 1:</label>
                          <select name="pemberi_wewenang1" id="pemberi_wewenang1" class="form-control">
                            <option value="">--Tentukan pemegang wewenang--</option>
                            @foreach ($pegawai as $peg)
                                <option value="{{ $peg->id }}" {{ old('pemberi_wewenang1', $data->pemberi_wewenang1) == $peg->id ? 'selected' : '' }}>{{ $peg->nama }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="pemberi_wewenang2">Pemegang Wewenang 2:</label>
                          <select name="pemberi_wewenang2" id="pemberi_wewenang2" class="form-control">
                            <option value="">--Tentukan pemegang wewenang--</option>
                            @foreach ($pegawai as $peg)
                                <option value="{{ $peg->id }}" {{ old('pemberi_wewenang2', $data->pemberi_wewenang2) == $peg->id ? 'selected' : '' }}>{{ $peg->nama }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="pemberi_wewenang3">Pemegang Wewenang 3:</label>
                          <select name="pemberi_wewenang3" id="pemberi_wewenang3" class="form-control">
                            <option value="">--Tentukan pemegang wewenang--</option>
                            @foreach ($pegawai as $peg)
                                <option value="{{ $peg->id }}" {{ old('pemberi_wewenang3', $data->pemberi_wewenang3) == $peg->id ? 'selected' : '' }}>{{ $peg->nama }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                      <div class="form-group">
                          <div class="row p-3 justify-content-md-start">
                              <input type="submit" value="submit" class="btn btn-primary">
                              <input type="reset" value="Clear" class="btn btn-warning ml-2">
                              <a href="{{ route('company.index') }}" class="btn btn-dark ml-2"> <i class="fas fa-reply"></i>Back  </a>
                          </div>
                      </div>
                  </form>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection
