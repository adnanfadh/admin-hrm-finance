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
                    <li class="breadcrumb-item"><a href="{{ route('pengajuan.index') }}" style="text-decoration: none"> Pengajuan</a></li>
                    <li class="breadcrumb-item " aria-current="page">Track Pengajuan</li>
                    </ol>
                </nav>
            </div>
        </div>

        
        <div class="box bg-white p-3 shadow-sm rounded">
            <div class="row">
                <div class="col-md-12">
                    <table class="table tab-content">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td scope="row" class="font-size-h2-md">{{ date('d F Y,  H:i:s A', strtotime($d->tanggal_action)) }}</td>
                                        <td><span class="badge p-1 badge-primary font-size-h2-md">{{ $d->keterangan_track }}</span></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td scope="row"></td>
                                    <td></td>
                                    <td></td>
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
   
  </script>

@endpush