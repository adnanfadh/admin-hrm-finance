@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5 m-0">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('users.index') }}" style="text-decoration: none"> List User</a></li>
              <li class="breadcrumb-item active" aria-current="page">Show Detail</li>
            </ol>
          </nav>

          <div class="content">
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title w-100 d-flex flex-row justify-content-between">
                  <h3 class="card-label text-gray-700">Add Data User</h3>
                    @can('userroles-list')
                        <a class="btn btn-success" href="{{ route('users.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Back</a>
                    @endcan
                </div>
              </div>
              <div class="card-body bg-white">
                <div class="row">
                    <div class="col-md-8">
                        <h2>
                            <ul>
                                <li><strong>Nama(nip):</strong> {{ $user->pegawai->nama }} ({{ $user->pegawai->nip }})</li>
                                <br>
                                <li><strong>Username:</strong> {{ $user->username }}</li>
                                <br>
                                <li><strong>Alamat Email:</strong> {{ $user->email }}</li>
                                <br>
                                <li><strong>Roles:</strong>
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                    @endif
                                </li>
                            </ul>
                        </h2>
                    </div>
                    <div class="col-md-4">
                        <img src="{{ Storage::url($user->photo) }}" class="w-75 rounded" alt="">
                    </div>
                </div>
              </div>
              <div class="card-footer d-flex flex-row">
                @can('userroles-edit')
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary"><i class="fas fa-pencil-alt mr-1"></i> Edit</a>
                @endcan
                @can('userroles-delete')
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger ml-1">
                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                        </button>
                    </form> 
                @endcan
              </div>
            </div>
          </div>
        </div>
        
@endsection