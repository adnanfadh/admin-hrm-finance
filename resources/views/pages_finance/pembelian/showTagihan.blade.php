@extends('layouts.app_finance')

@push('addon-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
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
                    <li class="breadcrumb-item " aria-current="page">Penagihan</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box shadow-sm bg-white pr-5 pl-5 pb-1 pt-3 rounded">
                <div class="row">
                    <div class="col-md-12">
                        <div aria-current="page">
                            <h4>Penagihan</h4>
                        </div>
                    </div>
                </div>
                <hr class="mt-0 mb-1 bg-secondary">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div aria-current="page">
                            <p>catat penagihan transaksi biaya.....</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2 justify-content-center">
        <div class="col-md-12">
            <div class="box bg-white p-5 shadow-sm rounded">
                <form action="{{ url('fnc/bayar_cicilan_pembelian') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="box bg-light p-5 mt-5 rounded" id="box-show-pembelian">
                        <div class="row">
                        <div class="col-md-6 col-12 order-sm-2 order-lg-1">
                            <table width="100%">
                                <tr class="font-size-h6-sm font-weight-bolder">
                                    <td width="30%">No Transaksi</td>
                                    <td width="5%">:</td>
                                    <td width="65%"><input type="text" value="{{ $data->no_transaksi }}" id="isi_no_transaksi" class="form-control bg-transparent border-0 font-weight-bolder" readonly></td>
                                </tr>
                                <tr class="font-size-h6-sm font-weight-bolder">
                                    <td width="30%">Tgl. Transaksi</td>
                                    <td width="5%">:</td>
                                    <td width="65%"><input type="text" id="isi_tgl_transaksi" value="{{ date('d F Y', strtotime($data->tanggal_transaksi)) }}" class="form-control bg-transparent border-0 font-weight-bolder" readonly></td>
                                </tr>
                                    <tr class="font-size-h6-sm font-weight-bolder">
                                        <td width="30%">Penerima</td>
                                        <td width="5%">:</td>
                                        <td width="65%"><input type="text" id="isi_pegawai" value="{{ $data->supplier->nama_supplier }}" class="form-control bg-transparent border-0 font-weight-bolder" readonly></td>
                                    </tr>
                                <tr class="font-size-h6-sm font-weight-bolder">
                                    <td width="30%">Metode Pembayaran</td>
                                    <td width="5%">:</td>
                                    <td width="65%"><input type="text" id="isi_metode" value="{{ $data->metode_pembayaran->nama_metode ?? '-' }}" class="form-control bg-transparent border-0 font-weight-bolder" readonly></td>
                                </tr>
                                @if ($data->bayar_nanti !== NULL)
                                    <tr class="font-size-h6-sm font-weight-bolder">
                                        <td width="30%">Syarat Pembayaran</td>
                                        <td width="5%">:</td>
                                        <td width="65%"><input type="text" id="isi_syarat" value="{{ $data->syarat_pembayaran->nama_syarat }}" class="form-control bg-transparent border-0 font-weight-bolder" readonly></td>
                                    </tr>
                                @endif
                                <tr class="font-size-h6-sm font-weight-bolder">
                                    <td width="30%">Total Pembelian</td>
                                    <td width="5%">:</td>
                                    <td width="65%"><input type="text" id="isi_total_pembelian" value="{{  "Rp. ".number_format($data->total,2,',','.'); }}" class="form-control bg-transparent border-0 font-weight-bolder" readonly></td>
                                </tr>
                                <tr class="font-size-h6-sm font-weight-bolder"> 
                                    <td width="20%">Sisa Tagihan</td>
                                    <td width="5%">:</td>
                                    <td width="65%"><input type="text" id="isi_sisa_tagihan" value="{{ "Rp. ".number_format($data->sisa_tagihan,2,',','.'); }}" name="sisa_tagihan" class="form-control bg-transparent border-0 font-weight-bolder" readonly></td>
                                </tr>
                            </table>
                            <td width="65%"><input type="text" id="isi_sisa_tagihan" value="{{ $data->sisa_tagihan }}" name="sisa_tagihan2" class="form-control bg-transparent border-0 font-weight-bolder" readonly></td>
                        </div>
                        <div class="col-md-6 col-12 order-sm-1 order-lg-2">
                            <div class="box bg-white rounded p-5 font-size-h4-sm font-weight-bolder text-center">
                                <label for="" class="label-control" class="col-md-12 font-weight-bolder font-size-h3-sm">Nominal Bayar:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">RP.</span>
                                    </div>
                                    <input type="text" id="nominal_pembayaran" name="nominal_pembayaran" class="form-control bg-warning-o-40 border-0 font-weight-bolder font-size-h3-sm @error('nominal_pembayaran') is-invalid @enderror">
                                    <br>
                                </div>
                                @error('nominal_pembayaran')
                                    <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mt-5">
                                <label for="tanggal_bayar" class="col-md-12 text-center font-weight-bolder">Account Pembayaran:</label>
                                <select name="account_pembayar" id="account_pembayar" class="custom-select @error('account_pembayar') is-invalid @enderror">
                                    @foreach ($bank as $b)
                                        <option value="{{ $b->id }}">({{ $b->nomor }}) {{ $b->nama }} ({{ $b->category_account->nama_category_account }})</option>
                                    @endforeach
                                </select>
                                @error('account_pembayar')
                                    <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mt-5">
                                <label for="tanggal_bayar" class="col-md-12 text-center font-weight-bolder">Tanggal Pembayaran:</label>
                                <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control @error('tanggal_bayar') is-invalid @enderror" value="{{ old('tanggal_bayar') }}">
                                @error('tanggal_bayar')
                                    <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mt-5">
                                <label for="keterangan" class="col-md-12 text-center font-weight-bolder">Keterangan:</label>
                                <textarea name="keterangan" id="keterangan" cols="30" rows="3" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                                <input type="hidden" name="id_pembelian" id="" value="{{ $data->id }}">
                                @error('keterangan')
                                    <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mt-5">
                                <input type="submit" value="Submit" class="btn btn-lg btn-primary btn-block">
                            </div>
                        </div>
                    </div>
                    </div>
                </form>
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
{{-- <script src="/assets/vendor/autoNumeric/autoNumeric.min.js"></script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#pembelian_id').selectize({
            sortField: 'text'
        });
    });
</script>

@endpush