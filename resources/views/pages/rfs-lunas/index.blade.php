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
                                                            <i class="fa-solid fa-eye"></i>
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title_pure">Log Material Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date Time</th>
                                        <th>Material</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody id="v_body"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('aku_jawa')
    <script>
        $(document).ready(function() {
            $('table').DataTable();
        })

        function showEdit(id) {
            $.ajax({
                url: `/sales-order/show_manufacturing_log/${id}`,
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

                let data = e.data

                let htmlnya = "";
                let seq = 1
                data.forEach(el => {
                    htmlnya += `
                    <tr>
                        <td>${seq}</td>
                        <td>${el.created_at}</td>
                        <td>${el.kode_barang}</td>
                        <td>${el.qty}</td>
                        <td>${el.satuan}</td>
                        <td>${el.phase_seq.toUpperCase()} -  ${el.notes}</td>
                    </tr>
                    `

                    seq++;
                });

                $('#v_body').html(htmlnya)

                $('#modal_edit').modal('show')
                $.unblockUI();
            })
        }
    </script>
@endsection
