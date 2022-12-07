
@extends('layouts.app_finance') 
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box rounded bg-white p-3">
                <h1>Laporan Laba Rugi<span class="font-size-h5-sm text-black-50"> dalam (IDR)</span></h1>
                <hr>
                <form action="{{ route('result_laba_rugi') }}" method="post" enctype="multipart/form-data">
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
                        <h2 class="font-weight-bolder">Laporan Laba Rugi</h2>
                        <h6>{{ $tanggal_awal }} s/d {{ $tanggal_akhir }}</h6>
                        <span>dalam(IDR)</span>
                    </div>
                </div>
                <table class="table mt-5" style="width:100%" id="example">
                    <thead style="background: rgba(0, 110, 255, 0.719);">
                        <tr>
                            <th>Date</th>
                            <th class="text-right">{{ $tanggal_awal }}/{{ $tanggal_akhir }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2" class="font-weight-bolder">
                                Pendapatan dari penjualan
                            </td>
                        </tr>
                        @forelse ($pendapatan_penjualan as $pp)
                            <tr>
                                <td class="pl-10">
                                    ({{ $pp->account_bank->nomor }}) {{ $pp->account_bank->nama }}
                                </td>
                                <td class="text-right">
                                    @php
                                        $pendapatan_sum_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $pp->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('debit');
                                        $pendapatan_sum_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $pp->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('kredit');
                                        
                                        // echo $pendapatan_sum_debit;

                                    @endphp
                                    {{ number_format($pendapatan_sum_debit - $pendapatan_sum_kredit,2,',','.'); }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">
                                    --Data delum ada!!!--
                                </td>
                            </tr>
                        @endforelse
                        <tr class="font-weight-bolder">
                            <td>
                                Total pendapatan dari penjualan
                            </td>
                            <td class="text-right">
                                @php
                                    $sum_total_pendapatan_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 13);})->sum('debit');
                                    $sum_total_pendapatan_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 13);})->sum('kredit');
                                @endphp
                                Rp. {{ number_format($sum_total_pendapatan_debit - $sum_total_pendapatan_kredit,2,',','.'); }}
                            </td>
                        </tr>

                        {{-- harga pokok penjualan --}}
                        <tr>
                            <td colspan="2" class="font-weight-bolder">
                                Harga pokok penjualan
                            </td>
                        </tr>
                        @forelse ($harga_pokok_penjualan as $hpp)
                            <tr>
                                <td class="pl-10">
                                    ({{ $hpp->account_bank->nomor }}) {{ $hpp->account_bank->nama }}
                                </td>
                                <td class="text-right">
                                    @php
                                        $pendapatan_sum_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $hpp->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('debit');
                                        $pendapatan_sum_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $hpp->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('kredit');
                                        
                                        // echo $pendapatan_sum_debit;

                                    @endphp
                                    {{ number_format($pendapatan_sum_debit - $pendapatan_sum_kredit,2,',','.'); }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">
                                    --Data delum ada!!!--
                                </td>
                            </tr>
                        @endforelse
                        <tr class="font-weight-bolder">
                            <td>
                                Total harga pokok penjualan
                            </td>
                            <td class="text-right">
                                @php
                                    $sum_total_pokok_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 15);})->sum('debit');
                                    $sum_total_pokok_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 15);})->sum('kredit');
                                @endphp
                                Rp. {{ number_format($sum_total_pokok_debit - $sum_total_pokok_kredit,2,',','.'); }}
                            </td>
                        </tr>
                        <tr class="font-weight-bolder text-success">
                            <td>
                                Laba Kotor
                            </td>
                            <td class="text-right">
                                Rp. {{ number_format(($sum_total_pendapatan_debit - $sum_total_pendapatan_kredit) - ($sum_total_pokok_debit - $sum_total_pokok_kredit),2,',','.'); }}
                            </td>
                        </tr>

                        {{-- Biaya operasional --}}
                        <tr>
                            <td colspan="2" class="font-weight-bolder">
                                Biaya Operasional
                            </td>
                        </tr>
                        @forelse ($biaya_operasional as $bo)
                            <tr>
                                <td class="pl-10">
                                    ({{ $bo->account_bank->nomor }}) {{ $bo->account_bank->nama }}
                                </td>
                                <td class="text-right">
                                    @php
                                        $biaya_operasional_sum_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $bo->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('debit');
                                        $biaya_operasional_sum_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $bo->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('kredit');
                                        
                                    @endphp
                                    {{ number_format($biaya_operasional_sum_debit - $biaya_operasional_sum_kredit,2,',','.'); }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">
                                    --Data delum ada!!!--
                                </td>
                            </tr>
                        @endforelse
                        <tr class="font-weight-bolder">
                            <td>
                                Total Biaya
                            </td>
                            <td class="text-right">
                                @php
                                    $sum_total_biaya_operasional_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 15);})->sum('debit');
                                    $sum_total_biaya_operasional_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 15);})->sum('kredit');
                                @endphp
                                Rp. {{ number_format($sum_total_biaya_operasional_debit - $sum_total_biaya_operasional_kredit,2,',','.'); }}
                            </td>
                        </tr>
                        <tr class="font-weight-bolder text-success">
                            <td>
                                Pendapatan Bersih Operasional
                            </td>
                            <td class="text-right">
                                Rp. {{ number_format((($sum_total_pendapatan_debit - $sum_total_pendapatan_kredit) - ($sum_total_pokok_debit - $sum_total_pokok_kredit)) - ($sum_total_biaya_operasional_debit - $sum_total_biaya_operasional_kredit),2,',','.'); }}
                            </td>
                        </tr>


                        {{-- Pendapatan Lainnya --}}
                        <tr>
                            <td colspan="2" class="font-weight-bolder">
                                Pendapatan Lainnya
                            </td>
                        </tr>
                        @forelse ($pendapatan_lainnya as $pl)
                            <tr>
                                <td class="pl-10">
                                    ({{ $pl->account_bank->nomor }}) {{ $pl->account_bank->nama }}
                                </td>
                                <td class="text-right">
                                    @php
                                        $biaya_pendapatan_lainnya_sum_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $pl->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('debit');
                                        $biaya_pendapatan_lainnya_sum_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $pl->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('kredit');
                                        
                                    @endphp
                                    {{ number_format($biaya_pendapatan_lainnya_sum_debit - $biaya_pendapatan_lainnya_sum_kredit,2,',','.'); }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">
                                    --Data delum ada!!!--
                                </td>
                            </tr>
                        @endforelse
                        <tr class="font-weight-bolder">
                            <td>
                                Total Pendapatan Lainnya
                            </td>
                            <td class="text-right">
                                @php
                                    $sum_total_pendapatan_lainnya_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 15);})->sum('debit');
                                    $sum_total_pendapatan_lainnya_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 15);})->sum('kredit');
                                @endphp
                                Rp. {{ number_format($sum_total_pendapatan_lainnya_debit - $sum_total_pendapatan_lainnya_kredit,2,',','.'); }}
                            </td>
                        </tr>


                        {{-- Biaya Lainnya --}}
                        <tr>
                            <td colspan="2" class="font-weight-bolder">
                                Biaya Lainnya
                            </td>
                        </tr>
                        @forelse ($biaya_lainnya as $bl)
                            <tr>
                                <td class="pl-10">
                                    ({{ $bl->account_bank->nomor }}) {{ $bl->account_bank->nama }}
                                </td>
                                <td class="text-right">
                                    @php
                                        $biaya_biaya_lainnya_sum_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $bl->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('debit');
                                        $biaya_biaya_lainnya_sum_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $bl->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('kredit');
                                        
                                    @endphp
                                    {{ number_format($biaya_biaya_lainnya_sum_debit - $biaya_biaya_lainnya_sum_kredit,2,',','.'); }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">
                                    --Data delum ada!!!--
                                </td>
                            </tr>
                        @endforelse
                        <tr class="font-weight-bolder">
                            <td>
                                Total Biaya Lainnya
                            </td>
                            <td class="text-right">
                                @php
                                    $sum_total_biaya_lainnya_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 15);})->sum('debit');
                                    $sum_total_biaya_lainnya_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 15);})->sum('kredit');
                                @endphp
                                Rp. {{ number_format($sum_total_biaya_lainnya_debit - $sum_total_biaya_lainnya_kredit,2,',','.'); }}
                            </td>
                        </tr>
                        <tr class="font-weight-bolder text-success">
                            <td>
                                Pendapatan Bersih
                            </td>
                            <td class="text-right">
                                Rp. {{ number_format(($sum_total_pendapatan_debit - $sum_total_pendapatan_kredit)-($sum_total_pokok_debit - $sum_total_pokok_kredit)-($sum_total_biaya_operasional_debit - $sum_total_biaya_operasional_kredit)-($sum_total_pendapatan_lainnya_debit - $sum_total_pendapatan_lainnya_kredit)-($sum_total_biaya_lainnya_debit - $sum_total_biaya_lainnya_kredit),2,',','.'); }}
                            </td>
                        </tr>
                        <tr class="font-weight-bolder text-success">
                            <td>
                                Total Pendapatan Komprehensif untuk periode ini
                            </td>
                            <td class="text-right">
                                Rp. {{ number_format(($sum_total_pendapatan_debit - $sum_total_pendapatan_kredit)-($sum_total_pokok_debit - $sum_total_pokok_kredit)-($sum_total_biaya_operasional_debit - $sum_total_biaya_operasional_kredit)-($sum_total_pendapatan_lainnya_debit - $sum_total_pendapatan_lainnya_kredit)-($sum_total_biaya_lainnya_debit - $sum_total_biaya_lainnya_kredit),2,',','.'); }}
                            </td>
                        </tr>
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
