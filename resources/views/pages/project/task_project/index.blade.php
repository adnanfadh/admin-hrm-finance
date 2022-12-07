@extends('layouts.app')


@push('addon-style')
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" /> --}}
@endpush
@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="col-12 col-md-12 col-lg-12">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
              <ol class="breadcrumb shadow-sm bg-white p-5">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none text-light-dark-75"><i class="fa fa-home" aria-hidden="true"> </i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('project.index') }}" class="text-decoration-none text-light-dark-75">Project</a></li>
                <li class="breadcrumb-item active" aria-current="page">Task Project</li>
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

          <div class="content pt-0">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-custom gutter-b border-0 shadow">
                    <div class="card-header bg-info">
                        <div class="card-title d-flex w-100 flex-row justify-content-between">
                            <div class="title text-black-40">
                                <h2 class="text-white">Detail Information Project</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach ($project as $p)
                        <table class="w-100">
                            <tr>
                                <td width="20%"><h5>Client</h5></td>
                                <td><h5>:</h5></td>
                                <td><h5 class="text-black-50">{{ $p->client->name }}</h5></td>
                            </tr>
                            <tr>
                                <td><h5>Project Title</h5></td>
                                <td><h5>:</h5></td>
                                <td><h5 class="text-black-50">{{ $p->title }}</h5></td>
                            </tr>
                            <tr>
                                <td><h5>Status Project</h5></td>
                                <td><h5>:</h5></td>
                                <td><h5 class="text-black-50">
                                    @if ($p->status_project == 0)
                                        <span class="label label-inline label-lg font-weight-bold label-rounded label-dark p-5"><h5>Backlog</h5></span>
                                    @endif
                                    @if ($p->status_project == 1)
                                        <span class="label label-inline label-lg font-weight-bold label-rounded label-primary p-5"><h5>To Do</h5></span>
                                    @endif
                                    @if ($p->status_project == 2)
                                        <span class="label label-inline label-lg font-weight-bold label-rounded label-success p-5"><h5>Done</h5></span>
                                    @endif
                                </h5></td>
                            </tr>
                            <tr>
                                <td><h5>Tanggal Pengerjaan</h5></td>
                                <td><h5>:</h5></td>
                                <td><h5 class="text-black-50">{{ date('d F Y', strtotime($p->start_date)) }}  -  {{ date('d F Y', strtotime($p->end_date)) }}</h5></td>
                            </tr>
                             <tr>
                                <td><h5>Prioritas Project</h5></td>
                                <td><h5>:</h5></td>
                                <td><h5 class="text-black-50">
                                    @if ($p->prioritas == 0)
                                        <span class="label label-inline label-lg font-weight-bold label-rounded label-success p-5"><h5>Low Priority</h5></span>
                                    @endif
                                    @if ($p->prioritas == 1)
                                        <span class="label label-inline label-lg font-weight-bold label-rounded label-primary p-5"><h5>Medium Priority</h5></span>
                                    @endif
                                    @if ($p->prioritas == 2)
                                        <span class="label label-inline label-lg font-weight-bold label-rounded label-danger p-5"><h5>High Priority</h5></span>
                                    @endif
                                </h5></td>
                            </tr>
                            <tr>
                                <td><h5>Ringkasan Project</h5></td>
                                <td><h5>:</h5></td>
                                <td><h5 class="text-black-50">{{ $p->ringkasan_project }}</h5></td>
                            </tr>
                            <tr>
                                <td><h5>Description</h5></td>
                                <td><h5>:</h5></td>
                                <td><h5 class="text-black-50">{{ $p->description }}</h5></td>
                            </tr>
                        </table>
                        @endforeach
                    </div>
                </div>
              <div class="card card-custom gutter-b border-0 shadow">
                <div class="card-header">
                  <div class="card-title d-flex w-100 flex-row justify-content-between">
                    <div class="title">
                        <h3 class="card-label text-gray-700">List Task Project</h3>
                    </div>
                    {{-- <a href="{{ route('project.create') }}" class="btn btn-primary">Add Task</a> --}}
                    <!-- Button trigger modal-->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Add Task
                    </button>
                  </div>
                </div>
                <div class="card-body bg-white">
                  <div class="row">
                      <div class="col-md-4">
                        <div class="card">
                            <div class="card-header text-center bg-gray-500">
                                <h3>Backlog</h3>
                            </div>
                            <ul class="list-group list-group-flush">
                                @forelse ($task_project_0 as $task0)
                                <li class="list-group-item bg-gray-300 d-flex flex-row justify-content-between mt-1">
                                    <h5>{{ $task0->task }}</h5>
                                    <div class="aksi d-flex flex-row">
                                        {{-- <a href="javascript:void(0)" id="edit" data-id="{{ $task0->id }}" class="btn btn-info">Edit</a> --}}
                                        <a href="{{ route('taskproject.edit', $task0->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-pencil-alt    "></i>
                                        </a>
                                        <form action="{{ route('taskproject.destroy', $task0->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                            <button type="submit" class="btn btn-danger btn-sm ml-1">
                                                <i class="fas fa-trash    "></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                                @empty
                                    <li class="list-group-item bg-gray-300 d-flex flex-row justify-content-center mt-1">
                                        --task not found--
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                      </div>
                      <div class="col-md-4">
                          <div class="card">
                            <div class="card-header text-center bg-warning-o-100">
                                <h3>Doing</h3>
                            </div>
                            <ul class="list-group list-group-flush">
                                @forelse ($task_project_1 as $task1)
                                <li class="list-group-item bg-warning-o-40 d-flex flex-row justify-content-between mt-1">
                                    <h5>{{ $task1->task }}</h5>
                                    <div class="aksi d-flex flex-row">
                                        <a href="{{ route('taskproject.edit', $task1->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-pencil-alt "></i>
                                        </a>
                                        <form action="{{ route('taskproject.destroy', $task1->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                            <button type="submit" class="btn btn-danger btn-sm ml-1">
                                                <i class="fas fa-trash    "></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                                    
                                @empty
                                    <li class="list-group-item bg-warning-o-40 d-flex flex-row justify-content-center mt-1">
                                        --task not found--
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="card">
                            <div class="card-header text-center bg-success-o-100">
                                <h3>Done</h3>
                            </div>
                            <ul class="list-group list-group-flush">
                                @forelse ($task_project_2 as $task2)
                                <li class="list-group-item bg-success-o-40 d-flex flex-row justify-content-between mt-1">
                                    <h5>{{ $task2->task }}</h5>
                                    <div class="aksi d-flex flex-row">
                                        <a href="{{ route('taskproject.edit', $task2->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-pencil-alt "></i>
                                        </a>
                                        <form action="{{ route('taskproject.destroy', $task2->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                            <button type="submit" class="btn btn-danger btn-sm ml-1">
                                                <i class="fas fa-trash    "></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                                @empty
                                <li class="list-group-item bg-success-o-40 d-flex flex-row justify-content-center mt-1">
                                    --task not found--
                                </li>
                                @endforelse
                            </ul>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{-- <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card titil">
                    <h3>Edit Your Task</h3>
                </div>
            </div>
            <div class="card-body">
                @foreach ($project as $pro)
                <form action="{{ route('taskproject.update', $proj->id) }}" method="post" enctype="multipart/form-data">
                    @endforeach
                @method('PUT')
                @csrf
                    <div class="form-group text-center">
                        <input type="text" name="project_id" id="project_id" value="" class="form-control">
                    </div>
                    <div class="form-group text-center">
                        <label for="task">Task</label>
                        <input type="text" name="task" id="task" class="form-control bg-primary-o-50">
                    </div>
                    <div class="form-group text-center">
                        <label for="status_task">Status Task</label>
                        <input type="text" name="status_task" id="status_task" class="form-control bg-primary-o-50">
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" value="Change">
                    </div>
                </form>
            </div>
          </div> --}}
        </div>

        {{-- modal add --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('taskproject.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group text-center">
                            @foreach ($project as $pro)
                            <input type="hidden" name="project_id" value="{{ $pro->id }}" class="form-control">
                            @endforeach
                        </div>
                        <div class="form-group text-center">
                            <label for="task">Task</label>
                            <input type="text" name="task" id="task" class="form-control bg-primary-o-50">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary font-weight-bold" value="Save">
                    </div>
                    </form>
                </div>
            </div>
        </div>
@endsection

@push('addon-script')
{{-- <script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
            $('body').on('click', '#edit', function () {
            var id = $(this).data('id');
            $.get(`/api/taskprojected/${id}`, function (data) {
                // $('#postCrudModal').html("Edit post");
                // $('#btn-save').val("edit-post");
                $('#edit_task').modal('show');
                $('#project_id').val(data.project_id);
                $('#task').val(data.task);
            })
        });
    });
</script> --}}
@endpush

