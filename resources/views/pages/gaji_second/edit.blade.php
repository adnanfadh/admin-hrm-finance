@extends('layouts.app')

@section('content')

    <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb shadow-sm bg-white p-5 mb-0">
              <li class="breadcrumb-item"><a href="/dashboard" style="text-decoration: none"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Gaji</li>
            </ol>
          </nav>

          <div class="content mb-4">
            <div class="card card-custom gutter-b border-0 shadow">
              <div class="card-header">
                <div class="card-title">
                  <h3 class="card-label text-gray-700">Edit Data Gaji</h3>
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
                  <form action="{{ route('gaji_second.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf


                    <div class="row">
                      <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="pegawai_id">Nama Pegawai:</label>
                            <select name="pegawai_id" id="pegawai_id" class="form-control">
                              <option value="" selected>--Tentukan Pegawai--</option>
                                @foreach ($pegawai as $b)
                                <option value="{{ $b->id }}" {{ old('pegawai_id', $data->pegawai_id) == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6 col-12">
                          <div class="form-group">
                            <label for="periode">Periode:</label>
                            <input type="month" name="periode" id="periode" class="form-control" value="{{ old('periode', $periode) != null ? $periode : '' }}" id="example-month-input">
                          </div>
                        </div>
                    </div>
                      <div class="row">
                        <div class="col-md-6 col-12">
                          <div class="card pt-5 p-4">
                            <label for="" style="position: absolute; top: -15px; padding: 2px 4px" class="bg-white font-weight-bolder text-primary font-size-h4">Penerimaan</label>
                            <div class="form-group">
                              <label for="tunjangan_kerajinan">Gaji Pokok:</label>
                              <div class="input-group">
                                <div  class="input-group-prepend">
                                  <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" name="gaji_pokok" id="gaji_pokok" class="form-control" value="{{ old('gaji_pokok', $data->gaji_pokok) != null ? $data->gaji_pokok : '' }}">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="tunjangan_kerajinan">Tunjangan Kerajinan:</label>
                              <div class="input-group">
                                <div  class="input-group-prepend">
                                  <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" name="tunjangan_kerajinan" id="tunjangan_kerajinan" class="form-control" value="{{ old('tunjangan_kerajinan', $data->tunjangan_kerajinan) != null ? $data->tunjangan_kerajinan : '' }}">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="tunjangan_makan">Tunjangan Makan:</label>
                              <div class="input-group">
                                <div  class="input-group-prepend">
                                  <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" name="tunjangan_makan" id="tunjangan_makan" class="form-control" value="{{ old('tunjangan_makan', $data->tunjangan_makan) != null ? $data->tunjangan_makan : '' }}">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="tunjangan_jabatan">Tunjangan Jabatan:</label>
                              <div class="input-group">
                                <div  class="input-group-prepend">
                                  <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" name="tunjangan_jabatan" id="tunjangan_jabatan" class="form-control" value="{{ old('tunjangan_jabatan', $data->tunjangan_jabatan) != null ? $data->tunjangan_jabatan : '' }}">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="lembur_harian">Lembur Harian:</label>
                              <div class="input-group">
                                <div  class="input-group-prepend">
                                  <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" name="lembur_harian" id="lembur_harian" class="form-control" value="{{ old('lembur_harian', $data->lembur_harian) != null ? $data->lembur_harian : '' }}">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="lembur_hari_libur">Lembur Hari Libur:</label>
                              <div class="input-group">
                                <div  class="input-group-prepend">
                                  <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" name="lembur_hari_libur" id="lembur_hari_libur" class="form-control" value="{{ old('lembur_hari_libur', $data->lembur_hari_libur) != null ? $data->lembur_hari_libur : '' }}">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="lembur_event">Lembur Event:</label>
                              <div class="input-group">
                                <div  class="input-group-prepend">
                                  <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" name="lembur_event" id="lembur_event" class="form-control" value="{{ old('lembur_event', $data->lembur_event) != null ? $data->lembur_event : '' }}">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="perjalanan_dinas">Perjalanan Dinas:</label><div class="input-group">
                                <div  class="input-group-prepend">
                                  <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" name="perjalanan_dinas" id="perjalanan_dinas" class="form-control" value="{{ old('perjalanan_dinas', $data->perjalanan_dinas) != null ? $data->perjalanan_dinas : '' }}">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="tunjangan_keluarga">Tunjangan Keluarga:</label>
                              <div class="input-group">
                                <div  class="input-group-prepend">
                                  <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" name="tunjangan_keluarga" id="tunjangan_keluarga" class="form-control" value="{{ old('tunjangan_keluarga', $data->tunjangan_keluarga) != null ? $data->tunjangan_keluarga : '' }}">
                              </div>
                            </div>



                          </div>
                        </div>
                        <div class="col-md-6 col-12">
                          <div class="card pt-5 p-4">
                            <label for="" style="position: absolute; top: -15px; padding: 2px 4px" class="bg-white font-weight-bolder text-primary font-size-h4">Potongan</label>

                            <div class="form-group">
                                <label for="pajak_21">Pajak 21:</label>
                                <div class="input-group">
                                  <div  class="input-group-prepend">
                                    <span  class="input-group-text">RP</span>
                                  </div>
                                  <input type="text" name="pajak_21" id="pajak_21" class="form-control" value="{{ old('pajak_21', $data->pajak_21) != null ? $data->pajak_21 : '' }}">
                                </div>
                              </div>

                            <div class="form-group">
                              <label for="biaya_jabatan">Biaya Jabatan:</label>
                              <div class="input-group">
                                <div  class="input-group-prepend">
                                  <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" name="biaya_jabatan" id="biaya_jabatan" class="form-control" value="{{ old('biaya_jabatan', $data->biaya_jabatan) != null ? $data->biaya_jabatan : '' }}">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="tabungan">Tabungan:</label>
                              <div class="input-group">
                                <div  class="input-group-prepend">
                                  <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" name="tabungan" id="tabungan" class="form-control" value="{{ old('tabungan', $data->tabungan) != null ? $data->tabungan : '' }}">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="bpjs_kesehatan">BPJS Kesehatan:</label>
                              <div class="input-group">
                                <div  class="input-group-prepend">
                                  <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" name="bpjs_kesehatan" id="bpjs_kesehatan" class="form-control" value="{{ old('bpjs_kesehatan', $data->bpjs_kesehatan) != null ? $data->bpjs_kesehatan : '' }}">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="bpjs_ketenagakerjaan">BPJS Ketenagakerjaan:</label>
                              <div class="input-group">
                                <div  class="input-group-prepend">
                                  <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" name="bpjs_ketenagakerjaan" id="bpjs_ketenagakerjaan" class="form-control" value="{{ old('bpjs_ketenagakerjaan', $data->bpjs_ketenagakerjaan) != null ? $data->bpjs_ketenagakerjaan : '' }}">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="potongan_lain_lain">Potongan Lain-lain:</label>
                              <div class="input-group">
                                <div  class="input-group-prepend">
                                  <span  class="input-group-text">RP</span>
                                </div>
                                <input type="text" name="potongan_lain_lain" id="potongan_lain_lain" class="form-control" value="{{ old('potongan_lain_lain', $data->potongan_lain_lain) != null ? $data->potongan_lain_lain : '' }}">
                              </div>
                            </div>



                          </div>

                          <div class="card pt-5 p-4" style="margin-top:20px">
                            <label for="" style="position: absolute; top: -15px; padding: 2px 4px" class="bg-white font-weight-bolder text-primary font-size-h4">Catatan</label>

                            <div class="form-group">
                                <div class="input-group">
                                  <textarea name="catatan" id="catatan" class="form-control" >{{ old('catatan', $data->catatan) != null ? $data->catatan : '' }}</textarea>
                                </div>
                              </div>

                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                          <div class="row p-3 justify-content-md-start">
                              <input type="submit" value="submit" class="btn btn-primary">
                          </div>
                      </div>
                  </form>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

@endsection
