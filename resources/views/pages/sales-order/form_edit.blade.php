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
                <form action="{{ route('sales-order.update', $datas->id) }}" method="post">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Detail Order</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ $datas->title }}" required />
                                        @if ($errors->has('title'))
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="motif_id">Motif</label>
                                        <select class="form-control" id="motif_id" name="motif_id" required>
                                            <option value=""></option>
                                            @foreach ($motifs as $motif)
                                                <option @selected($datas->motif_id == $motif->id) value="{{ $motif->id }}">
                                                    {{ $motif->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('motif_id'))
                                            <span class="text-danger">{{ $errors->first('motif_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="metode">Metode</label>
                                        <select class="form-control" id="metode" name="metode" required>
                                            <option @selected($datas->metode == 'pure') value="pure">PURE</option>
                                            <option @selected($datas->metode == 'skinning') value="skinning">SKINNING</option>
                                        </select>
                                        @if ($errors->has('metode'))
                                            <span class="text-danger">{{ $errors->first('metode') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="barang_jadi_id">Barang</label>
                                        <select class="form-control" id="barang_jadi_id" name="barang_jadi_id" required>
                                            <option value=""></option>
                                            @foreach ($barang_jadis as $barang_jadi)
                                                <option @selected($datas->barang_jadi_id == $barang_jadi->id) value="{{ $barang_jadi->id }}">
                                                    {{ $barang_jadi->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('barang_jadi_id'))
                                            <span class="text-danger">{{ $errors->first('barang_jadi_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="dp">DP</label>
                                        <input type="number" class="form-control" id="dp" name="dp"
                                            value="{{ (int) $datas->dp }}" required />
                                        @if ($errors->has('dp'))
                                            <span class="text-danger">{{ $errors->first('dp') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_jual">Harga Jual</label>
                                        <input type="number" class="form-control" id="harga_jual" name="harga_jual"
                                            value="{{ (int) $datas->harga_jual }}" required />
                                        @if ($errors->has('harga_jual'))
                                            <span class="text-danger">{{ $errors->first('harga_jual') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Detail Customer</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nama_customer">Nama Customer</label>
                                        <input type="text" class="form-control" id="nama_customer" name="nama_customer"
                                            value="{{ $datas->nama_customer }}" required />
                                        @if ($errors->has('nama_customer'))
                                            <span class="text-danger">{{ $errors->first('nama_customer') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat Customer</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat"
                                            value="{{ $datas->alamat }}" required />
                                        @if ($errors->has('alamat'))
                                            <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="no_telp">No Telp Customer</label>
                                        <input type="text" class="form-control" id="no_telp" name="no_telp"
                                            value="{{ $datas->no_telp }}" required />
                                        @if ($errors->has('no_telp'))
                                            <span class="text-danger">{{ $errors->first('no_telp') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="order_from_id">Order From</label>
                                        <select class="form-control" id="order_from_id" name="order_from_id" required>
                                            <option value=""></option>
                                            @foreach ($order_froms as $order_from)
                                                <option @selected($datas->order_from_id == $order_from->id) value="{{ $order_from->id }}">
                                                    {{ $order_from->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('order_from_id'))
                                            <span class="text-danger">{{ $errors->first('order_from_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ route('sales-order') }}" class="btn btn-dark mr-1">
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
@endsection

@section('aku_jawa')
    <script>
        $(document).ready(function() {
            $('#barang_jadi_id').on('change', () => {
                showBarangJadi()
            })
        })

        function showBarangJadi() {
            $.ajax({
                url: '/data-reference/barang-jadi/show/' + $('#barang_jadi_id').val(),
                method: 'get',
                dataType: 'json',
                beforeSend: function() {
                    $('#harga_jual').val('')
                    $.blockUI()
                }
            }).fail(e => {
                console.log(e.responseText)
                $.unblockUI();
            }).done(e => {
                console.log(e)
                $('#harga_jual').val(e.harga_jual)
                $.unblockUI()
            })
        }
    </script>
@endsection
