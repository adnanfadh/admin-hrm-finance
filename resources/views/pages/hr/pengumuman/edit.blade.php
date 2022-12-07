@extends('layouts.app')

@push('addon-style')
    <style>
        .box::-webkit-scrollbar {
            display: none;
        }
    </style>
@endpush

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Tambah Pengumuman</li>
            </ol>
          </nav>

          <div class="content">
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Tambah Pengumuman</h3>
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
                  <form action="{{ route('pengumumanhr.update', $pengumumanhr->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ $pengumumanhr->title }}"> 
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $pengumumanhr->tanggal }}"> 
                            </div>
                        </div>
                    </div>
                      {{-- <div class="form-group">
                        <label for="pegawai_id">Nama Pegawai:</label>
                        <div class="box w-100 max-h-105px bg-gray-200 p-5 overflow-auto rounded">
                            <div class="row">
                                @foreach ($pegawai as $b)
                                <div class="col-md-3 col-12 p-5 rounded bg-white m-2">
                                    <div class="checkbox-inline d-flex">
                                        
                                        <label class="checkbox checkbox-outline checkbox-success">
                                            @for ($i = 0; $i < count($dataku); $i++)
                                            <input type="checkbox" name="pegawai_id[]" value="{{ $b->id }}" {{ old('pegawai_id', $dataku[$i]) == $b->id ? 'checked' : '' }}>
                                            @endfor
                                            <span></span>
                                            
                                            {{ $b->nama }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                                
                            </div>
                        </div>
                      </div> --}}
                      <div class="form-group">
                        <label for="pegawai_id">Nama Pegawai:</label>
                        <div class="box w-100 max-h-105px bg-gray-200 p-5 overflow-auto rounded">
                            <div class="row">
                                @foreach ($pegawai as $b)
                                
                                <div class="col-md-3 col-12 p-5 rounded bg-white m-2">
                                    <div class="checkbox-inline d-flex">
                                      <label class="checkbox checkbox-outline checkbox-success">
                                          @for ($i = 0; $i < count($dataku); $i++)
                                            
                                          <input type="checkbox" name="pegawai_id[]" value="{{ $b->id }}" {{ $dataku[$i] == $b->id ? 'checked' : '' }}>
                                            
                                            
                                          @endfor
                                            <span>
                                            </span>
                                            {{ $b->nama }}
                                            
                                        </label>
                                    </div>
                                </div>
                                
                                @endforeach
                                
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="ringkasan">Ringkasan:</label>
                        <input type="text" name="ringkasan" id="ringkasan" class="form-control" value="{{ $pengumumanhr->ringkasan }}"> 
                      </div>
                      <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ $pengumumanhr->description }}</textarea>
                         
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
