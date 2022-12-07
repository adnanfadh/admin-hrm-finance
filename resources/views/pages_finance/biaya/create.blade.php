@extends('layouts.app_finance') 

@push('addon-style')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
@endpush 

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb shadow-sm bg-white p-5">
                    <li class="breadcrumb-item"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('biaya.index') }}" style="text-decoration: none"> Biaya</a></li>
                    <li class="breadcrumb-item " aria-current="page">Create Biaya</li>
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
                            <p>Biaya</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div aria-current="page">
                            <h4>Catat seluruh anggaran baiaya perusahaan</h4>
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
    {{-- Start Message Untuk keterangan berhasil/gagal upload --}}
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
    {{-- End Message untuk kterangan berhasil/gagal upload --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card card-custom gutter-b border-0 shadow">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label text-gray-700">Create Biaya</h3>
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
                    <form action="{{ route('biaya.store') }}" method="post" enctype="multipart/form-data">
                        @csrf 
                        {{-- satart box input pelalnggan --}}
                        <div class="box-supplier bg-light p-5 rounded">
                            <div class="row">
                                <div class="col-md-6 order-lg-1 order-sm-2 order-md-1 mt-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="account_pembayar" class="font-weight-bold">Bayar Dari:</label>
                                                <select class="form-control" id="account_pembayar" name="account_pembayar">
                                                    <option value="">--Pilih Account Pembayaran--</option>
                                                    {{-- <option value="12" class="font-weight-bolder bg-primary text-white">Create New Account</option> --}}
                                                    @foreach ($account_pembayar as $ac)
                                                        <option value="{{ $ac->id }}">({{ $ac->nomor }})-{{ $ac->nama }} ({{ $ac->category_account->nama_category_account }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex flex-column justify-content-center mt-3">
                                            <div class="form-group">
                                                <input type="checkbox" id="bayar_nanti" class="checkbox-lg" name="bayar_nanti" value="bayar nanti">
                                                <label for="bayar_nanti" class="font-weight-bold font-size-h4-xl">Bayar Nanti</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 order-lg-2 order-sm-1 order-md-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box bg-white p-5 rounded d-flex flex-column text-right">
                                                <div class="ket-total">
                                                    <h4>Total:</h4>
                                                </div>
                                                <div class="nominal bg-warning-o-80 p-3 rounded">
                                                    <input type="text" id="total_global" value="0" class="form-control bg-transparent border-0 font-weight-bolder text-right total_global" style="font-size: 1.7rem">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end box input supplier --}} {{-- start box input info transaksi --}}
                        <div class="box-info-transaksi mt-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="box bg-white shadow-sm p-2 rounded mb-2 pt-4">
                                    <div class="form-group d-flex flex-row justify-content-around">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="RadiosNavigasi" id="supplier" value="supplier" checked>
                                            <label class="form-check-label" for="supplier">
                                                Supplier
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="RadiosNavigasi" id="pegawai" value="pegawai">
                                            <label class="form-check-label" for="pegawai">
                                                Pegawai
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat_penagihan" class="font-weight-bold">Penerima:</label>
                                        <select name="penerima_supplier" id="supplier_id" class="custom-select" onchange="myFunction()">
                                            <option value="" selected disabled>--Select Supplier--</option>
                                            <option value="12" class="font-weight-bolder bg-primary text-white">Add New Supplier</option>
                                            @foreach ($supplier as $sup)
                                                <option value="{{ $sup->id }}">({{ $sup->kode_supplier }}) {{ $sup->nama_supplier }}</option>
                                            @endforeach
                                        </select>
                                        <select name="penerima_pegawai" id="penerima_pegawai" class="custom-select">
                                            <option value="" selected disabled>--Select Pegawai--</option>
                                            @foreach ($pegawai as $peg)
                                                <option value="{{ $peg->id }}">({{ $peg->nip }}) {{ $peg->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <label for="alamat_penagihan" class="font-weight-bold">Alamat Penagihan:</label>
                                        <textarea name="alamat_penagihan" id="alamat_penagihan" cols="30" rows="6" class="form-control" placeholder="E.G. Jl buah batu regency">{{ old('alamat') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="no_biaya" class="font-weight-bold">No. Biaya:</label>
                                        <input type="text" name="no_biaya" id="no_biaya" class="form-control" value="{{ $kode }}">
                                    </div>
                                    <div class="form-group" id="form_syarat_pembayaran">
                                        <label for="syarat_pembayaran" class="font-weight-bold">Syarat Pembayaran</label>
                                        <select name="syarat_pembayaran" id="syarat_id" class="form-control" onchange="AddSyaratShow()">
                                            <option value="">-- Syarat Pembayaran --</option>
                                            {{-- <option value="10" class="text-white bg-primary font-weight-bolder">Add New Syarat</option> --}}
                                            @foreach ($syarat_pembayaran as $s)
                                                <option value="{{ $s->id }}">{{ $s->nama_syarat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="form_tanggal_jatuh_tempo">
                                        <label for="tanggal_jatuh_tempo" class="font-weight-bold">Tgl. Jatuh Tempo:</label>
                                        <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tanggal_transaksi" class="font-weight-bold">Tgl. Transaksi:</label>
                                        <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" class="form-control" value="{{ old('tanggal_transaksi') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="metode_pembayaran" class="font-weight-bold">Metode Pembayaran:</label>
                                        <select name="metode_pembayaran" id="metode_id" class="form-control" onchange="AddMetodeShow()">
                                            <option value="" selected disabled>-- Metode Pembayaran --</option>
                                            @foreach ($metode_pembayaran as $met)
                                                <option value="{{ $met->id }}">{{ $met->nama_metode }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end box input info transaksi --}} {{-- start table detail pembelian --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover scroll-horizontal-vertical w-100 table-responsive-lg" width="100%">
                                        <thead class="bg-dark text-white w-100">
                                            <tr>
                                                <th width="20%">Akun Biaya</th>
                                                <th width="25%">Deskripsi</th>
                                                <th width="15%">Pajak</th>
                                                <th width="20%">Potongan Pajak</th>
                                                <th width="20%">Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody id="myTable">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- end table detail pembelian --}} {{-- start row button add delete cell table --}}
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary btn-sm" id="btnAddForm" onclick="myCreateFunction()">Tambah Product</button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="myDeleteFunction()">Delete Product</button>
                            </div>
                        </div>
                        <hr> {{-- end row button add delete cell table --}}
                        <div class="row d-flex flex-row justify-content-between">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="memo" class="font-weight-bold">Memo:</label>
                                    <textarea name="memo" id="memo" cols="30" rows="5" class="form-control" placeholder="Little note...">{{ old('memo') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="lampiran" class="font-weight-bold">Lampiran:</label>
                                    <div class="input-group mt-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="lampiran" value="{{ old('lampiran') }}" name="lampiran">
                                            <label class="custom-file-label" for="lampiran">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mt-10">
                                    <div class="col-md-5">
                                        <h6 class="font-weight-bolder">Subtotal</h6>
                                    </div>
                                    <div class="col-md-7 text-right">
                                        <input type="text" name="sub_total" id="sub_total" class="form-control bg-transparent border-0 font-size-h6-lg font-weight-bolder text-right" value="0" readonly>
                                    </div>
                                </div>
                                <div class="row mt-10">
                                    <div class="col-md-5">
                                        <h6 class="font-weight-bolder">Potongan Pajak</h6>
                                    </div>
                                    <div class="col-md-7 text-right">
                                        <input type="text" name="potongan_pajak_display" id="potongan_pajak_display" class="form-control bg-transparent border-0 font-size-h6-lg font-weight-bolder text-right" value="0" readonly>
                                    </div>
                                </div>
                                <hr class="bg-primary my-5">
                                <div class="row">
                                    <div class="col-md-5">
                                        <h6 class="font-weight-bolder">Total</h6>
                                    </div>
                                    <div class="col-md-7 text-right">
                                        <input type="text" name="total_global" id="total_global" class="form-control bg-transparent border-0 font-size-h6-lg font-weight-bolder text-right total_global" value="0" readonly>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <select name="akun_pemotong" id="akun_pemotong" class="custom-select">
                                                <option value="">--Select Account--</option>
                                                {{-- <option value="12" class="font-weight-bolder bg-primary text-white">Create New Account</option> --}}
                                                    @foreach ($account_pembayar as $ac)
                                                        <option value="{{ $ac->id }}">{{ $ac->nomor }}{{ $ac->nama }}{{ $ac->category_account->nama_category_account }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-right">
                                        <input type="text" name="besar_potongan" id="besar_potongan" class="form-control font-size-h6-lg font-weight-bolder text-right" value="0" onkeyup="jum_potongan()">
                                    </div>
                                </div>
                                <hr class="bg-primary my-5">
                                <div class="row">
                                    <div class="col-md-5">
                                        <h6 class="font-weight-bolder">Grand Total</h6>
                                    </div>
                                    <div class="col-md-7 text-right">
                                        <input type="text" name="grand_total" id="grand_total" class="form-control bg-transparent border-0 font-size-h6-lg font-weight-bolder text-right" value="0" readonly>
                                    </div>
                                </div>
                                <hr class="bg-primary my-5">
                                <div class="row">
                                    <div class="col-md-5">
                                        <h6 class="font-weight-bolder">Sisa Tagihan</h6>
                                        <input class="form-control hitung_row" value="" type="hidden" id="hitung_row" name="hitung_row" readonly>
                                    </div>
                                    <div class="col-md-7 text-right">
                                        <input type="text" name="sisa_tagihan" id="sisa_tagihan" class="form-control bg-transparent border-0 font-size-h6-lg font-weight-bolder text-right" value="0" readonly>
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

{{-- modal untuk add supplier --}}
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="SupplierForm" name="SupplierForm" class="form-horizontal" method="POST">
                   <input type="hidden" name="Supplier_id" id="Supplier_id">
                   <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="kode_supplier">Kode Supplier:</label>
                            <input type="text" name="kode_supplier" id="kode_supplier" value="{{ old('kode_supplier') }}" class="form-control bg-secondary">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="nama_supplier">Nama Supplier:</label>
                            <input type="text" name="nama_supplier" id="nama_supplier" class="form-control" value="{{ old('nama_supplier') }}" autofocus>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Alamat Email:</label>
                            <input type="email" name="email_supplier" id="email_supplier" class="form-control" value="{{ old('email_supplier') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kontak">Kontak:</label>
                            <input type="text" name="kontak_supplier" id="kontak_supplier" class="form-control" value="{{ old('kontak_supplier') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea name="alamat_supplier" id="alamat_supplier" cols="30" rows="5" class="form-control">{{ old('alamat_supplier') }}</textarea>
                </div>

                    <div class="col-sm-offset-2 col-sm-12 text-right">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                     <button type="btn" class="btn btn-danger" id="saveBtnclose">Close
                    </button>
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


<script>

function myFunction() {
            console.log(document.getElementById("supplier_id").value);
            if (document.getElementById("supplier_id").value == 12) {
                $.ajax({
                url: "{{ route('getAjaxSupplierPembelian') }}",
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                    success:function(data){
                        var kode_cus = 'S-000'+data.data;
                        // console.log(data);
                        $('#saveBtn').val("create-Supplier");
                        $('#Supplier_id').val('');
                        $('#kode_supplier').val(kode_cus);
                        $('#modelHeading').html("Create New Supplier");
                        $('#ajaxModel').modal('show');
                    }
                });
            }else{
                var supplierId = document.getElementById("supplier_id").value;
                // var datid = $this.val(); 
                // console.log(supplierId);
                    $.ajax({
                        url: "../suppliers_id_pembelian"+'/' + supplierId,
                        type: "get",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){
                            // console.log(data[0]);
                            // console.log(data[0].email_supplier);
                            // $('#email_supplier').val(data[0].email_supplier);
                            $('#alamat_penagihan').val(data[0].alamat_supplier);
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
                data: $('#SupplierForm').serialize(),
                url: "{{ route('storeAjaxSupplierPembelian') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#SupplierForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: 'Success...',
                            text: data.success
                    });
                    // table.draw();
                    $('#supplier_id').append('<option value="'+ data.dataId +'" selected>' + data.data.nama_supplier+ '</option>');
                    myFunction();
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
        $('#saveBtnclose').click(function (e) {
            e.preventDefault();
            $('#ajaxModel').modal('hide');
        });
    });
    
    $(document).ready(function(){


        //     var inputHari = 5
        // $('#besar_potongan').val(new Date(new Date().getTime());
        // console.log(new Date(new Date().getTime()+(inputHari*24*60*60*1000)));

        // code untuk checkbok bayar nanti
        $('#form_tanggal_jatuh_tempo').hide();
        $('#form_syarat_pembayaran').hide();
        $('#bayar_nanti').click(function() {
            if ($(this).is(':checked')) {
                console.log('click');
                $('#account_pembayar').attr('disabled', true);
                $('#account_pembayar').val('');
                $('#form_tanggal_jatuh_tempo').fadeIn(1000);
                $('#form_syarat_pembayaran').fadeIn(1500);
            }else{
                $('#account_pembayar').attr('disabled', false);
                $('#account_pembayar').val('');
                $('#form_tanggal_jatuh_tempo').fadeOut(1500);
                $('#form_syarat_pembayaran').fadeOut(1000);
            }
        });

        // kode untuk radio button penerima
        $('#penerima_pegawai').hide();
        $('input:radio[name="RadiosNavigasi"]').change(function(){
            if($(this).is(':checked') && $(this).val() == 'supplier'){
                $('#supplier_id').fadeIn(2000);
                $('#penerima_pegawai').hide();
                console.log('pegawai hide');
            }else{
                $('#penerima_pegawai').fadeIn(2000);
                $('#supplier_id').hide();
                console.log('supplier hide');
            }
        });


    });
        // kode untuk menambah row tabel
        // function untuk menambah row detail pembelian
        function myCreateFunction() {
            var table = document.getElementById("myTable");
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);

            var callProduct = get_akun_biaya();
            var callPajak = get_data_pajak();

            cell1.innerHTML = `
                            <select id='akun_biaya' class="akun_biaya form-control" name="akun_biaya[]">
                                <option value="" disabled selected>-- Pilih Akun --</option>
                            </select>
                            `;
                                
            cell2.innerHTML = `<input class="form-control deskripsi" value="" type="text" id="deskripsi" name="deskripsi[]">`;
            cell3.innerHTML = `<select id='pajak_id' class="pajak_id form-control" name="pajak_id[]">
                                <option value="" selected>-- Pilih Pajak --</option>
                            </select>
                            `;
            cell4.innerHTML = `<input class="form-control potongan_pajak" value="0" type="text" id="potongan_pajak" name="potongan_pajak[]">`;
            cell5.innerHTML = `<div class="input-group mb-3">
                                    <div  class="input-group-prepend">
                                        <span  class="input-group-text">RP</span>
                                    </div>
                                    <input type="text" class="form-control jumlah" id="jumlah" name="jumlah[]" value="0">
                                </div>
                                
                                `
                                ;
            
            // pajak onchange

            

            const paj_select = document.querySelectorAll('.pajak_id');
            for (let p = 0; p < paj_select.length; p++) {
                paj_select[p].addEventListener('change', function get(){
                    // console.log(paj_select[p]);
                    // console.log(paj_select[p]);
                    var pajakId = paj_select[p].value;
                    var parameter_pajak = p + 1;
                    var jumlah = $('#myTable tr:nth-child('+parameter_pajak+') #jumlah').val();
                    // console.log(jumlah);

                    if (!pajakId) {
                        $('#myTable tr:nth-child('+parameter_pajak+') #potongan_pajak').val('0');
                        let hasil_total_global = document.querySelectorAll(".jumlah");
                        var sub_total = 0;
                            for (let i = 0; i < hasil_total_global.length; i++){
                                sub_total += parseInt(hasil_total_global[i].value);
                                var jum_row = parseInt(i); 
                            }

                            // hasil_potongan_pajak = $('.potongan_pajak');
                        var hasil_potongan_pajak = document.querySelectorAll(".potongan_pajak");
                        // console.log(hasil_potongan_pajak.length);
                        var pajak_display = 0;
                            for (let p = 0; p < hasil_potongan_pajak.length; p++) {
                                pajak_display += parseInt(hasil_potongan_pajak[p].value);
                                console.log(hasil_potongan_pajak[p].value);
                            }
                        
                            $('#hitung_row').val(jum_row);
                            $('#sub_total').val(sub_total);
                            $('#potongan_pajak_display').val(pajak_display);
                            // console.log(pajak_display);
                            $('.total_global').val(sub_total+pajak_display);
                            $('#sisa_tagihan').val(sub_total+pajak_display);
                    }else{
                        if (jumlah == 0) {
                            $('#myTable tr:nth-child('+parameter_pajak+') #potongan_pajak').val('0');
                            let hasil_total_global = document.querySelectorAll(".jumlah");
                            var sub_total = 0;
                                for (let i = 0; i < hasil_total_global.length; i++){
                                    sub_total += parseInt(hasil_total_global[i].value);
                                    var jum_row = parseInt(i); 
                                }

                                // hasil_potongan_pajak = $('.potongan_pajak');
                            var hasil_potongan_pajak = document.querySelectorAll(".potongan_pajak");
                            // console.log(hasil_potongan_pajak.length);
                            var pajak_display = 0;
                                for (let p = 0; p < hasil_potongan_pajak.length; p++) {
                                    pajak_display += parseInt(hasil_potongan_pajak[p].value);
                                    console.log(hasil_potongan_pajak[p].value);
                                }
                            
                                $('#hitung_row').val(jum_row);
                                $('#sub_total').val(sub_total);
                                $('#potongan_pajak_display').val(pajak_display);
                                // console.log(pajak_display);
                                $('.total_global').val(sub_total+pajak_display);
                                $('#sisa_tagihan').val(sub_total+pajak_display);
                        }else{
                            $.ajax({
                                url: "../pajak_id_pembelian"+'/' + pajakId,
                                type: "GET",
                                data: {"_token":"{{ csrf_token() }}"},
                                success: function(data){
                                    var besar_pajak = (jumlah * data[0].persentase) / 100;
                                    // var jum_pajak = jum_sementara - besar_pajak;
                                    $('#myTable tr:nth-child('+parameter_pajak+') #potongan_pajak').val(besar_pajak);
                                    let hasil_total_global = document.querySelectorAll(".jumlah");
                                    var sub_total = 0;
                                        for (let i = 0; i < hasil_total_global.length; i++){
                                            sub_total += parseInt(hasil_total_global[i].value);
                                            var jum_row = parseInt(i); 
                                        }

                                        // hasil_potongan_pajak = $('.potongan_pajak');
                                    var hasil_potongan_pajak = document.querySelectorAll(".potongan_pajak");
                                    // console.log(hasil_potongan_pajak.length);
                                    var pajak_display = 0;
                                        for (let p = 0; p < hasil_potongan_pajak.length; p++) {
                                            pajak_display += parseInt(hasil_potongan_pajak[p].value);
                                            console.log(hasil_potongan_pajak[p].value);
                                        }
                                    
                                        $('#hitung_row').val(jum_row);
                                        $('#sub_total').val(sub_total);
                                        $('#potongan_pajak_display').val(pajak_display);
                                        // console.log(pajak_display);
                                        $('.total_global').val(sub_total+pajak_display);
                                        $('#sisa_tagihan').val(sub_total+pajak_display);
                                }
                            });
                        }
                    }

                    
                })
            }

            // hitung jumlah row untuk perulangan di backend
            let hasil_total_global = document.querySelectorAll(".jumlah");
            for (let i = 0; i < hasil_total_global.length; i++){
                var jum_row = parseInt(i); 
            }
            $('#hitung_row').val(jum_row);



            // keyup jumlah
            const JumlahTotal = document.querySelectorAll('.jumlah');
            for (let j = 0; j < JumlahTotal.length; j++) {
                JumlahTotal[j].addEventListener('keyup', function(){
                    var jumlahTotal = JumlahTotal[j].value;
                    var parameter_jumlah = j + 1;
                    var pajak_id = $('#myTable tr:nth-child('+parameter_jumlah+') #pajak_id').val();
                    if (!pajak_id) {
                        console.log('data tidak ada');
                        let hasil_total_global = document.querySelectorAll(".jumlah");
                        var sub_total = 0;
                            for (let i = 0; i < hasil_total_global.length; i++){
                                sub_total += parseInt(hasil_total_global[i].value);
                                var jum_row = parseInt(i); 
                            }

                        var hasil_potongan_pajak = document.querySelectorAll(".potongan_pajak");
                        var pajak_display = 0;
                            for (let paj = 0; paj < hasil_potongan_pajak.length; paj++) {
                                pajak_display += parseInt(hasil_potongan_pajak[paj].value);
                            }
                        
                            $('#hitung_row').val(jum_row);
                            $('#sub_total').val(sub_total);
                            $('#potongan_pajak_display').val(pajak_display);
                            $('.total_global').val(sub_total+pajak_display);
                            $('#grand_total').val(sub_total+pajak_display);
                            $('#sisa_tagihan').val(sub_total+pajak_display);
                    } else {
                        $.ajax({
                                url: "../pajak_id_pembelian"+'/' + pajak_id,
                                type: "GET",
                                data: {"_token":"{{ csrf_token() }}"},
                                success: function(data){
                                    var besar_pajak = (jumlahTotal * data[0].persentase) / 100;
                                    // var jum_pajak = jum_sementara - besar_pajak;
                                    $('#myTable tr:nth-child('+parameter_jumlah+') #potongan_pajak').val(besar_pajak);
                                    let hasil_total_global = document.querySelectorAll(".jumlah");
                                    var sub_total = 0;
                                        for (let i = 0; i < hasil_total_global.length; i++){
                                            sub_total += parseInt(hasil_total_global[i].value);
                                            var jum_row = parseInt(i); 
                                        }

                                    var hasil_potongan_pajak = document.querySelectorAll(".potongan_pajak");
                                    var pajak_display = 0;
                                        for (let paj = 0; paj < hasil_potongan_pajak.length; paj++) {
                                            pajak_display += parseInt(hasil_potongan_pajak[paj].value);
                                        }
                                    
                                        $('#hitung_row').val(jum_row);
                                        $('#sub_total').val(sub_total);
                                        $('#potongan_pajak_display').val(pajak_display);
                                        $('.total_global').val(sub_total+pajak_display);
                                        $('#grand_total').val(sub_total+pajak_display);
                                        $('#sisa_tagihan').val(sub_total+pajak_display);
                                }
                            });
                    }

                    
                })
                
            }
        }

        function jum_potongan(){
            var data_total = document.getElementById('total_global').value;
            var data_potongan = document.getElementById('besar_potongan').value;
            var hasil = data_total - data_potongan;
            $('#grand_total').val(hasil);
            $('#sisa_tagihan').val(hasil);
        }

        function get_akun_biaya(){
            $.ajax({
                    url: "{{ route('get_akun_biaya') }}",
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    success: function(data){
                        $.each(data, function(key, log){
                            var product = '<option value="'+ log.id +'" class="'+ log.id +'">(' +log.nomor +' ) '+ log.nama +'</option>';
                            $('.akun_biaya').last().append(product);
                            
                        })
                    }
            })
        }

        function get_data_pajak(){
            $.ajax({
                    url: "{{ route('get_pajak_ajax_pembelian') }}",
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    success: function(data){
                        $.each(data, function(key, log){
                            var pajak = '<option value="'+ log.id +'">' + log.nama_pajak+ '</option>';
                            $('.pajak_id').last().append(pajak);
                        })
                    }
                })
        }

        function myDeleteFunction() {
            document.getElementById("myTable").deleteRow(-1);

            let hasil_total_global = document.querySelectorAll(".jumlah");
            var sub_total = 0;
            for (let i = 0; i < hasil_total_global.length; i++){
                sub_total += parseInt(hasil_total_global[i].value);
                var jum_row = parseInt(i); 
            }
            var hasil_potongan_pajak = document.querySelectorAll(".potongan_pajak");
                    var pajak_display = 0;
                        for (let paj = 0; paj < hasil_potongan_pajak.length; paj++) {
                            pajak_display += parseInt(hasil_potongan_pajak[paj].value);
                        }
            $('#potongan_pajak_display').val(pajak_display);
            $('#hitung_row').val(jum_row);
            $('#sub_total').val(sub_total);
            $('.total_global').val(sub_total+pajak_display);
            $('#grand_total').val(sub_total+pajak_display);
            $('#sisa_tagihan').val(sub_total+pajak_display);
        }
</script>
{{-- <script type="text/javascript">
    $(document).ready(function () {
        $('#account_pembayar').selectize({
            sortField: 'text'
        });
    });
</script> --}}

@endpush
