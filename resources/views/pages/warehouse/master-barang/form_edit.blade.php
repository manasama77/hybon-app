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
                    <div class="col-12 col-md-4 offset-md-4">
                        <form action="{{ route('warehouse.master-barang.update', $datas->id) }}" method="post">
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
                                        <label for="nama_barang">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                            value="{{ old('nama_barang') ?? $datas->nama_barang }}" required />
                                        @if ($errors->has('nama_barang'))
                                            <span class="text-danger">{{ $errors->first('nama_barang') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="tipe_barang_id">Tipe Barang</label>
                                        <select class="form-control" id="tipe_barang_id" name="tipe_barang_id" required>
                                            <option value=""></option>
                                            @foreach ($tipe_barangs as $tipe_barang)
                                                <option @selected($datas->tipe_barang_id == $tipe_barang->id) value="{{ $tipe_barang->id }}">
                                                    {{ $tipe_barang->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('tipe_barang_id'))
                                            <span class="text-danger">{{ $errors->first('tipe_barang_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_vendor">Nama Vendor</label>
                                        <input type="text" class="form-control" id="nama_vendor" name="nama_vendor"
                                            value="{{ old('nama_vendor') ?? $datas->nama_vendor }}" required />
                                        @if ($errors->has('nama_vendor'))
                                            <span class="text-danger">{{ $errors->first('nama_vendor') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="tipe_stock">Tipe Stock</label>
                                        <select class="form-control" id="tipe_stock" name="tipe_stock" required>
                                            <option @selected($datas->tipe_stock == 'satuan') value="satuan">Satuan</option>
                                            <option @selected($datas->tipe_stock == 'lembar') value="lembar">Lembar</option>
                                        </select>
                                        @if ($errors->has('tipe_stock'))
                                            <span class="text-danger">{{ $errors->first('tipe_stock') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="satuan">Nama Satuan</label>
                                        <input type="text" class="form-control" id="satuan" name="satuan"
                                            value="{{ old('satuan') ?? $datas->satuan }}" required />
                                        @if ($errors->has('satuan'))
                                            <span class="text-danger">{{ $errors->first('satuan') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <a href="{{ route('warehouse.master-barang') }}" class="btn btn-dark mr-1">
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
        $(document).ready(function() {})
    </script>
@endsection
