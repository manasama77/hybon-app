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
                    <div class="col-12">

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $page_title }} List</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="bg-dark">
                                            <tr>
                                                {{-- <th><i class="fa-solid fa-cogs"></i></th> --}}
                                                <th>Kode Barang</th>
                                                <th>Barang</th>
                                                <th>Tipe Barang</th>
                                                <th>Out By</th>
                                                <th>Stock</th>
                                                <th>Satuan</th>
                                                <th>Harga Jual</th>
                                                <th>Sales Order</th>
                                                <th>Tanggal Out</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datas as $data)
                                                <tr>
                                                    {{-- <td>
                                                        <button type="button" class="btn btn-danger"
                                                            onclick="askDelete('{{ $data->id }}')">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </td> --}}
                                                    <td>{{ $data->kode_barang }}</td>
                                                    <td>
                                                        ({{ $data->stock_monitor->master_barang->kode_barang }})
                                                        {{ $data->stock_monitor->master_barang->nama_barang }}
                                                    </td>
                                                    <td>{{ $data->stock_monitor->master_barang->tipe_barang->name }}</td>
                                                    <td>{{ $data->created_name->name ?? '-' }}</td>
                                                    <td>
                                                        @if ($data->tipe_stock == 'satuan')
                                                            {{ number_format($data->qty, 0) }}
                                                        @else
                                                            {{ $data->panjang }} x {{ $data->lebar }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $data->stock_monitor->master_barang->satuan }}</td>
                                                    <td>{{ number_format($data->harga_jual, 2) }}</td>
                                                    <td>{{ $data->sales_order->code_order ?? '-' }}</td>
                                                    <td>{{ $data->created_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('aku_jawa')
    <script>
        $(document).ready(function() {
            $('table').DataTable();
        })

        function askDelete(id) {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Anda yakin ingin menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    processDestroy(id)
                }
            })
        }

        function processDestroy(id) {
            $.ajax({
                url: "/warehouse/stock-in/destroy/" + id,
                method: "POST",
                beforeSend: function() {
                    $.blockUI({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                        css: {
                            border: 'none',
                            padding: '15px',
                            backgroundColor: 'transparent',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            opacity: .5,
                            color: '#fff',
                        },
                        baseZ: 9999,
                    })
                }
            }).fail(function(e) {
                $.unblockUI();

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: e.responseText
                })
            }).done(function(e) {
                $.unblockUI();

                if (e.success) {
                    Swal.fire(
                        'Terhapus!',
                        'Data telah di hapus.',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "{{ route('warehouse.stock-in') }}"
                        }
                    })
                } else {
                    Swal.fire(
                        'Gagal!',
                        e.message,
                        'error'
                    )
                }
            })
        }
    </script>
@endsection
