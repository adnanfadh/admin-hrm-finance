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
                <h1>Pengiriman Penjualan<span class="font-size-h5-sm text-black-50"> dalam (IDR)</span></h1>
                <hr>
                <form action="{{ route('result_pengiriman_penjualan') }}" method="post" enctype="multipart/form-data">
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
                        <h2 class="font-weight-bolder">Pengiriman Penjualan</h2>
                        <h6>{{ $tanggal_awal }} s/d {{ $tanggal_akhir }}</h6>
                        <span>dalam(IDR)</span>
                    </div>
                </div>
                <table class="table mt-5" style="width:100%" id="example">
                    <thead style="background: rgba(0, 110, 255, 0.719);">
                        <tr>
                            <th>Pelanggan/Nama Product</th>
                            <th>Satuan</th>
                            <th>Kuantitas</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customer as $item)
                            <tr>
                                <td colspan="5" class="bg-primary-o-50 pl-5">
                                    <h6 class="font-weight-bolder">{{ $item->nama_customer }}</h6>
                                </td>
                            </tr>
                            @php
                                $get = \App\Models\Finance\Penjualan::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['customer_id' => $item->id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->with(['customer','detail_penjualan'])->get();
                            @endphp
                            @foreach ($get as $ge)
                                @php
                                    $get_detail = \App\Models\Finance\DetailPenjualan::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where('penjualan_id', $ge->id)->get();
                                    $get_detail_total = \App\Models\Finance\DetailPenjualan::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where('penjualan_id', $ge->id)->sum('total');
                                @endphp
                            @endforeach
                            @foreach ($get_detail as $g)
                                <tr>
                                    <td class="pl-15">
                                        {{ $g->product->nama_product }}
                                    </td>
                                    <td>
                                        {{ $g->product->satuan }}
                                    </td>
                                    <td>
                                        {{ $g->qty_pembelian }}
                                    </td>
                                    <td>
                                        {{ number_format($g->total,2,',','.'); }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-right font-weight-bolder">{{ $item->nama_customer }}| Total Penjualan</td>
                                <td class="font-weight-bolder">
                                    {{ number_format($get_detail_total,2,',','.'); }}
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <h2>Pengiriman penjualan berdasarkan tanggal tersebut belum ada!!</h2>
                                <a href="{{ route('penjualan.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>Buat Penjualan</a>
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