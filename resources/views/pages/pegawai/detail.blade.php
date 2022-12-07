@extends('layouts.app')

@push('addon-style')
<script type="text/javascript" src="/assets/vendor/html2canvas/html2canvas-master/dist/html2canvas.js"></script>
@endpush

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Pegawai</li>
            </ol>
          </nav>

          <div class="row">
              <div class="col-md-12">
                  <div class="box rounded-top-xl bg-primary-o-45 px-5 py-10">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="title">
                                <h3 class="font-weight-bolder">Detail Pegawai</h3>
                                {{-- <small> --}}
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro quisquam asperiores nam ea quas hic harum id architecto, iusto aliquid dolores eligendi tempora dicta mollitia labore blanditiis ad illum aliquam?</p>
                                {{-- </small> --}}
                            </div>
                        </div>
                        <div class="col-md-2 text-right">
                            <a href="{{ route('pegawai.index') }}" class="btn btn-dark"> <i class="fa fa-reply" aria-hidden="true"></i> Back</a>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="box bg-success-o-30 rounded-bottom-xl p-5">
                            <div class="row">
                                <div class="col-md-7 mt-2">
                                    <div class="box bg-white shadow-sm rounded">
                                        <div class="Biodata-show p-3">
                                            <table class="table">
                                                <tr>
                                                    <td width="30%" class="font-size-h6-xl">Nama Pegawai</td>
                                                    <td width="5%" class="font-size-h6-xl font-weight-bolder">:</td>
                                                    <td class="font-size-h6-xl font-weight-bolder text-capitalize">{{ $pegawai->nama }} ({{ $pegawai->nip }})</td>
                                                </tr>
                                                {{-- <tr>
                                                    <td width="30%" class="font-size-h6-xl">Kode Pegawai</td>
                                                    <td width="5%" class="font-size-h6-xl font-weight-bolder">:</td>
                                                    <td class="font-size-h6-xl">{{ $pegawai->kode_pegawai }}</td>
                                                </tr> --}}
                                                <tr>
                                                    <td width="30%" class="font-size-h6-xl">TTL</td>
                                                    <td width="5%" class="font-size-h6-xl font-weight-bolder">:</td>
                                                    <td class="font-size-h6-xl"><span class="text-capitalize">{{ $pegawai->tempat_lahir }},</span> {{ date('d F Y', strtotime($pegawai->tanggal_lahir)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="30%" class="font-size-h6-xl">Jenis Kelamin</td>
                                                    <td width="5%" class="font-size-h6-xl font-weight-bolder">:</td>
                                                    <td class="font-size-h6-xl text-capitalize">{{ $pegawai->jenis_kelamin }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="30%" class="font-size-h6-xl">Status</td>
                                                    <td width="5%" class="font-size-h6-xl font-weight-bolder">:</td>
                                                    <td class="font-size-h6-xl text-capitalize">{{ $pegawai->jenis_kelamin }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="30%" class="font-size-h6-xl">No. Telpon</td>
                                                    <td width="5%" class="font-size-h6-xl font-weight-bolder">:</td>
                                                    <td class="font-size-h6-xl text-capitalize">{{ $pegawai->tlp }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="30%" class="font-size-h6-xl">Departement</td>
                                                    <td width="5%" class="font-size-h6-xl font-weight-bolder">:</td>
                                                    <td class="font-size-h6-xl text-capitalize">{{ $pegawai->bidang->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="30%" class="font-size-h6-xl">Jabatan</td>
                                                    <td width="5%" class="font-size-h6-xl font-weight-bolder">:</td>
                                                    <td class="font-size-h6-xl text-capitalize">{{ $pegawai->jabatan->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="30%" class="font-size-h6-xl">Alamat Lengkap</td>
                                                    <td width="5%" class="font-size-h6-xl font-weight-bolder">:</td>
                                                    <td class="font-size-h6-xl text-capitalize">{{ $pegawai->alamat }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 mt-2">
                                    <div class="box bg-white shadow-sm rounded p-3 overflow-hidden">
                                        <div class="barcode-show d-flex justify-content-center text-center" id="barcode-show">
                                            <div class="show">
                                                {{-- {!! DNS1D::getBarcodeHTML($pegawai->nip, 'C39E', 1.5, 50); !!} --}}
                                                
                                                @php
                                                    $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
                                                @endphp
                                                <img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($pegawai->nip, $generatorPNG::TYPE_CODE_128, 2, 70)) }}">
                                            </div>
                                        </div>
                                        {{-- <div class="button text-center mt-5">

                                            <button type='button' id='but_screenshot' class="btn btn-secondary" onclick='screenshot();'><i class="fa fa-camera" aria-hidden="true"></i> Take screenshot</button>
                                        </div> --}}
                                    </div>
                                    {{-- <div class="box bg-white rounded p-3 mt-3" id="result-screen">

                                    </div> --}}
                                </div>
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection


@push('addon-script')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type='text/javascript'>
    // $('#result-screen').hide();
        function screenshot(){
            $('#barcode-download').attr('download');
        //    html2canvas(document.getElementById('barcode-show')).then(function(canvas) {

        //     $('#result-screen').fadeIn(200);
        //     document.getElementById('result-screen').appendChild(canvas);

        //     var base64URL = canvas.toDataURL();
            // $.ajax({
            //    url: 'ajaxfile.php',
            //    type: 'post',
            //    data: {image: base64URL},
            //    success: function(data){
            //       console.log('Upload successfully');
            //    }
            // });
          });
        }
        </script>
@endpush
