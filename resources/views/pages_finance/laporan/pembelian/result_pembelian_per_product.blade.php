@extends('layouts.app_finance') 
@push('addon-style')
{{-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <style media="print">
        * {
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
            color-adjust: exact !important;                 /*Firefox*/
        }
        @media print {
            .example {
              border-bottom: solid; 
              border-right: solid; 
              background-color: #000000;
              -webkit-print-color-adjust: exact;
            }
          }
      </style>
@endpush
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box rounded bg-white p-3">
                <h1>Pembelian Per Product<span class="font-size-h5-sm text-black-50"> dalam (IDR)</span></h1>
                <hr>
                <form action="{{ route('result_pembelian_per_product') }}" method="post" enctype="multipart/form-data">
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
                        <h2 class="font-weight-bolder">Pembelian Per Product</h2>
                        <h6>{{ $tanggal_awal }} s/d {{ $tanggal_akhir }}</h6>
                        <span>dalam(IDR)</span>
                    </div>
                </div>
                <table class="table mt-5" style="width:100%" id="example2">
                    <thead style="background: rgba(0, 110, 255, 0.719);">
                        <tr>
                            <th>Nama Product</th>
                            <th>Kuantitas pembelian</th>
                            <th>Satuan</th>
                            <th>Total Nilai Dibeli</th>
                            <th>Harga Pembelian Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $pembelian = \App\Models\Finance\Pembelian::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->get();
                            $pembelian_singgle = \App\Models\Finance\Pembelian::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->count();
                        @endphp

                        @if ($pembelian2 > 0)
                            @foreach ($product as $item)
                                <tr>
                                    <td>{{ $item->nama_product }}</td>
                                    <td>
                                        @foreach ($pembelian as $beli)
                                            @php
                                                $jumlah_qty = \App\Models\Finance\DetailPembelian::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['product_id' => $item->id])->where(['pembelian_id' => $beli->id])->sum('qty_pembelian');
                                            @endphp
                                        @endforeach
                                        {{ $jumlah_qty }}
                                    </td>
                                    <td>{{ $item->satuan }}</td>
                                    <td>
                                        @foreach ($pembelian as $beli)
                                            @php
                                                $dataku = \App\Models\Finance\DetailPembelian::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['product_id' => $item->id])->where(['pembelian_id' => $beli->id])->sum('total');
                                            @endphp
                                        @endforeach
                                        {{ number_format($dataku,2,',','.'); }}
                                    </td>
                                    <td>
                                        @php
                                            if ($dataku == 0) {
                                                $rataRata = $dataku;
                                            }else {
                                                $rataRata = $dataku / $jumlah_qty;
                                            }
                                            @endphp
                                            {{ number_format($rataRata,2,',','.'); }}
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td colspan="3" class="text-right font-weight-bolder">{{ $item->nama_product }}| Total Pembelian</td>
                                    <td colspan="2" class="font-weight-bolder">
                                        {{ number_format($dataku,2,',','.'); }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">
                                    <h2>Pembelian berdasarkan tanggal tersebut belum ada!!</h2>
                                    <a href="{{ route('pembelian.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>Buat Penjualan</a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@push('addon-script')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#example').DataTable( {
            responsive: true
        } );
     
        new $.fn.dataTable.FixedHeader( table );
    });

    
</script>

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