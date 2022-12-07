@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Slip Gaji</li>
            </ol>
          </nav>
          <div class="content mb-4">
            <div class="row">
              <div class="col-md-12">
                <div class="card bg-white rounded shadow-sm p-5" id="slip">
                  <table class="border-2 table table-bordered">
                    <tr>
                      <td colspan="6" class="text-center font-weight-bolder">{{ $data->pegawai->company->nama_company }}</td>
                    </tr>
                    <tr>
                      <td width="20%">Periode</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">{{ $data->periode }}</td>
                      <td width="20%">Nama</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">{{ $data->pegawai->nama }}</td>
                    </tr>
                    <tr>
                      <td width="20%">NIP</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">{{ $data->pegawai->nip }}</td>
                      <td width="20%">Jabatan</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">{{ $data->pegawai->jabatan->nama }}</td>
                    </tr>
                    <tr>
                      <td width="20%" colspan="3"></td>
                      <td width="20%">Divisi/Unit</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">{{ $data->pegawai->bidang->nama }}</td>
                    </tr>
                    <tr class="bg-dark-o-25">
                      <td width="20%" colspan="3" class="text-center font-weight-bolder">PENERIMAAN</td>
                      <td width="20%" colspan="3" class="text-center font-weight-bolder">POTONGAN</td>
                    </tr>
                    <tr>
                      <td width="20%">Gaji Pokok</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->gaji_pokok,2,',','.');}}</td>
                      <td width="20%">Pajak 21</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->pajak_21,2,',','.'); }}</td>
                    </tr>
                    <tr>
                      <td width="20%">Tunjangan Kerajinan</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->tunjangan_kerajinan,2,',','.');}}</td>
                      <td width="20%">Biaya Jabatan</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->biaya_jabatan,2,',','.');}}</td>
                    </tr>
                    <tr>
                      <td width="20%">Tunjangan Makanan</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->tunjangan_makan,2,',','.');}}</td>
                      <td width="20%">Tabungan</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->tabungan,2,',','.');}}</td>
                    </tr>
                    <tr>
                      <td width="20%">Tunjangan Jabatan</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->tunjangan_jabatan,2,',','.');}}</td>
                      <td width="20%">BPJS Kesehatan</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->bpjs_kesehatan,2,',','.');}}</td>
                    </tr>
                    <tr>
                      <td width="20%">Lembur Harian</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->lembur_harian,2,',','.');}}</td>
                      <td width="20%">bpjs_ketenagakerjaan</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->bpjs_ketenagakerjaan,2,',','.');}}</td>
                    </tr>
                    <tr>
                      <td width="20%">Lembur Hari Libur</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->lembur_hari_libur,2,',','.');}}</td>
                      <td width="20%">Potongan Lain-lain</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->potongan_lain_lain,2,',','.');}}</td>
                    </tr>
                    <tr>
                      <td width="20%">Lembur Event</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->lembur_event,2,',','.');}}</td>
                      <td width="20%" colspan="3"></td>
                    </tr>
                    <tr>
                      <td width="20%">Pejalanan Dinas</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->perjalanan_dinas,2,',','.');}}</td>
                      <td width="20%">Total Penerimaan</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->total_penerimaan,2,',','.');}}</td>
                    </tr>
                    <tr>
                      <td width="20%">Tunjanga Keluarga</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->tunjangan_keluarga,2,',','.');}}</td>
                      <td width="20%">Total Potongan</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%">Rp. {{ number_format($data->total_potongan,2,',','.');}}</td>
                    </tr>
                    <tr>
                      <td width="20%" colspan="4" class="text-center font-weight-bolder">TAKE HOME PAY</td>
                      <td width="5%" class="text-center">:</td>
                      <td width="25%" class="text-center font-weight-bolder"> Rp. {{ number_format($data->total_gaji_bersih,2,',','.');}}</td>
                    </tr>
                    <tr height="100px" style="vertical-align: middle;">
                      <td width="20%" class="text-center font-weight-bolder" style="vertical-align: middle;">NOTE</td>
                      <td width="5%" class="text-center" style="vertical-align: middle;">:</td>
                      <td width="25%" colspan="4" style="vertical-align: middle;word-wrap: break-word">{{ $data->catatan }}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-center">
                <button onclick="printContent('slip')" class="btn btn-primary mt-3"> <i class="fa fa-print" aria-hidden="true"> Print</i></button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->

@endsection
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
@push('addon-script')

@endpush
