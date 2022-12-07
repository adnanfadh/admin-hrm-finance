@extends('layouts.app_finance') 
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-custom gutter-b border-0 shadow">
                <div class="card-header">
                    <div class="card-title">
                        <span><i class="fas fa-address-book mr-1 icon-2x"></i></span>
                        <h3 class="card-label text-gray-700">Add Data Supplier</h3>
                    </div>
                </div>
                <div class="card-body bg-white">
                    <form action="{{ route('supplier.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="kode_supplier">Kode Supplier:</label>
                                    <input type="text" name="kode_supplier" id="kode_supplier" class="form-control bg-secondary" value="S-000{{ $data+1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="nama_supplier">Nama Supplier:</label>
                                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control" value="{{ old('nama_supplier') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email_supplier">Alamat Email:</label>
                                    <input type="email" name="email_supplier" id="email_supplier" class="form-control" value="{{ old('email_supplier') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kontak_supplier">Kontak:</label>
                                    <input type="text" name="kontak_supplier" id="kontak_supplier" class="form-control" value="{{ old('kontak_supplier') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat_supplier">Alamat:</label>
                            <textarea name="alamat_supplier" id="alamat_supplier" cols="30" rows="5" class="form-control">{{ old('alamat_supplier') }}</textarea>
                        </div>
                        <div class="form-group">
                            <div class="row p-3 justify-content-md-start">
                                <input type="submit" value="submit" class="btn btn-primary">
                                <input type="reset" value="Clear" class="btn btn-warning ml-2">
                                <a href="{{ route('kontak.index') }}" class="btn btn-dark ml-2"> <i class="fas fa-reply"></i>Back </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection