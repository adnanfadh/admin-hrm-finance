@extends('layouts.app_finance') 
@push('addon-style')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
@endpush 
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Page Heading -->
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb shadow-sm bg-white p-5">
                    <li class="breadcrumb-item"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pembelian.index') }}" style="text-decoration: none"> Pembelian</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pembelian.show', $data->id) }}" style="text-decoration: none">Detail Pembelian</a></li>
                    <li class="breadcrumb-item " aria-current="page">Edit Pembelian</li>
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
                            <p>Edit Pembelian</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div aria-current="page">
                            <h4>Edit Data Pemesanan Pembelian</h4>
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
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card card-custom gutter-b border-0 shadow">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label text-gray-700">Form Edit Pembelian</h3>
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

                    <form action="{{ route('pembelian.update', $data->id) }}" method="post" enctype="multipart/form-data">
                      @method('PUT')
                        @csrf 
                      {{-- satart box input pelalnggan --}}
                      <div class="box-pelanggan bg-light p-5 rounded">
                          <div class="row">
                              <div class="col-md-6 order-lg-1 order-sm-2 order-md-1 mt-3">
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="pelanggan" class="font-weight-bold">Pelanggan:</label>
                                              <select class="form-control" id="supplier_id" name="supplier_id" onchange="myFunction()">
                                                  <option value="" disabled>-- Tentukan Supplier --</option>
                                                  <option value="{{ $data->supplier->id }}" selected>{{ $data->supplier->nama_supplier }}</option>
                                                  <option value="12" class="font-weight-bolder bg-primary text-white">Add New Supplier</option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="email" class="font-weight-bold">Email:</label>
                                              <input type="text" class="form-control" id="email_supplier" name="email_supplier" value="{{ $data->supplier->email_supplier }}" readonly>
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
                      {{-- end box input pelanggan --}} {{-- start box input info transaksi --}}
                      <div class="box-info-transaksi mt-5">
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="alamat" class="font-weight-bold">Alamat Penagihan:</label>
                                      <textarea name="alamat_penagihan" id="alamat_penagihan" cols="30" rows="6" class="form-control">{{ $data->alamat_penagihan }}</textarea>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="no_transaksi" class="font-weight-bold">No. Transaksi:</label>
                                      <input type="text" name="no_transaksi" id="no_transaksi" class="form-control" value="{{ $data->no_transaksi }}">
                                  </div>
                                  <div class="form-group">
                                      <label for="tanggal_transaksi" class="font-weight-bold">Tgl. Transaksi:</label>
                                      <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" value="{{$data->tanggal_transaksi}}" class="form-control">
                                  </div>
                                  <div class="form-group" id="metode_pembayaran_group"> 
                                      <label for="metode_pembayaran" class="font-weight-bold">Metode Pembayaran:</label>
                                      <select name="metode_pembayaran_id" id="metode_id" class="form-control" onchange="AddMetodeShow()">
                                        <option value="11" class="font-weight-bolder bg-primary text-white">Add New Metode</option>
                                            @if ($data->metode_pembayaran_id !== null)
                                                <option value="{{ $data->metode_pembayaran->id }}" selected>{{ $data->metode_pembayaran->nama_metode }}</option>
                                            @endif
                                        </select>
                                        <select name="metode_pembayaran_id2" id="metode_id2" class="form-control" style="display: none">
                                            <option value="11" class="font-weight-bolder bg-primary text-white">Add New Metode</option>
                                            @if ($data->metode_pembayaran_id !== null)
                                                <option value="{{ $data->metode_pembayaran->id }}" selected>{{ $data->metode_pembayaran->nama_metode }}</option>
                                            @endif
                                        </select>
                                    </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="tanggal_jatuh_tempo" class="font-weight-bold">Tgl. Pengajuan:</label>
                                      <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" class="form-control" value="{{ $data->tanggal_jatuh_tempo }}">
                                  </div>
                                  <div class="form-group">
                                      <label for="syarat_pembayaran" class="font-weight-bold">Syarat Pembayaran</label>
                                      <select name="syarat_pembayaran_id" id="syarat_id" class="form-control" onchange="AddSyaratShow()">
                                        <option value="10" class="text-white bg-primary font-weight-bolder">Add New Syarat</option>
                                        <option value="{{ $data->syarat_pembayaran->id }}" selected>{{ $data->syarat_pembayaran->nama_syarat }}</option>
                                      </select>
                                      <select name="syarat_pembayaran_id2" id="syarat_id2" class="form-control" style="display: none">
                                        <option value="10" class="text-white bg-primary font-weight-bolder">Add New Syarat</option>
                                        <option value="{{ $data->syarat_pembayaran->id }}" selected>{{ $data->syarat_pembayaran->nama_syarat }}</option>
                                      </select>
                                  </div>
                                  <div class="form-group" id="nominal_tagihan_group">
                                      <label for="nominal_tagihan" class="font-weight-bold">Nominal Tagihan:</label>
                                      <div class="input-group mb-3">
                                          <div  class="input-group-prepend">
                                              <span  class="input-group-text">RP.</span>
                                          </div>
                                          <input type="text" class="form-control" name="nominal_tagihan" value="{{ $data->nominal_tagihan }}" id="nominal_tagihan">
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      {{-- end box input info transaksi --}}
                      <div class="row">
                        <div class="col-md-12">
                            <div class="box bg-danger-o-10 rounded">
                                {{-- @if ($data->jenis_pembelian = "Pembelian RAB") --}}
                                    <div class="form-group p-1 text-right">
                                        <label for="switch_rab" class="font-weight-bold font-size-h4-xl">Pembelian RAB</label>
                                        <input type="checkbox" id="switch_rab" class="checkbox-lg" name="switch_rab" value="1" {{ old('switch_rab', $data->jenis_pembelian) == 'Pembelian RAB' ? 'checked' : '' }}>
                                    </div>
                                {{-- @else
                                    <div class="form-group p-1 text-right">
                                        <label for="switch_rab" class="font-weight-bold font-size-h4-xl">Pembelian RAB</label>
                                        <input type="checkbox" id="switch_rab" class="checkbox-lg" name="switch_rab" value="1">
                                    </div>
                                @endif --}}
                            </div>
                        </div>
                      </div>
                      @if ($data->jenis_pembelian == "Pembelian RAB")
                        <div class="pembelian_rab" id="pembelian_rab">
                            {{-- start table detail pembelian --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover scroll-horizontal-vertical w-100 table-responsive-lg" width="100%">
                                            <thead class="bg-dark text-white w-100">
                                                <tr>
                                                    <th width="20%">Item</th>
                                                    <th width="10%">Vendor</th>
                                                    <th width="10%">Item Approved</th>
                                                    <th width="20%">Estimasi Budget</th>
                                                    <th width="10%">Total Budget</th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTableRAB">
                                                @foreach ($data->detail_pembelian as $it)
                                                <tr>
                                                <td>
                                                    <select id='pengajuan_selected' class="pengajuan_selected form-control" name="pengajuan_selected[]">
                                                    <option value="" disabled selected>-- Pilih Product --</option>
                                                    @foreach ($pengajuan as $pg)
                                                        <option value="{{ $pg->id }}" {{ old('item_pengajuan', $it->pengajuan->id) == $pg->id ? 'selected' : '' }}>{{ $pg->item }}</option>
                                                    @endforeach
                                                </select>
                                                </td>
                                                <td>
                                                    <input class="form-control vendor" value="{{ $it->pengajuan->vendor }}" type="text" id="vendor" name="vendor[]">
                                                </td>
                                                <td>
                                                    <input class="form-control item_approved" value="{{ $it->pengajuan->jumlah_item_approved }}" type="text" id="item_approved" name="item_approved[]" readonly>
                                                </td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                    <div  class="input-group-prepend">
                                                        <span  class="input-group-text">RP</span>
                                                    </div>
                                                    <input type="text" class="form-control budget" id="budget" name="budget[]" value="{{ $it->pengajuan->budget }}" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">RP</span>
                                                    </div>
                                                    <input type="text" class="form-control total_budget" value="{{ $it->pengajuan->budget_approved }}" id="total_budget" name="total_budget[]" readonly>
                                                    </div>
                                                </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- end table detail pembelian --}} {{-- start row button add delete cell table --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary btn-sm" id="btnAddForm" onclick="myCreateFunctionRAB()">Tambah Product</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="myDeleteFunctionRAB()">Delete Product</button>
                                </div>
                            </div>
                            <hr> {{-- end row button add delete cell table --}}
                        </div>
                      @else
                        <div class="pembelian_biasa" id="pembelian_biasa">
                            {{-- start table detail pembelian --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover scroll-horizontal-vertical w-100 table-responsive-lg" width="100%">
                                            <thead class="bg-dark text-white w-100">
                                                <tr>
                                                    <th width="20%">Produk</th>
                                                    <th width="10%">Qty</th>
                                                    <th width="10%">Satuan</th>
                                                    <th width="20%">Harga satuan</th>
                                                    <th width="10%">Diskon</th>
                                                    <th width="10%">Pajak</th>
                                                    <th width="20%">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="myTable">
                                                @foreach ($data->detail_pembelian as $item)
                                                <tr>
                                                <td>
                                                    <select id='product_selected' class="product_selected form-control" name="product_selected[]">
                                                    <option value="" disabled selected>-- Pilih Product --</option>
                                                    @foreach ($product as $prod)
                                                        <option value="{{ $prod->id }}" {{ old('product_selected', $item->product->id) == $prod->id ? 'selected' : '' }}>{{ $prod->nama_product }}</option>
                                                    @endforeach
                                                </select>
                                                </td>
                                                <td>
                                                    <input class="form-control qty_pembelian" value="{{ $item->qty_pembelian }}" type="text" id="qty_pembelian" name="qty_pembelian[]">
                                                </td>
                                                <td>
                                                    <input class="form-control satuan_product" value="{{ $item->product->satuan }}" type="text" id="satuan_product" name="satuan_product[]" readonly>
                                                </td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                    <div  class="input-group-prepend">
                                                        <span  class="input-group-text">RP</span>
                                                    </div>
                                                    <input type="text" class="form-control harga_satuan" id="harga_satuan" name="harga_satuan[]" value="{{ $item->product->harga_satuan }}" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="form-control discount_per_product" value="{{ $item->discount_product }}" type="text" id="disk_product" name="discount_per_product[]">
                                                    <input class="form-control total_discount" value="{{ $item->total_discount }}" type="hidden" id="total_discount" name="total_discount[]" readonly>
                                                </td>
                                                <td>
                                                    <select class="form-control pajak_per_product" id="pajak_product" name="pajak_per_product[]">
                                                    @if ($item->pajak_id == null)
                                                        <option value="" selected>-- Pilih Pajak --</option>
                                                        @foreach ($pajak as $paj)
                                                        <option value="{{ $paj->id ?? '' }}">{{ $paj->nama_pajak}}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="" selected>-- Pilih Pajak --</option>
                                                        @foreach ($pajak as $paj)
                                                        <option value="{{ $paj->id ?? '' }}" {{ old('pajak_per_product', $item->pajak->id) == $paj->id ? 'selected' : '' }}>{{ $paj->nama_pajak ?? '' }}</option>
                                                        @endforeach
                                                    @endif
                                                    </select>
                                                    <input class="form-control potongan_pajak" value="{{ $item->potongan_pajak }}" type="hidden" id="potongan_pajak" name="potongan_pajak[]" readonly>
                                                </td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">RP</span>
                                                    </div>
                                                    <input type="text" class="form-control total_per_product" value="{{ $item->total }}" id="total_per_product" name="total_per_product[]" readonly>
                                                    </div>
                                                </td>
                                                </tr>
                                                @endforeach
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
                        </div>
                      @endif
                      <div class="row d-flex flex-row justify-content-between">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="pesan" class="font-weight-bold">Pesan:</label>
                                  <textarea name="pesan" id="pesan" cols="30" rows="5" class="form-control" placeholder="Little note...">{{ $data->pesan }}</textarea>
                              </div>
                              <div class="form-group">
                                  <label for="lampiran" class="font-weight-bold">Lampiran:</label>
                                  <div class="input-group mt-2">
                                      <div class="custom-file">
                                          <input type="file" class="custom-file-input" id="lampiran" name="lampiran">
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
                              <hr class="bg-primary my-5">
                              <div class="row">
                                  <div class="col-md-5">
                                      <h6 class="font-weight-bolder">Total</h6>
                                  </div>
                                  <div class="col-md-7 text-right">
                                      <input type="text" name="total_global" id="total_global" class="form-control bg-transparent border-0 font-size-h6-lg font-weight-bolder text-right total_global" value="{{ $data->total }}" readonly>
                                  </div>
                              </div>
                              <hr class="bg-primary my-5">
                              <div class="row">
                                  <div class="col-md-5">
                                      <h6 class="font-weight-bolder">Sisa Tagihan</h6>
                                      <input class="form-control hitung_row" value="" type="hidden" id="hitung_row" name="hitung_row" readonly>
                                  </div>
                                  <div class="col-md-7 text-right">
                                      <input type="text" name="sisa_tagihan" id="sisa_tagihan" class="form-control bg-transparent border-0 font-size-h6-lg font-weight-bolder text-right" value="{{ $data->sisa_tagihan }}" readonly>
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
                                <input type="submit" class="btn btn-primary" value="Buat">
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
<!-- /.container-fluid -->



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
                          <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="kontak">Kontak:</label>
                          <input type="text" name="kontak" id="kontak" class="form-control" value="{{ old('kontak') }}">
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <label for="alamat">Alamat:</label>
                  <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control">{{ old('alamat') }}</textarea>
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

{{-- modal untuk add metode --}}
<div class="modal fade" id="ajaxModelMetode" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="modelHeadingMetode"></h4>
          </div>
          <div class="modal-body">
              <form id="MetodeForm" name="MetodeForm" class="form-horizontal">
                 <input type="hidden" name="Metode_id" id="Metode_id">
                 
                  <div class="col-md-12 col-12">
                      <div class="form-group">
                          <label for="nama_metode">Nama Metode:</label>
                          <input type="text" autofocus name="nama_metode" id="nama_metode" value="{{ old('nama_metode') }}" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="account_bank" class="col-sm-12 control-label">AccountBank</label>
                            <select name="account_bank" id="account_bank" class="form-control">
                                <option value="">-- Account Bank --</option>
                                @foreach ($account_bank as $ab)
                                    <option value="{{ $ab->id }}">({{ $ab->nomor }})-{{ $ab->nama }}</option>
                                @endforeach
                            </select>
                    </div>
                  </div>
                  <div class="col-sm-offset-2 col-sm-10">
                   <button type="submit" class="btn btn-primary" id="saveBtnMetode" value="create">Save changes
                   </button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>


{{-- modal untuk add Syarat --}}
<div class="modal fade" id="ajaxModelSyarat" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="modelHeadingSyarat"></h4>
          </div>
          <div class="modal-body">
              <form id="SyaratForm" name="SyaratForm" class="form-horizontal">
                 <input type="hidden" name="Syarat_id" id="Syarat_id">
                 
                  <div class="col-md-12 col-12">
                      <div class="form-group">
                          <label for="nama_syarat">Nama Syarat:</label>
                          <input type="text" autofocus name="nama_syarat" id="nama_syarat" value="{{ old('nama_syarat') }}" class="form-control">
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="jangka_waktu">Jangka Waktu:</label>
                          <div class="input-group">
                              <input type="number" name="jangka_waktu" id="jangka_waktu" class="form-control" value="{{ old('jangka_waktu') }}">
                              <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">Hari</span>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-offset-2 col-sm-10">
                   <button type="submit" class="btn btn-primary" id="saveBtnSyarat" value="create">Save changes
                   </button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>


{{-- modal panduan penggunaan --}}
<!-- Modal -->
<div class="modal fade" id="panduanModal" tabindex="-1" role="dialog" aria-labelledby="panduanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="panduanModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

@endsection



@push('addon-script')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">

</script>

{{-- script untuk tambah supplier --}}
<script type="text/javascript">
        function myFunction() {
            if (document.getElementById("supplier_id").value == 12) {
                $.ajax({
                url: "{{ route('getAjaxSupplierPembelian') }}",
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                    success:function(data){
                        var kode_sup = 'S-000'+data.data;
                        console.log(data);
                        $('#saveBtn').val("create-Supplier");
                        $('#Supplier_id').val('');
                        $('#kode_supplier').val(kode_sup);
                        $('#modelHeading').html("Create New Supplier");
                        $('#ajaxModel').modal('show');
                    }
                });
            }else{
                var supplierId = document.getElementById("supplier_id").value;
                // var datid = $this.val(); 
                // console.log(supplierId);
                    $.ajax({
                        url: "../../suppliers_id_pembelian"+'/' + supplierId,
                        type: "get",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){
                            // console.log(data[0].email);
                            $('#email_supplier').val(data[0].email_supplier);
                        }
                    });
                
            }
        }

    $(function () {

        $.ajax({
                        url: "../../get_syarat_pembayaran_id"+'/' + {!! $data->syarat_pembayaran_id !!},
                        type: "GET",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){
                            // console.log(data);
                            // // fungsi untuk merubah tanggal jatuh  tempo
                            // var date_transaksi = document.getElementById("tanggal_transaksi").value;
                            // const d = new Date(date_transaksi);

                            // d.setDate(d.getDate() + data.jangka_waktu);
                            // // console.log(d);
                            // // $('#tanggal_jatuh_tempo').val("20/02/2022");


                            if (data.jangka_waktu > 0) {
                                $('#nominal_tagihan_group').show();
                                $('#metode_pembayaran_group').hide();
                            } else {
                                $('#nominal_tagihan_group').hide();
                                $('#metode_pembayaran_group').show();
                            }
                        }
                    });
  
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
</script>

{{-- script untuk tambah metode pembayaran --}}
<script type="text/javascript">
        function AddMetodeShow() {
            if (document.getElementById("metode_id").value == 11) {
                $('#saveBtnMetode').val("create-metode");
                $('#Metode_id').val('');
                // $('#MetodeForm').trigger("reset");
                $('#modelHeadingMetode').html("Create New Metode");
                $('#ajaxModelMetode').modal('show');
            }
            console.log(document.getElementById("metode_id").value);
        }
    $(function () {
  
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#saveBtnMetode').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
            data: $('#MetodeForm').serialize(),
            url: "{{ route('storeAjaxMetode') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {

                $('#MetodeForm').trigger("reset");
                $('#ajaxModelMetode').modal('hide');
                Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'Success...',
                        text: data.success
                });
                // table.draw();
                $('#metode_id').append('<option value="'+ data.dataId +'" selected>' + data.data.nama_metode+ '</option>');
            },
            error: function (data) {
                console.log('Error:', data);
                Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Oops..',
                        text: data.error
                    });
                $('#saveBtnModal').html('Save Changes');
            }
        });
    });
    });
</script>

{{-- script ajax tambah syarat pembayaran --}}
<script type="text/javascript">
    function AddSyaratShow(){
            if (document.getElementById("syarat_id").value == 10) {
                $('#saveBtnSyarat').val("create-sayarat");
                $('#Syarat_id').val('');
                $('#modelHeadingSyarat').html("Create New Syarat");
                $('#ajaxModelSyarat').modal('show');

                // console.log(document.getElementById("syarat_pembayaran").value);
            }else{
                var data_id = document.getElementById("syarat_id").value;
                // hitung pajak
                $.ajax({
                        url: "../../get_syarat_pembayaran_id"+'/' + data_id,
                        type: "GET",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){
                            console.log(data);
                            // fungsi untuk merubah tanggal jatuh  tempo
                            var date_transaksi = document.getElementById("tanggal_transaksi").value;
                            const d = new Date(date_transaksi);

                            d.setDate(d.getDate() + data.jangka_waktu);
                            // console.log(d);
                            // $('#tanggal_jatuh_tempo').val("20/02/2022");


                            if (data.jangka_waktu > 0) {
                                $('#nominal_tagihan_group').show();
                                $('#metode_pembayaran_group').hide();
                            } else {
                                $('#nominal_tagihan_group').hide();
                                $('#metode_pembayaran_group').show();
                            }
                        }
                    });
            }
        }
    
    $(function (){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $('#saveBtnSyarat').click(function (e){
            e.preventDefault();
            $(this).html('sending..');

            $.ajax({
                data: $('#SyaratForm').serialize(),
                url: "{{ route('storeAjaxSyarat') }}",
                type: "POST",
                dataType: "JSON",
                success: function(data){
                    console.log(data.data);
                    $('#SyaratForm').trigger("reset");
                    $('#ajaxModelSyarat').modal('hide');
                    Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: 'Success...',
                            text: data.success
                    });
                    console.log(data.dataId);
                    $('#syarat_id').append('<option value="'+ data.dataId +'" selected>' + data.data.nama_syarat+ '</option>');
                },
                error: function(data){
                    $('#ajaxModelSyarat').modal('hide');
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Oops..',
                        text: data.error
                    });
                    $('#saveBtnSyarat').html('Save Changes');
                }
            })
        })
    })
</script>

<script type="text/javascript">
        $(document).ready(function(){
            // $('#pembelian_rab').hide();
            $('#switch_rab').click(function() {
                if ($(this).is(':checked')) {
                    $('#pembelian_rab').show();
                    $('#pembelian_biasa').hide();
                    myCreateFunctionRAB();
                    myDeleteFunctionRAB();
                }else{
                    $('#pembelian_rab').hide();
                    $('#pembelian_biasa').show();
                    // console.log('pembelian biasa show');
                    myCreateFunction2();
                    myDeleteFunction();
                }
            });
        });
        $(document).ready(function() {
            if ($('#switch_rab').is(':checked')) {
                    myCreateFunctionRAB2();
                    myDeleteFunctionRAB2();
                }else{
                    myCreateFunction2();
                    myDeleteFunction();
                }
        // var dek = 0;
        // for (let i = 0; i <= 30; i++) {
        //     dek += i;
        // }
        // console.log(6**2);

        // var dadu = prompt("Masukan jumlah dadu", 0);
        // var kemungkinan = prompt("Kemungkinan muncul", 0);
        // alert(kemungkinan**dadu);

        


        let hasil_total_global = document.querySelectorAll(".total_per_product");
        for (let i = 0; i < hasil_total_global.length; i++){
            var jum_row = parseInt(i); 
        }
        $('#hitung_row').val(jum_row);

            //  ajax untuk mengambil data supplier
            $.ajax({
                url: "{{ route('get_suppliers_pembelian') }}",
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                    success:function(data){
                        $.each(data, function(key, log){
                            $('#supplier_id').append('<option value="'+ log.id +'">' + log.nama_supplier+ '</option>');
                           });
                    }
            });


            // ajax untuk mengambil data metode pembayaran
            $.ajax({
                url: "{{ route('get_metode_pembelian') }}",
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                    success:function(data){
                        $.each(data, function(key, log){
                            $('#metode_id').append('<option value="'+ log.id +'">' + log.nama_metode+ '</option>');
                           });
                    }
            });

            // ajax untuk mengambil data syarat pembayaran
            $.ajax({
                url: "{{ route('get_syarat_pembelian') }}",
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                    success:function(data){
                        $.each(data, function(key, log){
                            $('#syarat_id').append('<option value="'+ log.id +'">' + log.nama_syarat+ '</option>');
                           });
                    }
            });

            // ajax untuk mengambil data account bank
            $.ajax({
                url: "{{ route('get_account_bank_pembelian') }}",
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                    success:function(data){
                        $.each(data, function(key, log){
                            $('#account_bank_id').append('<option value="'+ log.id +'">' + log.nama+ '</option>');
                           });
                    }
            });
    });
</script>
<script type="text/javascript">

    

    

    // function ketika input discount di keyup
    function total_discount_global(){
        var data_discount = document.getElementById("discount_global").value;
        var data_sub_total = document.getElementById("sub_total").value;
        var total_global = document.getElementById("total_global").value;

        var besar_discount = data_sub_total * (data_discount / 100);
        var total_hasil = data_sub_total - besar_discount;

        $('#discount_global_result').val(besar_discount);
        $('.total_global').val(total_hasil);
        $('#sisa_tagihan').val(total_hasil);
    }

    // function untuk menambah row detail pembelian
    function myCreateFunction2() {
        var table = document.getElementById("myTable");
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);
        var cell7 = row.insertCell(6);

        cell1.innerHTML = `
                        <select id='product_selected' class="product_selected form-control" name="product_selected[]">
                            <option value="" disabled selected>-- Pilih Product --</option>
                            
                        </select>
                        
                        `;
                            
        cell2.innerHTML = `<input class="form-control qty_pembelian" value="2" type="text" id="qty_pembelian" name="qty_pembelian[]">`;
        cell3.innerHTML = `<input class="form-control satuan_product" value="" type="text" id="satuan_product" name="satuan_product[]" readonly>`;
        cell4.innerHTML = `<div class="input-group mb-3">
                                <div  class="input-group-prepend">
                                    <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" class="form-control harga_satuan" id="harga_satuan" name="harga_satuan[]" readonly>
                            </div>`;
        cell5.innerHTML = `<input class="form-control discount_per_product" value="0" type="text" id="disk_product" name="discount_per_product[]">
                        <input class="form-control total_discount" value="0" type="text" id="total_discount" name="total_discount[]" readonly>`;
        cell6.innerHTML = `<select class="form-control pajak_per_product" id="pajak_product" name="pajak_per_product[]">
                                <option value="" selected>-- Pilih Pajak --</option>
                               
                            </select>
                            <input class="form-control potongan_pajak" value="" type="text" id="potongan_pajak" name="potongan_pajak[]" readonly>

                        `;
                                        
        cell7.innerHTML = `<div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">RP</span>
                                </div>
                                <input type="text" class="form-control total_per_product" value="0" id="total_per_product" name="total_per_product[]" readonly>
                            </div>`;
        // cell8.innerHTML = `<button type="button" class="btn btn-danger btn-sm btn_delete_row"><i class="fas fa-trash"></i></button>`;


        const prod_select = document.querySelectorAll('.product_selected');
        for (let i = 0; i < prod_select.length; i++) {
            prod_select[i].addEventListener('change', function(){
                var productId = prod_select[i].value;
                var parameter_product = i + 1;
                $.ajax({
                    url: "../../products_id_pembelian"+'/' + productId,
                    type: "GET",
                    data: {"_token":"{{ csrf_token() }}"},
                    success: function(data){
                        $('#myTable tr:nth-child('+parameter_product+') #satuan_product').val(data[0].satuan);
                        $('#myTable tr:nth-child('+parameter_product+') #harga_satuan').val(data[0].harga_satuan);
                        var qty_pembelian = $('#myTable tr:nth-child('+parameter_product+') #qty_pembelian').val();
                        var harga_satuan = $('#myTable tr:nth-child('+parameter_product+') #harga_satuan').val();
                        var total = qty_pembelian * harga_satuan;
                        $('#myTable tr:nth-child('+parameter_product+') #total_per_product').val(total);
                    }
                });
            })
        }


        // qty keyup
        const qty_pen = document.querySelectorAll(".qty_pembelian");
        for (let q = 0; q < qty_pen.length; q++) {
            qty_pen[q].addEventListener('keyup', function(){
                var parameter_qty = q + 1;

                // get data pajak dan discount
                let pajak_value = $('#myTable tr:nth-child('+parameter_qty+') #pajak_product').val()
                let discount_value = $('#myTable tr:nth-child('+parameter_qty+') #disk_product').val()

                const harga_satuan = $('#myTable tr:nth-child('+parameter_qty+') #harga_satuan').val();
                const qty_pembelian = $('#myTable tr:nth-child('+parameter_qty+') #qty_pembelian').val();



                if ((discount_value != 0)  && pajak_value) { //kondisi jika diskon dan pajak ada

                    // hitung discount dulu
                    var total_set_qty = harga_satuan * qty_pembelian;
                    var besar_dist = (total_set_qty * discount_value) / 100;
                    $('#myTable tr:nth-child('+parameter_qty+') #total_discount').val(besar_dist);
                    var jum_sementara = total_set_qty - besar_dist;

                    $('#myTable tr:nth-child('+parameter_qty+') #total_discount').val(besar_dist);

                    // hitung pajak
                    $.ajax({
                        url: "../../pajak_id_pembelian"+'/' + pajak_value,
                        type: "GET",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){
                            var besar_pajak = (total_set_qty * data[0].persentase) / 100;
                            var jum_pajak = jum_sementara + besar_pajak;
                            $('#myTable tr:nth-child('+parameter_qty+') #total_per_product').val(jum_pajak);
                        }
                    });

                } else if(pajak_value){  //kondisi jika pajak ada
                    $.ajax({
                        url: "../../pajak_id_pembelian"+'/' + pajak_value,
                        type: "GET",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){
                            var total_set_qty = harga_satuan * qty_pembelian;
                            var besar_pajak = (total_set_qty * data[0].persentase) / 100;
                            var jum_sementara = total_set_qty + besar_pajak;
                            $('#myTable tr:nth-child('+parameter_qty+') #total_per_product').val(jum_sementara);
                        }
                    });
                } else if (discount_value != 0){ //kondisi jika discount ada
                    console.log('kondisi jika discount ada');
                    var total_set_qty = harga_satuan * qty_pembelian;
                    var besar_dist = (total_set_qty * discount_value) / 100;
                    $('#myTable tr:nth-child('+parameter_qty+') #total_discount').val(besar_dist);
                    var jum_sementara = total_set_qty - besar_dist;
                    $('#myTable tr:nth-child('+parameter_qty+') #total_per_product').val(jum_sementara);
                } else{ //kondisi jika pajak dan discount tidak ada
                    console.log('kondisi jika pajak dan discount tidak ada');
                    var total_set_qty = harga_satuan * qty_pembelian;
                    $('#myTable tr:nth-child('+parameter_qty+') #total_per_product').val(total_set_qty);
                }

                let hasil_total_global = document.querySelectorAll(".total_per_product");
                    var sub_total = 0;
                    for (let i = 0; i < hasil_total_global.length; i++){
                        sub_total += parseInt(hasil_total_global[i].value);
                        var jum_row = parseInt(i); 
                    }
                    $('#hitung_row').val(jum_row);
                    $('#sub_total').val(sub_total);
                    $('.total_global').val(sub_total);
                    $('#sisa_tagihan').val(sub_total);
            })
        }


        // discount keyup
        const dis_per_prod = document.querySelectorAll(".discount_per_product");
        for (let d = 0; d < dis_per_prod.length; d++) {
            dis_per_prod[d].addEventListener('keyup', function(){
                var distId = dis_per_prod[d].value;
                var parameter_dist = (parseInt(d) + 1);

                const harga_satuan = $('#myTable tr:nth-child('+parameter_dist+') #harga_satuan').val();
                const qty_pembelian = $('#myTable tr:nth-child('+parameter_dist+') #qty_pembelian').val();
                const discount_value = $('#myTable tr:nth-child('+parameter_dist+') #disk_product').val();
                let pajaks = $('#myTable tr:nth-child('+parameter_dist+') #pajak_product').val();
                // console.log(pajaks);
                if (!pajaks) {
                    // console.log('ada tidak ada');
                    var besar_dist = ((harga_satuan * qty_pembelian) * discount_value) / 100;
                    var diskon = (harga_satuan * qty_pembelian) - besar_dist;
                    $('#myTable tr:nth-child('+parameter_dist+') #total_discount').val(besar_dist);
                    $('#myTable tr:nth-child('+parameter_dist+') #total_per_product').val(diskon);

                    let hasil_total_global = document.querySelectorAll(".total_per_product");
                    var sub_total = 0;
                    for (let i = 0; i < hasil_total_global.length; i++){
                        sub_total += parseInt(hasil_total_global[i].value);
                        var jum_row = parseInt(i); 
                    }
                        $('#hitung_row').val(jum_row);
                        $('#sub_total').val(sub_total);
                        $('.total_global').val(sub_total);
                        $('#sisa_tagihan').val(sub_total);
                }else{
                    // console.log(pajaks);
                    $.ajax({
                        url: "../../pajak_id_pembelian"+'/' + pajaks,
                        type: "GET",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){
                            var pajaks_potongan = ((harga_satuan * qty_pembelian) * data[0].persentase) / 100;
                            var jum_sementara = (harga_satuan * qty_pembelian) - pajaks_potongan;

                            var besar_dist = ((harga_satuan * qty_pembelian) * discount_value) / 100;
                            var jum_distcount = jum_sementara - besar_dist;

                            $('#myTable tr:nth-child('+parameter_dist+') #total_discount').val(besar_dist);
                            $('#myTable tr:nth-child('+parameter_dist+') #total_per_product').val(jum_distcount);

                            let hasil_total_global = document.querySelectorAll(".total_per_product");
                            var sub_total = 0;
                            for (let i = 0; i < hasil_total_global.length; i++){
                                sub_total += parseInt(hasil_total_global[i].value);
                                var jum_row = parseInt(i); 
                            }
                                $('#hitung_row').val(jum_row);
                                $('#sub_total').val(sub_total);
                                $('.total_global').val(sub_total);
                                $('#sisa_tagihan').val(sub_total);
                        }
                    });
                }
            })
        }
        

        // pajak onchange
        const paj_select = document.querySelectorAll('.pajak_per_product');
        for (let p = 0; p < paj_select.length; p++) {
            paj_select[p].addEventListener('change', function(){
                var pajakId = paj_select[p].value;
                // console.log(pajakId);
                var parameter_pajak = p + 1;

                if (!pajakId) {
                    let qty_pembelian = $('#myTable tr:nth-child('+parameter_pajak+') #qty_pembelian').val();
                        let harga_satuan = $('#myTable tr:nth-child('+parameter_pajak+') #harga_satuan').val();
                        let discount = $('#myTable tr:nth-child('+parameter_pajak+') #disk_product').val();

                        if (discount = 0) {
                            let potongan_pajaks = ((qty_pembelian * harga_satuan) * 0) / 100;
                            $('#myTable tr:nth-child('+parameter_pajak+') #potongan_pajak').val(potongan_pajaks);
                            let hasil_setelah_dipotong = (qty_pembelian * harga_satuan) + potongan_pajaks;
                            $('#myTable tr:nth-child('+parameter_pajak+') #total_per_product').val(hasil_setelah_dipotong);
                        }else{
                            let discount_value = $('#myTable tr:nth-child('+parameter_pajak+') #disk_product').val();
                            let besar_dist = ((harga_satuan * qty_pembelian) * (discount_value) / 100);
                            $('#myTable tr:nth-child('+parameter_pajak+') #total_discount').val(besar_dist);
                            let tot_set_diskon = (harga_satuan * qty_pembelian) - besar_dist;
                            let potongan_pajaks = (tot_set_diskon * 0) / 100;
                            $('#myTable tr:nth-child('+parameter_pajak+') #potongan_pajak').val(potongan_pajaks);
                            let hasil_setelah_dipotong = tot_set_diskon + potongan_pajaks;
                            $('#myTable tr:nth-child('+parameter_pajak+') #total_per_product').val(hasil_setelah_dipotong);
                        }


                        let hasil_total_global = document.querySelectorAll(".total_per_product");
                        var sub_total = 0;
                        for (let i = 0; i < hasil_total_global.length; i++){
                            sub_total += parseInt(hasil_total_global[i].value);
                            var jum_row = parseInt(i); 
                        }
                            $('#hitung_row').val(jum_row);
                            $('#sub_total').val(sub_total);
                            $('.total_global').val(sub_total);
                            $('#sisa_tagihan').val(sub_total);
                } else{
                    $.ajax({
                        url: "../../pajak_id_pembelian"+'/' + pajakId,
                        type: "GET",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){
                            let qty_pembelian = $('#myTable tr:nth-child('+parameter_pajak+') #qty_pembelian').val();
                            let harga_satuan = $('#myTable tr:nth-child('+parameter_pajak+') #harga_satuan').val();
                            let discount = $('#myTable tr:nth-child('+parameter_pajak+') #disk_product').val();

                            if (discount = 0) {
                                let potongan_pajaks = ((qty_pembelian * harga_satuan) * data[0].persentase) / 100;
                                $('#myTable tr:nth-child('+parameter_pajak+') #potongan_pajak').val(potongan_pajaks);
                                let hasil_setelah_dipotong = (qty_pembelian * harga_satuan) + potongan_pajaks;
                                $('#myTable tr:nth-child('+parameter_pajak+') #total_per_product').val(hasil_setelah_dipotong);
                            }else{
                                let discount_value = $('#myTable tr:nth-child('+parameter_pajak+') #disk_product').val();
                                let besar_dist = ((harga_satuan * qty_pembelian) * (discount_value) / 100);
                                $('#myTable tr:nth-child('+parameter_pajak+') #total_discount').val(besar_dist);
                                let tot_set_diskon = (harga_satuan * qty_pembelian) - besar_dist;
                                let potongan_pajaks = ((harga_satuan * qty_pembelian) * data[0].persentase) / 100;
                                $('#myTable tr:nth-child('+parameter_pajak+') #potongan_pajak').val(potongan_pajaks);
                                let hasil_setelah_dipotong = tot_set_diskon + potongan_pajaks;
                                $('#myTable tr:nth-child('+parameter_pajak+') #total_per_product').val(hasil_setelah_dipotong);
                            }



                            let hasil_total_global = document.querySelectorAll(".total_per_product");
                            var sub_total = 0;
                            for (let i = 0; i < hasil_total_global.length; i++){
                                sub_total += parseInt(hasil_total_global[i].value);
                                var jum_row = parseInt(i); 
                            }
                                $('#hitung_row').val(jum_row);
                                $('#sub_total').val(sub_total);
                                $('.total_global').val(sub_total);
                                $('#sisa_tagihan').val(sub_total);
                        }
                    });
                }

                
            })
        }

        let hasil_total_global = document.querySelectorAll(".total_per_product");
        for (let i = 0; i < hasil_total_global.length; i++){
            var jum_row = parseInt(i); 
        }
        $('#hitung_row').val(jum_row);
    }
    

    function myCreateFunction() {
        var table = document.getElementById("myTable");
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var cell6 = row.insertCell(5);
        var cell7 = row.insertCell(6);
        // var cell8 = row.insertCell(7);
        var callProduct = get_data_product();
        var callPajak = get_data_pajak();

        cell1.innerHTML = `
                        <select id='product_selected' class="product_selected form-control" name="product_selected[]">
                            <option value="" disabled selected>-- Pilih Product --</option>
                            
                        </select>
                        
                        `;
                            
        cell2.innerHTML = `<input class="form-control qty_pembelian" value="2" type="text" id="qty_pembelian" name="qty_pembelian[]">`;
        cell3.innerHTML = `<input class="form-control satuan_product" value="" type="text" id="satuan_product" name="satuan_product[]" readonly>`;
        cell4.innerHTML = `<div class="input-group mb-3">
                                <div  class="input-group-prepend">
                                    <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" class="form-control harga_satuan" id="harga_satuan" name="harga_satuan[]" readonly>
                            </div>`;
        cell5.innerHTML = `<input class="form-control discount_per_product" value="0" type="text" id="disk_product" name="discount_per_product[]">
                        <input class="form-control total_discount" value="0" type="text" id="total_discount" name="total_discount[]" readonly>`;
        cell6.innerHTML = `<select class="form-control pajak_per_product" id="pajak_product" name="pajak_per_product[]">
                                <option value="" selected>-- Pilih Pajak --</option>
                               
                            </select>
                            <input class="form-control potongan_pajak" value="" type="text" id="potongan_pajak" name="potongan_pajak[]" readonly>

                        `;
                                        
        cell7.innerHTML = `<div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">RP</span>
                                </div>
                                <input type="text" class="form-control total_per_product" value="0" id="total_per_product" name="total_per_product[]" readonly>
                            </div>`;
        // cell8.innerHTML = `<button type="button" class="btn btn-danger btn-sm btn_delete_row"><i class="fas fa-trash"></i></button>`;


        const prod_select = document.querySelectorAll('.product_selected');
        for (let i = 0; i < prod_select.length; i++) {
            prod_select[i].addEventListener('change', function(){
                var productId = prod_select[i].value;
                var parameter_product = i + 1;
                $.ajax({
                    url: "../../products_id_pembelian"+'/' + productId,
                    type: "GET",
                    data: {"_token":"{{ csrf_token() }}"},
                    success: function(data){
                        $('#myTable tr:nth-child('+parameter_product+') #satuan_product').val(data[0].satuan);
                        $('#myTable tr:nth-child('+parameter_product+') #harga_satuan').val(data[0].harga_satuan);
                        var qty_pembelian = $('#myTable tr:nth-child('+parameter_product+') #qty_pembelian').val();
                        var harga_satuan = $('#myTable tr:nth-child('+parameter_product+') #harga_satuan').val();
                        var total = qty_pembelian * harga_satuan;
                        $('#myTable tr:nth-child('+parameter_product+') #total_per_product').val(total);
                    }
                });
            })
        }


        // qty keyup
        const qty_pen = document.querySelectorAll(".qty_pembelian");
        for (let q = 0; q < qty_pen.length; q++) {
            qty_pen[q].addEventListener('keyup', function(){
                var parameter_qty = q + 1;

                // get data pajak dan discount
                let pajak_value = $('#myTable tr:nth-child('+parameter_qty+') #pajak_product').val()
                let discount_value = $('#myTable tr:nth-child('+parameter_qty+') #disk_product').val()

                const harga_satuan = $('#myTable tr:nth-child('+parameter_qty+') #harga_satuan').val();
                const qty_pembelian = $('#myTable tr:nth-child('+parameter_qty+') #qty_pembelian').val();



                if ((discount_value != 0)  && pajak_value) { //kondisi jika diskon dan pajak ada

                    // hitung discount dulu
                    var total_set_qty = harga_satuan * qty_pembelian;
                    var besar_dist = (total_set_qty * discount_value) / 100;
                    $('#myTable tr:nth-child('+parameter_qty+') #total_discount').val(besar_dist);
                    var jum_sementara = total_set_qty - besar_dist;

                    $('#myTable tr:nth-child('+parameter_qty+') #total_discount').val(besar_dist);

                    // hitung pajak
                    $.ajax({
                        url: "../../pajak_id_pembelian"+'/' + pajak_value,
                        type: "GET",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){
                            var besar_pajak = (total_set_qty * data[0].persentase) / 100;
                            var jum_pajak = jum_sementara + besar_pajak;
                            $('#myTable tr:nth-child('+parameter_qty+') #total_per_product').val(jum_pajak);
                        }
                    });

                } else if(pajak_value){  //kondisi jika pajak ada
                    $.ajax({
                        url: "../../pajak_id_pembelian"+'/' + pajak_value,
                        type: "GET",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){
                            var total_set_qty = harga_satuan * qty_pembelian;
                            var besar_pajak = (total_set_qty * data[0].persentase) / 100;
                            var jum_sementara = total_set_qty + besar_pajak;
                            $('#myTable tr:nth-child('+parameter_qty+') #total_per_product').val(jum_sementara);
                        }
                    });
                } else if (discount_value != 0){ //kondisi jika discount ada
                    console.log('kondisi jika discount ada');
                    var total_set_qty = harga_satuan * qty_pembelian;
                    var besar_dist = (total_set_qty * discount_value) / 100;
                    $('#myTable tr:nth-child('+parameter_qty+') #total_discount').val(besar_dist);
                    var jum_sementara = total_set_qty - besar_dist;
                    $('#myTable tr:nth-child('+parameter_qty+') #total_per_product').val(jum_sementara);
                } else{ //kondisi jika pajak dan discount tidak ada
                    console.log('kondisi jika pajak dan discount tidak ada');
                    var total_set_qty = harga_satuan * qty_pembelian;
                    $('#myTable tr:nth-child('+parameter_qty+') #total_per_product').val(total_set_qty);
                }

                let hasil_total_global = document.querySelectorAll(".total_per_product");
                    var sub_total = 0;
                    for (let i = 0; i < hasil_total_global.length; i++){
                        sub_total += parseInt(hasil_total_global[i].value);
                        var jum_row = parseInt(i); 
                    }
                    $('#hitung_row').val(jum_row);
                    $('#sub_total').val(sub_total);
                    $('.total_global').val(sub_total);
                    $('#sisa_tagihan').val(sub_total);
            })
        }


        // discount keyup
        const dis_per_prod = document.querySelectorAll(".discount_per_product");
        for (let d = 0; d < dis_per_prod.length; d++) {
            dis_per_prod[d].addEventListener('keyup', function(){
                var distId = dis_per_prod[d].value;
                var parameter_dist = (parseInt(d) + 1);

                const harga_satuan = $('#myTable tr:nth-child('+parameter_dist+') #harga_satuan').val();
                const qty_pembelian = $('#myTable tr:nth-child('+parameter_dist+') #qty_pembelian').val();
                const discount_value = $('#myTable tr:nth-child('+parameter_dist+') #disk_product').val();
                let pajaks = $('#myTable tr:nth-child('+parameter_dist+') #pajak_product').val();
                // console.log(pajaks);
                if (!pajaks) {
                    // console.log('ada tidak ada');
                    var besar_dist = ((harga_satuan * qty_pembelian) * discount_value) / 100;
                    var diskon = (harga_satuan * qty_pembelian) - besar_dist;
                    $('#myTable tr:nth-child('+parameter_dist+') #total_discount').val(besar_dist);
                    $('#myTable tr:nth-child('+parameter_dist+') #total_per_product').val(diskon);

                    let hasil_total_global = document.querySelectorAll(".total_per_product");
                    var sub_total = 0;
                    for (let i = 0; i < hasil_total_global.length; i++){
                        sub_total += parseInt(hasil_total_global[i].value);
                        var jum_row = parseInt(i); 
                    }
                        $('#hitung_row').val(jum_row);
                        $('#sub_total').val(sub_total);
                        $('.total_global').val(sub_total);
                        $('#sisa_tagihan').val(sub_total);
                }else{
                    // console.log(pajaks);
                    $.ajax({
                        url: "../../pajak_id_pembelian"+'/' + pajaks,
                        type: "GET",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){
                            var pajaks_potongan = ((harga_satuan * qty_pembelian) * data[0].persentase) / 100;
                            var jum_sementara = (harga_satuan * qty_pembelian) - pajaks_potongan;

                            var besar_dist = ((harga_satuan * qty_pembelian) * discount_value) / 100;
                            var jum_distcount = jum_sementara - besar_dist;

                            $('#myTable tr:nth-child('+parameter_dist+') #total_discount').val(besar_dist);
                            $('#myTable tr:nth-child('+parameter_dist+') #total_per_product').val(jum_distcount);

                            let hasil_total_global = document.querySelectorAll(".total_per_product");
                            var sub_total = 0;
                            for (let i = 0; i < hasil_total_global.length; i++){
                                sub_total += parseInt(hasil_total_global[i].value);
                                var jum_row = parseInt(i); 
                            }
                                $('#hitung_row').val(jum_row);
                                $('#sub_total').val(sub_total);
                                $('.total_global').val(sub_total);
                                $('#sisa_tagihan').val(sub_total);
                        }
                    });
                }
            })
        }
        

        // pajak onchange
        const paj_select = document.querySelectorAll('.pajak_per_product');
        for (let p = 0; p < paj_select.length; p++) {
            paj_select[p].addEventListener('change', function(){
                var pajakId = paj_select[p].value;
                // console.log(pajakId);
                var parameter_pajak = p + 1;

                if (!pajakId) {
                    let qty_pembelian = $('#myTable tr:nth-child('+parameter_pajak+') #qty_pembelian').val();
                        let harga_satuan = $('#myTable tr:nth-child('+parameter_pajak+') #harga_satuan').val();
                        let discount = $('#myTable tr:nth-child('+parameter_pajak+') #disk_product').val();

                        if (discount = 0) {
                            let potongan_pajaks = ((qty_pembelian * harga_satuan) * 0) / 100;
                            $('#myTable tr:nth-child('+parameter_pajak+') #potongan_pajak').val(potongan_pajaks);
                            let hasil_setelah_dipotong = (qty_pembelian * harga_satuan) + potongan_pajaks;
                            $('#myTable tr:nth-child('+parameter_pajak+') #total_per_product').val(hasil_setelah_dipotong);
                        }else{
                            let discount_value = $('#myTable tr:nth-child('+parameter_pajak+') #disk_product').val();
                            let besar_dist = ((harga_satuan * qty_pembelian) * (discount_value) / 100);
                            $('#myTable tr:nth-child('+parameter_pajak+') #total_discount').val(besar_dist);
                            let tot_set_diskon = (harga_satuan * qty_pembelian) - besar_dist;
                            let potongan_pajaks = (tot_set_diskon * 0) / 100;
                            $('#myTable tr:nth-child('+parameter_pajak+') #potongan_pajak').val(potongan_pajaks);
                            let hasil_setelah_dipotong = tot_set_diskon + potongan_pajaks;
                            $('#myTable tr:nth-child('+parameter_pajak+') #total_per_product').val(hasil_setelah_dipotong);
                        }


                        let hasil_total_global = document.querySelectorAll(".total_per_product");
                        var sub_total = 0;
                        for (let i = 0; i < hasil_total_global.length; i++){
                            sub_total += parseInt(hasil_total_global[i].value);
                            var jum_row = parseInt(i); 
                        }
                            $('#hitung_row').val(jum_row);
                            $('#sub_total').val(sub_total);
                            $('.total_global').val(sub_total);
                            $('#sisa_tagihan').val(sub_total);
                } else{
                    $.ajax({
                        url: "../../pajak_id_pembelian"+'/' + pajakId,
                        type: "GET",
                        data: {"_token":"{{ csrf_token() }}"},
                        success: function(data){
                            let qty_pembelian = $('#myTable tr:nth-child('+parameter_pajak+') #qty_pembelian').val();
                            let harga_satuan = $('#myTable tr:nth-child('+parameter_pajak+') #harga_satuan').val();
                            let discount = $('#myTable tr:nth-child('+parameter_pajak+') #disk_product').val();

                            if (discount = 0) {
                                let potongan_pajaks = ((qty_pembelian * harga_satuan) * data[0].persentase) / 100;
                                $('#myTable tr:nth-child('+parameter_pajak+') #potongan_pajak').val(potongan_pajaks);
                                let hasil_setelah_dipotong = (qty_pembelian * harga_satuan) + potongan_pajaks;
                                $('#myTable tr:nth-child('+parameter_pajak+') #total_per_product').val(hasil_setelah_dipotong);
                            }else{
                                let discount_value = $('#myTable tr:nth-child('+parameter_pajak+') #disk_product').val();
                                let besar_dist = ((harga_satuan * qty_pembelian) * (discount_value) / 100);
                                $('#myTable tr:nth-child('+parameter_pajak+') #total_discount').val(besar_dist);
                                let tot_set_diskon = (harga_satuan * qty_pembelian) - besar_dist;
                                let potongan_pajaks = ((harga_satuan * qty_pembelian) * data[0].persentase) / 100;
                                $('#myTable tr:nth-child('+parameter_pajak+') #potongan_pajak').val(potongan_pajaks);
                                let hasil_setelah_dipotong = tot_set_diskon + potongan_pajaks;
                                $('#myTable tr:nth-child('+parameter_pajak+') #total_per_product').val(hasil_setelah_dipotong);
                            }



                            let hasil_total_global = document.querySelectorAll(".total_per_product");
                            var sub_total = 0;
                            for (let i = 0; i < hasil_total_global.length; i++){
                                sub_total += parseInt(hasil_total_global[i].value);
                                var jum_row = parseInt(i); 
                            }
                                $('#hitung_row').val(jum_row);
                                $('#sub_total').val(sub_total);
                                $('.total_global').val(sub_total);
                                $('#sisa_tagihan').val(sub_total);
                        }
                    });
                }

                
            })
        }

        let hasil_total_global = document.querySelectorAll(".total_per_product");
        for (let i = 0; i < hasil_total_global.length; i++){
            var jum_row = parseInt(i); 
        }
        $('#hitung_row').val(jum_row);
    }









    // function untuk mengambil data product
    function get_data_product(){
        $.ajax({
                url: "{{ route('get_product_pembelian') }}",
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                success: function(data){
                    $.each(data, function(key, log){
                        var product = '<option value="'+ log.id +'" class="'+ log.id +'">' + log.nama_product+ '</option>';

                        $('.product_selected').last().append(product);
                    })
                }
            })
    }
    // var product;

    // ajax untuk mengambil data pajak kemudian ditempeml di select input
    function get_data_pajak(){
        $.ajax({
                url: "{{ route('get_pajak_ajax_pembelian') }}",
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                success: function(data){
                    $.each(data, function(key, log){
                        var pajak = '<option value="'+ log.id +'">' + log.nama_pajak+ '</option>';
                        $('.pajak_per_product').last().append(pajak);
                    })
                }
            })
    }

    // function untuk delete row detail pembelian
    function myDeleteFunction() {
        document.getElementById("myTable").deleteRow(-1);

        let hasil_total_global = document.querySelectorAll(".total_per_product");
        var sub_total = 0;
        for (let i = 0; i < hasil_total_global.length; i++){
            sub_total += parseInt(hasil_total_global[i].value);
            var jum_row = parseInt(i); 
        }
        $('#hitung_row').val(jum_row);
        $('#sub_total').val(sub_total);
        $('.total_global').val(sub_total);
        $('#sisa_tagihan').val(sub_total);
    }

</script>



{{-- script rab --}}
<script>
    // delete function
    // function untuk delete row detail pembelian
    function myDeleteFunctionRAB() {
        document.getElementById("myTableRAB").deleteRow(-1);

        let hasil_total_global_rab = document.querySelectorAll(".total_budget");
        var sub_total_rab = 0;
        for (let i = 0; i < hasil_total_global_rab.length; i++){
            sub_total_rab += parseInt(hasil_total_global_rab[i].value);
            var jum_row = parseInt(i); 
        }
        $('#hitung_row').val(jum_row);
        $('#sub_total').val(sub_total_rab);
        $('.total_global').val(sub_total_rab);
        $('#sisa_tagihan').val(sub_total_rab);
    }

    // function untuk menambah row detail pembelian
    function myCreateFunctionRAB() {
        var table = document.getElementById("myTableRAB");
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        var callProduct = get_data_pengajuan();

        cell1.innerHTML = `
                        <select id='pengajuan_selected' class="pengajuan_selected form-control" name="pengajuan_selected[]">
                            <option value="" disabled selected>-- Pilih Pengajuan --</option>
                            
                        </select>
                        
                        `;
                            
        cell2.innerHTML = `<input class="form-control vendor" value="" type="text" id="vendor" name="vendor[]" readonly>`;
        cell3.innerHTML = `<input class="form-control item_approved" value="2" type="text" id="item_approved" name="item_approved[]" readonly>`;
        cell4.innerHTML = `<div class="input-group mb-3">
                                <div  class="input-group-prepend">
                                    <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" class="form-control budget" id="budget" name="budget[]" readonly>
                            </div>`;
        cell5.innerHTML = `<div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">RP</span>
                                </div>
                                <input type="text" class="form-control total_budget" value="0" id="total_budget" name="total_budget[]" readonly>
                            </div>`;
        // cell8.innerHTML = `<button type="button" class="btn btn-danger btn-sm btn_delete_row"><i class="fas fa-trash"></i></button>`;


        const pengajuan_select = document.querySelectorAll('.pengajuan_selected');
        for (let i = 0; i < pengajuan_select.length; i++) {
            pengajuan_select[i].addEventListener('change', function(){
                var pengajuanId = pengajuan_select[i].value;
                var parameter_pengajuan = i + 1;
                $.ajax({
                    url: "../../pengajuan_id_pembelian"+'/' + pengajuanId,
                    type: "GET",
                    data: {"_token":"{{ csrf_token() }}"},
                    success: function(data){
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #vendor').val(data[0].vendor);
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #item_approved').val(data[0].jumlah_item_approved);
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #budget').val(data[0].budget);
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #total_budget').val(data[0].budget_approved);
                        
                        let hasil_total_global = document.querySelectorAll(".total_budget");
                        var sub_total = 0;
                        for (let i = 0; i < hasil_total_global.length; i++){
                            sub_total += parseInt(hasil_total_global[i].value);
                            var jum_row = parseInt(i); 
                        }
                        $('#hitung_row').val(jum_row);
                        $('#sub_total').val(sub_total);
                        $('.total_global').val(sub_total);
                        $('#sisa_tagihan').val(sub_total);
                    }
                });
            })
        }


        // for (let i = 0; i < hasil_total_global.length; i++){
        //     var jum_row = parseInt(i); 
        // }
        // $('#hitung_row').val(jum_row);
    }

    const pengajuan_select = document.querySelectorAll('.pengajuan_selected');
        for (let i = 0; i < pengajuan_select.length; i++) {
            pengajuan_select[i].addEventListener('change', function(){
                var pengajuanId = pengajuan_select[i].value;
                var parameter_pengajuan = i + 1;
                $.ajax({
                    url: "../../pengajuan_id_pembelian"+'/' + pengajuanId,
                    type: "GET",
                    data: {"_token":"{{ csrf_token() }}"},
                    success: function(data){
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #vendor').val(data[0].vendor);
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #item_approved').val(data[0].jumlah_item_approved);
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #budget').val(data[0].budget);
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #total_budget').val(data[0].budget_approved);
                        
                        let hasil_total_global = document.querySelectorAll(".total_budget");
                        var sub_total = 0;
                        for (let i = 0; i < hasil_total_global.length; i++){
                            sub_total += parseInt(hasil_total_global[i].value);
                            var jum_row = parseInt(i); 
                        }
                        $('#hitung_row').val(jum_row);
                        $('#sub_total').val(sub_total);
                        $('.total_global').val(sub_total);
                        $('#sisa_tagihan').val(sub_total);
                    }
                });
            })
        }


    // function untuk mengambil data pengajuan
    function get_data_pengajuan(){
        $.ajax({
                url: "{{ route('get_pengajuan_pembelian') }}",
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                success: function(data){
                    $.each(data, function(key, log){
                        var pengajuan = '<option value="'+ log.id +'" class="'+ log.id +'">' + log.item+ '</option>';

                        $('.pengajuan_selected').last().append(pengajuan);
                    })
                }
            })
    }

</script>



{{-- script rab --}}
<script>
    // delete function
    // function untuk delete row detail pembelian
    function myDeleteFunctionRAB2() {
        document.getElementById("myTableRAB").deleteRow(-1);

        let hasil_total_global_rab = document.querySelectorAll(".total_budget");
        var sub_total_rab = 0;
        for (let i = 0; i < hasil_total_global_rab.length; i++){
            sub_total_rab += parseInt(hasil_total_global_rab[i].value);
            var jum_row = parseInt(i); 
        }
        $('#hitung_row').val(jum_row);
        $('#sub_total').val(sub_total_rab);
        $('.total_global').val(sub_total_rab);
        $('#sisa_tagihan').val(sub_total_rab);
    }

    // function untuk menambah row detail pembelian
    function myCreateFunctionRAB2() {
        var table = document.getElementById("myTableRAB");
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);

        cell1.innerHTML = `
                        <select id='pengajuan_selected' class="pengajuan_selected form-control" name="pengajuan_selected[]">
                            <option value="" disabled selected>-- Pilih Pengajuan --</option>
                            
                        </select>
                        
                        `;
                            
        cell2.innerHTML = `<input class="form-control vendor" value="" type="text" id="vendor" name="vendor[]" readonly>`;
        cell3.innerHTML = `<input class="form-control item_approved" value="2" type="text" id="item_approved" name="item_approved[]" readonly>`;
        cell4.innerHTML = `<div class="input-group mb-3">
                                <div  class="input-group-prepend">
                                    <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" class="form-control budget" id="budget" name="budget[]" readonly>
                            </div>`;
        cell5.innerHTML = `<div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">RP</span>
                                </div>
                                <input type="text" class="form-control total_budget" value="0" id="total_budget" name="total_budget[]" readonly>
                            </div>`;
        // cell8.innerHTML = `<button type="button" class="btn btn-danger btn-sm btn_delete_row"><i class="fas fa-trash"></i></button>`;


        const pengajuan_select = document.querySelectorAll('.pengajuan_selected');
        for (let i = 0; i < pengajuan_select.length; i++) {
            pengajuan_select[i].addEventListener('change', function(){
                var pengajuanId = pengajuan_select[i].value;
                var parameter_pengajuan = i + 1;
                $.ajax({
                    url: "../../pengajuan_id_pembelian"+'/' + pengajuanId,
                    type: "GET",
                    data: {"_token":"{{ csrf_token() }}"},
                    success: function(data){
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #vendor').val(data[0].vendor);
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #item_approved').val(data[0].jumlah_item_approved);
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #budget').val(data[0].budget);
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #total_budget').val(data[0].budget_approved);
                        
                        let hasil_total_global = document.querySelectorAll(".total_budget");
                        var sub_total = 0;
                        for (let i = 0; i < hasil_total_global.length; i++){
                            sub_total += parseInt(hasil_total_global[i].value);
                            var jum_row = parseInt(i); 
                        }
                        $('#hitung_row').val(jum_row);
                        $('#sub_total').val(sub_total);
                        $('.total_global').val(sub_total);
                        $('#sisa_tagihan').val(sub_total);
                    }
                });
            })
        }


        // for (let i = 0; i < hasil_total_global.length; i++){
        //     var jum_row = parseInt(i); 
        // }
        // $('#hitung_row').val(jum_row);
    }

    const pengajuan_select = document.querySelectorAll('.pengajuan_selected');
        for (let i = 0; i < pengajuan_select.length; i++) {
            pengajuan_select[i].addEventListener('change', function(){
                var pengajuanId = pengajuan_select[i].value;
                var parameter_pengajuan = i + 1;
                $.ajax({
                    url: "../../pengajuan_id_pembelian"+'/' + pengajuanId,
                    type: "GET",
                    data: {"_token":"{{ csrf_token() }}"},
                    success: function(data){
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #vendor').val(data[0].vendor);
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #item_approved').val(data[0].jumlah_item_approved);
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #budget').val(data[0].budget);
                        $('#myTableRAB tr:nth-child('+parameter_pengajuan+') #total_budget').val(data[0].budget_approved);
                        
                        let hasil_total_global = document.querySelectorAll(".total_budget");
                        var sub_total = 0;
                        for (let i = 0; i < hasil_total_global.length; i++){
                            sub_total += parseInt(hasil_total_global[i].value);
                            var jum_row = parseInt(i); 
                        }
                        $('#hitung_row').val(jum_row);
                        $('#sub_total').val(sub_total);
                        $('.total_global').val(sub_total);
                        $('#sisa_tagihan').val(sub_total);
                    }
                });
            })
        }

</script>

@endpush
