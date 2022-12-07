@extends('layouts.app_finance')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
@section('content')
<div class="container">
    <!--begin::Row-->
    <div class="card-rounded bg-white mb-5">
        <!--end::Chart-->
        <!--begin::Stats-->
        <div class="card-spacer ">
            <!--begin::Row-->
            <div class="row justify-content-end">
                <div class="col-md-4">
                    <div class="form-group">
                        @php $transdate = date('Y-m', time()); @endphp
                        <form id="DateFilterForm" name="DateFilterForm" class="form-horizontal">
                            <div class="input-group" id='kt_daterangepicker_6'>
                                <input type="text" name="tanggal_filter" class="form-control" id="tanggal_filter" placeholder="Filter By Date">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="col-lg-6 col-md-6 bg-primary px-6 py-8 rounded-xl mx-5">
                    <div class="d-flex justify-content-center ">
                        <div class="mx-5">
                            <div class="d-flex justify-content-center ">
                                <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">						<!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                     <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M11 17h2v-1h1c.55 0 1-.45 1-1v-3c0-.55-.45-1-1-1h-3v-1h4V8h-2V7h-2v1h-1c-.55 0-1 .45-1 1v3c0 .55.45 1 1 1h3v1H9v2h2v1zm9-13H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4V6h16v12z"/></svg>															</span></div>
                            <a href="#" class="text-white font-weight-bolder font-size-h6">Uang Masuk/Penerimaan</a>
                        </div>
                        <div class="align-items-center ">
                            <br/>
                            <h1 class="font-weight-bolderer text-white text-center">:</h1>
                        </div>
                        <div class="align-items-center mx-5 px-5">
                            <br/>
                            <h1 class="font-weight-bolderer text-white text-center" id="nominal_uang_masuk">Rp. {{ number_format($sum_uang_masuk ?? 0,2,',','.') }}</h1>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 col-md-6 bg-danger px-6 py-8 rounded-xl mx-5">
                    <div class="d-flex justify-content-center ">
                        <div class="mx-5">
                            <div class="d-flex justify-content-center ">
                                <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">						<!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M11 17h2v-1h1c.55 0 1-.45 1-1v-3c0-.55-.45-1-1-1h-3v-1h4V8h-2V7h-2v1h-1c-.55 0-1 .45-1 1v3c0 .55.45 1 1 1h3v1H9v2h2v1zm9-13H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4V6h16v12z"/></svg>															</span></div>
                            <a href="#" class="text-white font-weight-bolder font-size-h6">Uang Keluar/Pengeluaran</a>
                        </div>
                        <div class="align-items-center ">
                            <br/>
                            <h1 class="font-weight-bolderer text-primary text-white">:</h1>
                        </div>
                        <div class="align-items-center mx-5 px-5">
                            <br/>
                            <h1 class="font-weight-bolderer text-white text-center" id="nominal_uang_keluar">RP. {{ number_format($sum_uang_keluar ?? 0,2,',','.') }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Card Kedua --}}
            <div class="d-flex justify-content-center mt-5">
                <div class="col-lg-6 col-md-6 px-6 py-8 rounded-xl mx-5">
                    <div class="d-flex justify-content-center ">
                        <canvas id="myChart" height="150"></canvas>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 bg-white px-6 py-8 rounded-xl mx-5">
                    <div class="d-flex justify-content-center ">
                        <canvas id="myChart2" height="150"></canvas>
                    </div>
                </div>
            </div>

            {{-- card kedua --}}
        </div>
    </div>
    <div class="row">
        {{-- Penjualan dan pembelian --}}
        <div class="col-lg-6 col-xxl-4">
            <!--begin::Mixed Widget 1-->
            <div class="card card-custom">
                <!--begin::Body-->
                <!--begin::Chart-->
                <div>
                    <div class="bg-light-warning col-12 px-6 py-1 ">
                        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" 
                                                        fill="#FFA800">
                                                            <path d="M0 0h24v24H0V0z" fill="none"/>
                                                            <path d="M12.5 6.9c1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-.39.08-.75.21-1.1.36l1.51 1.51c.32-.08.69-.13 1.09-.13zM5.47 3.92L4.06 5.33 7.5 8.77c0 2.08 1.56 3.22 3.91 3.91l3.51 3.51c-.34.49-1.05.91-2.42.91-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c.96-.18 1.83-.55 2.46-1.12l2.22 2.22 1.41-1.41L5.47 3.92z"/>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                        <a href="#" class="text-warning font-weight-bolder font-size-h6 ml-4">Total Saldo (dalam IDR)</a>
                                        </span>
                    </div>
                    <div class="bg-light-white col-12 px-6 py-1 ">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="text-muted mt-3 font-weight-bolder font-size-sm text-dark">Total</span><br/>
                            <span class="font-weight-bolderer text-dark" id="total_saldo">Rp. {{ number_format($total_saldo ?? 0,2,',','.') }}</span>
                        </h3>
                    </div>
                </div>

                <div class="">
                    <div class="bg-light-danger col-12 px-6 py-1 ">
                        <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#F64E60">
                                                            <path d="M0 0h24v24H0V0z" fill="none"/>
                                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                        <a href="#" class="text-danger font-weight-bolder font-size-h6 ml-4">Total Assets (dalam IDR)</a>
                                        </span>
                    </div>
                    <div class="bg-light-white col-12 px-6 py-1 ">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="text-muted mt-3 font-weight-bolder font-size-sm text-dark">Total</span><br/>
                            <span class="font-weight-bolderer text-dark" id="total_asset">Rp. {{ number_format($nominal_asset ?? 0,2,',','.') }}</span>
                        </h3>
                    </div>
                </div>
                <!--end::Chart-->
                {{--
                <div class="">
                    <div class="bg-light-success col-12 px-6 py-1 ">
                        <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#1BC5BD">
                                                            <path d="M0 0h24v24H0V0z" fill="none"/>
                                                            <path d="M11 17h2v-1h1c.55 0 1-.45 1-1v-3c0-.55-.45-1-1-1h-3v-1h4V8h-2V7h-2v1h-1c-.55 0-1 .45-1 1v3c0 .55.45 1 1 1h3v1H9v2h2v1zm9-13H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4V6h16v12z"/>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                        <a href="#" class="text-success font-weight-bolder font-size-h6 ml-4">Pelunasan Diterima (dalam IDR)</a>
                                        </span>
                    </div>
                    <div class="bg-light-white col-12 px-6 py-1 ">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="text-muted mt-3 font-weight-bolder font-size-sm text-dark">Total</span><br/>
                            <span class="font-weight-bolderer text-dark">Rp. {{ number_format($sum_uang_masuk ?? 0,2,',','.') }}</span>
                        </h3>
                    </div>
                </div> --}}
                <!--end::Chart-->
                <!--end::Stats-->
                <!--end::Body-->
            </div>
            <!--end::Mixed Widget 1-->
        </div>
        <div class="col-lg-6 col-xxl-4">
            <!--begin::Mixed Widget 1-->
            <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                <!--begin::Body-->

                <!--begin::Chart-->
                <div>
                    <div class="bg-light-warning col-12 px-6 py-1 ">
                        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" 
                                                        fill="#FFA800">
                                                            <path d="M0 0h24v24H0V0z" fill="none"/>
                                                            <path d="M12.5 6.9c1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-.39.08-.75.21-1.1.36l1.51 1.51c.32-.08.69-.13 1.09-.13zM5.47 3.92L4.06 5.33 7.5 8.77c0 2.08 1.56 3.22 3.91 3.91l3.51 3.51c-.34.49-1.05.91-2.42.91-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c.96-.18 1.83-.55 2.46-1.12l2.22 2.22 1.41-1.41L5.47 3.92z"/>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                        <a href="#" class="text-warning font-weight-bolder font-size-h6 ml-4">Total Piutang (dalam IDR)</a>
                                        </span>
                    </div>
                    <div class="bg-light-white col-12 px-6 py-1 ">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="text-muted mt-3 font-weight-bolder font-size-sm text-dark">Total</span><br/>
                            <span class="font-weight-bolderer text-dark" id="total_piutang">Rp. {{ number_format($piutang ?? 0,2,',','.') }}</span>
                        </h3>
                    </div>
                </div>

                <div class="">
                    <div class="bg-light-danger col-12 px-6 py-1 ">
                        <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#F64E60">
                                                            <path d="M0 0h24v24H0V0z" fill="none"/>
                                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                        <a href="#" class="text-danger font-weight-bolder font-size-h6 ml-4">Total Hutang (dalam IDR)</a>
                                        </span>
                    </div>
                    <div class="bg-light-white col-12 px-6 py-1 ">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="text-muted mt-3 font-weight-bolder font-size-sm text-dark">Total</span><br/>
                            <span class="font-weight-bolderer text-dark" id="total_hutang">Rp. {{ number_format($hutang ?? 0,2,',','.') }}</span>
                        </h3>
                    </div>
                </div>
                <!--end::Chart-->
                <div class="">
                    <div class="bg-light-success col-12 px-6 py-1 ">
                        <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#1BC5BD">
                                                            <path d="M0 0h24v24H0V0z" fill="none"/>
                                                            <path d="M11 17h2v-1h1c.55 0 1-.45 1-1v-3c0-.55-.45-1-1-1h-3v-1h4V8h-2V7h-2v1h-1c-.55 0-1 .45-1 1v3c0 .55.45 1 1 1h3v1H9v2h2v1zm9-13H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4V6h16v12z"/>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                        <a href="#" class="text-success font-weight-bolder font-size-h6 ml-4">Total Kasbon (dalam IDR)</a>
                                        </span>
                    </div>
                    <div class="bg-light-white col-12 px-6 py-1 ">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="text-muted mt-3 font-weight-bolder font-size-sm text-dark">Total</span><br/>
                            <span class="font-weight-bolderer text-dark">Rp. {{ number_format($kasbon ?? 0,2,',','.') }}</span>
                        </h3>
                    </div>
                </div>
                <!--end::Chart-->
                <!--end::Stats-->
                <!--end::Body-->
            </div>
            <!--end::Mixed Widget 1-->
        </div>

        {{-- End Penjualan dan pembelian --}}


        <!--end::Table-->
    </div>
