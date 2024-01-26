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
                        <form action="{{ route('warehouse.stock-in.store') }}" method="post">
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
                                        <label for="master_barang_id">Master Barang</label>
                                        <select class="form-control" id="master_barang_id" name="master_barang_id" required>
                                            <option value=""></option>
                                            @foreach ($master_barangs as $master_barang)
                                                <option value="{{ $master_barang->id }}">
                                                    {{ $master_barang->nama_barang }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('master_barang_id'))
                                            <span class="text-danger">{{ $errors->first('master_barang_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="tipe_barang">Tipe Barang</label>
                                        <input type="text" class="form-control" id="tipe_barang" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_vendor">Nama Vendor</label>
                                        <input type="text" class="form-control" id="nama_vendor" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label for="tipe_stock">Tipe Stock</label>
                                        <input type="text" class="form-control" id="tipe_stock" readonly />
                                    </div>
                                    <div id="group_lembar" class="form-group" style="display: none;">
                                        <label for="panjang">Qty</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">P</span>
                                            </div>
                                            <input type="number" class="form-control" id="panjang" name="panjang"
                                                value="{{ old('panjang') }}" required />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">x</span>
                                            </div>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">L</span>
                                            </div>
                                            <input type="number" class="form-control" id="lebar" name="lebar"
                                                value="{{ old('lebar') }}" required />
                                            <div class="input-group-append">
                                                <span class="input-group-text satuan"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="group_satuan" class="form-group" style="display: none;">
                                        <label for="qty">Qty</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="qty" name="qty"
                                                required />
                                            <div class="input-group-append">
                                                <span class="input-group-text satuan"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_jual">Harga Jual</label>
                                        <input type="text" class="form-control" id="harga_jual" name="harga_jual"
                                            value="{{ old('harga_jual') }}" required />
                                        @if ($errors->has('harga_jual'))
                                            <span class="text-danger">{{ $errors->first('harga_jual') }}</span>
                                        @endif
                                    </div>
                                    <div class="card-footer d-flex justify-content-end">
                                        <a href="{{ route('warehouse.stock-in') }}" class="btn btn-dark mr-1">
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
            $('#master_barang_id').on('change', () => {
                showMasterBarang()
            })
        })

        function showMasterBarang() {
            $.ajax({
                url: '/warehouse/master-barang/show/' + $('#master_barang_id').val(),
                method: 'get',
                dataType: 'json',
                beforeSend: function() {
                    $('#tipe_barang').val('')
                    $('#nama_vendor').val('')
                    $('#tipe_stock').val('')
                    $.blockUI()
                }
            }).fail(e => {
                console.log(e.responseText)
                $.unblockUI();
            }).done(e => {
                console.log(e)

                $('#tipe_barang').val(e.tipe_barang.name)
                $('#nama_vendor').val(e.nama_vendor)
                $('#tipe_stock').val(e.tipe_stock)

                if (e.tipe_stock == "lembar") {
                    $('#group_lembar').show()
                    $('#group_satuan').hide()
                    $('#panjang').val('').attr('required', true)
                    $('#lebar').val('').attr('required', true)
                    $('#qty').val('').attr('required', false)
                } else {
                    $('#group_lembar').hide()
                    $('#group_satuan').show()
                    $('#panjang').val('').attr('required', false)
                    $('#lebar').val('').attr('required', false)
                    $('#qty').val('').attr('required', true)
                }

                $('#panjang').val('')
                $('#lebar').val('')
                $('#qty').val('')
                $('.satuan').text(e.satuan)

                $.unblockUI()
            })
        }
    </script>
@endsection
