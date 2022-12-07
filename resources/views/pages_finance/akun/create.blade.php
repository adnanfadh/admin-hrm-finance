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
                        <li class="breadcrumb-item active"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true">Dashboard</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('accountbank.index') }}" class="text-decoration-none font-weight-bolder">Account Bank</a></li>
                        <li class="breadcrumb-item" aria-current="page">Create</li>
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
                            <h3 class="card-label text-gray-700">Add Data Account</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('accountbank.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nomor">Nomor:</label>
                                        <input type="text" name="nomor" id="nomor" class="form-control bg-secondary" value="0" readonly>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="nama">Nama:</label>
                                        <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category:</label>
                                        <select name="category" id="category_id" class="form-control" onchange="myFunction()">
                                            <option value="" readonly disabled selected>--Chose Category Account--</option>
                                            <option value="0">Ctare New Account</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->nama_category_account }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pajak_id">Pajak:</label>
                                        <select name="pajak_id" id="pajak_id" class="form-control">
                                            <option value="" readonly disabled selected>--Chose Pajak Account--</option>
                                            @foreach ($pajak as $p)
                                                <option value="{{ $p->id }}">{{ $p->nama_pajak }}</option>
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
                                            <option value="1">Account Parent</option>
                                            <option value="2">Account Child</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="parent_account_group">
                                        <label for="parent_account">Account Parent</label>
                                        <select name="parent_account" id="parent_account" class="form-control">
                                            @foreach ($account_parent as $ap)
                                                <option value="{{ $ap->id }}">({{ $ap->nomor }}) {{ $ap->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="details">Details:</label>
                                        <input type="text" name="details" id="details" value="{{ old('details') }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" id="col_nama_bank">
                                    <div class="form-group">
                                        <label for="nama_bank">Nama Bank:</label>
                                        <select name="nama_bank" id="nama_bank" class="form-control">
                                            <option value="" readonly disabled selected>--Pilih Bank--</option>
                                            <option value="MANDIRI">MANDIRI</option>
                                            <option value="BRI">BRI</option>
                                            <option value="BCA">BCA</option>
                                            <option value="BNI">BNI</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="col_no_rekening">
                                    <div class="form-group">
                                        <label for="no_rekening">No Rekening:</label>
                                        <input type="text" name="no_rekening" id="no_rekening" class="form-control" value="{{ old('no_rekening') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5" id="col_saldo">
                                    <div class="form-group">
                                        <label for="saldo">Saldo:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                              </div>
                                            {{-- <span class="input-group-text" id="basic-addon1">Rp.</span> --}}
                                            <input type="number" name="saldo" id="saldo" class="form-control" value="{{ old('saldo') }}" placeholder="25.000.000">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="status">Status Akun</label>
                                        <select name="status" id="status" class="custom-select">
                                            <option value="1">Tidak dapat dihapus</option>
                                            <option value="0">Dapat dihapus</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group text-center">
                                        <label for="reimburse">Reimburse</label>
                                        <br>
                                        <input type="checkbox" name="reimburse" id="1" value="1" class="checkbox-circle">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col md-12">
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi:</label>
                                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" class="form-control">{{ old('deskripsi') }}</textarea>
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

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="CategoryForm" name="CategoryForm" class="form-horizontal">
                       <input type="hidden" name="Category_id" id="Category_id">
                        <div class="form-group">
                            <label for="nama_Category" class="col-sm-12 control-label">Nomor Category</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nomor_category_account" name="nomor_category_account" placeholder="Enter Name Category" required="" value="{{ old('nomor_category_account') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="persentase" class="col-sm-12 control-label">Nama Category</label>
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nama_category_account" name="nama_category_account" placeholder="Enter Name Category" required="" value="{{ old('nama_category_account') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                {{-- <button type="reset" class="btn btn-info">Reset</button> --}}
                                <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                        </div>
                    </form>
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
$('#parent_account_group').hide();
    function sub_accounts(){
        if (document.getElementById("sub_account").value == 1) {
            $('#parent_account_group').hide();
            // console.log('parent hide');
        } else {
            $('#parent_account_group').show();
            // console.log('parent show');
        }
    }


$('#col_nama_bank').hide();
$('#col_no_rekening').hide();
    function myFunction() {
            console.log(document.getElementById("category_id").value);
            if (document.getElementById("category_id").value == 3) {
                var categoryId = document.getElementById("category_id").value;
                    $.ajax({
                        url: "../category_id" + '/' + categoryId,
                        type: "get",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){

                            // console.log(data[0].email_supplier);
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
                        url: "../category_id" + '/' + categoryId,
                        type: "get",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){

                            // console.log(data[0].email_supplier);
                            $('#nomor').val(data);
                            $('#col_nama_bank').hide();
                            $('#col_no_rekening').hide();
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
            }
        }

        $(function () {
  
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');
        
                $.ajax({
                    data: $('#CategoryForm').serialize(),
                    url: "{{ route('categoryaccount.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
        
                        $('#CategoryForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: 'Success...',
                                text: data.success
                        });
                        $('#category_id').append('<option value="'+ data.dataId +'" selected>' + data.data.nama_category_account+ '</option>');
                        $('#nomor').val(data.data.nomor_category_account);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        Swal.fire({
                                type: 'error',
                                icon: 'error',
                                title: 'Oops..',
                                text: data.error
                            });
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });
        });
</script>    
@endpush