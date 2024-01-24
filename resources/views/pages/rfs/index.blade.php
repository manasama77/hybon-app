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
                                                        <button type="button" class="btn btn-info"
                                                            onclick="showEdit('{{ $data->id }}')">
                                                            Edit
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

    <form id="form-edit">
        <div class="modal fade" id="modal_edit" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="modal_title" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title_pure">Edit Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="code_order">Kode Order</label>
                            <input type="text" class="form-control" id="code_order" readonly />
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" readonly />
                        </div>
                        <div class="form-group">
                            <label for="harga_jual">Harga Jual</label>
                            <input type="number" class="form-control" id="harga_jual" name="harga_jual" readonly />
                        </div>
                        <div class="form-group">
                            <label for="dp">DP</label>
                            <input type="number" class="form-control" id="dp" name="dp" required />
                        </div>
                        <div class="form-group">
                            <label for="sisa_pelunasan">Sisa Pelunasan</label>
                            <input type="number" class="form-control" id="sisa_pelunasan" name="sisa_pelunasan" readonly />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="sales_order_id" name="sales_order_id" />
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-save fa-fw"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('aku_jawa')
    <script>
        let temp_sales_order_id

        $(document).ready(function() {
            $('table').DataTable();

            $('#form-edit').on('submit', e => {
                e.preventDefault()

                let dp = $('#dp').val()

                $.ajax({
                    url: `/rfs/update/${temp_sales_order_id}`,
                    method: 'post',
                    dataType: 'json',
                    data: {
                        dp: dp
                    },
                    beforeSend: function() {
                        $('#modal_edit').block({
                            message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                        })
                    }
                }).fail(e => {
                    console.log(e.responseText)
                    $('#modal_edit').unblock()
                    Swal.fire('Oops!', e.responseText, 'error')
                }).done(e => {
                    console.log(e)

                    if (e.success) {
                        $('#modal_edit').unblock().modal('hide')
                        Swal.fire(
                            'Berhasil!',
                            e.message,
                            'success'
                        ).then((result) => {
                            window.location.reload()
                        })
                    } else {
                        $('#modal_edit').unblock()
                        Swal.fire(
                            'Oops!',
                            e.message,
                            'error'
                        )
                    }
                })

            })

            $('#dp').on('change keyup', () => {
                let harga_jual = $('#harga_jual').val()
                let dp = $('#dp').val()
                let sisa_pelunasan = parseInt(harga_jual) - parseInt(dp)

                $('#sisa_pelunasan').val(sisa_pelunasan)
            })
        })

        function showEdit(id) {
            temp_sales_order_id = id

            $.ajax({
                url: `/sales-order/show_for_manufacturing/${id}`,
                method: 'get',
                dataType: 'json',
                beforeSend: function() {
                    $.blockUI({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                    })
                }
            }).fail(e => {
                console.log(e.responseText)
                $.unblockUI();
                Swal.fire('Gagal!', e.responseText, 'error')
            }).done(e => {
                console.log(e)

                $('#code_order').val(e.data.code_order)
                $('#title').val(e.data.title)
                $('#harga_jual').val(parseInt(e.data.harga_jual))
                $('#dp').val(parseInt(e.data.dp)).trigger('change').attr('max', parseInt(e.data.harga_jual))

                $('#modal_edit').modal('show')
                $.unblockUI();
            })
        }
    </script>
@endsection
