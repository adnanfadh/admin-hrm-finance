@extends('layouts.app')

@push('addon-style')
<link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">

<style>

.ticket {
  font-family: Helvetica;
  margin: 0 auto 0 auto;
  max-width: 100%;
  background-color: #ffffff;
  height: auto;
  display: flex;
  flex-direction: column;
  border-radius: 5px 5px 0 0;
  -webkit-print-color-adjust: exact; 
}
/* @media print {
        html, body {
            width: 210mm;
            height: 297mm;        
        }
        .ticket {
            margin: 0;
            border: initial;
            border-radius: initial;
            max-width: 58mm;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
      } */
.header {
  border-radius: 5px 5px 0 0;
  background-color: #fff;
  font-size: 40px;
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
  max-width: 100px;
  /*background-color: #c0c0c0;
  font-size: 5px;*/
  height: auto;
}
.nama-instansi {
  color: #ffffff;
  font-size: 70px;
  margin: auto 0px;
}
.informasi{
  padding-top: 5px;
  border-radius: 5px 5px 0 0;
  margin-top: -5px;
  background-color: #ffffff;
  margin-bottom: 15px;
  -webkit-print-color-adjust: exact;
}
.informasi-ticket {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  height: auto;
  padding: 5px 15px;
  background-color: #ffffff;
  font-size: 25px;
  -webkit-print-color-adjust: exact;
}

.widget-barcode{
  margin: 0px 15px 5px 15px;
  display: flex;
  flex-direction: row;
}
.ket-barcode{
  margin-left: 10px;
  font-size: 15px;
}
</style>
@endpush

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">View Data Peserta</li>
            </ol>
          </nav>

          <div class="content mb-4">
            <div class="card border-0 shadow">
              <div class="card-header p-3">
                <h3 class="h3 m-0 text-gray-700">View Detail Data Peserta</h3>
              </div>
              <div class="card-body bg-white">
                @foreach ($data as $d)
                
                <div class="row">
                  <div class="show-ticket col-md-12 col-12 mt-2">
                    <section class="ticket shadow" id="ticket2" name="ticket2">
                      <div class="header">
                        <div class="title">Boarding Pass</div>
                      </div>
                      <div class="instansi">
                        <div class="logo">
                          <img
                            src="https://drw-group.id/wp-content/uploads/2020/11/logo-drw-group.png"
                          />
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
                            {{$d['hari']}} ~
                            {{$d['tgl_keberangkatan']}} ~ 
                            {{$d['jam_keberangkatan']}}
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
                              {!! QrCode::size(200)->generate($d['link'] . $d['id']) !!}
                          </div>
                          <div class="ket-barcode">
                            <div class="mt-2 mb-0">scan qrode dengan aplikasi android untuk memastikan keaslian ticket</div>
                          </div>
                        </div>
                    </section>
                    <div class="row">
                      <div class="col-md-12 text-center">
                        <button onclick="printContent('ticket2')" class="btn btn-primary mt-3"> <i class="fa fa-print" aria-hidden="true"> Print Ticket</i></button>
                        <button onclick="printTicket()" class="btn btn-primary mt-3"> <i class="fa fa-print" aria-hidden="true"> Print Ticket2</i></button>
                      </div>
                    </div>
                  </div>
                  <div class="detail-peserta col-md-9 col-12 bg-light p-3 mt-2">
                    
                        <table class="table">
                            <tr>
                              <td>kode peserta</td>
                              <td>:</td>
                              <td>{{ $d['kode_peserta'] }}</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>
                                @if ($d['status'] == '0')
                                  <span class="badge bg-success text-white p-2">Verified</span>
                                @else
                                  <span class="badge bg-danger text-white p-2">Non-Verified</span>
                                @endif
                              </td>
                            </tr>
                            <tr>
                              <td>Nama Peserta</td>
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
                            {{-- <tr>
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
                    <div class="row">
                          <a href="{{ route('peserta.index') }}" style="text-decoration:none" class="btn btn-primary mb-1 mt-1"> <i class="fa fa-reply" aria-hidden="true"> Kembali</i></a>
                          <a href="{{ route('peserta.edit', $d['id']) }}" style="text-decoration:none" class="btn btn-primary mb-1 ml-1 mt-1"> <i class="fa fa-paint-brush" aria-hidden="true"> Edit</i></a>
                          <form action="{{ route('verifikasi-peserta', $d['id']) }}" method="POST">
                            @method('PUT') 
                            @csrf()
                                <button type="submit" class="btn btn-success mt-1 ml-1">
                                  <i class="fa fa-check" aria-hidden="true" title="Verifikasi"> Verifikasi</i>
                                </button>
                            </form>
                    </div>
                    
                    
                @endforeach
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        

@endsection

@push('addon-script')
  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script> --}}
  <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

  <script>
    function printContent(el){
      var restorepage = document.body.innerHTML;
      var printcontent = document.getElementById(el).innerHTML;
      // document.body.style.width="48mm";
      document.body.innerHTML = printcontent;
      window.print();
      // window.frames["ticket2"].window.print();
      document.body.innerHTML = restorepage;
    }
  </script>

  <script>
    function printTicket(){
      printJS({
        printable: 'ticket2',
        type: 'html',
        targetStyles: ['*'],
        header: 'prinin'
      })
    }
  </script>

@endpush