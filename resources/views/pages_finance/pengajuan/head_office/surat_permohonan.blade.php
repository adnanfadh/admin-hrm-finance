@extends('layouts.app_finance')

@push('addon-style')
    <style>
        @media print {
            .pengajuan23 { page-break-before: always; }
        }
        .pengajuan23 { page-break-before: always; }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Page Heading -->
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb shadow-sm bg-white p-5">
                    <li class="breadcrumb-item"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pengajuan_head.index') }}" style="text-decoration: none"> Pengajuan</a></li>
                    <li class="breadcrumb-item " aria-current="page">Surat Permohonan</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="kwitansi" id="print-invoice">
            <div class="pengajuan1 bg-white p-10" style="width: 21cm; height: 29cm; margin: 3cm 3cm 3cm 4cm;">
                <div class="row">
                    <div class="col-md-7 col-7">
                        <div class="col-md-5">
                            <div class="widger-logo bg-dark-o-50 p-3 rounded d-flex justify-content-center" style="overflow: hidden">
                                <img src="{{ asset('assets/image/logo-dzawani-group.png') }}" alt="" class="mr-2" style="max-height: 7em;">
                            </div>
                        </div>
                        <h4 class="m-0 mt-2 text-black-60">{{ $data->creatbycompany->nama_company }}</h4>
                    </div>
                    <div class="col-md-5 col-5 p-0">
                        <p class="m-0">{{ $data->creatbycompany->alamat_company }}</p>
                        <hr>
                        <p class="m-0">{{ $data->creatbycompany->email_company }}, 
                            <br>{{ $data->creatbycompany->telpon_company }}</p>
                        <p class="m-0"><a href="{{ $data->creatbycompany->website_company }}">{{ $data->creatbycompany->website_company }}</a></p>
                    </div>
                </div>
                <hr class="m-0 mt-5">
                <hr class="m-0 mt-1">
                <div class="row mt-10">
                    <div class="col-md-12 text-center">
                        <h2>SURAT PENGAJUAN</h2>
                    </div>
                    <div class="col-md-12 text-right">
                        {{-- <p>Bandung, {{ date('d F Y', strtotime($data->tanggal_pengajuan)) }}</p> --}}
                    </div>
                    <div class="col-md-12 mt-15">
                        <table class="w-100">
                            <tr>
                                <td width="10%"><p>Nomor</p></td>
                                <td width="5%">:</td>
                                <td width="820%"><p>{{ $data->no_surat }}</p></td>
                            </tr>
                            <tr>
                                <td><p>Perihal</p></td>
                                <td>:</td>
                                <td><p>{{ $data->perihal_surat }}</p></td>
                            </tr>
                            <tr>
                                <td><p>Lampiran</p></td>
                                <td>:</td>
                                <td><p>{{ $data->lampiran_surat }}</p></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12 mt-10">
                        <p>Kepada Yth,</p>
                        <p class="font-weight-bolder">{{ $data->penerimaTo->nama }} ({{ $data->penerimaTo->jabatan->nama }})</p>
                        <p>di</p>
                        <p>Tempat</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-10">
                        <p>Saya yang bertanda tangan dibawah ini:</p>
                        <table class="ml-15 w-100">
                            <tr>
                                <td width="10%"><p>Nama</p></td>
                                <td width="5%">:</td>
                                <td width="85%"><p>{{ $data->creatby->pegawai->nama }}</p></td>
                            </tr>
                            <tr>
                                <td ><p>Jabatan</p></td>
                                <td >:</td>
                                <td ><p>{{ $data->creatby->pegawai->jabatan->nama }}</p></td>
                            </tr>
                            <tr>
                                <td ><p>Peusahaan</p></td>
                                <td >:</td>
                                <td ><p>{{ $data->creatby->pegawai->company->nama_company }}</p></td>
                            </tr>
                        </table>
                            <p class="mb-1">Sesuai dengan informasi yang telah disampaikan, sekiranya ingin mengajukan dana sebesar <b> Rp. {{ number_format($data->total_nominal_pengajuan,2,',','.') }}</b> </p>
                            <p class="mt-1">Demikian surat pengajuan ini kami sampaikan dengan sebenarnya, atas perhatian dan kerjasamanya kami sampaikan terima kasih.</p>
                    </div>
                </div>
                <div class="row mt-10">
                    <div class="col-md-9">
                    </div>
                    <div class="col-md-3 text-center">
                        Bandung, {{ date('d F Y', strtotime($data->tanggal_pengajuan)) }}
                        <p class="mb-10">{{ $data->creatby->pegawai->company->nama_company }}</p>
                        <img src="{{ Storage::url($data->creatby->pegawai->ttd) }}" class="w-50" alt="">
    
                        <p class="mt-10">{{ $data->creatby->pegawai->nama }}</p>
                    </div>
                </div>
            </div>
            <div id="pengajuan" style="@media print(page-break-after: always;)"></div>
            <div class="pengajuan2 bg-white p-10 mt-2" id="pengajuan2" style="width: 21cm; height: 29cm; margin: 3cm 3cm 3cm 4cm;">
                @if ($data->status_pengajuan == 3)
                    <div class="row">
                        <div class="col-md-7 col-7">
                            <div class="col-md-5">
                                <div class="widger-logo bg-dark-o-50 p-3 rounded d-flex justify-content-center" style="overflow: hidden">
                                    <img src="{{ asset('assets/image/logo-dzawani-group.png') }}" alt="" class="mr-2" style="max-height: 7em;">
                                </div>
                            </div>
                            <h4 class="m-0">{{ $data->creatbycompany->nama_company }}</h4>
                        </div>
                        <div class="col-md-5 col-5 p-0">
                            <p class="m-0">{{ $data->creatbycompany->alamat_company }}</p>
                            <hr>
                            <p class="m-0">{{ $data->creatbycompany->email_company }}, 
                            <br>{{ $data->creatbycompany->telpon_company }}</p>
                            <p class="m-0"><a href="{{ $data->creatbycompany->website_company }}">{{ $data->creatbycompany->website_company }}</a></p>
                        </div>
                    </div>
                    <hr class="m-0 mt-5">
                    <hr class="m-0 mt-1">
                    <div class="row mt-lg-10">
                        <div class="col-md-12">
                            <h2>Rincian Pengajuan</h2>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Item</th>
                                        <th>Qty</th>
                                        <th>Merek/Vendor</th>
                                        <th>Estimasi Kebutuhan</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $bil = 1;
                                    @endphp
                                    @foreach ($data->detail_pengajuan as $det)
                                        <tr>
                                            <td class="text-center">{{ $bil++ }}</td>
                                            <td>{{ $det->item }}</td>
                                            <td class="text-center">{{ $det->jumlah_item_approved }}</td>
                                            <td>{{ $det->vendor }}</td>
                                            <td class="text-right">Rp. {{ number_format($det->budget,2,',','.') }}</td>
                                            <td class="text-right">Rp. {{ number_format($det->budget_approved,2,',','.') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" class="text-center"><b>Total</b></td>
                                        <td class="text-right"><b>Rp. {{ number_format($data->total_nominal_approved,2,',','.') }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 text-center">
                            {{-- <p>Bandung, {{ date('d F Y', strtotime($data->tanggal_pengajuan)) }}</p> --}}
                        </div>
                    </div>
                    <div class="row mt-30"></div>
                    <div class="row mt-39">
                        <div class="col-md-4 text-center">
                            <p class="mb-10">Diajukan,</p>

                            
                            <img src="{{ Storage::url($data->creatby->pegawai->ttd) }}" class="w-25" alt="">
                            <p class="mt-10 font-weight-bolder">{{ $data->creatby->pegawai->nama }}</p>
                            <p> {{ $data->creatby->pegawai->jabatan->nama }}</p>
                            {{-- <p>{{ $data->creatby->pegawai->company->nama_company }}</p> --}}
                        </div>
                        <div class="col-md-4 text-center">
                            <p class="mb-10">Mengetahui,</p>
                            
                            @php
                                $Mengetahui = \App\Models\User::query()->with(['pegawai', 'pegawai.jabatan', 'pegawai.company'])->where(['id' => $data->mengetahui])->get();
                                @endphp

                            @foreach ($Mengetahui as $me)
                                <img src="{{ Storage::url($me->pegawai->ttd) }}" class="w-25" alt="">
                                <p class="mt-10 font-weight-bolder">{{ $me->pegawai->nama }}</p>
                                <p> {{ $me->pegawai->jabatan->nama }}</p>
                                {{-- <p>{{ $me->pegawai->company->nama_company }}</p> --}}
                            @endforeach
                            

                        </div>
                        <div class="col-md-4 text-center">
                            <p class="mb-10">Menyetujui,</p>

                            @php
                                $menyetujui = \App\Models\User::query()->with(['pegawai', 'pegawai.jabatan', 'pegawai.company'])->where(['id' => $data->menyetujui])->get();
                            @endphp

                            @foreach ($menyetujui as $meny)
                                <img src="{{ Storage::url($meny->pegawai->ttd) }}" class="w-25" alt="">
                                <p class="mt-10 font-weight-bolder">{{ $meny->pegawai->nama }}</p>
                                <p> {{ $meny->pegawai->jabatan->nama }}</p>
                                {{-- <p>{{ $meny->pegawai->company->nama_company }}</p> --}}
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="button-print">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group text-center">
                        @if (Auth::user()->pegawai->company->id == 1)
                            <a href="{{ route('pengajuan_head.edit', $data->id) }}" class="btn btn-primary mt-3">Give Consent</a>
                            <button onclick="printContent('print-invoice')" class="btn btn-primary mt-3"> <i class="fa fa-print" aria-hidden="true"> Print</i></button>
                            @else
                            <button onclick="printContent('print-invoice')" class="btn btn-primary mt-3"> <i class="fa fa-print" aria-hidden="true"> Print</i></button>
                        @endif

                    </div>
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
      
      
      
      document.body.innerHTML = printcontent;
    //   document.body.style.marginLeft="auto";
    //   document.body.style.marginRight="auto";
    //   document.body.style.width="21cm";
    //   document.body.style.height="29cm";
    //   document.getElementById("pengajuan2").style.page_break_before="always";
    //   document.body.innerHTML = printcontent2;
    // window.location.replace("http://www.google.com");
      window.print();
      document.body.innerHTML = restorepage;
    //   document.body.style.padding="0";
    }
  </script>

@endpush