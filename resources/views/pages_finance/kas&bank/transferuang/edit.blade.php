@extends('layouts.app_finance') 

@push('addon-style')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
@endpush 

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb shadow-sm bg-white p-5">
                        <li class="breadcrumb-item"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kasbank.index') }}" style="text-decoration: none"> Kas & Bank</a></li>
                        <li class="breadcrumb-item " aria-current="page">Edit Transfer Uang</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box-nav shadow-sm bg-white p-5 rounded">
                    <div class="row">
                        <div class="col-md-12">
                            <div aria-current="page">
                                <p>Transfer Uang</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div aria-current="page">
                                <h4>Edit transfer uang yang dilakukan</h4>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 d-flex flex-lg-row flex-sm-column justify-content-sm-start justify-content-lg-end">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="button" class="btn btn-block btn-outline-primary mt-2" data-toggle="modal" data-target="#panduanModal"> <i class="fas fa-file"></i>Lihat Panduan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                <script>
                    Swal.fire({
                        type: 'success',
                        title: 'Success...',
                        text: '{{ $message }}'
                    });
                </script>
                @endif @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                <script>
                    Swal.fire({
                        type: 'error',
                        title: 'Oops..',
                        text: '{{ $message }}'
                    });
                </script>
                @endif
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card card-custom gutter-b border-0 shadow">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label text-gray-700">Edit Terima Uang</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form action="{{ route('transferuang.update',$data->id) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf 
                            {{-- satart box input pelalnggan --}}
                            <div class="box-customer bg-light p-5 rounded">
                                <div class="row">
                                    <div class="col-md-6 order-lg-1 order-sm-2 order-md-1 mt-3">
                                        <div class="form-group">
                                            <label for="account_transper" class="font-weight-bold">Akun Transfer:</label>
                                            <select class="form-control" id="account_transper" name="account_transper">
                                                <option value="" selected disabled>--Pilih Account Setor--</option>
                                                @foreach ($account_setor as $ac)
                                                    <option value="{{ $ac->id }}" {{ old('account_transper', $data->account_transper) == $ac->id ? 'selected' : '' }}>({{ $ac->nomor }})-{{ $ac->nama }} ({{ $ac->category_account->nama_category_account }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 order-lg-1 order-sm-2 order-md-1 mt-3">
                                        <div class="form-group">
                                            <label for="account_setor" class="font-weight-bold">Akun Setor:</label>
                                            <select class="form-control" id="account_setor" name="account_setor">
                                                <option value="" selected disabled>--Pilih Account Setor--</option>
                                                @foreach ($account_setor as $ac)
                                                    <option value="{{ $ac->id }}" {{ old('account_setor', $data->account_setor) == $ac->id ? 'selected' : '' }}>({{ $ac->nomor }})-{{ $ac->nama }} ({{ $ac->category_account->nama_category_account }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-info-transaksi mt-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="memo" class="font-weight-bold">Memo:</label>
                                            <textarea name="memo" id="memo" cols="30" rows="5" class="form-control" placeholder="Little note...">{{ $data->memo }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="lampiran" class="font-weight-bold">Lampiran:</label>
                                            <div class="input-group mt-2">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="lampiran" value="" name="lampiran">
                                                    <input type="file" class="custom-file-input" id="lampiran_old" value="{{ old('lampiran') }}" name="lampiran_old">
                                                    <label class="custom-file-label" for="lampiran">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="no_transaksi" class="font-weight-bold">No. Transaksi:</label>
                                                    <input type="text" name="no_transaksi" id="no_transaksi" class="form-control bg-secondary font-weight-bolder" value="{{ $data->no_transaksi }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggal_transaksi" class="font-weight-bold">Tgl. Transaksi:</label>
                                                    <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" class="form-control" value="{{ $data->tanggal_transaksi }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="tanggal_transaksi" class="font-weight-bold">Nominal:</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">RP.</span>
                                                        </div>
                                                        <input type="text" id="jumlah" name="jumlah" class="form-control bg-warning-o-40 border-0 font-weight-bolder font-size-h3-sm" value="{{ $data->jumlah }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-10">
                                <div class="col-md-12 d-flex flex-row justify-content-between">
                                  <div class="btn-reset">
                                      <input type="reset" class="btn btn-primary" value="Batal">
                                  </div>
                                  <div class="btn-push text-sm-center text-lg-right">
                                      <input type="submit" class="btn btn-primary" value="Input & Submit">
                                  </div>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection