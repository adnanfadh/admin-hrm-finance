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
                    <li class="breadcrumb-item"><a href="{{ route('pengajuan.index') }}" style="text-decoration: none"> Pengajuan</a></li>
                    <li class="breadcrumb-item " aria-current="page">Create Pengajuan</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box-nav shadow-sm bg-white p-5 rounded">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div aria-current="page">
                            {{-- <h4>Create Pengajuan</h4> --}}
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
                        <h3 class="card-label text-gray-700">Create Pengajuan</h3>
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
                    <form action="{{ route('pengajuan.store') }}" method="post" enctype="multipart/form-data">
                        @csrf 
                        {{-- satart box input pelalnggan --}}
                        <div class="box-supplier bg-light p-5 rounded">
                            <div class="row">
                                <div class="col-md-6 order-lg-1 order-sm-2 order-md-1 mt-3">
                                    <div class="form-group mt-10">
                                        <label for="alamat_penagihan" class="font-weight-bold">Jenis Pengajuan:</label>
                                        <br>
                                        <input type="radio" class="form-check-inline" name="jenis_pengajuan" id="jenis_pengajuan" value="1" checked><label for="jenis_pengajuan">RAB</label>
                                        <input type="radio" class="form-check-inline ml-15" name="jenis_pengajuan" id="jenis_pengajuan2" value="2"><label for="jenis_pengajuan2">Pengajuan Langsung</label>
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
                                    <div class="form-group">
                                        <label for="tanggal_pengajuan" class="font-weight-bold">Tanggal Pengajuan:</label>
                                        <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan" class="form-control" value="{{ old('tanggal_pengajuan') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="penerima" class="font-weight-bold">Penerima:</label>
                                        <select name="penerima" id="penerima" class="form-control">
                                            @foreach ($penerima as $p)
                                                <option value="{{ $p->id }}">{{ $p->nama }}/{{ $p->jabatan->nama }}/{{ $p->company->nama_company }}</option>
                                            @endforeach
                                        </select>
                                        <small>*Nama Pegawai / Jabatan / Company</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_surat" class="font-weight-bold">No Surat:</label>
                                        <input type="text" name="no_surat" id="no_surat" class="form-control" value="{{ old('no_surat') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="perihal_surat" class="font-weight-bold">Perihal Surat:</label>
                                        <input type="text" name="perihal_surat" id="perihal_surat" class="form-control" value="{{ old('perihal_surat') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="lampiran_surat" class="font-weight-bold">Lampiran Surat:</label>
                                        <input type="text" name="lampiran_surat" id="lampiran_surat" class="form-control" value="{{ old('lampiran_surat') }}">
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
                                            <tr class="text-center">
                                                <th width="10%">Tgl Pelaksanaan</th>
                                                <th width="30%">Item</th>
                                                <th width="15%">Vendor</th>
                                                <th width="20%">Harga</th>
                                                <th width="5%">Jumlah Item</th>
                                                <th width="20%">Budget</th>
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
                        <hr> 
                        {{-- end row button add delete cell table --}}
                        <div class="row d-flex flex-row justify-content-between">
                            <div class="col-md-4">
                                
                            </div>
                            <div class="col-md-6">
                                <div class="row mt-10">
                                    <div class="col-md-5">
                                        <h6 class="font-weight-bolder">Total</h6>
                                    </div>
                                    <div class="col-md-7 text-right">
                                        <input type="text" name="total_nominal_pengajuan" id="total_global" class="form-control bg-transparent border-0 font-size-h6-lg font-weight-bolder text-right total_global" value="0" readonly>
                                        <input class="form-control hitung_row" value="" type="text" id="hitung_row" name="hitung_row" readonly>
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
            var cell6 = row.insertCell(5);

            cell1.innerHTML = `
                            <input class="form-control tanggal_pelaksanaan" value="" type="date" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan[]">
                            `;
                                
            cell2.innerHTML = `
                            <input class="form-control item" value="" type="text" id="item" name="item[]">
                            `;
            cell3.innerHTML = `
                            <input class="form-control vendor" value="" type="text" id="vendor" name="vendor[]">
                            `;
            cell4.innerHTML = `
                            <div class="input-group mb-3">
                                    <div  class="input-group-prepend">
                                        <span  class="input-group-text">RP</span>
                                    </div>
                                    <input type="text" class="form-control harga" id="harga" name="harga[]" value="0">
                            `;
            cell5.innerHTML = `
                            <input class="form-control jumlah_item" value="1" type="numeric" id="jumlah_item" name="jumlah_item[]">
                            `;
            cell6.innerHTML = `
                            <div class="input-group mb-3">
                                <div  class="input-group-prepend">
                                    <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" class="form-control budget" id="budget" name="budget[]" value="0">
                            </div>
                            `;
            
            // Harga Item keyup
            const harga_item = document.querySelectorAll('.harga');
            for (let p = 0; p < harga_item.length; p++) {
                harga_item[p].addEventListener('keyup', function get(){
                    var harga_items = harga_item[p].value;
                    var parameter_harga = p + 1;
                    var budget = $('#myTable tr:nth-child('+parameter_harga+') #budget').val();
                    var jum_item = $('#myTable tr:nth-child('+parameter_harga+') #jumlah_item').val();


                    if (jum_item > 1) {
                        $('#myTable tr:nth-child('+parameter_harga+') #budget').val(harga_items * jum_item);
                        let hasil_total_global = document.querySelectorAll(".budget");
                            var sub_total = 0;
                            for (let i = 0; i < hasil_total_global.length; i++){
                                sub_total += parseInt(hasil_total_global[i].value);
                                var jum_row = parseInt(i); 
                            }
                        $('#hitung_row').val(jum_row);
                        $('.total_global').val(sub_total);
                    } else {
                        $('#myTable tr:nth-child('+parameter_harga+') #budget').val(harga_items);
                        let hasil_total_global = document.querySelectorAll(".budget");
                            var sub_total = 0;
                            for (let i = 0; i < hasil_total_global.length; i++){
                                sub_total += parseInt(hasil_total_global[i].value);
                                var jum_row = parseInt(i); 
                            }
                        $('#hitung_row').val(jum_row);
                        $('.total_global').val(sub_total);
                    }
                })
            }



            // jumlah item keyup
            const jumlah_item = document.querySelectorAll('.jumlah_item');
                for (let p = 0; p < jumlah_item.length; p++) {
                    jumlah_item[p].addEventListener('keyup', function get(){
                        var jumlah_items = jumlah_item[p].value;
                        var parameter_item = p + 1;
                        var budget = $('#myTable tr:nth-child('+parameter_item+') #budget').val();
                        var harga_item = $('#myTable tr:nth-child('+parameter_item+') #harga').val();
    
    
                        if (harga_item > 0) {
                            $('#myTable tr:nth-child('+parameter_item+') #budget').val(jumlah_items * harga_item);
                            let hasil_total_global = document.querySelectorAll(".budget");
                                var sub_total = 0;
                                for (let i = 0; i < hasil_total_global.length; i++){
                                    sub_total += parseInt(hasil_total_global[i].value);
                                    var jum_row = parseInt(i); 
                                }
                            $('#hitung_row').val(jum_row);
                            $('.total_global').val(sub_total);
                        } else {
                            $('#myTable tr:nth-child('+parameter_item+') #budget').val(harga_item);
                            let hasil_total_global = document.querySelectorAll(".budget");
                                var sub_total = 0;
                                for (let i = 0; i < hasil_total_global.length; i++){
                                    sub_total += parseInt(hasil_total_global[i].value);
                                    var jum_row = parseInt(i); 
                                }
                            $('#hitung_row').val(jum_row);
                            $('.total_global').val(sub_total);
                        }
                    })
                }


            // hitung jumlah row untuk perulangan di backend
            let hasil_total_global = document.querySelectorAll(".budget");
            var sub_total = 0;
            for (let i = 0; i < hasil_total_global.length; i++){
                sub_total += parseInt(hasil_total_global[i].value);
                var jum_row = parseInt(i); 
            }
            $('#hitung_row').val(jum_row);
            $('.total_global').val(sub_total);
        }


        function myDeleteFunction() {
            document.getElementById("myTable").deleteRow(-1);

            let hasil_total_global = document.querySelectorAll(".budget");
            var sub_total = 0;
            for (let i = 0; i < hasil_total_global.length; i++){
                sub_total += parseInt(hasil_total_global[i].value);
                var jum_row = parseInt(i); 
            }
            $('#hitung_row').val(jum_row);
            $('.total_global').val(sub_total);
        }
</script>

@endpush
