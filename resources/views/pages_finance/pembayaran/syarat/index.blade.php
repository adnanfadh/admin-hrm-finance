@extends('layouts.app_finance')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb shadow-sm bg-white p-5">
                        <li class="breadcrumb-item active"><a href="/fnc/dashboard_finance" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true">Dashboard</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('daftarlainnya.index') }}" class="text-decoration-none font-weight-bolder">Daftar Lainnya</a></li>
                        <li class="breadcrumb-item" aria-current="page">Syarat Pembayaran</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card card-custom gutter-t">
                    <div class="card-header">
                        <div class="card-title w-100 d-flex flex-row justify-content-between">
                            <h3 class="card-label text-gray-700">List Syarat Pembayaran</h3>
                            <a class="btn btn-primary btn-sm" href="javascript:void(0)" id="createNewSyarat"><i class="fas fa-plus"></i>Create New Syarat</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover scroll-horizontal-vertical w-100 data-table" id="crudTable">
                                <thead class="bg-secondary text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Syarat</th>
                                        <th>Jangka Waktu</th>
                                        <th>Account Bank</th>
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
                    <form id="SyaratForm" name="SyaratForm" class="form-horizontal">
                       <input type="hidden" name="Syarat_id" id="Syarat_id">
                        <div class="form-group">
                            <label for="nama_syarat" class="col-sm-12 control-label">Nama Syarat Pembayaran</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="nama_syarat" name="nama_syarat" placeholder="Enter Name Syarat" value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jangka_waktu" class="col-sm-12 control-label">Jangka Waktu</label>
                            <div class="col-sm-12">
                                <div class="input-group">
                                <input type="number" class="form-control" id="jangka_waktu" name="jangka_waktu" placeholder="Enter Jangka waktu" value="" maxlength="50" required="" onkeyup="Jangkawaktu()">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Hari</span>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="account_bank" class="col-sm-12 control-label">AccountBank</label>
                            <div class="col-sm-12">
                                <select name="account_bank" id="account_bank" class="form-control">
                                    <option value="">-- Account Bank --</option>
                                    @foreach ($account_bank as $ab)
                                        <option value="{{ $ab->id }}">({{ $ab->nomor }})-{{ $ab->nama }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" name="account_bank" id=""> --}}
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                         <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                         </button>
                        </div>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                    </button>
                </div> --}}
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

    function Jangkawaktu(){
        $data = document.getElementById('jangka_waktu').value;

        if ($data != 0) {
            $('#account_bank').hide();
            $('#account_bank').val('');
        } else {
            $('#account_bank').show();
        }
    }

    $(function () {

        // ajax untuk mengambil data account
        // $.ajax({
        //         url: "{{ route('get_account_bank_syarat') }}",
        //         type: "GET",
        //         data : {"_token":"{{ csrf_token() }}"},
        //             success:function(data){
        //                 $.each(data, function(key, log){
        //                     $('#account_bank').append('<option value="'+ log.id +'">('+ log.nomor +')' + log.nama+ '</option>');
        //                    });
        //             }
        //     });
  
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
              {data: 'nama_syarat', name: 'nama_syarat'},
              {data: 'jangka_waktu', name: 'jangka_waktu'},
              {data: 'account', name: 'account'},
              {data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'},
          ]
      });
  
      $('#createNewSyarat').click(function () {
          $('#saveBtn').val("create-syarat");
          $('#Syarat_id').val('');
          $('#SyaratForm').trigger("reset");
          $('#modelHeading').html("Create New Syarat");
          $('#ajaxModel').modal('show');
      });
  
      $('body').on('click', '.editSyarat', function () {
        var Syarat_id = $(this).data('id');
        $.get("syaratpembayaran"+'/' + Syarat_id +'/edit', function (data) {
            $('#modelHeading').html("Edit Syarat");
            $('#saveBtn').val("edit-syarat");
            $('#ajaxModel').modal('show');
            $('#Syarat_id').val(data.id); 
            $('#nama_syarat').val(data.nama_syarat);
            $('#jangka_waktu').val(data.jangka_waktu);
            $('#account_bank').val(data.account_bank);
        })
     });
  
      $('#saveBtn').click(function (e) {
          e.preventDefault();
          $(this).html('Sending..');
  
          $.ajax({
            data: $('#SyaratForm').serialize(),
            url: "",
            type: "POST",
            dataType: 'json',
            success: function (data) {
  
                $('#SyaratForm').trigger("reset");
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
  
      $('body').on('click', '.deleteSyarat', function () {
  
          var Syarat_id = $(this).data("id");
          confirm("Are You sure want to delete !");
  
          $.ajax({
              type: "DELETE",
              url: "syaratpembayaran"+'/'+Syarat_id,
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