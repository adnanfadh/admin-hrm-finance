@extends('layouts.app_finance')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb shadow-sm bg-white p-5">
                        <li class="breadcrumb-item active"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true">Dashboard</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('daftarlainnya.index') }}" class="text-decoration-none font-weight-bolder">Daftar Lainnya</a></li>
                        <li class="breadcrumb-item" aria-current="page">Pajak</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-12">
                <div class="card card-custom gutter-t">
                    <div class="card-header">
                        <div class="card-title w-100 d-flex flex-row justify-content-between">
                            <h3 class="card-label text-gray-700">List Pajak</h3>
                            <a class="btn btn-primary" href="javascript:void(0)" id="createNewPajak"><i class="fas fa-plus"></i>Create New Pajak</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover scroll-horizontal-vertical w-100 data-table" id="crudTable">
                                <thead class="bg-secondary text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pajak</th>
                                        <th>Persentase</th>
                                        <th width="40%" class="text-center">Aksi</th>
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

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="PajakForm" name="PajakForm" class="form-horizontal">
                       <input type="hidden" name="Pajak_id" id="Pajak_id">
                        <div class="form-group">
                            <label for="nama_pajak" class="col-sm-12 control-label">Nama pajak</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama_pajak" name="nama_pajak" placeholder="Enter Name Pajak" required="" value="{{ old('nama_pajak') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="persentase" class="col-sm-12 control-label">Persentase</label>
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="persentase" name="persentase" placeholder="Enter Name Pajak" required="" value="{{ old('persentase') }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-light">%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                {{-- <button type="reset" class="btn btn-info">Reset</button> --}}
                                <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(function () {
  
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });
  
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
                url: '{!! url()->current() !!}',
            },
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'nama_pajak', name: 'nama_pajak'},
              {data: 'persentase', name: 'persentase'},
              {data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'},
          ]
      });
  
      $('#createNewPajak').click(function () {
          $('#saveBtn').val("create-pajak");
          $('#Pajak_id').val('');
          $('#PajakForm').trigger("reset");
          $('#modelHeading').html("Create New Pajak");
          $('#ajaxModel').modal('show');
      });
  
      $('body').on('click', '.editPajak', function () {
        var Pajak_id = $(this).data('id');
        $.get("pajak"+'/' + Pajak_id +'/edit', function (data) {
            $('#modelHeading').html("Edit Pajak");
            $('#saveBtn').val("edit-pajak");
            $('#ajaxModel').modal('show');
            $('#Pajak_id').val(data.id);
            $('#nama_pajak').val(data.nama_pajak);
            $('#persentase').val(data.persentase);
        })
     });
  
      $('#saveBtn').click(function (e) {
          e.preventDefault();
          $(this).html('Sending..');
  
          $.ajax({
            data: $('#PajakForm').serialize(),
            url: "",
            type: "POST",
            dataType: 'json',
            success: function (data) {
  
                $('#PajakForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'Success...',
                        text: data.success
                });
                table.draw();
  
            },
            error: function (data) {
                console.log('Error:', data);
                Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Oops..',
                        text: data.error
                    });
                $('#saveBtn').html('Save Changes');
            }
        });
      });
  
      $('body').on('click', '.deletePajak', function () {
  
          var Metode_id = $(this).data("id");
          confirm("Are You sure want to delete !");
  
          $.ajax({
              type: "DELETE",
              url: "pajak"+'/'+Metode_id,
              success: function (data) {
                  console.log(data.success);
                  Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: 'Success...',
                        text: data.success
                    });
                  table.draw();
              },
              error: function (data) {
                  console.log('Error:', data);
                  Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: 'Oops..',
                        text: data.error
                    });
              }
          });
      });
  
    });
  </script>

@endpush