@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Asset</li>
            </ol>
          </nav>

          <div class="content">
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Add Data Asset</h3>
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
                  <form action="{{ route('asset.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="bidang_id">Nama Bidang:</label>
                        <select name="bidang_id" id="bidang_id" class="form-control">
                          <option value="" selected>--Tentukan Bidang--</option>
                            @foreach ($bidang as $b)
                              <option value="{{ $b->id }}">{{ $b->nama }}</option>
                            @endforeach
                        </select>
                        <small id="nama" class="text-muted">Tentukan Bidang untuk asset yang baru</small>
                      </div>
                      <div class="form-group">
                        <label for="asset">Asset:</label>
                        <input type="text" name="asset" id="asset" class="form-control" value="{{ old('asset') }}"> 
                        <small id="asset" class="text-muted">Tentukan asset yang dimilki</small>
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