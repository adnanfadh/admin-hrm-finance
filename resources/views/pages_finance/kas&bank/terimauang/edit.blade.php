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
                    <li class="breadcrumb-item"><a href="{{ route('kasbank.index') }}" style="text-decoration: none"> Kas & Bank</a></li>
                    <li class="breadcrumb-item " aria-current="page">Edit Terima Uang</li>
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
                            <p>Terima Uang</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div aria-current="page">
                            <h4>Edit Penerimaan uang yang dilakukan</h4>
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
                        <h3 class="card-label text-gray-700">Edit Kirim Uang</h3>
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
                    <form action="{{ route('terimauang.update', $data->id) }}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf 
                        {{-- satart box input pelalnggan --}}
                        <div class="box-supplier bg-light p-5 rounded">
                            <div class="row">
                                <div class="col-md-6 order-lg-1 order-sm-2 order-md-1 mt-3">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="account_setor" class="font-weight-bold">Bayar Dari:</label>
                                                <select class="form-control" id="account_setor" name="account_setor">
                                                    <option value="">--Pilih Account Pembayaran--</option>
                                                    {{-- <option value="12" class="font-weight-bolder bg-primary text-white">Create New Account</option> --}}
                                                    @foreach ($account_setor as $ac)
                                                        <option value="{{ $ac->id }}" {{ old('account_setor', $data->account_setor) == $ac->id ? 'selected' : '' }}>({{ $ac->nomor }})-{{ $ac->nama }} ({{ $ac->category_account->nama_category_account }})</option>
                                                    @endforeach
                                                </select>
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
                                                    <input type="text" id="total_global" value="{{ $data->total }}" class="form-control bg-transparent border-0 font-weight-bolder text-right total_global" style="font-size: 1.7rem">
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
                                            @if ($data->penerima_supplier == NULL)
                                                <div class="form-check">
                                                    <input class="form-check-input RadiosNavigasi" type="radio" name="RadiosNavigasi" id="customer" value="customer">
                                                    <label class="form-check-label" for="customer">
                                                        Customer
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input RadiosNavigasi" type="radio" name="RadiosNavigasi" id="pegawai" value="pegawai" checked>
                                                    <label class="form-check-label" for="pegawai">
                                                        Pegawai
                                                    </label>
                                                </div>
                                            @else
                                                <div class="form-check">
                                                    <input class="form-check-input RadiosNavigasi" type="radio" name="RadiosNavigasi" id="customer" value="customer" checked>
                                                    <label class="form-check-label" for="customer">
                                                        Customer
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input RadiosNavigasi" type="radio" name="RadiosNavigasi" id="pegawai" value="pegawai">
                                                    <label class="form-check-label" for="pegawai">
                                                        Pegawai
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat_penagihan" class="font-weight-bold">Penerima:</label>
                                            <select name="pengirim_customer" id="pengirim_customer" class="custom-select" onchange="send_penerima_customer();">
                                                <option value="" selected disabled>--Select Supplier--</option>
                                                @foreach ($customer as $sup)
                                                    <option value="{{ $sup->id }}"  {{ old('pengirim_customer', $data->pengirim_customer) == $sup->id ? 'selected' : '' }}>({{ $sup->kode_customer }}) {{ $sup->nama_customer }}</option>
                                                @endforeach
                                            </select>
                                            <select name="pengirim_pegawai" id="pengirim_pegawai" class="custom-select" onchange="send_pengirim_pegawai();">
                                                <option value="" selected disabled>--Select Pegawai--</option>
                                                @foreach ($pegawai as $peg)
                                                    <option value="{{ $peg->id }}" {{ old('pengirim_pegawai', $data->pengirim_pegawai) == $peg->id ? 'selected' : '' }}>({{ $peg->nip }}) {{ $peg->nama }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" name="pengirim" id="pengirim_uang" class="form-control mt-1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="no_transaksi" class="font-weight-bold">No. Transaksi:</label>
                                        <input type="text" name="no_transaksi" id="no_transaksi" class="form-control" value="{{ $data->no_transaksi }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tanggal_transaksi" class="font-weight-bold">Tgl. Transaksi:</label>
                                        <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" class="form-control" value="{{ $data->tanggal_transaksi }}">
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
                                                <th width="20%">Akun Pengirim</th>
                                                <th width="25%">Deskripsi</th>
                                                <th width="15%">Pajak</th>
                                                <th width="20%">Potongan Pajak</th>
                                                <th width="20%">Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody id="myTable">
                                            @forelse ($detail_terima_uang as $item)
                                                <tr>
                                                    <td>
                                                        <select id='akun_pengirim' class="akun_pengirim form-control" name="akun_pengirim[]">
                                                            <option value="" disabled selected>-- Pilih Akun --</option>
                                                            @foreach ($account_pengirim as $bi)
                                                                <option value="{{ $bi->id }}" {{ old('akun_pengirim', $item->akun_pengirim) == $bi->id ? 'selected' : '' }}>({{ $bi->nomor }}){{ $bi->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control deskripsi" value="{{ $item->deskripsi }}" type="text" id="deskripsi" name="deskripsi[]">
                                                    </td>
                                                    <td>
                                                        <select id='pajak_id' class="pajak_id form-control" name="pajak_id[]">
                                                            @if ($item->pajak_id !== NULL)
                                                                <option value="">-- Pilih Pajak --</option>
                                                                @foreach ($pajak as $paj)
                                                                    <option value="{{ $paj->id }}" {{ old('pajak_id', $item->pajak_id) == $paj->id ? 'selected' : '' }}>{{ $item->pajak->nama_pajak }}</option>
                                                                @endforeach
                                                            @else
                                                                <option value="" selected>-- Pilih Pajak --</option>
                                                                @foreach ($pajak as $paj)
                                                                    <option value="{{ $paj->id }}">{{ $paj->nama_pajak }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control potongan_pajak" value="{{ $item->potongan_pajak }}" type="text" id="potongan_pajak" name="potongan_pajak[]">
                                                    </td>
                                                    <td>
                                                        <div class="input-group mb-3">
                                                            <div  class="input-group-prepend">
                                                                <span  class="input-group-text">RP</span>
                                                            </div>
                                                            <input type="text" class="form-control jumlah" id="jumlah" name="jumlah[]" value="{{ $item->jumlah }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5">
                                                        <p>Data Not Found</p>
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                    <textarea name="memo" id="memo" cols="30" rows="5" class="form-control" placeholder="Little note...">{{ $data->memo }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="lampiran" class="font-weight-bold">Lampiran:</label>
                                    <div class="input-group mt-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="lampiran" value="{{ old('lampiran') }}" name="lampiran">
                                            <label class="custom-file-label" for="lampiran">Choose file</label>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" id="lampiran" value="{{ $data->lampiran }}" name="lampiran_old">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mt-10">
                                    <div class="col-md-5">
                                        <h6 class="font-weight-bolder">Subtotal</h6>
                                    </div>
                                    <div class="col-md-7 text-right">
                                        <input type="text" name="sub_total" id="sub_total" class="form-control bg-transparent border-0 font-size-h6-lg font-weight-bolder text-right" value="{{ $data->sub_total }}" readonly>
                                    </div>
                                </div>
                                <div class="row mt-10">
                                    <div class="col-md-5">
                                        <h6 class="font-weight-bolder">Potongan Pajak</h6>
                                    </div>
                                    <div class="col-md-7 text-right">
                                        <input type="text" name="potongan_pajak_display" id="potongan_pajak_display" class="form-control bg-transparent border-0 font-size-h6-lg font-weight-bolder text-right" value="{{ $besar_potongan }}" readonly>
                                    </div>
                                </div>
                                <hr class="bg-primary my-5">
                                <div class="row">
                                    <div class="col-md-5">
                                        <h6 class="font-weight-bolder">Total</h6>
                                    </div>
                                    <div class="col-md-7 text-right">
                                        <input type="text" name="total_global" id="total_global" class="form-control bg-transparent border-0 font-size-h6-lg font-weight-bolder text-right total_global" value="{{ $data->total }}" readonly>
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

@push('addon-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


<script>
    function send_pengirim_pegawai(){
        $data_peg = document.getElementById('pengirim_pegawai').value;
        $('#pengirim_uang').val($data_peg);
    }

    function send_penerima_customer(){
        $data_sup = document.getElementById('pengirim_customer').value;
        $('#pengirim_uang').val($data_sup);
    }
    $(document).ready(function(){
        myCreateFunction2();
        myDeleteFunction();

        let hasil_total_global = document.querySelectorAll(".jumlah");
        for (let i = 0; i < hasil_total_global.length; i++){
            var jum_row = parseInt(i); 
        }
        $('#hitung_row').val(jum_row);

        // kode untuk radio button penerima
        // $('#penerima_supplier').hide();
        // $('input:radio[name="RadiosNavigasi"]').change(function(){
            if($(".RadiosNavigasi").is(':checked') == 'customer'){
                $('#pengirim_customer').show();
                $('#pengirim_pegawai').hide();
                console.log('supplier on');
            }else{
                $('#pengirim_customer').hide();
                $('#pengirim_pegawai').show();
                console.log('pegawai on');

            }
        // });

        $('input:radio[name="RadiosNavigasi"]').change(function(){
            if($(this).is(':checked') && $(this).val() == 'customer'){
                $('#pengirim_customer').fadeIn(2000);
                $('#pengirim_pegawai').hide();
                console.log('supplier on');
            }else{
                $('#pengirim_customer').hide();
                $('#pengirim_pegawai').fadeIn(2000);
                console.log('pegawai on');

            }
        });


    });
        // kode untuk menambah row tabel
        // function untuk menambah row detail pembelian
        function myCreateFunction2() {
            var table = document.getElementById("myTable");
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);

            cell1.innerHTML = `
                            <select id='akun_tujuan' class="akun_tujuan form-control" name="akun_tujuan[]">
                                <option value="" disabled selected>-- Pilih Akun --</option>
                            </select>
                            `;
                                
            cell2.innerHTML = `<input class="form-control deskripsi" value="" type="text" id="deskripsi" name="deskripsi[]">`;
            cell3.innerHTML = `<select id='pajak_id' class="pajak_id form-control" name="pajak_id[]">
                                <option value="" selected>-- Pilih Pajak --</option>
                            </select>
                            `;
            cell4.innerHTML = `<input class="form-control potongan_pajak" value="0" type="text" id="potongan_pajak" name="potongan_pajak[]" readonly>`;
            cell5.innerHTML = `<div class="input-group mb-3">
                                    <div  class="input-group-prepend">
                                        <span  class="input-group-text">RP</span>
                                    </div>
                                    <input type="text" class="form-control jumlah" id="jumlah" name="jumlah[]" value="0">
                                </div>`;
            
            // pajak onchange
            const paj_select = document.querySelectorAll('.pajak_id');
            for (let p = 0; p < paj_select.length; p++) {
                paj_select[p].addEventListener('change', function(){
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
                                    // console.log(hasil_potongan_pajak[p].value);
                                }
                            
                                $('#hitung_row').val(jum_row);
                                $('#sub_total').val(sub_total);
                                $('#potongan_pajak_display').val(pajak_display);
                                // console.log(pajak_display);
                                $('.total_global').val(sub_total+pajak_display);
                                jum_potongan();
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
                                    // console.log(hasil_potongan_pajak[p].value);
                                }
                            
                                $('#hitung_row').val(jum_row);
                                $('#sub_total').val(sub_total);
                                $('#potongan_pajak_display').val(pajak_display);
                                // console.log(pajak_display);
                                $('.total_global').val(sub_total+pajak_display);
                                jum_potongan();
                        }else{
                            $.ajax({
                                url: "../../pajak_id_pembelian"+'/' + pajakId,
                                type: "GET",
                                data: {"_token":"{{ csrf_token() }}"},
                                success: function(data){
                                    var besar_pajak = (jumlah * data[0].persentase) / 100;
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
                                                // console.log(hasil_potongan_pajak[p].value);
                                            }
                                        
                                            $('#hitung_row').val(jum_row);
                                            $('#sub_total').val(sub_total);
                                            $('#potongan_pajak_display').val(pajak_display);
                                            // console.log(pajak_display);
                                            $('.total_global').val(sub_total+pajak_display);
                                            jum_potongan();
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
                    } else {
                        $.ajax({
                                url: "../../pajak_id_pembelian"+'/' + pajak_id,
                                type: "GET",
                                data: {"_token":"{{ csrf_token() }}"},
                                success: function(data){
                                    var besar_pajak = (jumlahTotal * data[0].persentase) / 100;
                                    // var jum_pajak = jum_sementara - besar_pajak;
                                    $('#myTable tr:nth-child('+parameter_jumlah+') #potongan_pajak').val(besar_pajak);
                                }
                            });
                    }

                    let hasil_total_global = document.querySelectorAll(".jumlah");
                    var sub_total = 0;
                        for (let i = 0; i < hasil_total_global.length; i++){
                            sub_total += parseInt(hasil_total_global[i].value);
                            var jum_row = parseInt(i); 
                        }

                    var hasil_potongan_pajak = document.querySelectorAll("potongan_pajak");
                    var pajak_display = 0;
                        for (let paj = 0; paj < hasil_potongan_pajak.length; paj++) {
                            pajak_display += parseInt(hasil_potongan_pajak[paj].value);
                        }
                    
                        $('#hitung_row').val(jum_row);
                        $('#sub_total').val(sub_total);
                        $('#potongan_pajak_display').val(pajak_display);
                        $('.total_global').val(sub_total+pajak_display);
                        // $('#grand_total').val(sub_total+pajak_display);
                })
                
            }
        }

        function myCreateFunction() {
            var table = document.getElementById("myTable");
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);

            var callProduct = get_akun_tujuan();
            var callPajak = get_data_pajak();

            cell1.innerHTML = `
                            <select id='akun_tujuan' class="akun_tujuan form-control" name="akun_tujuan[]">
                                <option value="" disabled selected>-- Pilih Akun --</option>
                            </select>
                            `;
                                
            cell2.innerHTML = `<input class="form-control deskripsi" value="" type="text" id="deskripsi" name="deskripsi[]">`;
            cell3.innerHTML = `<select id='pajak_id' class="pajak_id form-control" name="pajak_id[]">
                                <option value="" selected>-- Pilih Pajak --</option>
                            </select>
                            `;
            cell4.innerHTML = `<input class="form-control potongan_pajak" value="0" type="text" id="potongan_pajak" name="potongan_pajak[]" readonly>`;
            cell5.innerHTML = `<div class="input-group mb-3">
                                    <div  class="input-group-prepend">
                                        <span  class="input-group-text">RP</span>
                                    </div>
                                    <input type="text" class="form-control jumlah" id="jumlah" name="jumlah[]" value="0">
                                </div>`;
            
            // pajak onchange
            const paj_select = document.querySelectorAll('.pajak_id');
            for (let p = 0; p < paj_select.length; p++) {
                paj_select[p].addEventListener('change', function(){
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
                            // console.log(hasil_potongan_pajak[p].value);
                        }
                    
                        $('#hitung_row').val(jum_row);
                        $('#sub_total').val(sub_total);
                        $('#potongan_pajak_display').val(pajak_display);
                        // console.log(pajak_display);
                        $('.total_global').val(sub_total+pajak_display);


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
                                        // console.log(hasil_potongan_pajak[p].value);
                                    }
                                
                                    $('#hitung_row').val(jum_row);
                                    $('#sub_total').val(sub_total);
                                    $('#potongan_pajak_display').val(pajak_display);
                                    // console.log(pajak_display);
                                    $('.total_global').val(sub_total+pajak_display);
                        }else{
                            $.ajax({
                                url: "../../pajak_id_pembelian"+'/' + pajakId,
                                type: "GET",
                                data: {"_token":"{{ csrf_token() }}"},
                                success: function(data){
                                    var besar_pajak = (jumlah * data[0].persentase) / 100;
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
                                                // console.log(hasil_potongan_pajak[p].value);
                                            }
                                        
                                            $('#hitung_row').val(jum_row);
                                            $('#sub_total').val(sub_total);
                                            $('#potongan_pajak_display').val(pajak_display);
                                            // console.log(pajak_display);
                                            $('.total_global').val(sub_total+pajak_display);
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
                    } else {
                        $.ajax({
                                url: "../../pajak_id_pembelian"+'/' + pajak_id,
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
        }

        function get_akun_tujuan(){
            $.ajax({
                    url: "{{ route('get_akun_pengirim') }}",
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    success: function(data){
                        $.each(data, function(key, log){
                            var product = '<option value="'+ log.id +'" class="'+ log.id +'">(' +log.nomor +' ) '+ log.nama +'</option>';
                            $('.akun_tujuan').last().append(product);
                            
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
        }
</script>

@endpush
