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
            <div class="box rounded bg-white p-5 d-flex flrx-row justify-content-between">
                <h1>Laporan Saldo Account<span class="font-size-h5-sm text-black-50"> dalam (IDR)</span></h1>
                <div class="text-right">
                    <button onclick="printContent('ticket2')" class="btn btn-primary mt-3"> <i class="fa fa-print" aria-hidden="true"> Print</i></button>
                </div>
            </div>
            <div class="box bg-white rounded p-5 mt-3" name="ticket2" id="ticket2">
                {{-- <div class="row">
                    @php
                        $data_day = date("d");
                        $data_month = date("m");
                        $data_year = date("Y");
                    @endphp
                    <table>
                        <br>
                        <tr>
                            <td>Kemarin</td>
                            <td>:</td>
                            <td>
                                {{ $data_year }}-{{ $data_month }}-{{ $data_day - 1 }}
                            </td>
                        </tr>
                        <tr>
                            <td>Seminggu yang lalu</td>
                            <td>:</td>
                            <td>
                                {{ $data_year }}-{{ $data_month }}-{{ $data_day - 7 }}
                            </td>
                        </tr>
                    </table>
                    <br>

                </div> --}}
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3>Pt. Dzawani Teknologi indonesia</h3>
                        <h2 class="font-weight-bolder">Laporan Saldo Account</h2>
                        {{-- <h6>{{ $tanggal_awal }} s/d {{ $tanggal_akhir }}</h6> --}}
                        <span>dalam(IDR)</span>
                    </div>
                </div>
                <table class="table mt-5" style="width:100%" id="example2">
                    <thead style="background: rgba(0, 110, 255, 0.719);">
                        <tr>
                            <th>No</th>
                            <th>Nama Account</th>
                            <th>Nomor</th>
                            <th>Category</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($bank as $item)
                            <tr>
                                <td>
                                    {{ $no++ }}
                                </td>
                                <td>
                                    {{ $item->nama }}
                                </td>
                                <td>
                                    {{ $item->nomor }}
                                </td>
                                <td>
                                    {{ $item->category_account->nama_category_account }}
                                </td>
                                <td>
                                    {{ number_format($item->saldo,2,',','.'); }}
                                </td>
                            </tr>
                            
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                <h2>Account tersebut belum ada!!</h2>
                                <a href="{{ route('accountbank.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>Buat Penjualan</a>
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