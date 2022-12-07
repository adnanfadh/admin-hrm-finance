
@extends('layouts.app_finance') 
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box rounded bg-white p-3">
                <h1>Daftar Nilai Persediaan Barang<span class="font-size-h5-sm text-black-50"> dalam (IDR)</span></h1>
                <hr>
                <form action="{{ route('result_nilai_persediaan_barang') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_awal">Tanggal Awal</label>
                                <input type="date" class="form-control" name="tanggal_awal" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                <input type="date" class="form-control" name="tanggal_akhir" required>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex flex-column justify-content-end">
                            <div class="form-group">
                                <input type="submit" value="Filter Now" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box bg-white rounded p-3 mt-3">
                <table class="table table-head-bg">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Transaksi</th>
                            <th>Deskripsi</th>
                            <th>Mutasi</th>
                            <th>Stok Barang</th>
                            <th>Harga</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection