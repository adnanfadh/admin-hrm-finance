@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Task</li>
            </ol>
          </nav>

          <div class="content pt-0">
            <div class="card card-custom gutter-b border-0 shadow col-md-6">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Edit Data Task Project</h3>
                </div>
              </div>
              <div class="card-body bg-white">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                  @endif
                  <form action="{{ route('taskproject.update', $taskproject->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group text-center">
                        <label for="">Id Project</label>
                        <input type="text" name="project_id" id="project_id" value="{{ $taskproject->project_id }}" class="form-control">
                    </div>
                    <div class="form-group text-center">
                        <label for="task">Task</label>
                        <input type="text" name="task" id="task" value="{{ $taskproject->task }}" class="form-control bg-primary-o-50">
                    </div>
                    <div class="form-group text-center">
                        <label for="status_task">Status Task</label>
                        <select name="status_task" id="" class="form-control bg-primary-o-50">
                            <option value="" disabled>--Select Your Status Task--</option>
                            @if ($taskproject->status_task == 0)
                                <option value="0" selected>Backlog</option>
                                <option value="1" >Doing</option>
                                <option value="2" >Done</option>
                            @endif
                            @if ($taskproject->status_task == 1)
                                <option value="0" >Backlog</option>
                                <option value="1" selected>Doing</option>
                                <option value="2" >Done</option>
                            @endif
                            @if ($taskproject->status_task == 2)
                                <option value="0" >Backlog</option>
                                <option value="1" >Doing</option>
                                <option value="2" selected>Done</option>
                            @endif
                        </select>
                    </div>
                      <div class="form-group">
                          <div class="row p-3 justify-content-md-start">
                              <input type="submit" value="submit" class="btn btn-primary">
                              <input type="reset" value="Clear" class="btn btn-warning ml-2">
                              <a href="{{ route('project.show',$taskproject->project_id ) }}" class="btn btn-dark ml-2"> <i class="fas fa-reply"></i>Back  </a>
                          </div>
                      </div>
                  </form>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection