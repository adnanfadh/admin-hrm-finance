@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="breadcum">
        <div class="col-md-12">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
              <ol class="breadcrumb shadow-sm bg-white">
                <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">User Profile</li>
              </ol>
            </nav>

            {{-- @if ($message = Session::get('success'))
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
            @endif --}}
        </div>
    </div>

    <div class="content-body mt-10">
        <div class="col-md-12">
            <div class="row">
				<div class="col-4">
					<ul class="nav flex-column nav-pills bg-white p-5 rounded">
						<li class="nav-item mb-2">
							<div class="row">
                                <div class="col-md-12 justify-content-center">
                                    <div class="informasi d-flex flex-column">
                                        <div class="image-input image-input-outline image-input-circle d-flex flex-lg-row-fluid" id="kt_image_3">
                                            <div class="image-input-wrapper" style="background-image: url({{ Storage::url(Auth::user()->photo) }})"></div>

                                            <div class="keterangan ml-5 mt-5">
                                                <h3 class="text-gray-700">
                                                    {{ Auth::user()->pegawai->nama }}
                                                </h3>
                                                <span>
                                                    {{ Auth::user()->email }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
						</li>
                        <li class="nav-item mb-2 mt-5">
							<a class="nav-link active" id="profile-tab-5" data-toggle="tab" href="#profile-5">
								<span class="nav-icon">
                                    <i class="fas fa-user"></i>
								</span>
								<span class="nav-text">Personal Information</span>
							</a>
						</li>
						<li class="nav-item mb-2">
        					<a class="nav-link" id="account-tab-5" data-toggle="tab" href="#account-5" aria-controls="account">
								<span class="nav-icon">
                                    <i class="fas fa-user-edit"></i>
								</span>
								<span class="nav-text">Account Setting</span>
							</a>
						</li>
						{{-- <li class="nav-item">
							<a class="nav-link" id="banking-tab-5" data-toggle="tab" href="#banking-5" aria-controls="banking">
								<span class="nav-icon">
                                    <i class="fas fa-piggy-bank    "></i>
								</span>
								<span class="nav-text">Banking Setting</span>
							</a>
						</li> --}}
                        <li class="nav-item">
							<a class="nav-link" id="password-tab-5" data-toggle="tab" href="#password-5" aria-controls="password">
								<span class="nav-icon">
                                    <i class="fas fa-exchange-alt"></i>
								</span>
								<span class="nav-text">Change Password</span>
							</a>
						</li>
					</ul>
				</div>
			    <div class="col-8">
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
					<div class="tab-content" id="myTabContent5">
						<div class="tab-pane fade show active" id="profile-5" role="tabpanel" aria-labelledby="profile-tab-5">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label text-gray-600">
                                            <i class="fas fa-user text-gray mr-2"></i>
                                            Personal Information
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                              <label for="nip">Nip</label>
                                              <input type="text" name="" id="" class="form-control" value="{{ Auth::user()->pegawai->nip }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                              <label>Nama</label>
                                              <input type="text" name="" id="" class="form-control" value="{{ Auth::user()->pegawai->nama }}"  disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                              <label>Tempat Lahir</label>
                                              <input type="text" name="" id="" class="form-control" value="{{ Auth::user()->pegawai->tempat_lahir }}"  disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                              <label>Tanggal Lahir</label>
                                              <input type="text" name="" id="" class="form-control" value="{{ Auth::user()->pegawai->tanggal_lahir }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                              <label>Jenis Kelamin</label>
                                              @if (Auth::user()->pegawai->jenis_kelamin == "laki-laki")
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked disabled>
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                        Laki Laki
                                                        </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" disabled>
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                        Perempuan
                                                        </label>
                                                </div>
                                              @else
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" disabled>
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                        Laki Laki
                                                        </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" disabled checked>
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                        Perempuan
                                                        </label>
                                                </div>
                                              @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                              <label>Status</label>
                                              <input type="text" name="" id="" class="form-control" value="{{ Auth::user()->pegawai->status }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                              <label>Alamat</label>
                                              <input type="text" name="" id="" class="form-control" value="{{ Auth::user()->pegawai->alamat }}"  disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                              <label>No Telpon</label>
                                              <input type="text" name="" id="" class="form-control" value="{{ Auth::user()->pegawai->tlp }}"  disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                              <label>Bidang</label>
                                              <input type="text" name="" id="" class="form-control" value="{{ Auth::user()->pegawai->bidang->nama }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                              <label>Jabatan</label>
                                              <input type="text" name="" id="" class="form-control" value="{{ Auth::user()->pegawai->jabatan->nama }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="tab-pane fade" id="account-5" role="tabpanel" aria-labelledby="account-tab-5">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            <i class="fas fa-user-edit    mr-2"></i>
                                            Account Setting
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('user.update', Auth::user()->id) }}" method="post" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4 col-12">
                                                <div class="image-input image-input-outline" id="kt_image_1">
                                                    <div class="image-input-wrapper" style="@if (Auth::user()->photo)
                                    background-image: url('{{ Storage::url(Auth::user()->photo) }}')
                                @else
                                    background-color: #000;
                                @endif"></div>

                                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="photo" accept=".png, .jpg, .jpeg"/ >
                                                    <input type="hide" name="photo2" accept=".png, .jpg, .jpeg"/ value="{{ Auth::user()->photo }}">
                                                    </label>

                                                </div>
                                            </div>
                                            <div class="col-md-8 col-12">
                                                <div class="row">
                                                    <div class="col-12 col-md-12">
                                                        <div class="form-group">
                                                          <label for="email">Email</label>
                                                          <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" placeholder="" value="{{ Auth::user()->email }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="col-12 col-md-12">
                                                        <div class="form-group">
                                                          <label for="username">Username</label>
                                                          <input type="text" class="form-control" name="username" id="username"  placeholder="" value="{{ Auth::user()->username }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-end">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="submit" value="Submit" class="btn btn-primary">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
						{{-- <div class="tab-pane fade" id="banking-5" role="tabpanel" aria-labelledby="banking-tab-5">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            <i class="fas fa-user-edit    mr-2"></i>
                                            Account Setting
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="#" method="post">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="bank">Bank</label>
                                                    <select name="bank" id="bank" class="form-control">
                                                        <option value="1">MANDIRI</option>
                                                        <option value="2">BCA</option>
                                                        <option value="3">BRI</option>
                                                        <option value="4">BNI</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="atas_nama">Atas Nama</label>
                                                    <input type="text" name="atas_nama" id="atas_nama" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <label for="no_rek">No Rekening</label>
                                                <input type="text" name="no_rekening" id="no_rekening" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <input type="submit" value="Submit" class="btn btn-primary">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> --}}
                        <div class="tab-pane fade" id="password-5" role="tabpanel" aria-labelledby="password-tab-5">
                            <div class="card card-custom gutter-b">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            <i class="fas fa-exchange-alt  mr-2 "></i>
                                            Change Password
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('changePassword') }}" method="post" enctype="multipart/form-data">
                                        {{-- @method('PUT') --}}
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="col-md-8 col-12">
                                                <div class="form-group {{ $errors->has('current_password') ? ' has-error' : '' }}">
                                                    <label for="old-password">Old-Password</label>
                                                    <input id="current_password" type="password" class="form-control" name="current_password" required>
 
                                                    @if ($errors->has('current_password'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('current_password') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-8 col-12">
                                                <div class="form-group {{ $errors->has('new_password') ? ' has-error' : '' }}">
                                                    <label for="password">New-Password</label>
                                                    <input id="new_password" type="password" class="form-control" name="new_password" required>
 
                                                    @if ($errors->has('new_password'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('new_password') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-8 col-12">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirm Password</label>
                                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                                <div class="col-md-8 col-12 text-center">
                                                    <input type="submit" value="Submit" class="btn btn-primary">
                                                </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
					</div>
			    </div>
			</div>
        </div>
    </div>
</div>
@endsection

@push('addon-script')
    <script>
        var avatar1 = new KTImageInput('kt_image_1');
    </script>
@endpush