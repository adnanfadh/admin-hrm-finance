@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Show Project</li>
            </ol>
          </nav>

          <div class="content pt-0">
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Show Data Project</h3>
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
                  <form action="{{ route('project.update', $project->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                      <div class="form-group">
                        <label for="client_id">Client :</label>
                        <select name="client_id" id="client_id" class="form-control bg-success-o-40">
                            <option value="" disabled selected>--Tentukan Client Project--</option>
                            @foreach ($client as $u)
                                <option value="{{ $u->id }}" {{ old('client_id', $project->client_id) == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="row">
                          <div class="col-md-8">
                              <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" name="title" id="title" class="form-control bg-success-o-40" value="{{ $project->title }}">
                              </div>
                          </div>
                          <div class="col md-4">
                              <div class="form-group">
                                <label for="Prioritas">Prioritas:</label>
                                <select name="prioritas" id="prioritas" class="form-control bg-success-o-40 text-center">
                                  @if ($project->prioritas == 0)
                                  <option value="" disabled class="bg-danger-o-10">--Tentukan Client Project--</option>
                                  <option value="0" class="bg-danger-o-30" selected>low priority</option>
                                  <option value="1" class="bg-danger-o-40">medium priority</option>
                                  <option value="2" class="bg-danger-o-50">high priority</option>
                                      
                                  @endif
                                  @if ($project->prioritas == 1)
                                  <option value="" disabled class="bg-danger-o-10">--Tentukan Client Project--</option>
                                  <option value="0" class="bg-danger-o-30">low priority</option>
                                  <option value="1" class="bg-danger-o-40" selected>medium priority</option>
                                  <option value="2" class="bg-danger-o-50">high priority</option>
                                      
                                  @endif
                                  @if ($project->prioritas == 2)
                                  <option value="" disabled class="bg-danger-o-10">--Tentukan Client Project--</option>
                                  <option value="0" class="bg-danger-o-30">low priority</option>
                                  <option value="1" class="bg-danger-o-40">medium priority</option>
                                  <option value="2" class="bg-danger-o-50" selected>high priority</option>
                                      
                                  @endif
                                </select>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                <label for="start_date">Start Date:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control bg-success-o-40" value="{{ $project->start_date }}">
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                <label for="end_date">End Date:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control bg-success-o-40" value="{{ $project->end_date }}">
                              </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                <label for="status_project">Status Project:</label>
                                <select name="status_project" id="status_project" class="form-control bg-success-o-40 text-center">
                                  @if ($project->status_project == 0)
                                  <option value="" disabled class="bg-info-o-10">--Tentukan Status Project--</option>
                                  <option value="0" class="bg-info-o-30" selected>Backlog</option>
                                  <option value="1" class="bg-info-o-40">To Do</option>
                                  <option value="2" class="bg-info-o-50">Doing</option>
                                  <option value="2" class="bg-info-o-50">Done</option>
                                  @endif
                                  @if ($project->status_project == 1)
                                  <option value="" disabled class="bg-info-o-10">--Tentukan Status Project--</option>
                                  <option value="0" class="bg-info-o-30" >Backlog</option>
                                  <option value="1" class="bg-info-o-40" selected>To Do</option>
                                  <option value="2" class="bg-info-o-50">Doing</option>
                                  <option value="2" class="bg-info-o-50">Done</option>
                                  @endif
                                  @if ($project->status_project == 2)
                                  <option value="" disabled class="bg-info-o-10">--Tentukan Status Project--</option>
                                  <option value="0" class="bg-info-o-30" >Backlog</option>
                                  <option value="1" class="bg-info-o-40">To Do</option>
                                  <option value="2" class="bg-info-o-50" selected>Doing</option>
                                  <option value="2" class="bg-info-o-50">Done</option>
                                  @endif
                                  @if ($project->status_project == 3)
                                  <option value="" disabled class="bg-info-o-10">--Tentukan Status Project--</option>
                                  <option value="0" class="bg-info-o-30" >Backlog</option>
                                  <option value="1" class="bg-info-o-40">To Do</option>
                                  <option value="2" class="bg-info-o-50" >Doing</option>
                                  <option value="2" class="bg-info-o-50" selected>Done</option>
                                  @endif
                                </select>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="ringkasan_project">Ringkasan Project</label>
                            <textarea name="ringkasan_project" id="ringkasan_project" cols="30" rows="3" class="form-control bg-success-o-40">{{ $project->ringkasan_project }}</textarea>
                          </div>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="description">Deskripsi Project</label>
                            <textarea name="description" id="description" cols="30" rows="3" class="form-control bg-success-o-40">{{ $project->description }}</textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="">Team:</label>
                          
                            <div class="box bg-success-o-40 p-5 rounded">
                              <div class="row">
                                @foreach ($pegawai as $p)
                                @for ($i = 0; $i < $dat ; $i++)
                                <div class="col-md-3 bg-white p-3 rounded m-2">
                                  <label class="checkbox checkbox-outline checkbox-success text-wrap">
                                    <input type="checkbox" name="pegawai_id[]" value="{{ $p->id }}" {{ $dataku[$i] == $p->id ? 'checked' : '' }}>
                                    <span></span>
                                    {{ $i }}
                                    {{ $p->nama }}
                                  </label>
                                </div>
                                @endfor
                                @endforeach
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                          <div class="row p-3 justify-content-md-start">
                              <input type="submit" value="submit" class="btn btn-primary">
                              <input type="reset" value="Clear" class="btn btn-warning ml-2">
                              <a href="{{ route('project.index') }}" class="btn btn-dark ml-2"> <i class="fas fa-reply"></i>Back  </a>
                          </div>
                      </div>
                  </form>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection