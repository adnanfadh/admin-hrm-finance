@extends('layouts.app')

@section('content')
   <link
      rel="stylesheet"
      href="https://unpkg.com/swiper/swiper-bundle.min.css"
    />

    <!-- Begin Page Content -->
        <div class="container">

          <div class="content">
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

      {{--Bagian Atas  --}}
   <div class="card-body p-0 position-relative overflow-hidden"  style="margin-top:-2em;">
                    <!--begin::Chart-->
   <div  class="card-rounded bg-white">
    <div class="swiper mySwiper">
      <div class="swiper-wrapper my-5 mb-5">
        @php
            $pengumuman_get = \App\Models\Pengumumanhr::all();
        @endphp
        @forelse ($pengumuman_get as $item)
          <div class="swiper-slide px-6 ps-6 pe-6">
              <div class=" justify-content-center px-6 ps-6 pe-6">
                <h1 class="text-center">{{ $item->title }}</h1>
              <p class="text-center">{{ $item->tanggal }}	</p>
              <p class="text-center">
                {!! $item->description !!}
              </p></div>
            </div>
        @empty
        <div class="swiper-slide px-6 ps-6 pe-6">
          <div class=" justify-content-center px-6 ps-6 pe-6">
            <h1 class="text-center mt-3">Pengumuman belum ada</h1>
          </div>
        </div>
        @endforelse
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div>
        <br/>
          <div class="swiper-pagination mt-5"></div>
      </div>
    </div>
   </div>
   <br/>
        <div  class="card-rounded bg-white">
                    <!--end::Chart-->
                    <!--begin::Stats-->
                    <div class="card-spacer my-0 mx-5">
                        <!--begin::Row-->
                        <div class="row pt-5 justify-content-center">
                            <div class="col-lg-5 col-md-5 bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7">
                              <div class="d-flex justify-content-around">
                               <div>
                                <div class="d-flex justify-content-center">
                                  <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                              <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#ffc107"><path d="M9 13.75c-2.34 0-7 1.17-7 3.5V19h14v-1.75c0-2.33-4.66-3.5-7-3.5zM4.34 17c.84-.58 2.87-1.25 4.66-1.25s3.82.67 4.66 1.25H4.34zM9 12c1.93 0 3.5-1.57 3.5-3.5S10.93 5 9 5 5.5 6.57 5.5 8.5 7.07 12 9 12zm0-5c.83 0 1.5.67 1.5 1.5S9.83 10 9 10s-1.5-.67-1.5-1.5S8.17 7 9 7zm7.04 6.81c1.16.84 1.96 1.96 1.96 3.44V19h4v-1.75c0-2.02-3.5-3.17-5.96-3.44zM15 12c1.93 0 3.5-1.57 3.5-3.5S16.93 5 15 5c-.54 0-1.04.13-1.5.35.63.89 1 1.98 1 3.15s-.37 2.26-1 3.15c.46.22.96.35 1.5.35z"/></svg>																<!--end::Svg Icon-->
															</span></div>
                                <a href="#" class="text-warning font-weight-bold font-size-h6">Jumlah Pegawai</a>
                            </div>
                                <div class="align-items-center">
                                  <br/>
                                 <h1 class="font-weight-bolder text-info text-center">
                                    @php
                                    if(Auth::user()->pegawai->company->nama_company == "Panca Wibawa Global"){
                                        $pegawai = \App\Models\Pegawai::count();
                                        echo $pegawai - 1;
                                    }else{
                                        $pegawai = \App\Models\Pegawai::where('company_id', Auth::user()->pegawai->company_id)->count();
                                        echo $pegawai;
                                    }
                                    @endphp
                                  </h1>
                                 <p class="font-weight-bolder text-info text-center">pegawai</p>
                                </div>
                            </div>
                            </div>
                            <div class="col-lg-5 col-md-5 bg-light-primary px-6 py-8 rounded-xl mb-7">
                             <div class="d-flex justify-content-around">
                               <div>
                              <div class="d-flex justify-content-center">
                                <span class="svg-icon svg-icon-3x  d-block my-2">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
															<svg xmlns="http://www.w3.org/2000/svg"  height="24px" viewBox="0 0 24 24" width="24px" fill="#0d6efd"><g><g><rect height="1.5" width="4" x="14" y="12"/><rect height="1.5" width="4" x="14" y="15"/><path d="M20,7h-5V4c0-1.1-0.9-2-2-2h-2C9.9,2,9,2.9,9,4v3H4C2.9,7,2,7.9,2,9v11c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V9 C22,7.9,21.1,7,20,7z M11,7V4h2v3v2h-2V7z M20,20H4V9h5c0,1.1,0.9,2,2,2h2c1.1,0,2-0.9,2-2h5V20z"/><circle cx="9" cy="13.5" r="1.5"/><path d="M11.08,16.18C10.44,15.9,9.74,15.75,9,15.75s-1.44,0.15-2.08,0.43C6.36,16.42,6,16.96,6,17.57V18h6v-0.43 C12,16.96,11.64,16.42,11.08,16.18z"/></g></g></svg>
																<!--end::Svg Icon-->
															</span>
                            </div>
                                <a href="#" class="text-primary font-weight-bold font-size-h6">Jumlah Lembur</a>
                            </div>
                                <div class="align-items-center">
                                  <br/>
                                 <h1 class="font-weight-bolder text-warning text-center">
                                  @php
                                  $lembur = \App\Models\Lembur::where(['pegawai_id' => Auth::user()->pegawai->id])->count();
                                  @endphp
                                  {{ $lembur }}
                                 </h1>
                                 <p class="font-weight-bolder text-warning text-center">pegawai</p>
                                </div>
                            </div>
                            </div>
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row justify-content-center">
                            <div class="col-lg-5 col-md-5 bg-light-danger px-6 py-8 rounded-xl mt-2 mr-7">
                              <div class="d-flex justify-content-around">
                               <div>
                            <div class="d-flex justify-content-center">
                                <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
													    	<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#198754"><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7-.25c.22 0 .41.1.55.25.12.13.2.31.2.5 0 .41-.34.75-.75.75s-.75-.34-.75-.75c0-.19.08-.37.2-.5.14-.15.33-.25.55-.25zM19 19H5V5h14v14zM12 6c-1.65 0-3 1.35-3 3s1.35 3 3 3 3-1.35 3-3-1.35-3-3-3zm0 4c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-6 6.47V18h12v-1.53c0-2.5-3.97-3.58-6-3.58s-6 1.07-6 3.58zM8.31 16c.69-.56 2.38-1.12 3.69-1.12s3.01.56 3.69 1.12H8.31z"/></svg>
																<!--end::Svg Icon-->
															</span>
                            </div>
                                <a href="#" class="text-success font-weight-bold font-size-h6">Jumlah Cuti</a>
                            </div>
                                <div class="align-items-center">
                                  <br/>
                                 <h1 class="font-weight-bolder text-success text-center">
                                  @php
                                    $cuti = \App\Models\Cuti::where(['pegawai_id' => Auth::user()->pegawai->id])->count();
                                  @endphp
                                  {{ $cuti }}
                                 </h1>
                                 <p class="font-weight-bolder text-success text-center">pegawai</p>
                                </div>
                            </div>
                            </div>
                            <div class="col-lg-5 col-md-5 bg-light-success px-6 py-8  mt-2 rounded-xl">
                              <div class="d-flex justify-content-around">
                               <div>
                             <div class="d-flex justify-content-center">
                                <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M12.7037037,14 L15.6666667,10 L13.4444444,10 L13.4444444,6 L9,12 L11.2222222,12 L11.2222222,14 L6,14 C5.44771525,14 5,13.5522847 5,13 L5,3 C5,2.44771525 5.44771525,2 6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,13 C19,13.5522847 18.5522847,14 18,14 L12.7037037,14 Z" fill="#000000" opacity="0.3" />
																		<path d="M9.80428954,10.9142091 L9,12 L11.2222222,12 L11.2222222,16 L15.6666667,10 L15.4615385,10 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 L9.80428954,10.9142091 Z" fill="#000000" />
																	</g>
																</svg>
																<!--end::Svg Icon-->
															</span>
                            </div>
                                <a href="#" class="text-danger font-weight-bold font-size-h6">Jumlah Project</a>
                            </div>
                                <div class="align-items-center">
                                  <br/>
                                 <h1 class="font-weight-bolder text-danger text-center">
                                  @php
                                  $project = \App\Models\Project::where(['pegawai_id' => Auth::user()->pegawai->id])->count();
                                  @endphp
                                  {{ $project }}
                                 </h1>
                                 <p class="font-weight-bolder text-danger text-center">Project</p>
                                </div>
                            </div>
                            </div>
                        </div>
                        {{-- subdivisi --}}
                        <div class="row justify-content-center mt-5 px-5 ms-2">
                           <div class="col-lg-10 col-md-10 bg-info px-6 py-8 rounded-xl mt-2 mr-7 jus">
                              <div class="d-flex justify-content-around">
                               <div>
                                <div class="d-flex justify-content-center">
                                  <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
														    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#fff"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M18.36 9l.6 3H5.04l.6-3h12.72M20 4H4v2h16V4zm0 3H4l-1 5v2h1v6h10v-6h4v6h2v-6h1v-2l-1-5zM6 18v-4h6v4H6z"/></svg> 																<!--end::Svg Icon-->
														    	</span>
                                </div>
                                <a href="#" class="text-white font-weight-bold font-size-h6">Jumlah Company</a>
                               </div>
                                <div class="align-items-center">
                                  <br/>
                                 <h1 class="font-weight-bolder text-white text-center">{{$subunit = \App\Models\Company::count() }}
                                </h1>
                                 <p class="font-weight-bolder text-white text-center">Company</p>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Stats-->
                </div>
     {{-- List Gaji --}}
       <div class="card card-custom gutter-b border-0 shadow mt-5 ">
           <div class="card-header border-0 bg-danger py-5 ">
                  <div class="card-title">
                    <h3 class="card-title font-weight-bolder text-white">List Absen</h3>
                  </div>
                </div>
                <div class="card-body bg-white">
                  <div class="table-responsive">
                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Pegawai</th>
                          <th>Tanggal</th>
                          <th>Jam Masuk</th>
                          <th>Jam Keluar</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

      {{-- List Cuti  --}}
 <div class="card card-custom gutter-b border-0 shadow mt-5 ">
           <div class="card-header border-0 bg-primary py-5 ">
                  <div class="card-title">
                    <h3 class="card-title font-weight-bolder text-white">List Project</h3>
                  </div>
                </div>
                <div class="card-body bg-white">
                  <div class="table-responsive">
                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTableProject" >
                      <thead>
                      <tr>
                          <th>No</th>
                          <th>Title</th>
                          <th>Prioritas</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              {{-- list Gaji --}}
        <div class="card card-custom gutter-b border-0 shadow mt-5 ">
           <div class="card-header border-0 bg-success py-5 ">
                  <div class="card-title">
                    <h3 class="card-title font-weight-bolder text-white">List Cuti</h3>
                  </div>
                </div>
                 <div class="card-body bg-white">
                  <div class="table-responsive">
                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTableCuti">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Pegawai</th>
                          <th>Tanggal Mulai</th>
                          <th>Taggal Selesai</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
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

    <script>
        // AJAX DataTable
        var datatable = $('#crudTable').DataTable({
          processing: true,
            serverSide: true,
            ordering: true,
            responsive: true,
            autoWidth : true,
            ajax: {
                url: '{!! route("absen.index") !!}',
            },
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'pegawai.nama', name: 'pegawai.nama' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'jam_masuk', name: 'jam_masuk' },
                { data: 'jam_keluar', name: 'jam_keluar' },
                { data: 'keterangan', name: 'keterangan' }
            ]
        });

    var datatable1 = $('#crudTableCuti').DataTable({
          processing: true,
            serverSide: true,
            ordering: true,
            responsive: true,
            autoWidth : true,
            ajax: {
               url: '{!! route("cuti.index") !!}',
            },
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'pegawai.nama', name: 'pegawai.nama' },
                { data: 'tanggal_mulai', name: 'tanggal_mulai' },
                { data: 'tanggal_selesai', name: 'tanggal_selesai' },
                { data: 'keterangan', name: 'keterangan' },
            ]
        });

    var datatable2 = $('#crudTableProject').DataTable({
          processing: true,
            serverSide: true,
            ordering: true,
            responsive: true,
            autoWidth : true,
            ajax: {
                 url: '{!! route("project.index") !!}',
            },
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},

                { data: 'title',  name: 'title' },
                { data: 'prioritas',  name: 'prioritas' },
                { data: 'start_date',  name: 'start_date' },
                { data: 'end_date',  name: 'end_date' }
            ]
        });
    </script>

        <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
      var swiper = new Swiper(".mySwiper", {
        spaceBetween: 30,
        centeredSlides: true,
         loop: true,
        autoplay: {
          delay: 5500,
          disableOnInteraction: false,
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });
    </script>
@endpush
