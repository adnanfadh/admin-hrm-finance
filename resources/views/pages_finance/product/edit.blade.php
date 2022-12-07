@extends('layouts.app_finance')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb shadow-sm bg-white p-5">
                        <li class="breadcrumb-item active"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true">Dashboard</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('product.index') }}" class="text-decoration-none font-weight-bolder">Product</a></li>
                        <li class="breadcrumb-item" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
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
            <div class="col-md-12">
                <div class="card card-custom gutter-t">
                    <div class="card-header">
                        <div class="card-title">
                            <span><i class="fas fa-address-book mr-1 icon-2x"></i></span>
                            <h3 class="card-label text-gray-700">Add Data Product</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="nama_product">Nama Product:</label>
                                        <input type="text" name="nama_product" id="nama_product" class="form-control" value="{{ $product->nama_product }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="qty">Quantity:</label>
                                        <input type="text" name="qty" id="qty" class="form-control" value="{{ $product->qty }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="satuan">Satuan:</label>
                                        <input type="text" name="satuan" id="satuan" class="form-control" value="{{ $product->satuan }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="harga_satuan">Harga Satuan:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                            </div>
                                            <input type="number" name="harga_satuan" id="harga_satuan" class="form-control" value="{{ $product->harga_satuan }}" placeholder="25.000.000">
                                        </div>
                                    </div>
                                    
                                </div><div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category">Category:</label>
                                        <select name="category" id="category" class="form-control">
                                            @switch($data = $product->category)
                                            @case(1)
                                                <option value="" readonly disabled>--Pilih Category--</option>
                                                <option value="1" selected>Penjualan</option>
                                                <option value="2">Pembelian</option>
                                                <option value="3">Asset Kantor</option>
                                                @break
                                            @case(2)
                                                <option value="" readonly disabled>--Pilih Category--</option>
                                                <option value="1">Penjualan</option>
                                                <option value="2" selected>Pembelian</option>
                                                <option value="3">Asset Kantor</option>
                                                @break
                                            @case(3)
                                                <option value="" readonly disabled>--Pilih Category--</option>
                                                <option value="1">Penjualan</option>
                                                <option value="2">Pembelian</option>
                                                <option value="3" selected>Asset Kantor</option>
                                                @break
                                            @default
                                                <option value="" readonly disabled selected>--Pilih Category--</option>
                                                <option value="1">Penjualan</option>
                                                <option value="2">Pembelian</option>
                                                <option value="3">Asset Kantor</option>
                                            @endswitch
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="gambar">Gambar:</label>
                                        <input type="hidden" name="photo" id="photo" value="{{ $product->gambar }}" class="form-control">
                                        <input type="file" name="gambar" id="gambar" value="{{ old('gambar') }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" value="submit" class="btn btn-primary">
                                <input type="reset" value="Clear" class="btn btn-warning ml-2">
                                <a href="{{ route('accountbank.index') }}" class="btn btn-dark ml-2"> <i class="fas fa-reply"></i>Back </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection