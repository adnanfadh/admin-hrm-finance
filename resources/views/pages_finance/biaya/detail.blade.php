@extends('layouts.app_finance')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Page Heading -->
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb shadow-sm bg-white p-5">
                    <li class="breadcrumb-item"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('biaya.index') }}" style="text-decoration: none"> Biaya</a></li>
                    <li class="breadcrumb-item " aria-current="page">Detail Biaya</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            @if ($message = Session::get('success'))
              <script>
                  Swal.fire({
                      type: 'success',
                      title: 'Success...',
                      text: '{{ $message }}'
                  });
              </script>
            @endif
            @if ($message = Session::get('error'))
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
        <div class="row">
            <div class="col-md-12">
                <div class="box rounded-top bg-white p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="title-transaction text-sm-left text-center">
                                <h4 class="text-dark-50">Transaksi</h4>
                                <h2 class="text-primary">{{ $data->transaksi }} #{{ $data->no_biaya }}</h2>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="keterangan-transaksi text-sm-right text-center">
                                @php
                                    if ($data->status == 1) {
                                        echo '<h1 class="text-warning mt-5"><u>Belum Dibayar</u></h1>';
                                    }else{
                                        echo '<h1 class="text-success mt-5"><u>Sudah Dibayar</u></h1>';
                                    }
                                @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box bg-primary-o-45 d-flex flex-row" style="border-top: 2px solid rgb(41, 127, 255)">
                        <div class="col-md-4">
                            @if ($data->bayar_nanti == NULL)
                                <table class="table">
                                    <tr>
                                        <td>
                                            <h5 class="mr-5 font-weight-bolder">Bayar Dari</h5>
                                        </td>
                                        <td>
                                            <h6 class="text-primary">{{$data->account_bank->nama}}</h6>
                                        </td>
                                    </tr>
                                </table>
                            @else
                            <div class="text-header d-flex flex-row p-3">
                                <input type="checkbox" name="bayar_nanti" id="bayar_nanti" class="form-check-input position-static" checked disabled>
                                <label for="bayar_nanti" class="font-weight-bolder ml-2 font-size-h6"> {{$data->bayar_nanti}}</label>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-8 p-3 text-sm-right text-left">
                            <h2>Total Amount <span class="font-weight-bolder text-primary">{{ "Rp. ".number_format($data->total,2,',','.'); }}</span></h2>
                            <a type="button" class="btn text-primary" data-toggle="modal" data-target="#exampleModal">
                                lihat jurnal entry
                            </a>
                        </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box rounded-top bg-white p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table">
                                <tr>
                                    <td width="40%">
                                        <h6 class="font-weight-bolder">Penerima</h6>
                                    </td>
                                    <td>:</td>
                                    <td class="text-primary">
                                        @if ($data->penerima_supplier == NULL)
                                        <h6>{{$data->pegawai->nama}}</h6>
                                        @else
                                        <h6>{{$data->supplier->nama_supplier}}</h6>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    
                                    <td>
                                        <h6 class="font-weight-bolder">Alamat Penagihan</h6>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <h6>{{$data->alamat_penagihan}}</h6>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table">
                                <tr>
                                    <td>
                                        <h6 class="font-weight-bolder">Tgl Transaksi</h6>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <h6>{{ $data->tanggal_transaksi }}</h6>
                                    </td>
                                </tr>
                                @if ($data->account_pembayar == NULL)
                                    <tr>
                                        <td>
                                            <h6 class="font-weight-bolder">Tgl Jatuh Tempo</h6>
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <h6>{{ $data->tanggal_jatuh_tempo }}</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h6 class="font-weight-bolder">Syarat Pembayaran</h6>
                                        </td>
                                        <td>:</td>
                                        <td>
                                            <h6>{{ $data->syarat_pembayarans->nama_syarat }}</h6>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table">
                                <tr>
                                    <td>
                                        <h6 class="font-weight-bolder">No. Transaksi</h6>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        {{-- @php
                                            $pecah = explode(' ', $data->no_biaya);
                                            $pisah = substr($pecah[1], -5);
                                        @endphp --}}
                                        <h6>{{ $data->no_biaya }}</h6>
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td>
                                        <h6 class="font-weight-bolder">Cara Pembayaran</h6>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <h6>{{ $data->metode_pembayarans->nama_metode }}</h6>
                                    </td>
                                </tr> --}}
                            </table>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12">
                            <table class="table table-hover mt-5">
                                <thead class="bg-primary-o-45">
                                    <tr class="font-weight-bolder">
                                        <th>Akun Biaya</th>
                                        <th>Deskripsi</th>
                                        <th>Pajak</th>
                                        <th class="text-right">Jumlah (dalam IDR)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data_detail as $item)
                                        <tr>
                                            <td>
                                                {{ $item->account_bank->nama }}
                                            </td>
                                            <td>
                                                {{ $item->deskripsi }}
                                            </td>
                                            <td>
                                                @if ($item->pajak_id !== NULL)
                                                {{ $item->pajak->nama_pajak }}
                                                @else
                                                    {{ '--none--' }}
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($item->jumlah,2,',','.'); }}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                data tidak ada
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row justify-content-end mt-5">
                        <div class="col-md-6">
                            <table class="table text-right">
                                <tr>
                                    <td>
                                        <h6 class="font-weight-bolder">Sub Total</h6>
                                    </td>
                                    <td>
                                        <h6>{{ "Rp. ".number_format($data->sub_total,2,',','.');  }}</h6>
                                    </td>
                                </tr>
                                @if ($pajak !== 0)
                                    <tr>
                                        <td>
                                            <h6 class="font-weight-bolder">Pajak</h6>
                                        </td>
                                        <td>
                                            <h6>{{ "Rp. ".number_format($pajak,2,',','.'); }}</h6>
                                            <div class="line d-flex flex-row">
                                                <span style="content: '';width: 100%;margin-top: 6px; height: 3px; background-color: rgb(116, 116, 116)"></span>
                                                <i class="fa fa-plus ml-2" aria-hidden="true"></i>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>
                                        <h6 class="font-weight-bolder">Total</h6>
                                    </td>
                                    <td>
                                        <h6>{{ "Rp. ".number_format($data->total,2,',','.'); }}</h6>
                                    </td>
                                </tr>
                                @if ($data->akun_pemotong !== NULL)
                                    <tr>
                                        <td>
                                            <h6 class="font-weight-bolder">Akun Pemotong</h6>
                                            {{-- <p class="text-primary">({{ $data->account_bank->nomor }}) {{ $data->account_bank->nama }}</p> --}}
                                        </td>
                                        <td>
                                            <h6>{{ "Rp. ".number_format($data->besar_potongan,2,',','.'); }}</h6>
                                            <div class="line d-flex flex-row">
                                                <span style="content: '';width: 100%;margin-top: 6px; height: 3px; background-color: rgb(116, 116, 116)"></span>
                                                <i class="fa fa-minus ml-2" aria-hidden="true"></i>
                                                {{-- <i class="fa fa-plus ml-2" aria-hidden="true"></i> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>
                                        <h6 class="font-weight-bolder">Grand Total</h6>
                                    </td>
                                    <td>
                                        <h6 class="font-weight-bolder">{{ "Rp. ".number_format($data->grand_total,2,',','.'); }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4 class="font-weight-bolder text-primary">Sisa Tagihan</h4>
                                    </td>
                                    <td>
                                        <h4 class="font-weight-bolder text-primary">{{ "Rp. ".number_format($data->sisa_tagihan,2,',','.'); }}</h4>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    @if ($data->verifikasi == 1)
                    <div class="row">
                        <div class="col-md-12 d-flex flex-row justify-content-between">
                            <div class="input-group">
                                <a href="{{ url('fnc/cetak_pdf') }}" target="_blank" id="btn-pdf" class="btn btn-secondary d-flex flex-row">
                                    Cetak
                                    <span><i class="fa fa-download text-dark-50 ml-2" aria-hidden="true"></i></span>
                                </a>
                            </div>
                            <div class="button-left d-flex flex-row">
                                <form action="{{ route('biaya.destroy', $data->id) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger mr-2 d-flex flex-row" onclick="return confirm('apakah anda ingin menghapus')">
                                        Hapus
                                        <i class="fas fa-trash ml-2"></i>
                                    </button>
                                </form>
                                <a href="{{ route('biaya.edit', $data->id) }}" class="btn btn-primary d-flex flex-row">Edit <i class="fa fa-paint-brush ml-2" aria-hidden="true"></i></a>
                                @if ($data->status == 1)
                                    <a href="{{ url('fnc/showBayar', $data->id) }}" class="btn btn-success d-flex flex-row ml-2">Bayar<i class="fas fa-money-bill ml-1"></i></a>
                                @endif
                                <a href="{{ url('fnc/lacak_pembayaran_biaya', $data->id) }}" class="btn btn-info d-flex flex-row ml-2"><i class="fas fa-book"></i>Riwayat Pembayaran</a>
                            </div>
                        </div>
                    </div>
                        
                    @endif
                </div>
            </div>
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body mt-5">
            <div class="title p-0 m-0">
                <span class="text-dark-50" id="exampleModalLabel">Laporan Jurnal</span>
                <h4 class="text-primary" id="exampleModalLabel">{{ $data->transaksi }} #{{ $data->no_biaya }}</h4>
            </div>
            <table class="table table-head-bg table-hover">
                <thead class="bg-primary-o-45">
                    <tr>
                        <th>Nomor Akun</th>
                        <th>Akun</th>
                        <th>Debit (dalam IDR)</th>
                        <th>Kredit (dalam IDR)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jurnal_entry as $jurnal)
                        <tr>
                            <td>
                                {{ $jurnal->account_bank->nomor }}
                            </td>
                            <td>
                                {{ $jurnal->account_bank->nama }}
                            </td>
                            <td>
                                {{ number_format($jurnal->debit,2,',','.'); }}
                            </td>
                            <td>
                                {{ number_format($jurnal->kredit,2,',','.'); }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-primary-o-45">
                    <tr class="font-weight-bolder">
                        <td colspan="2">
                            Total
                        </td>
                        <td>
                            {{ number_format($sum_jurnal_debit,2,',','.'); }}
                        </td>
                        <td>
                            {{ number_format($sum_jurnal_kredit,2,',','.'); }}
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="row text-right">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection