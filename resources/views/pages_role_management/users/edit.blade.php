@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5 m-0">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('users.index') }}" style="text-decoration: none"> List User</a></li>
              <li class="breadcrumb-item"><a href="{{ route('users.show', $user->id) }}" style="text-decoration: none"> Show Detail</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit User</li>
            </ol>
          </nav>

          <div class="content">
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title w-100 d-flex flex-row justify-content-between">
                  <h3 class="card-label text-gray-700">Add Data User</h3>
                  @can('userroles-edit')
                        <a class="btn btn-success" href="{{ route('users.show', $user->id) }}"><i class="fa fa-reply" aria-hidden="true"></i> Back</a>
                    @endcan
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
                <div class="row">
                    <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Username:</strong>
                                    <input type="text" name="username" value="{{ $user->username }}" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan Nama Lengkap">
                                    @error('username')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>    
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Alamat Email">
                                    @error('email')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>    
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Password:</strong>
                                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Confirm Password:</strong>
                                    {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Pegawai id:</label>
                                    <select name="pegawai_id" class="custom-select @error('pegawai_id') is-invalid @enderror">
                                        <option value="">--Select Pegawai--</option>
                                        @foreach ($pegawais as $p)
                                            <option value="{{ $p->id }}" {{ old('pegawai_id', $user->pegawai_id) == $p->id ? 'selected' : '' }}>({{ $p->nip }}){{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Role:</strong>
                                    {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Image:</strong>
                                    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                                    <input type="hidden" value="{{ $user->photo }}" name="old_photo">
                                    @error('photo')
                                        <div class="alert alert-danger mt-1">
                                            {{ $message }}
                                        </div>    
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        
@endsection