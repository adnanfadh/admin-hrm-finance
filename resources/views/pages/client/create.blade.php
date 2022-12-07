@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add Client</li>
            </ol>
          </nav>

          <div class="content pt-0">
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Add Data Client</h3>
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
                  <form action="{{ route('client.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="nama">User Account:</label>
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="" disabled selected>--Tentukan account untuk Client--</option>
                            @foreach ($user as $u)
                                <option value="{{ $u->id }}">{{ $u->username }} - {{ $u->email }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="row">
                          <div class="col-md-8">
                              <div class="form-group">
                                <label for="name">Name Client:</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                              </div>
                          </div>
                          <div class="col md-4">
                              <div class="form-group">
                                <label for="kontak">Kontak:</label>
                                <input type="text" name="kontak" id="kontak" class="form-control" value="{{ old('kontak') }}">
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label for="alamat">Alamat:</label>
                                <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control">{{ old('alamat') }}</textarea>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="row p-3 justify-content-md-start">
                              <input type="submit" value="submit" class="btn btn-primary">
                              <input type="reset" value="Clear" class="btn btn-warning ml-2">
                              <a href="{{ route('client.index') }}" class="btn btn-dark ml-2"> <i class="fas fa-reply"></i>Back  </a>
                          </div>
                      </div>
                  </form>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection