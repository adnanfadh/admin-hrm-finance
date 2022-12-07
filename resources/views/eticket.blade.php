<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Switch Template</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css?family=Heebo:400,700|IBM+Plex+Sans:600" rel="stylesheet">
    <link rel="stylesheet" href="/dist/css/style.css">
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

    <style>
        .ticket {
            font-family: Helvetica;
            margin: 0 auto 0 auto;
            max-width: 58mm;
            background-color: #ffffff;
            height: auto;
            display: flex;
            flex-direction: column;
            border-radius: 5px 5px 0 0;
            -webkit-print-color-adjust: exact;
        }
        
        .header {
            border-radius: 5px 5px 0 0;
            background-color: #c0c0c0;
            font-size: 5px;
            padding: 2px 2px 7px 2px;
            font-weight: 700;
            text-align: center;
            -webkit-print-color-adjust: exact;
        }
        
        .instansi {
            text-transform: uppercase;
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
            padding: 5px;
            border-radius: 5px 5px 0 0;
            margin-top: -5px;
            background-color: #424242;
            padding-bottom: 10px;
            -webkit-print-color-adjust: exact;
        }
        
        .instansi .logo img {
            max-width: 30px;
            /*background-color: #c0c0c0;
  font-size: 5px;*/
            height: auto;
        }
        
        .nama-instansi {
            color: #ffffff;
            font-size: 10px;
            margin: auto 0px;
        }
        
        .informasi {
            padding-top: 5px;
            border-radius: 5px 5px 0 0;
            margin-top: -5px;
            background-color: #ffffff;
            margin-bottom: 10px;
            -webkit-print-color-adjust: exact;
        }
        
        .informasi-ticket {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            height: auto;
            padding: 2px 15px;
            background-color: #ffffff;
            font-size: 7px;
            -webkit-print-color-adjust: exact;
        }
        
        .widget-barcode {
            margin: 0px 15px 5px 15px;
            display: flex;
            flex-direction: row;
        }
        
        .ket-barcode {
            margin-left: 10px;
            font-size: 5px;
        }
    </style>
</head>

<body class="is-boxed has-animations">
    <div class="body-wrap boxed-container">
        <main>
            <section class="section">
                <div class="container mb-5 mt-3 ">
                    {{--
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="box bg-white p-2 shadow rounded">
                                <div class="box-header m-0 p-0">
                                    <h1>Print Ticket</h1>
                                </div>
                                @foreach ($data as $d)
                                <div id="ticket">
                                    <div class="boarding-pass col-12 col-md-12 p-0">
                                        <div class="headere text-center">Boarding Pass</div>
                                        <section class="airport">

                                            <div class="ap1">
                                                <img src="https://drw-group.id/wp-content/uploads/2020/11/logo-drw-group.png" style="height: 100px">
                                            </div>

                                            <div class="ap2 mb-3">
                                                <h2>PT Dzawani Travelindo</h2>
                                            </div>

                                        </section>

                                        <section class="details">
                                            <div class="passenger">
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <h4>Nama :</h4>
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <h4>Tanggal Keberangkatan :</h4>
                                                    </div>
                                                </div>
                                                <div class="row mt-0">
                                                    <div class="col-5">
                                                        <h5 class="ml-2"><strong>{{$d['name']}}</strong></h5>
                                                    </div>
                                                    <div class="col-7">
                                                        <h5 class="ml-2">
                                                            {{$d['hari']}} ~ {{$d['tgl_keberangkatan']}} ~ {{$d['jam_keberangkatan']}}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <div class="row text-center">
                                            <div class="col">
                                                <div class="info">
                                                    <h4>Destinasi:</h4>
                                                    <h5>{{$d['destinasi']}}</h5>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="seat">
                                                    <h4>Kontingen:</h4>
                                                    <h5>{{$d['kontingen']}}</h5>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="gate">
                                                    <h4>Tanggal PCR:</h4>
                                                    <h5>{{$d['tgl_pcr']}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 mt-3 ml-2 justify-content-center text-center">
                                                <div class="barcode p-3 bg-light" style="border-radius: 5px ">
                                                    {!! QrCode::size(60)->generate($d['link'] . $d['id']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div> --}}

                    <div class="card border-0 shadow">
                        <div class="card-header p-3">
                            <h3 class="h3 m-0 text-gray-700">View Detail Data Peserta</h3>
                        </div>
                        <div class="card-body bg-white">
                            @foreach ($data as $d)

                            <div class="row">
                                <div class="show-ticket col-md-3 col-12 mt-2">
                                    <section class="ticket shadow" id="ticket">
                                        <div class="header">
                                            <div class="title">Boarding Pass</div>
                                        </div>
                                        <div class="instansi">
                                            <div class="logo">
                                                <img src="https://drw-group.id/wp-content/uploads/2020/11/logo-drw-group.png" />
                                            </div>
                                            <div class="nama-instansi">
                                                <div class="nama">PT Dzawani Travelindo</div>
                                            </div>
                                        </div>
                                        <div class="informasi">
                                            <div class="informasi-ticket">
                                                <div class="info">Kode</div>
                                                <div class="info-ket">2103090012</div>
                                            </div>
                                            <div class="informasi-ticket">
                                                <div class="info">Nama</div>
                                                <div class="info-ket">{{$d['name']}}</div>
                                            </div>
                                            <div class="informasi-ticket">
                                                <div class="info">Tgl Keberangkatan</div>
                                                <div class="info-ket">
                                                    {{$d['hari']}} ~ {{$d['tgl_keberangkatan']}} ~ {{$d['jam_keberangkatan']}}
                                                </div>
                                            </div>
                                            <div class="informasi-ticket">
                                                <div class="info">Destinasi</div>
                                                <div class="info-ket">{{$d['destinasi']}}</div>
                                            </div>
                                            <div class="informasi-ticket">
                                                <div class="info">Cabor</div>
                                                <div class="info-ket">{{ $d['cabor'] }}</div>
                                            </div>
                                            <div class="informasi-ticket">
                                                <div class="info">Tipe Kendaraan</div>
                                                <div class="info-ket">{{ $d['tipe_kendaraan'] }}</div>
                                            </div>
                                        </div>
                                        <div class="widget-barcode">
                                            <div class="barcode m-0">
                                                {!! QrCode::size(40)->generate($d['link'] . $d['id']) !!}
                                            </div>
                                            <div class="ket-barcode">
                                                <div class="mt-2 mb-0">scan qrode dengan aplikasi android untuk memastikan keaslian ticket</div>
                                            </div>
                                        </div>
                                    </section>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button onclick="printContent('ticket')" class="btn btn-primary mt-3"> <i class="fa fa-print" aria-hidden="true"></i>Print Ticket</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-peserta col-md-9 col-12 bg-light p-3 mt-2">

                                    <table class="table">
                                        <tr>
                                            <td>kode</td>
                                            <td>:</td>
                                            <td>{{ $d['kode_peserta'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>:</td>
                                            <td>
                                                @if ($d['status'] == '0')
                                                <span class="badge bg-success text-white p-2">Verified</span> @else
                                                <span class="badge bg-danger text-white p-2">Non-Verified</span> @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>:</td>
                                            <td>{{ $d['name'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Destinasi</td>
                                            <td>:</td>
                                            <td>{{ $d['destinasi'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kontingen</td>
                                            <td>:</td>
                                            <td>{{ $d['kontingen'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cabang Olahraga</td>
                                            <td>:</td>
                                            <td>{{ $d['cabor'] }}</td>
                                        </tr>
                                        {{--
                                        <tr>
                                            <td>Tanggal PCR</td>
                                            <td>:</td>
                                            <td>{{ $d['tgl_pcr'] }}</td>
                                        </tr> --}}
                                        <tr>
                                            <td>Hari berangkat</td>
                                            <td>:</td>
                                            <td>{{ $d['hari'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tangal berangkat</td>
                                            <td>:</td>
                                            <td>{{ $d['tgl_keberangkatan'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jam berangkat</td>
                                            <td>:</td>
                                            <td>{{ $d['jam_keberangkatan'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tipe Kendaraan</td>
                                            <td>:</td>
                                            <td>{{ $d['tipe_kendaraan'] }}</td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                            {{--
                            <div class="row">
                                <div class="col-md-6 col-12 mt-3">
                                    <a href="{{ route('peserta.index') }}" style="text-decoration:none" class="btn btn-primary mb-1"> <i class="fa fa-reply" aria-hidden="true"></i> Kembali</a>
                                    <a href="{{ route('peserta.edit', $d['id']) }}" style="text-decoration:none" class="btn btn-primary mb-1 ml-1"> <i class="fa fa-exchange" aria-hidden="true"></i> Edit</a>

                                </div>
                            </div> --}} @endforeach
                        </div>
                    </div>

                </div>
            </section>
        </main>

        <footer class="site-footer has-top-divider">
            <div class="container">
                <div class="site-footer-inner text-center">
                    <div class="footer-copyright">&copy; 2021 DTI, all rights reserved</div>
                </div>
            </div>
        </footer>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    {{--
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script> --}}

    <script>
        function printContent(el) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>


    <script src="/dist/js/main.min.js"></script>
</body>

</html>

{{-- nama destinasi kontingen tgl_pcr tgl_keberangkatan --}}