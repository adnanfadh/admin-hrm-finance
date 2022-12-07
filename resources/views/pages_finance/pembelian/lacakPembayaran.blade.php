@extends('layouts.app_finance')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb shadow-sm bg-white p-5">
                    <li class="breadcrumb-item"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pembelian.index') }}" style="text-decoration: none"> Pembelian</a></li>
                    <li class="breadcrumb-item " aria-current="page">Lacak Pembayaran</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong>{{ $message }}</strong>
                </div>
                <script>
                    Swal.fire({
                        type: 'success',
                        title: 'Success...',
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
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom gutter-b border-0 shadow">
                    <div class="card-header">
                        <div class="card-title w-100 d-flex flex-row justify-content-between">
                            <h3 class="card-label text-gray-700">Riwayat Pembayaran</h3>
                            <a href="{{ route('pembelian.index') }}" class="btn btn-dark ml-2"> <i class="fas fa-reply"></i>Back </a>
                        </div>
                    </div>
                    <div class="card-body pt-4 card-scroll">
                        @php
                                $no = 1; 
                                @endphp
                            @forelse ($data as $d)
                            <div class="timeline timeline-5 mt-3">
                                <!--begin::Item-->
                                <div class="timeline-item align-items-start">
                                    <!--begin::Label-->
                                    <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg">Pem ke-{{ $no++ }}</div>
                                    {{-- <!--end::Label-->{{ date('d F Y', strtotime($d->tanggal_bayar)); }} --}}
                                    <!--begin::Badge-->
                                    <div class="timeline-badge">
                                        <i class="fa fa-genderless text-warning icon-xl"></i>
                                    </div>
                                    <!--end::Badge-->
                                    <!--begin::Text-->
                                    <div class="font-weight-mormal font-size-lg timeline-content text-muted pl-3">

                                        <div class="table-responsive">
                                        <table class="table table-striped border-bottom border-3">
                                            <tbody>
                                            <tr>
                                                <td class="font-weight-bolder">Nominal</td>
                                                <td><i class="fas fa-arrow-circle-right"></i></td>
                                                <td class="d-flex flex-row">{{ "Rp. ".number_format($d->nominal_pembayaran,2,',','.'); }}  <small><span class="badge badge-pill badge-primary">{{ $d->jenis_pembayaran }}</span></small> <i class="fas fa-arrow-circle-right mx-2"></i>  
                                                    <form action="{{ url('fnc/pembayaranPembelian', $d->id) }}" method="POST">
                                                        @method('post')
                                                        @csrf
                                                        <input type="hidden" name="nominal_bayar" value="{{ $d->nominal_pembayaran }}">
                                                        <input type="hidden" name="account_bayar" value="{{ $d->account_pembayar }}">
                                                        <input type="hidden" name="id_pembelian" value="{{ $idData }}">
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                    <a href="{{ url('fnc/showjurnal_pembelian', $d->id) }}" class="btn btn-primary btn-sm ml-2">Show</a>
                                            </td>
                                                <tr>
                                                    <td class="font-weight-bolder">Keterangan</td>
                                                    <td><i class="fas fa-arrow-circle-right"></i></td>
                                                    <td class="d-flex flex-row">(<q> {{ $d->keterangan }} </q></q>)  </td>
                                                </tr>
                                            </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                    <!--end::Text-->
                                </div>
                            </div>
                            <!--end: Items-->
                            @empty
                            <div class="col-12 text-center bg-secondary rounded font-weight-bolder py-5" data-aos="fade-up" data-aos-delay="100">
                                Belum ada riwayat pembayaran
                              </div>
                            @endforelse
                            <!--end::Item-->
                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection