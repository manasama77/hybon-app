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
                                <div class="card-tools">
                                    <a href="{{ route('sales-order.create') }}" class="btn btn-primary">
                                        <i class="fa-solid fa-plus"></i> Tambah Data
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="bg-dark">
                                            <tr>
                                                <th><i class="fa-solid fa-cogs"></i></th>
                                                <th>Kode Order</th>
                                                <th>Title</th>
                                                <th>Motif</th>
                                                <th>Metode</th>
                                                <th>Barang Jadi</th>
                                                <th>Order From</th>
                                                <th>Nama Customer</th>
                                                <th>Alamat Customer</th>
                                                <th>No Telp Customer</th>
                                                <th>DP</th>
                                                <th>Harga Jual</th>
                                                <th>Input By</th>
                                                <th>Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datas as $data)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('sales-order.edit', $data->id) }}"
                                                            class="btn btn-info">
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-success"
                                                            onclick="askMove('{{ $data->id }}')">
                                                            <i class="fa-solid fa-arrow-right"></i>
                                                        </button>
                                                    </td>
                                                    <td>{{ $data->code_order }}</td>
                                                    <td>{{ $data->title }}</td>
                                                    <td>{{ $data->motif->name }}</td>
                                                    <td>{{ strtoupper($data->metode) }}</td>
                                                    <td>{{ $data->barang_jadi->name }}</td>
                                                    <td>{{ $data->order_from->name }}</td>
                                                    <td>{{ $data->nama_customer }}</td>
                                                    <td>{{ $data->alamat }}</td>
                                                    <td>{{ $data->no_telp }}</td>
                                                    <td>{{ number_format($data->dp) }}</td>
                                                    <td>{{ number_format($data->harga_jual) }}</td>
                                                    <td>{{ $data->create_name->name }}</td>
                                                    <td>{{ $data->notes }}</td>
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
                    // window.location = "/data-reference/motif/destroy/" + id
                    processDestroy(id)
                }
            })
        }

        function processDestroy(id) {
            $.ajax({
                url: "/data-reference/motif/destroy/" + id,
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
                            window.location = "{{ route('data-reference.motif') }}"
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

        function askMove(id) {
            Swal.fire({
                title: 'Pindah Data?',
                text: "Anda yakin ingin memindahkan data ini ke Product Design?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28A745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Pindahkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    processMove(id)
                }
            })
        }

        function processMove(id) {
            $.ajax({
                url: "/sales-order/move/product-design/" + id,
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
                        'Berhasil!',
                        e.message,
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "{{ route('sales-order') }}"
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
