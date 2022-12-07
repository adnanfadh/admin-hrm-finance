@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Month Riport</li>
            </ol>
          </nav>

          <div class="content mb-4">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="nav-wrapper">
                @include('pages.absen.navigasi')
              </div>
            </div>
              <div class="row">
                  <div class="col-md-4 col-12">
                    <div class="card card-custom gutter-b border-0 shadow">
                        <div class="card-header">
                          <div class="card-title">
                            <h3 class="card-label text-gray-700">Month Report</h3>
                          </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('result') }}" method="GET">
                              @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                         <div class="form-group justify-content-center">
                                            <label for="example-month-input" class="col-form-label">Month:</label>
                                            
                                            
                                            <div class="input-group" id='kt_daterangepicker_3'>
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                            </div>
                                            <input type="text" name="tanggal" class="form-control" placeholder="Email">
                                            </div>
    
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group justify-content-center">
                                            <label for="pegawai" class="col-form-label">Pegawai:</label>
                                            
                                            <select name="pegawai_id" id="pegawai_id" class="form-control">
                                                @foreach ($pegawai as $p)
                                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group text-center">
                                            <input type="submit" value="Submit" class="btn btn-primary">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                      </div>
                  </div>
                  <div class="col-md-8 col-12">
                      <div class="card card-custom gutter-b border-0 shadow">
                        <div class="card-header">
                          <div class="card-title">
                            <h3 class="card-label text-gray-700">List Bukti penggajian</h3>
                          </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover scroll-horizontal-vertical w-100">
                              <thead class="text-sm border-b select-none bg-primary-o-50 rounded-bottom">
                                <tr>
                                  {{-- <th class="px-6 py-3 font-bold text-center uppercase">No</th> --}}
                                  <th class="px-6 py-3 font-bold text-left uppercase">Nama Pegawai</th>
                                  <th class="px-6 py-3 font-bold text-left uppercase">Tanggal</th>
                                  <th class="px-6 py-3 font-bold text-left uppercase">Jam Masuk</th>
                                  <th class="px-6 py-3 font-bold text-left uppercase">Jam Keluar</th>
                                  <th class="px-6 py-3 font-bold text-left uppercase">Keterangan</th>
                                  {{-- <th class="px-6 py-3 font-bold text-right uppercase">Aksi</th> --}}
                                </tr>
                              </thead>
                              <tbody class="text-sm text-gray-700 bg-white divide-y divide-secondary-300">
                                @if ($total > 0)
                                @foreach ($absen as $gaj)
                                <tr>
                                  <td class="w-10 px-6 py-3 leading-6 sm:w-auto">{{ $gaj->pegawai->nama }}</td>
                                  <td class="px-6 py-3 leading-6">{{ $gaj->tanggal }}</td>
                                  <td class="px-6 py-3 leading-6">{{ $gaj->jam_masuk }}</td>
                                  <td class="px-6 py-3 leading-6">{{ $gaj->jam_keluar }}</td>
                                  <td class="px-6 py-3 leading-6">{{ $gaj->keterangan }}</td>
                                  {{-- <td class="px-6 text-right select-none whitespace-nowrap">
                                    
                                    <a class="btn-sm btn-primary" href="{{ route('absen.show', $gaj->id) }}">
                                      <i class="fas fa-print icon-sm-1x text-white"></i>
                                    </a>
                                  </td> --}}
                                </tr>
                                @endforeach
                                <tr class="font-weight-bolder text-center">
                                    <td colspan="3">Total Masuk</td>
                                    <td>:</td>
                                    <td>{{ $total }}</td>
                                </tr>
                                @else
                                <tr class="select-none text-center">
                                    <td colspan="6">
                                        <p>No data Search</p>
                                    </td>
                                </tr>
                                @endif
                              </tbody>
                            </table>
                        </div>
                      </div>
                  </div>
              </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection

@push('addon-script')
    <script>
        // Class definition

var KTBootstrapDaterangepicker = function () {

 // Private functions
 var demos = function () {
  // minimum setup
  $('#kt_daterangepicker_1, #kt_daterangepicker_1_modal').daterangepicker({
   buttonClasses: ' btn',
   applyClass: 'btn-primary',
   cancelClass: 'btn-secondary'
  });

  // input group and left alignment setup
  $('#kt_daterangepicker_2').daterangepicker({
   buttonClasses: ' btn',
   applyClass: 'btn-primary',
   cancelClass: 'btn-secondary'
  }, function(start, end, label) {
   $('#kt_daterangepicker_2 .form-control').val( start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
  });

  $('#kt_daterangepicker_2_modal').daterangepicker({
   buttonClasses: ' btn',
   applyClass: 'btn-primary',
   cancelClass: 'btn-secondary'
  }, function(start, end, label) {
   $('#kt_daterangepicker_2 .form-control').val( start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
  });

  // left alignment setup
  $('#kt_daterangepicker_3').daterangepicker({
   buttonClasses: ' btn',
   applyClass: 'btn-primary',
   cancelClass: 'btn-secondary'
  }, function(start, end, label) {
   $('#kt_daterangepicker_3 .form-control').val( start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
  });

  $('#kt_daterangepicker_3_modal').daterangepicker({
   buttonClasses: ' btn',
   applyClass: 'btn-primary',
   cancelClass: 'btn-secondary'
  }, function(start, end, label) {
   $('#kt_daterangepicker_3 .form-control').val( start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
  });


  // date & time
  $('#kt_daterangepicker_4').daterangepicker({
   buttonClasses: ' btn',
   applyClass: 'btn-primary',
   cancelClass: 'btn-secondary',

   timePicker: true,
   timePickerIncrement: 30,
   locale: {
    format: 'MM/DD/YYYY h:mm A'
   }
  }, function(start, end, label) {
   $('#kt_daterangepicker_4 .form-control').val( start.format('MM/DD/YYYY h:mm A') + ' / ' + end.format('MM/DD/YYYY h:mm A'));
  });

  // date picker
  $('#kt_daterangepicker_5').daterangepicker({
   buttonClasses: ' btn',
   applyClass: 'btn-primary',
   cancelClass: 'btn-secondary',

   singleDatePicker: true,
   showDropdowns: true,
   locale: {
    format: 'MM/DD/YYYY'
   }
  }, function(start, end, label) {
   $('#kt_daterangepicker_5 .form-control').val( start.format('MM/DD/YYYY') + ' / ' + end.format('MM/DD/YYYY'));
  });

  // predefined ranges
  var start = moment().subtract(29, 'days');
  var end = moment();

  $('#kt_daterangepicker_6').daterangepicker({
   buttonClasses: ' btn',
   applyClass: 'btn-primary',
   cancelClass: 'btn-secondary',

   startDate: start,
   endDate: end,
   ranges: {
   'Today': [moment(), moment()],
   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
   'This Month': [moment().startOf('month'), moment().endOf('month')],
   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
   }
  }, function(start, end, label) {
   $('#kt_daterangepicker_6 .form-control').val( start.format('MM/DD/YYYY') + ' / ' + end.format('MM/DD/YYYY'));
  });
 }

 return {
  // public functions
  init: function() {
   demos();
  }
 };
}();

jQuery(document).ready(function() {
 KTBootstrapDaterangepicker.init();
});
    </script>
@endpush