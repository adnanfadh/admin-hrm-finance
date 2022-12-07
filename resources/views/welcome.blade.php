<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Switch Template</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Heebo:400,700|IBM+Plex+Sans:600" rel="stylesheet">
    <link rel="stylesheet" href="/dist/css/style.css">
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

    <style>
        .form-control {
            width: 100%;
            padding: 0 10px;
            color: rgb(25, 0, 255);
            letter-spacing: 1px;
            border: none;
            box-shadow: 0 4px 2px -2px rgba(255, 255, 255, 0.5);
            border-bottom: 2px solid rgb(59, 37, 255);
            outline: none;
        }
    </style>
</head>
@php
    $cabor_mentah = ['Terjun Payung', 'Aeromodeling', 'Terbang Layang', 'Atletik', 'Bola Basket', 'Biliar', 'Panjat Tebing', 'Futsal', 'Bola Tangan', 'Judo', 'Tarung Derajat', 'Bermotor', 'Catur', 'Wushu', 'Anggar', 'Sepak bola Putri', 'Renang Perairan Terbuka', 'Angkat Besi', 'Angkat Berat', 'Binaraga', 'Softball', 'Voli Indoor', 'Voli Pasir', 'Canoeing', 'Rowing', 'Traditional Boat Race', 'Layar', 'Taekwondo', 'Karate', 'Pencak Silat', 'Selam Laut', 'Sepak Takraw', 'Sepatu Roda', 'Tenis', 'Bulutangkis', 'Tinju', 'Gantole', 'Paralayang', 'Loncat Indah', 'Renang', 'Renang Artistik', 'Polo Air', 'Hoki Outdoor-Indoor', 'Sotfball', 'Senam Aerobik', 'Senam Artistik', 'Senam Ritmik', 'Muaythai', 'Senam Kolam', 'Kempo', 'Rugby 7’S', 'Menembak', 'Kriket', 'Sepak bola', 'Panahan'];

    sort($cabor_mentah);

@endphp
<body class="is-boxed has-animations lights-off">
    <div class="body-wrap boxed-container">
        <header class="site-header">
            <div class="container">
                <div class="site-header-inner">
                    <div class="brand header-brand">

                    </div>
                </div>
            </div>
        </header>

        <main>
            {{-- <section class="hero">
                <div class="container">
                    <div class="hero-inner">
						<div class="hero-copy">
	                        <h1 class="hero-title mt-0">Selamat Datang!!!</h1>
	                        <p class="hero-paragraph">
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolore reiciendis iste laboriosam animi ea accusamus omnis ad architecto maiores. Ex minima aliquam ad animi accusantium quaerat voluptas nam laudantium explicabo?
                            </p>
	                        <div class="hero-cta">
								<a class="button button-primary" href="#daftar">Daftar</a>
								<div class="lights-toggle">
									<input id="lights-toggle" type="checkbox" name="lights-toggle" class="switch" checked="checked">
									<label for="lights-toggle" class="text-xs"><span>Turn me <span class="label-text">dark</span></span></label>
								</div>
							</div>
						</div>
						<div class="hero-media">
							<div class="header-illustration">
								<img class="header-illustration-image asset-light" src="dist/images/header-illustration-light.svg" alt="Header illustration">
								<img class="header-illustration-image asset-dark" src="dist/images/header-illustration-dark.svg" alt="Header illustration">
							</div>
							<div class="hero-media-illustration">
								<img class="hero-media-illustration-image asset-light" src="dist/images/hero-media-illustration-light.svg" alt="Hero media illustration">
								<img class="hero-media-illustration-image asset-dark" src="dist/images/hero-media-illustration-dark.svg" alt="Hero media illustration">
							</div>
							<div class="hero-media-container">
								<img class="hero-media-image asset-light" src="dist/images/hero-media-light.svg" alt="Hero media">
								<img class="hero-media-image asset-dark" src="dist/images/hero-media-dark.svg" alt="Hero media">
							</div>
						</div>
                    </div>
                </div>
            </section> --}}

			<section class="cta section" id="daftar">
                <div class="container-sm">
                    <div class="cta-inner section-inner">
                        <div class="cta-header text-center justify-content-center">
                            <h1 class="section-title mt-0">
                                Panca Group
                            </h1>
                            <h2 class="section-title mt-0">
                                Absen Pegawai
                            </h2>
                            <div class="col-12 col-md-10 box shadow rounded p-3 pt-5 pb-5 bg-transparent m-auto">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                                </div>
                                <script>
                                    Swal.fire({
                                        type: 'success',
                                        title: 'Selamat...',
                                        timer: 5000,
                                        text: '{{ $message }}'
                                    });
                                </script>
                            @endif

                                @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                                <script>
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops..',
                                        text: '{{ $message }}'

                                    });
                                </script>
                            @endif
                            <form class="form" action="/absensi" method="POST" >
                            @csrf
                                <div class="row text-left justify-content-center">
                                    <div class="col-12 col-md-10">
                                        <div class="form-group mt-3">
                                            <label for="name">Nomor Induk Pegawai :</label>
                                            <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}">
                                            @error('nip')
                                                <div class="alert alert-danger mt-1">
                                                {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="button button-primary btn-register mt-5">Absen</button>
                            </form>
                            </div>
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


    <script src="/dist/js/main.min.js"></script>
</body>
</html>

{{-- nama
destinasi
kontingen
tgl_pcr
tgl_keberangkatan --}}
