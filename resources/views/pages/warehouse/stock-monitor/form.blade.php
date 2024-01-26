@extends('layouts.adminlte.master')

@section('isi_aku_mas')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $page_title }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 offset-md-3">
                        <form action="{{ route('warehouse.stock-monitor.update', $data->id) }}" method="post">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $page_title }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="kode_barang">Kode Barang</label>
                                        <input type="text" class="form-control" id="kode_barang"
                                            value="{{ $data->kode_barang }}" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_barang">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang"
                                            value="{{ $data->master_barang->nama_barang }}" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_jual">Harga Jual</label>
                                        <input type="number" class="form-control" id="harga_jual" name="harga_jual"
                                            value="{{ $data->harga_jual }}" required />
                                        @if ($errors->has('harga_jual'))
                                            <span class="text-danger">{{ $errors->first('harga_jual') }}</span>
                                        @endif
                                    </div>
                                    <div class="card-footer d-flex justify-content-end">
                                        <a href="{{ route('warehouse.stock-monitor') }}" class="btn btn-dark mr-1">
                                            <i class="fa-solid fa-backward"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-save fa-fw"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('aku_jawa')
    <script>
        $(document).ready(function() {

        })
    </script>
@endsection
