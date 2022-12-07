
@extends('layouts.app_finance') 
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box rounded bg-white p-3">
                <h1>Daftar Nilai Persediaan Barang<span class="font-size-h5-sm text-black-50"> dalam (IDR)</span></h1>
                <hr>
                <form action="{{ route('result_nilai_persediaan_barang') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input type="date" class="form-control" name="tanggal_awal" value="{{ $tanggal_awal }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input type="date" class="form-control" name="tanggal_akhir" value="{{ $tanggal_akhir }}" required>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex flex-column justify-content-end">
                            <div class="form-group">
                                <input type="submit" value="Filter Now" class="btn btn-primary">
                            </div>
                        </div>
                        <div class="col-md-3 d-flex flex-column justify-content-end">
                            <div class="form-group text-right">
                                <button onclick="printContent('ticket2')" class="btn btn-primary mt-3"> <i class="fa fa-print" aria-hidden="true"> Print</i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box bg-white rounded p-5 mt-3" name="ticket2" id="ticket2">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3>Pt. Dzawani Teknologi indonesia</h3>
                        <h2 class="font-weight-bolder">Laporan Nilai Persediaan Barang</h2>
                        <h6>{{ $tanggal_awal }} s/d {{ $tanggal_akhir }}</h6>
                        <span>dalam(IDR)</span>
                    </div>
                </div>
                <table class="table mt-5" style="width:100%" id="example">
                    <thead style="background: rgba(0, 110, 255, 0.719);">
                        <tr>
                            <th>Tanggal</th>
                            <th>Transaksi</th>
                            <th>Deskripsi</th>
                            <th>Mutasi</th>
                            <th>Stok Barang</th>
                            <th>Harga</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($product as $item)
                            <tr>
                                <td colspan="7" class="bg-primary-o-50 pl-5">
                                    <h6 class="font-weight-bolder">{{ $item->nama_product }}</h6>
                                </td>
                            </tr>
                            @php
                                $get = \App\Models\Finance\LogTransaksi::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['product_id' => $item->id])->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->with(['account_bank', 'product'])->get();
                                $get_total = \App\Models\Finance\LogTransaksi::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['product_id' => $item->id])->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->with(['account_bank', 'product'])->orderBy('id', 'desc')->first();
                                // dd($get_total);
                            @endphp
                            @foreach ($get as $g)
                                <tr>
                                    <td class="pl-15">
                                        {{ $g->created_at }}
                                    </td>
                                    <td>
                    
                                        @if ($g->transaksi_key == 1)
                                            @php
                                                $transaksi_parent = \App\Models\Finance\Penjualan::findOrFail($g->transaksi_id);
                                            @endphp
                                        @else
                                            @php
                                                $transaksi_parent = \App\Models\Finance\Pembelian::findOrFail($g->transaksi_id);
                                            @endphp
                                        @endif
                                        {{ $transaksi_parent->no_transaksi }}
                                    </td>
                                    <td>
                                        @if ($g->transaksi_key == 1)
                                            {{ 'Sale' }}
                                        @else
                                            {{ 'Purchase' }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $g->stock_awal - $g->stock_akhir }}
                                    </td>
                                    <td>
                                        {{ $g->stock_akhir }}
                                    </td>
                                    <td>
                                        {{ number_format($item->harga_satuan,2,',','.'); }}
                                    </td>
                                    <td>
                                        {{ number_format($item->harga_satuan * $g->stock_akhir,2,',','.'); }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="text-right font-weight-bolder">{{ $item->nama_product }} | Stock Tersedia :</td>
                                <td class="font-weight-bolder">
                                    {{ $get_total->stock_akhir }}
                                </td>
                                <td class="text-right font-weight-bolder">
                                    Nilai Stock :
                                </td>
                                <td class="text-right font-weight-bolder">
                                    {{ number_format($get_total->stock_akhir * $item->harga_satuan,2,',','.'); }}
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                <h2>Persediaan Barang Belum Ada!!</h2>
                                <a href="{{ route('product.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>Buat Penjualan</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon-script')
<script>
    function printContent(el){
      var restorepage = document.body.innerHTML;
      var printcontent = document.getElementById(el).innerHTML;
      // document.body.style.width="48mm";
      document.body.innerHTML = printcontent;
      window.print();
      document.body.innerHTML = restorepage;
    }
  </script>
@endpush


