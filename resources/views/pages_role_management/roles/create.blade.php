@extends('layouts.app') 

@section('content')

<!-- Begin Page Content -->
<div class="container">

    <!-- Page Heading -->
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb shadow-sm bg-white p-5 m-0">
            <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}" style="text-decoration: none"> List Roles</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Role</li>
        </ol>
    </nav>

    <div class="content">
        <div class="card card-custom gutter-b border-0 shadow">
            <div class="card-header">
                <div class="card-title w-100 d-flex flex-row justify-content-between">
                    <h3 class="card-label text-gray-700">Add Data Role</h3>
                    @can('role-list')
                    <a class="btn btn-success" href="{{ route('roles.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Back</a> @endcan
                </div>
            </div>
            <div class="card-body bg-white">
                <div class="row">
                    <div class="col-md-12">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong> {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <strong>Permission:</strong>
                                <div class="box col-12">
                                    <ul class="nav nav-pills mb-5 justify-content-center" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="pills-list-tab" data-toggle="pill" href="#pills-list" role="tab" aria-controls="pills-list" aria-selected="true">List</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="pills-create-tab" data-toggle="pill" href="#pills-create" role="tab" aria-controls="pills-create" aria-selected="false">Create</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="pills-update-tab" data-toggle="pill" href="#pills-update" role="tab" aria-controls="pills-update" aria-selected="false">Update</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="pills-delete-tab" data-toggle="pill" href="#pills-delete" role="tab" aria-controls="pills-delete" aria-selected="false">Delete</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content bg-light rounded p-3" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-list" role="tabpanel" aria-labelledby="pills-list-tab">
                                            <div class="row mb-3">
                                                <div class="col-md-12 d-flex flex-row">
                                                    <input type="checkbox" class="form-check-inline mt-2" onchange="checkAll(this)" id="check_list" name="chk[]"><label for="check_list"><h3 class="font-weight-bold">Check All</h3></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @foreach ($permission_list as $value)
                                                    <div class="col-md-4 col-6">
                                                        <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name_list')) }} {{ $value->keterangan }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-create" role="tabpanel" aria-labelledby="pills-create-tab">
                                            <div class="row mb-3">
                                                <div class="col-md-12 d-flex flex-row">
                                                    <input type="checkbox" class="form-check-inline mt-2" onchange="checkAllCreate(this)" id="check_create" name="chk[]"><label for="check_create"><h3 class="font-weight-bold">Check All</h3></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @foreach ($permission_create as $value)
                                                    <div class="col-md-4 col-6">
                                                        <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name_create')) }} {{ $value->keterangan }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-update" role="tabpanel" aria-labelledby="pills-update-tab">
                                            <div class="row mb-3">
                                                <div class="col-md-12 d-flex flex-row">
                                                    <input type="checkbox" class="form-check-inline mt-2" onchange="checkAllEdit(this)" id="check_edit" name="chk[]"><label for="check_edit"><h3 class="font-weight-bold">Check All</h3></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @foreach ($permission_edit as $value)
                                                    <div class="col-md-4 col-6">
                                                        <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name_edit')) }} {{ $value->keterangan }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-delete" role="tabpanel" aria-labelledby="pills-delete-tab">
                                            <div class="row mb-3">
                                                <div class="col-md-12 d-flex flex-row">
                                                    <input type="checkbox" class="form-check-inline mt-2" onchange="checkAllDelete(this)" id="check_delete" name="chk[]"><label for="check_delete"><h3 class="font-weight-bold">Check All</h3></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @foreach ($permission_delete as $value)
                                                    <div class="col-md-4 col-6">
                                                        <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name_delete')) }} {{ $value->keterangan }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    @foreach($permission as $value)
                                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }} {{ $value->name }}</label>
                                    @endforeach
                                </div> --}}
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                            </div>
                        </div>
                        {!! Form::close() !!}

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
    function pilihsemua()
    {
        var daftarku = document.getElementsByName(permission[]”);
        var jml=daftarku.length;
        var b=0;
        for (b=0;b<jml;b++)
        {
            daftarku[b].checked=true;
            
        }
    }
</script>
<script type="text/javascript">
    function checkAll(ele) {
         var checkboxes = document.getElementsByClassName('name_list');
         if (ele.checked) {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox' ) {
                     checkboxes[i].checked = true;
                 }
             }
         } else {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox') {
                     checkboxes[i].checked = false;
                 }
             }
         }
     }
     function checkAllCreate(ele) {
         var checkboxes = document.getElementsByClassName('name_create');
         if (ele.checked) {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox' ) {
                     checkboxes[i].checked = true;
                 }
             }
         } else {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox') {
                     checkboxes[i].checked = false;
                 }
             }
         }
     }
     function checkAllEdit(ele) {
         var checkboxes = document.getElementsByClassName('name_edit');
         if (ele.checked) {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox' ) {
                     checkboxes[i].checked = true;
                 }
             }
         } else {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox') {
                     checkboxes[i].checked = false;
                 }
             }
         }
     }
     function checkAllDelete(ele) {
         var checkboxes = document.getElementsByClassName('name_delete');
         if (ele.checked) {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox' ) {
                     checkboxes[i].checked = true;
                 }
             }
         } else {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox') {
                     checkboxes[i].checked = false;
                 }
             }
         }
     }
   </script>
@endpush