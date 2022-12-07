@extends('layouts.app_finance')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb shadow-sm bg-white p-5">
                        <li class="breadcrumb-item active"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true">Dashboard</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('rulesJurnal.index') }}" class="text-decoration-none font-weight-bolder">Rules Jurnal</a></li>
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
                            <h3 class="card-label text-gray-700">Edit Rules Jurnal Input</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rulesJurnal.update', $data->id) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="rules_jurnal_name">Rules Jurnla Name:</label>
                                        <input type="text" name="rules_jurnal_name" id="rules_jurnal_name" class="form-control" value="{{ $data->rules_jurnal_name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="rules_jurnal_keterangan">Rules Jurnal Keterangan:</label>
                                        <textarea name="rules_jurnal_keterangan" id="rules_jurnal_keterangan" class="form-control" cols="30" rows="3">{{ $data->rules_jurnal_keterangan }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rules_jurnal_akun_debit">Rules Jurnal Debit:</label>
                                        <select name="rules_jurnal_akun_debit" id="rules_jurnal_akun_debit" class="form-control" {{ $data->rules_jurnal_akun_debit == null ? 'disabled' : '' }}>
                                            <option value="">--Pilih account--</option>
                                            @foreach ($account as $a)
                                                <option value="{{ $a->id }}" {{ old('rules_jurnal_akun_debit', $data->rules_jurnal_akun_debit) == $a->id ? 'selected' : '' }}>({{ $a->nomor }}){{ $a->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rules_jurnal_akun_kredit">Rules Jurnal Kredit:</label>
                                        <select name="rules_jurnal_akun_kredit" id="rules_jurnal_akun_kredit" class="form-control" {{ $data->rules_jurnal_akun_kredit == null ? 'disabled' : '' }}>
                                            <option value="">--Pilih account--</option>
                                            @foreach ($account as $a)
                                                <option value="{{ $a->id }}" {{ old('rules_jurnal_akun_kredit', $data->rules_jurnal_akun_kredit) == $a->id ? 'selected' : '' }}>({{ $a->nomor }}){{ $a->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rules_jurnal_akun_discount">Rules Jurnal Discount:</label>
                                        <select name="rules_jurnal_akun_discount" id="rules_jurnal_akun_discount" class="form-control" {{ $data->rules_jurnal_akun_discount == null ? 'disabled' : '' }}>
                                            <option value="">--Pilih account--</option>
                                            @foreach ($account as $a)
                                                <option value="{{ $a->id }}" {{ old('rules_jurnal_akun_discount', $data->rules_jurnal_akun_discount) == $a->id ? 'selected' : '' }}>({{ $a->nomor }}){{ $a->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rules_jurnal_akun_ppn">Rules Jurnal PPN:</label>
                                        <select name="rules_jurnal_akun_ppn" id="rules_jurnal_akun_ppn" class="form-control" {{ $data->rules_jurnal_akun_ppn == null ? 'disabled' : '' }}>
                                            <option value="">--Pilih account--</option>
                                            @foreach ($account as $a)
                                                <option value="{{ $a->id }}" {{ old('rules_jurnal_akun_ppn', $data->rules_jurnal_akun_ppn) == $a->id ? 'selected' : '' }}>({{ $a->nomor }}){{ $a->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" value="submit" class="btn btn-primary">
                                <input type="reset" value="Clear" class="btn btn-warning ml-2">
                                <a href="{{ route('rulesJurnal.index') }}" class="btn btn-dark ml-2"> <i class="fas fa-reply"></i>Back </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection