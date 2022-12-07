
@extends('layouts.app_finance') 
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box rounded bg-white p-3">
                <h1>Laporan Jurnal Penyesuaian<span class="font-size-h5-sm text-black-50"> dalam (IDR)</span></h1>
                <hr>
                <form action="{{ route('result_jurnal_penyesuaian') }}" method="post" enctype="multipart/form-data">
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
                        <h2 class="font-weight-bolder">Laporan Jurnal</h2>
                        <h6>{{ $tanggal_awal }} s/d {{ $tanggal_akhir }}</h6>
                        <span>dalam(IDR)</span>
                    </div>
                </div>
                <table class="table mt-5" style="width:100%" id="example">
                    <thead style="background: rgba(0, 110, 255, 0.719);">
                        <tr>
                            <th>Akun</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jurnal_entry as $item)
                            <tr>
                                <td colspan="4" class="bg-primary-o-50 pl-5">
                                    @php
                                        if ($item->category == 1) {
                                            // transaksi penjualan
                                            $transaksi_parent = \App\Models\Finance\Penjualan::findOrFail($item->transaksi_id);
                                            echo '<h6 class="font-weight-bolder">'.$transaksi_parent->transaksi.' #'.$transaksi_parent->no_transaksi.' | '. $transaksi_parent->tanggal_transaksi .'</h6>';
                                        } elseif ($item->category == 2) {
                                            // transaksi pembelian
                                            // $transaksi_parent = \App\Models\Finance\Pembelian::findOrFail($item->transaksi_id);
                                        } elseif ($item->category == 3) {
                                            // transaksi biaya
                                            $transaksi_parent = \App\Models\Finance\Biaya::findOrFail($item->transaksi_id);
                                            echo '<h6 class="font-weight-bolder">'.$transaksi_parent->transaksi.' #'.$transaksi_parent->no_biaya.' | '. $transaksi_parent->tanggal_transaksi .'</h6>';
                                        } elseif ($item->category == 4) {
                                            // transaksi kirim uang
                                            $transaksi_parent = \App\Models\Finance\KirimUang::findOrFail($item->transaksi_id);
                                            echo '<h6 class="font-weight-bolder">'.$transaksi_parent->transaksi.' #'.$transaksi_parent->no_transaksi.' | '. $transaksi_parent->tanggal_transaksi .'</h6>';
                                        } elseif ($item->category == 5) {
                                            // transaksi trima uang
                                            $transaksi_parent = \App\Models\Finance\TerimaUang::findOrFail($item->transaksi_id);
                                            echo '<h6 class="font-weight-bolder">'.$transaksi_parent->transaksi.' #'.$transaksi_parent->no_transaksi.' | '. $transaksi_parent->tanggal_transaksi .'</h6>';
                                        } else {
                                            // transaksi transfer uang
                                            $transaksi_parent = \App\Models\Finance\TransferUang::findOrFail($item->transaksi_id);
                                            echo '<h6 class="font-weight-bolder">'.$transaksi_parent->transaksi.' #'.$transaksi_parent->no_transaksi.' | '. $transaksi_parent->tanggal_transaksi .'</h6>';
                                            // {{ $transaksi_parent-> }}
                                        }
                                        
                                    @endphp
                                    {{-- <h6 class="font-weight-bolder">{{ $item->transaksi_id }}</h6> --}}
                                </td>
                            </tr>
                            @php
                                $get = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['transaksi_id' => $item->transaksi_id])->where(['category'=> $item->category])->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->with(['account_bank'])->orderBy('id', 'desc')->get();
                                $get_total_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['transaksi_id' => $item->transaksi_id])->where(['category'=> $item->category])->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->with(['account_bank'])->sum('debit');
                                $get_total_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['transaksi_id' => $item->transaksi_id])->where(['category'=> $item->category])->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->with(['account_bank'])->sum('kredit');

                                
                            @endphp
                            @foreach ($get as $g)
                                <tr>
                                    <td class="pl-15">
                                        ({{ $g->account_bank->nomor }}) - {{ $g->account_bank->nama }}
                                    </td>
                                    <td>
                                        {{ number_format($g->debit,2,',','.'); }}
                                    </td>
                                    <td>
                                        {{ number_format($g->kredit,2,',','.'); }}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)"  data-id="{{ $g->id }}" data-original-title="Edit" class="edit btn btn-primary btn-sm editMetode">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-right font-weight-bolder">Total :</td>
                                <td class="font-weight-bolder">
                                    {{ number_format($get_total_debit,2,',','.'); }}
                                </td>
                                <td class="font-weight-bolder">
                                    {{ number_format($get_total_kredit,2,',','.'); }}
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                <h2>Rincian Persediaan Barang Belum Ada!!</h2>
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

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="MetodeForm" name="MetodeForm" class="form-horizontal">
                   <input type="hidden" name="Metode_id" id="Metode_id">
                    <div class="form-group">
                        <label for="nama_metode" class="col-sm-12 control-label">Nama Metode</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nama_metode" name="nama_metode" placeholder="Enter Name Method" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="account_bank" class="col-sm-12 control-label">AccountBank</label> 
                        <div class="col-sm-12">
                            <select name="account_bank" id="account_bank" class="form-control">
                                <option value="">-- Account Bank --</option>
                                @foreach ($account_bank as $ab)
                                    <option value="{{ $ab->id }}">({{ $ab->nomor }})-{{ $ab->nama }}</option>
                                @endforeach
                            </select>
                            {{-- <input type="text" name="account_bank" id=""> --}}
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
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
  <script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // $('#createNewMetode').click(function () {
        //     $('#saveBtn').val("create-metode");
        //     $('#Metode_id').val('');
        //     $('#MetodeForm').trigger("reset");
        //     $('#modelHeading').html("Create New Metode");
        //     $('#ajaxModel').modal('show');
        // });

        $('body').on('click', '.editMetode', function () {

            var Metode_id = $(this).data('id');
            console.log('jurnal_penyesuaian' +'/' + Metode_id +'/edit');
            $.get('jurnal_penyesuaian' +'/' + Metode_id +'/edit', function (data) {
                $('#modelHeading').html("Edit Motode");
                $('#saveBtn').val("edit-metode");
                $('#ajaxModel').modal('show');
                $('#Metode_id').val(data.id);
                $('#nama_metode').val(data.nama_metode);
                $('#account_bank').val(data.account_bank);
            })
        });

    });
  </script>
@endpush