</div>
<!--end::Body-->
</div>
<!--end::Advance Table Widget 4-->
</div>
</div>
<!--end::Row-->
</div>
@endsection @push('addon-script')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>   --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script> --}}
<script>
    var statistics_chart_2 = document.getElementById("myChart").getContext('2d');

    var myChart = new Chart(statistics_chart_2, {
        type: 'line',
        data: {
            labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
            datasets: [{
                label: 'Statistics',
                data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
                borderWidth: 4,
                borderColor: '#6777ef',
                backgroundColor: 'transparent',
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6777ef',
                pointRadius: 5
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        stepSize: 10
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    }
                }]
            },
        }
    });
</script>

<script>
    var statistics_chart_2 = document.getElementById("myChart2").getContext('2d');

    var myChart = new Chart(statistics_chart_2, {
        type: 'line',
        data: {
            labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
            datasets: [{
                label: 'Statistics',
                data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
                borderWidth: 4,
                borderColor: '#6777ef',
                backgroundColor: 'transparent',
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6777ef',
                pointRadius: 5
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        stepSize: 10
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    }
                }]
            },
        }
    });
</script>



{{-- script date range picker --}}

<script>

    var KTBootstrapDaterangepicker = function() {

        // Private functions
        var demos = function() {
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
                $('#kt_daterangepicker_6 .form-control').val(start.format('MM/DD/YYYY') + ' s/d ' + end.format('MM/DD/YYYY'));
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