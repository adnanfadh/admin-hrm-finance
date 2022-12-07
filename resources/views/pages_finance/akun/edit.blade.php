@extends('layouts.app_finance')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb shadow-sm bg-white p-5">
                        <li class="breadcrumb-item active"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true">Dashboard</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('accountbank.index') }}" class="text-decoration-none font-weight-bolder">Account Bank</a></li>
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
                            <h3 class="card-label text-gray-700">Edit Data Account</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('accountbank.update', $accountbank->id) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nomor">Nomor:</label>
                                        <input type="text" name="nomor" id="nomor" class="form-control bg-secondary" value="{{ $accountbank->nomor }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="category">Category:</label>
                                        <select name="category" id="category_id" class="form-control" onchange="myFunction()">
                                            <option value="" readonly disabled selected>--Chose Category Account--</option>
                                            <option value="0">Ctare New Account</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}" {{ old('category', $accountbank->category) == $cat->id ? 'selected' : '' }}>{{ $cat->nama_category_account }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="nama">Nama:</label>
                                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $accountbank->nama }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pajak_id">pajak_id:</label>
                                        <select name="pajak_id" id="pajak_id" class="form-control">
                                            <option value="" readonly disabled selected>--Chose Pajak Account--</option>
                                            @foreach ($pajak as $p)
                                                <option value="{{ $p->id }}" {{ old('pajak_id', $accountbank->pajak_id) == $p->id ? 'selected' : '' }} >{{ $p->nama_pajak }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sub_account">Peran Account</label>
                                        <select name="sub_account" id="sub_account" class="form-control" onchange="sub_accounts()">
                                            <option value="">--Pilih peran account--</option>
                                            @if ($accountbank->parent_account == NULL)
                                                <option value="1" selected>Account Parent</option>
                                                <option value="2">Account Child</option>
                                            @else
                                                <option value="1">Account Parent</option>
                                                <option value="2" selected>Account Child</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="parent_account_group">
                                        <label for="parent_account">Account Parent</label>
                                        <select name="parent_account" id="parent_account" class="form-control">
                                            <option value="">--account parent--</option>
                                            @foreach ($account_parent as $ap)
                                                <option value="{{ $ap->id }}" {{ old('parent_account', $accountbank->parent_account) == $ap->id ? 'selected' : '' }} >({{ $ap->nomor }}) {{ $ap->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="details">Details:</label>
                                        <input type="text" name="details" id="details" value="{{ $accountbank->details }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" id="col_nama_bank">
                                    <div class="form-group">
                                        <label for="nama_bank">Nama Bank:</label>
                                        <select name="nama_bank" id="nama_bank" class="form-control">
                                            @switch($data = $accountbank->nama_bank)
                                                @case('MANDIRI')
                                                    <option value="">--Pilih Bank--</option>
                                                    <option value="MANDIRI" selected>MANDIRI</option>
                                                    <option value="BRI">BRI</option>
                                                    <option value="BCA">BCA</option>
                                                    <option value="BNI">BNI</option>
                                                    @break
                                                @case('BRI')
                                                    <option value="">--Pilih Bank--</option>
                                                    <option value="MANDIRI">MANDIRI</option>
                                                    <option value="BRI" selected>BRI</option>
                                                    <option value="BCA">BCA</option>
                                                    <option value="BNI">BNI</option>
                                                    @break
                                                @case('BCA')
                                                    <option value="">--Pilih Bank--</option>
                                                    <option value="MANDIRI">MANDIRI</option>
                                                    <option value="BRI">BRI</option>
                                                    <option value="BCA" selected>BCA</option>
                                                    <option value="BNI">BNI</option>
                                                    @break
                                                @case('BNI')
                                                    <option value="">--Pilih Bank--</option>
                                                    <option value="MANDIRI">MANDIRI</option>
                                                    <option value="BRI">BRI</option>
                                                    <option value="BCA">BCA</option>
                                                    <option value="BNI" selected>BNI</option>
                                                    @break
                                                @default
                                                    <option value="" selected>--Pilih Bank--</option>
                                                    <option value="MANDIRI">MANDIRI</option>
                                                    <option value="BRI">BRI</option>
                                                    <option value="BCA">BCA</option>
                                                    <option value="BNI">BNI</option>
                                            @endswitch
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="col_no_rekening">
                                    <div class="form-group">
                                        <label for="no_rekening">No Rekening:</label>
                                        <input type="text" name="no_rekening" id="no_rekening" class="form-control" value="{{ $accountbank->no_rekening }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="saldo">Saldo:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                            </div>
                                            <input type="number" name="saldo" id="saldo" class="form-control" value="{{ $accountbank->saldo }}" placeholder="25.000.000">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="status">Status Akun</label>
                                        <select name="status" id="status" class="custom-select">
                                            @if ($accountbank->status == 1)
                                                <option value="1" selected>Tidak dapat dihapus</option>
                                                <option value="0">Dapat dihapus</option>
                                            @else
                                                <option value="1">Tidak dapat dihapus</option>
                                                <option value="0" selected>Dapat dihapus</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group text-center">
                                        <label for="reimburse">Reimburse</label>
                                        <br>
                                        <input type="checkbox" name="reimburse" id="1" value="1" {{ old('reimburse', $accountbank->reimburse) == 1 ? 'checked' : '' }} class="checkbox-circle">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col md-12">
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi:</label>
                                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="form-control">{{ $accountbank->deskripsi }}</textarea>
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

@push('addon-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    if (document.getElementById("nama_bank").value == 0) {
        $('#col_nama_bank').hide();
        $('#col_no_rekening').hide();
    }else{
        $('#col_nama_bank').show();
        $('#col_no_rekening').show();
    }

    $('#parent_account_group').hide();

    if (document.getElementById("sub_account").value == 1) {
        $('#parent_account_group').hide();
        $('#parent_account').val(null);
    } else {
        $('#parent_account_group').show();
    }
    function sub_accounts(){
        if (document.getElementById("sub_account").value == 1) {
            $('#parent_account_group').show();
            $('#parent_account').val(null);
            // console.log('parent hide');
        } else {
            $('#parent_account_group').show();
            // console.log('parent show');
        }
    }
</script>

{{-- script untuk mengatur nomor category --}}
<script>
    function myFunction() {
            // console.log(document.getElementById("category_id").value);
            if (document.getElementById("category_id").value == 3) {
                var categoryId = document.getElementById("category_id").value;
                    $.ajax({
                        url: "../../category_id" + '/' + categoryId,
                        type: "get",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){
                            $('#nomor').val(data);
                            $('#col_nama_bank').show();
                            $('#col_no_rekening').show();
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
            }else{
                
                var categoryId = document.getElementById("category_id").value;
                    $.ajax({
                        url: "../../category_id" + '/' + categoryId,
                        type: "get",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){
                            $('#nomor').val(data);
                            $('#col_nama_bank').hide();
                            $('#col_no_rekening').hide();
                            $('#nama_bank').val(null);
                            $('#no_rekening').val(null);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
            }
        }
</script>
    
@endpush