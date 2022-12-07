
  <!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header header-fixed">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<!--begin::Header Menu Wrapper-->
							<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">

							</div>
							<!--end::Header Menu Wrapper-->
							<!--begin::Topbar-->
							<div class="topbar">
								<!--begin::User-->
								<div class="topbar-item">
									<div class="swich-account">
										@can('finance-list')
											<a href="/fnc/dashboard_finance" class="btn btn-primary"> <i class="fa fa-refresh" aria-hidden="true"></i>Switch Finance</a>
										@endcan
									</div>
									<div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
										<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
										<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ Auth::user()->pegawai->nama }}</span>
										<span class="symbol symbol-35 symbol-light-success">
											<span class="symbol-label font-size-h5 text-uppercase font-weight-bold">{{  substr(Auth::user()->pegawai->nama, 0 ,1) }}</span>
										</span>
									</div>
								</div>
								<!--end::User-->
							</div>
							<!--end::Topbar-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->

          <!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
				  <div class="subheader subheader-solid pl-5 pr-5" id="kt_subheader">
            		<marquee class="w-100" behavior="alternate" direction="left">
                        <h3 class="text-dark-25">Human Resource Management -
                            PT. {{Auth::user()->pegawai->company->nama_company}}
                        </h3>
           		    </marquee>
       			 </div>
						<!--end::Subheader-->
