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
                <h1>Buku Besar<span class="font-size-h5-sm text-black-50"> dalam (IDR)</span></h1>
                <hr>
                <form action="{{ route('result_buku_besar') }}" method="post" enctype="multipart/form-data">
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
                        <h2 class="font-weight-bolder">Buku Besar</h2>
                        <h6>{{ $tanggal_awal }} s/d {{ $tanggal_akhir }}</h6>
                        <span>dalam(IDR)</span>
                    </div>
                </div>
                <table class="table mt-5" style="width:100%" id="example2">
                    <thead style="background: rgba(0, 110, 255, 0.719);">
                        <tr>
                            <th>Nama Account/Tanggal</th>
                            <th>Transaksi</th>
                            <th>Nomor</th>
                            <th>Keterangan</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($account_bank as $item)
                            <tr class="bg-primary-o-45 font-weight-bolder">
                                <td colspan="6">
                                    <span class="ml-2">{{ $item->nama }} ( {{ $item->nomor }} )</span>
                                </td>
                            </tr>
                            @php
                                $jurnal = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id' => $item->id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->get();
                                $jurnal_debit_total = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id' => $item->id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->where(['kredit' => 0])->sum('debit');
                                $jurnal_kredit_total = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id' => $item->id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->where(['debit' => 0])->sum('kredit');


                            @endphp
                            @foreach ($jurnal as $jur)
                                <tr>
                                    <td>
                                        <span class="ml-4">{{ $jur->tanggal_transaksi }}</span>
                                    </td>
                                    <td>
                                        @php
                                            if ($jur->category == 1) {
                                                $transaksi = \App\Models\Finance\Penjualan::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->where(['id' => $jur->transaksi_id])->get();
                                            }elseif ($jur->category == 2) {
                                                $transaksi = \App\Models\Finance\Pembelian::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->where(['id' => $jur->transaksi_id])->get();
                                            }elseif ($jur->category == 3) {
                                                $transaksi = \App\Models\Finance\Biaya::query()->where(['company_id' => Auth::user()->pegawai->company->id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->where(['id' => $jur->transaksi_id])->get();
                                            }elseif ($jur->categoty == 4) {
                                                $transaksi = \App\Models\Finance\KirimUang::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->where(['id' => $jur->transaksi_id])->get();
                                            }elseif ($jur->categoty == 5) {
                                                $transaksi = \App\Models\Finance\TerimaUang::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->where(['id' => $jur->transaksi_id])->get();
                                            }else{
                                                $transaksi = \App\Models\Finance\TransferUang::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->where(['id' => $jur->transaksi_id])->get();
                                            }
                                        @endphp
                                        @foreach ($transaksi as $t)
                                            {{ $t->transaksi }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($transaksi as $t)
                                            {{ $t->no_transaksi }}
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $jur->keterangan }}
                                    </td>
                                    <td>
                                        {{ $jur->debit !== 0 ? number_format($jur->debit,2,',','.') : '' }}
                                    </td>
                                    <td>
                                        {{ $jur->kredit !== 0 ? number_format($jur->kredit,2,',','.') : '' }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="font-weight-bolder">
                                <td colspan="4" class="text-right">{{ $item->nama }}| Current Balance</td>
                                <td> {{ number_format($jurnal_debit_total,2,',','.') }} </td>
                                <td> {{ number_format($jurnal_kredit_total,2,',','.') }} </td>
                            </tr>
                            <tr></tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                <h2>Buku Besar berdasarkan tanggal tersebut belum ada!!</h2>
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