@extends('layouts.app') @push('addon-style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.css">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css"> @endpush @section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="col-12 col-md-12 col-lg-12">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white">
                <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Peserta</li>
            </ol>
        </nav>

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
        @endif @if ($message = Session::get('error'))
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

    <div class="content">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card border-0 shadow mb-4">
                <div class="card-header p-3">
                    <h3 class="h3 m-0 text-gray-700">List Peserta</h3>
                </div>
                <div class="card-body bg-white">
                    {{--
                    <a href="{{ route('peserta.create') }}" class="btn btn-primary mb-3"> <i class="fa fa-plus" aria-hidden="true"></i> Add Penilaian</a> --}}
                    <div class="table-responsive">
                        <table class="table table-hover table table-striped scroll-horizontal-vertical w-100" id="crudTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>kode</th>
                                    <th>nama</th>
                                    <th>destinasi</th>
                                    <th>cabor</th>

                                    <th>tgl berangkat</th>

                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 1; @endphp @foreach ($data as $pes)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $pes['kode_peserta'] }}</td>
                                    <td>{{ $pes['name'] }}</td>
                                    <td>{{ $pes['destinasi'] }}</td>
                                    <td>{{ $pes['cabor'] }}</td>

                                    <td>{{ $pes['tgl_keberangkatan'] }}</td>

                                    <td>
                                        @if ($pes['status'] == '0')
                                        <span class="badge bg-success text-white p-2">Verified</span> @else
                                        <span class="badge bg-danger text-white p-2">Non-Verified</span> @endif
                                    </td>
                                    <td>
                                        <div class="row">
                                            <a href="{{ route('peserta.show', $pes['id']) }}" style="text-decoration:none" class="btn btn-primary mb-1"> <i class="fa fa-eye" aria-hidden="true" title="Show Detail"></i></a>

                                            <form action="{{ route('verifikasi-peserta', $pes['id']) }}" method="POST">
                                                @method('PUT') @csrf()
                                                <button type="submit" class="btn btn-success mb-1 ml-1 mr-1">
                                              <i class="fa fa-check" aria-hidden="true" title="Verivikasi"></i>
                                            </button>
                                            </form>

                                            <form action="{{ route('peserta.destroy', $pes['id']) }}" method="POST">
                                                @method('delete') @csrf()
                                                <button type="submit" class="btn btn-danger" title="Delete" onclick="return confirm('Apakah Anda Yakin Untuk Hapus?')">
                                              <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@endsection @push('addon-script')

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>

<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#crudTable').DataTable({
            responsive: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>
@endpush