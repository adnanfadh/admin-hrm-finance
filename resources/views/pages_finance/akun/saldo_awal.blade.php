@extends('layouts.app_finance')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb shadow-sm bg-white p-5">
                        <li class="breadcrumb-item active"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true">Dashboard</i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accountbank.index') }}" >Account</a></li>
                        <li class="breadcrumb-item" aria-current="page">Saldo Awal Account</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
                {{-- <script>
                    Swal.fire({
                        type: 'error',
                        title: 'Oops..',
                        text: '{{ $message }}'
                    });
                </script> --}}
                @endif
            </div>
        </div>
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
            <div class="col-md-12">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <span><i class="fas fa-address-book mr-1 icon-2x"></i></span>
                            <h3 class="card-label text-gray-700">Saldo awal account</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{  route('saldo_awal',$data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{-- @method('PUT') --}}
                        <div class="row">
                            <div class="col-md-6">
                                <label for="debit">Debit</label>
                                <div class="input-group mb-3">
                                    <br>
                                    <div  class="input-group-prepend">
                                        <span  class="input-group-text">RP</span>
                                    </div>
                                    <input type="text" class="form-control" id="debit" name="debit" value="{{ old('debit') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="kredit">Kredit</label>
                                <div class="input-group mb-3">
                                    <br>
                                    <div  class="input-group-prepend">
                                        <span  class="input-group-text">RP</span>
                                    </div>
                                    <input type="text" class="form-control" id="kredit" name="kredit" value="{{ old('kredit') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <a href="{{ route('accountbank.index') }}" class="btn btn-dark"><i class="fa fa-reply" aria-hidden="true"></i> Back</a>
                                <input type="submit" value="submit" class="btn btn-primary">
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
@endsection


@push('addon-script')
    
@endpush