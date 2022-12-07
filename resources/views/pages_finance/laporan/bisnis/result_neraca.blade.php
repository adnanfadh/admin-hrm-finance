
@extends('layouts.app_finance') 
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box rounded bg-white p-3">
                <h1>Laporan Neraca<span class="font-size-h5-sm text-black-50"> dalam (IDR)</span></h1>
                <hr>
                <form action="{{ route('result_neraca') }}" method="post" enctype="multipart/form-data">
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
                        <h2 class="font-weight-bolder">Laporan Neraca</h2>
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
                            <td colspan="2">
                                Aktiva
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="font-weight-bolder pl-8">
                                Aktiva Lancar
                            </td>
                        </tr>
                        @forelse ($aktiva_lancar as $al)
                            <tr>
                                <td class="pl-15">({{ $al->account_bank->nomor }}) - {{ $al->account_bank->nama }}</td>
                                <td class="text-right">
                                    @php
                                        $aktiva_lancar_sum_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $al->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('debit');
                                        $aktiva_lancar_sum_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $al->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('kredit');
                                    @endphp
                                    {{ number_format($aktiva_lancar_sum_debit - $aktiva_lancar_sum_kredit,2,',','.'); }}
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
                            <td class="pl-8">
                                Total Aktiva Lancar
                            </td>
                            <td class="text-right">
                                @php
                                    $sum_total_aktiva_lancar_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 2);})->sum('debit');
                                    $sum_total_aktiva_lancar_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 2);})->sum('kredit');
                                @endphp
                                {{ number_format($sum_total_aktiva_lancar_debit - $sum_total_aktiva_lancar_kredit,2,',','.'); }}
                            </td>
                        </tr>


                        {{-- Aktiva Tetap --}}
                        <tr>
                            <td colspan="2" class="font-weight-bolder pl-8">
                                Aktiva Tetap
                            </td>
                        </tr>
                        @forelse ($aktiva_lancar as $at)
                            <tr>
                                <td class="pl-15">({{ $at->account_bank->nomor }}) - {{ $at->account_bank->nama }}</td>
                                <td class="text-right">
                                    @php
                                        $aktiva_tetap_sum_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $at->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('debit');
                                        $aktiva_tetap_sum_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $at->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('kredit');
                                    @endphp
                                    {{ number_format($aktiva_tetap_sum_debit - $aktiva_tetap_sum_kredit,2,',','.'); }}
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
                            <td class="pl-8">
                                Total Aktiva Tetap
                            </td>
                            <td class="text-right">
                                @php
                                    $sum_total_aktiva_tetap_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 5);})->sum('debit');
                                    $sum_total_aktiva_tetap_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 5);})->sum('kredit');
                                @endphp
                                {{ number_format($sum_total_aktiva_tetap_debit - $sum_total_aktiva_tetap_kredit,2,',','.'); }}
                            </td>
                        </tr>


                        {{-- Depresiasi & Amortilasi --}}
                        <tr>
                            <td colspan="2" class="font-weight-bolder pl-8">
                                Depresiasi & Amortisasi
                            </td>
                        </tr>
                        @forelse ($depresiasi_amortisasi as $da)
                            <tr>
                                <td class="pl-15">({{ $da->account_bank->nomor }}) - {{ $da->account_bank->nama }}</td>
                                <td class="text-right">
                                    @php
                                        $depresiasi_sum_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $da->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('debit');
                                        $depresiasi_sum_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $da->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('kredit');
                                    @endphp
                                    {{ number_format($depresiasi_sum_debit - $depresiasi_sum_kredit,2,',','.'); }}
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
                            <td class="pl-8">
                                Total Depresiasi & Amortisasi
                            </td>
                            <td class="text-right">
                                @php
                                    $sum_total_depresiasi_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 7);})->sum('debit');
                                    $sum_total_depresiasi_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 7);})->sum('kredit');
                                @endphp
                                {{ number_format($sum_total_depresiasi_debit - $sum_total_depresiasi_kredit,2,',','.'); }}
                            </td>
                        </tr>
                        <tr class="font-weight-bolder">
                            <td>
                                Total Aktiva
                            </td>
                            <td class="text-right">
                                {{ number_format(($sum_total_aktiva_lancar_debit - $sum_total_aktiva_lancar_kredit)+($sum_total_aktiva_tetap_debit - $sum_total_aktiva_tetap_kredit)+($sum_total_depresiasi_debit - $sum_total_depresiasi_kredit),2,',','.'); }}
                            </td>
                        </tr>

                        {{-- kewajiban dan modal --}}
                        <tr>
                            <td colspan="2">
                                Kewajiban dan Modal
                            </td>
                        </tr>
                        {{-- kewajiban lancar --}}
                        <tr>
                            <td colspan="2" class="font-weight-bolder pl-8">
                                Kewajiban Lancar
                            </td>
                        </tr>
                        @forelse ($kewajiban_lancar as $kl)
                            <tr>
                                <td class="pl-15">({{ $kl->account_bank->nomor }}) - {{ $kl->account_bank->nama }}</td>
                                <td class="text-right">
                                    @php
                                        $kewajiban_lancar_sum_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $kl->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('debit');
                                        $kewajiban_lancar_sum_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $kl->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('kredit');
                                    @endphp
                                    {{ number_format($kewajiban_lancar_sum_debit - $kewajiban_lancar_sum_kredit,2,',','.'); }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">
                                    --Data belum ada!!!--
                                </td>
                            </tr>
                        @endforelse
                        <tr class="font-weight-bolder">
                            <td class="pl-8">
                                Total Kewajiban Lancar
                            </td>
                            <td class="text-right">
                                @php
                                    $sum_total_kewajiban_lancar_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 10);})->sum('debit');
                                    $sum_total_kewajiban_lancar_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 10);})->sum('kredit');
                                @endphp
                                {{ number_format($sum_total_kewajiban_lancar_debit - $sum_total_kewajiban_lancar_kredit,2,',','.'); }}
                            </td>
                        </tr>
                        <tr class="font-weight-bolder">
                            <td class="pl-8">
                                Total Kewajiban
                            </td>
                            <td class="text-right">
                                {{ number_format($sum_total_kewajiban_lancar_debit - $sum_total_kewajiban_lancar_kredit,2,',','.'); }}
                            </td>
                        </tr>


                        {{-- Modal Pemilik --}}
                        <tr>
                            <td colspan="2" class="font-weight-bolder pl-8">
                                Modal Pemilik
                            </td>
                        </tr>
                        @forelse ($modal_pemilik as $mk)
                            <tr>
                                <td class="pl-15">({{ $mk->account_bank->nomor }}) - {{ $mk->account_bank->nama }}</td>
                                <td class="text-right">
                                    @php
                                        $modal_pemilik_sum_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $mk->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('debit');
                                        $modal_pemilik_sum_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->where(['account_id'=> $mk->account_id])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->sum('kredit');
                                    @endphp
                                    {{ number_format($modal_pemilik_sum_debit - $modal_pemilik_sum_kredit,2,',','.'); }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">
                                    --Data belum ada!!!--
                                </td>
                            </tr>
                        @endforelse
                        <tr class="font-weight-bolder">
                            <td class="pl-8">
                                Total Modal Pemilik
                            </td>
                            <td class="text-right">
                                @php
                                    $sum_total_modal_pemilik_debit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 7);})->sum('debit');
                                    $sum_total_modal_pemilik_kredit = \App\Models\Finance\JurnalEntry::query()->where(['creat_by_company' => Auth::user()->pegawai->company->id])->with(['account_bank'])->whereBetween('tanggal_transaksi', [$tanggal_awal, $tanggal_akhir])->whereHas('account_bank', function($account_bank){$account_bank->where('category', 7);})->sum('kredit');
                                @endphp
                                {{ number_format($sum_total_modal_pemilik_debit - $sum_total_modal_pemilik_kredit,2,',','.'); }}
                            </td>
                        </tr>


                        <tr class="font-weight-bolder">
                            <td>
                                Total Kewajiban dan Modal
                            </td>
                            <td class="text-right">
                                {{ number_format(($sum_total_kewajiban_lancar_debit - $sum_total_kewajiban_lancar_kredit)+($sum_total_modal_pemilik_debit - $sum_total_modal_pemilik_kredit),2,',','.'); }}
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
