@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container">

          <!-- Page Heading -->
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
              <ol class="breadcrumb shadow-sm bg-white p-5 m-0">
                <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Roles</li>
              </ol>
            </nav>

          <div class="content">
              <div class="row">
                  <div class="col-md-8">
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

                      <div class="card card-custom gutter-b border-0 shadow">
                        <div class="card-header">
                          <div class="card-title w-100 d-flex flex-row justify-content-between">
                            <h3 class="card-label text-gray-700">List User</h3>
                            @can('rolesManagement-create')
                                <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
                            @endcan
                          </div>
                        </div>
                        <div class="card-body bg-white">
                          <div class="table-responsive">
                            <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Guard Name</th>
                                    <th>Action</th>
                                 </tr>
                                   @foreach ($roles as $key => $role)
                                   <tr>
                                       <td>{{ ++$i }}</td>
                                       <td>{{ $role->name }}</td> 
                                       <td>{{ $role->guard_name }}</td>
                                       <td>
                                           @can('rolesManagement-edit')
                                               <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                           @endcan
                                           @can('rolesManagement-delete')
                                               {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                                   {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                               {!! Form::close() !!}
                                           @endcan
                                       </td>
                                   </tr>
                                 @endforeach
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

{{-- @push('addon-script')

    <script>
        var datatable = $('#crudTable').DataTable({
          processing: true,
            serverSide: true,
            ordering: true,
            responsive: true,
            autoWidth : true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                { data: 'DT_RowIndex', name:'DT_RowIndex'},
                { data: 'names', name: 'names' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '15%'
                },
            ]
        });
    </script>
@endpush --}}