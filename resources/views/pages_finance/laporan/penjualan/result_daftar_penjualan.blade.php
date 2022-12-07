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
                <h1>Daftar Penjualan<span class="font-size-h5-sm text-black-50"> dalam (IDR)</span></h1>
                <hr>
                <form action="{{ route('daftar_penjualan') }}" method="post" enctype="multipart/form-data">
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
                        <h2 class="font-weight-bolder">Daftar Penjualan</h2>
                        <h6>{{ $tanggal_awal }} s/d {{ $tanggal_akhir }}</h6>
                        <span>dalam(IDR)</span>
                    </div>
                </div>
                <table class="table mt-5" style="width:100%" id="example2">
                    <thead style="background: rgba(0, 110, 255, 0.719);">
                        <tr>
                            <th>Tanggal</th>
                            <th>Transaksi</th>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Status</th>
                            <th>Total tagihan</th>
                            <th>Sisa Tagihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penjualan as $item)
                            <tr>
                                <td>
                                    {{ $item->tanggal_transaksi }}
                                </td>
                                <td>
                                    {{ $item->transaksi }}
                                </td>
                                <td>
                                    {{ $item->no_transaksi }}
                                </td>
                                <td>
                                    {{ $item->customer->nama_customer }}
                                </td>
                                <td>
                                    @if ($item->status == 1)
                                        {{ 'Not yet paid' }}
                                    @else
                                        {{ 'Paid' }}
                                    @endif
                                </td>
                                <td>
                                    {{ number_format($item->total,2,',','.'); }}
                                </td>
                                <td>
                                    {{ number_format($item->sisa_tagihan,2,',','.'); }}
                                </td>
                            </tr>
                            
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <h2>Penjualan berdasarkan tanggal tersebut belum ada!!</h2>
                                <a href="{{ route('penjualan.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>Buat Penjualan</a>
                            </td>
                        </tr>
                        @endforelse
                        @if ($get_total > 0)
                            <tr>
                                <td colspan="6" class="text-right font-weight-bolder"> Total Penjualan</td>
                                <td class="font-weight-bolder">
                                    {{ number_format($get_total,2,',','.'); }}
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