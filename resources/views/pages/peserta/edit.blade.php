@extends('layouts.app') @section('content') @php $cabor_mentah = ['Terjun Payung', 'Aeromodeling', 'Terbang Layang', 'Atletik', 'Bola Basket', 'Biliar', 'Panjat Tebing', 'Futsal', 'Bola Tangan', 'Judo', 'Tarung Derajat', 'Bermotor', 'Catur', 'Wushu',
'Anggar', 'Sepak bola Putri', 'Renang Perairan Terbuka', 'Angkat Besi', 'Angkat Berat', 'Binaraga', 'Softball', 'Voli Indoor', 'Voli Pasir', 'Canoeing', 'Rowing', 'Traditional Boat Race', 'Layar', 'Taekwondo', 'Karate', 'Pencak Silat', 'Selam Laut', 'Sepak
Takraw', 'Sepatu Roda', 'Tenis', 'Bulutangkis', 'Tinju', 'Gantole', 'Paralayang', 'Loncat Indah', 'Renang', 'Renang Artistik', 'Polo Air', 'Hoki Outdoor-Indoor', 'Sotfball', 'Senam Aerobik', 'Senam Artistik', 'Senam Ritmik', 'Muaythai', 'Senam Kolam',
'Kempo', 'Rugby 7’S', 'Menembak', 'Kriket', 'Sepak bola', 'Panahan']; sort($cabor_mentah); @endphp

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb shadow-sm bg-white">
            <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Peserta</li>
        </ol>
    </nav>

    <div class="content mb-4">
        <div class="card border-0 shadow">
            <div class="card-header p-3">
                <h3 class="h3 m-0 text-gray-700">Edit Data Peserta</h3>
            </div>
            <div class="card-body bg-white">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('peserta.update', $peserta->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT') @csrf
                    <div class="row">
                        <div class="form-group mt-3 col-md-4">
                            <label for="kode_peserta">Kode Peserta:</label>
                            <input type="text" name="kode_peserta" id="kode_peserta" class="form-control @error('kode_peserta') is-invalid @enderror" value="{{ $peserta->kode_peserta }}" readonly> @error('kode_peserta')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mt-3">
                                <label for="name">Nama Lengkap:</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $peserta->name }}"> @error('name')
                                <div class="alert alert-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mt-3">
                                <label for="destinasi">Destinasi:</label>
                                <input type="text" name="destinasi" id="destinasi" class="form-control @error('destinasi') is-invalid @enderror" value="{{ $peserta->destinasi }}"> @error('destinasi')
                                <div class="alert alert-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mt-3">
                                <label for="kontingen">Kontingen:</label>
                                <input type="text" name="kontingen" id="kontingen" class="form-control @error('kontingen') is-invalid @enderror" value="{{ $peserta->kontingen }}"> @error('kontingen')
                                <div class="alert alert-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mt-3">
                                <label for="cabor">Cabang Olahraga:</label> {{-- <select name="cabor" id="cabor" class="form-control @error('cabor') is-invalid @enderror">
                              <option value="" selected disabled style="text-align: center">--Cabang Olahraga--</option>
                                @foreach ($cabor_mentah as $b)
                                  <option value="{{ $b }}" {{ old('cabor', $peserta->cabor) == $b ? 'selected' : '' }}>{{ $b}}</option>
                                @endforeach
                            </select> --}}
                                <input type="text" name="cabor" id="cabor" class="form-control @error('cabor') is-invalid @enderror" value="{{ $peserta->cabor }}"> @error('cabor')
                                <div class="alert alert-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{--
                        <div class="col-12 col-md-6">
                            <div class="form-group mt-3">
                                <label for="tgl_pcr">Tanggal PCR:</label>
                                <input type="date" name="tgl_pcr" id="tgl_pcr" class="form-control @error('tgl_pcr') is-invalid @enderror" value="{{ $peserta->tgl_pcr }}"> @error('tgl_pcr')
                                <div class="alert alert-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-12 col-md-12">
                            <div class="form-group mt-3">
                                <label for="tgl_keberangkatan">Tanggal Keberangkatan:</label>
                                <input type="date" name="tgl_keberangkatan" id="tgl_keberangkatan" class="form-control @error('tgl_keberangkatan') is-invalid @enderror" value="{{ $peserta->tgl_keberangkatan }}"> @error('tgl_keberangkatan')
                                <div class="alert alert-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mt-3">
                                <label for="jam_keberangkatan">Jam Keberangkatan:</label>
                                <input type="text" name="jam_keberangkatan" id="jam_keberangkatan" class="form-control @error('jam_keberangkatan') is-invalid @enderror" value="{{ $peserta->jam_keberangkatan }}"> @error('jam_keberangkatan')
                                <div class="alert alert-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mt-3">
                                <label for="tipe_kendaraan">Tipe Kendaraan:</label>
                                <input type="text" name="tipe_kendaraan" id="tipe_kendaraan" class="form-control @error('tipe_kendaraan') is-invalid @enderror" value="{{ $peserta->tipe_kendaraan }}"> @error('tipe_kendaraan')
                                <div class="alert alert-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row p-3 justify-content-md-start">
                            <a href="{{ route('peserta.show', $peserta->id) }}" style="text-decoration:none" class="btn btn-primary mr-1"> <i class="fa fa-reply" aria-hidden="true"></i> Kembali</a>
                            <input type="submit" value="submit" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@endsection