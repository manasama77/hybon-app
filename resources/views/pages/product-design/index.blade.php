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
                                                <th>Metode Molding</th>
                                                <th>Sub Molding</th>
                                                <th>Cost Molding</th>
                                                <th>Besaran Carbon</th>
                                                <th>Harga Material Skinning</th>
                                                <th>Input By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datas as $data)
                                                <tr>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-info"
                                                                onclick="showEdit('{{ $data->id }}', '{{ $data->metode }}')">
                                                                <i class="fa-solid fa-pencil"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-success"
                                                                onclick="askMove('{{ $data->id }}')">
                                                                <i class="fa-solid fa-arrow-right"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td>{{ $data->code_order }}</td>
                                                    <td>{{ $data->title }}</td>
                                                    <td>{{ $data->motif->name }}</td>
                                                    <td>{{ strtoupper($data->metode) }}</td>
                                                    <td>{{ $data->barang_jadi->name ?? '-' }}</td>
                                                    <td>{{ $data->order_from->name }}</td>
                                                    <td>{{ $data->nama_customer }}</td>
                                                    <td>{{ $data->alamat }}</td>
                                                    <td>{{ $data->no_telp }}</td>
                                                    <td>{{ number_format($data->dp) }}</td>
                                                    <td>{{ number_format($data->harga_jual) }}</td>
                                                    <td>{{ $data->sub_molding->metode_molding->name ?? '-' }}</td>
                                                    <td>{{ $data->sub_molding->name ?? '-' }}</td>
                                                    <td>{{ number_format($data->cost_molding_pure ?? 0, 2) }}</td>
                                                    <td>
                                                        {{ number_format($data->panjang_skinning ?? 0, 2) }} x
                                                        {{ number_format($data->lebar_skinning ?? 0, 2) }}
                                                    </td>
                                                    <td>{{ number_format($data->harga_material_skinning ?? 0, 2) }}</td>
                                                    <td>{{ $data->create_name->name }}</td>
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

    <form id="form-edit-pure">
        <div class="modal fade" id="modal_edit_pure" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="modal_title_pure" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title_pure">Edit Data - Metode Pure</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="code_order_pure">Kode Order</label>
                            <input type="text" class="form-control" id="code_order_pure" readonly />
                        </div>
                        <div class="form-group">
                            <label for="title_pure">Title</label>
                            <input type="text" class="form-control" id="title_pure" name="title_pure" readonly />
                        </div>
                        <div class="form-group">
                            <label for="dp_pure">DP</label>
                            <input type="number" class="form-control" id="dp_pure" name="dp_pure" required />
                        </div>
                        <div class="form-group">
                            <label for="metode_molding_id_pure">Metode Molding</label>
                            <select class="form-control" id="metode_molding_id_pure" name="metode_molding_id_pure" required>
                                <option value=""></option>
                                @foreach ($metode_moldings as $metode_molding)
                                    <option value="{{ $metode_molding->id }}">{{ $metode_molding->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="sub_molding_id_pure_block">
                            <label for="sub_molding_id_pure">Sub Molding</label>
                            <select class="form-control" id="sub_molding_id_pure" name="sub_molding_id_pure" required>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cost_molding_pure">Cost Molding</label>
                            <input type="number" class="form-control" id="cost_molding_pure" name="cost_molding_pure"
                                required />
                        </div>
                        <hr />
                        <h2 class="text-center">Status</h2>
                        <div class="form-group">
                            <label for="status_pure">New Status</label>
                            <input type="text" class="form-control" id="status_pure" name="status_pure" />
                        </div>
                        <button type="button" id="btn_status_pure" class="btn btn-info btn-block mb-3">Tambah
                            Status</button>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><i class="fa-solid fa-cogs"></i></th>
                                        <th>Status</th>
                                        <th>Date Time</th>
                                        <th>By</th>
                                    </tr>
                                </thead>
                                <tbody id="v_status_pure"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="sales_order_id_pure" name="sales_order_id_pure" />
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-save fa-fw"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="form-edit-skinning">
        <div class="modal fade" id="modal_edit_skinning" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="modal_title_skinning" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title_skinning">Edit Data - Metode Skinning</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="code_order_skinning">Kode Order</label>
                            <input type="text" class="form-control" id="code_order_skinning" readonly />
                        </div>
                        <div class="form-group">
                            <label for="title_skinning">Title</label>
                            <input type="text" class="form-control" id="title_skinning" readonly />
                        </div>
                        <div class="form-group">
                            <label for="dp_skinning">DP</label>
                            <input type="number" class="form-control" id="dp_skinning" name="dp_skinning" required />
                        </div>
                        <div class="form-group">
                            <label for="stock_id">Materials</label>
                            <select class="form-control" id="stock_id" name="stock_id" required>
                                <option value=""></option>
                                @foreach ($stocks as $stock)
                                    <option value="{{ $stock->id }}">
                                        {{ $stock->kode_barang }} ({{ $stock->panjang }}x{{ $stock->lebar }}
                                        {{ $stock->satuan }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="panjang_skinning">Besaran Carbon</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">P</span>
                                </div>
                                <input type="number" class="form-control" id="panjang_skinning" name="panjang_skinning"
                                    step="0.01" required />
                                <div class="input-group-prepend">
                                    <span class="input-group-text">x</span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">L</span>
                                </div>
                                <input type="number" class="form-control" id="lebar_skinning" name="lebar_skinning"
                                    step="0.01" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="sales_order_id_skinning" name="sales_order_id_skinning" />
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
        let temp_metode

        $(document).ready(function() {
            $('table').DataTable();

            $('#metode_molding_id_pure').on('change', () => {
                let value = $('#metode_molding_id_pure').val();

                $.ajax({
                    url: '/data-reference/sub-molding/show/' + value,
                    method: 'get',
                    dataType: 'json',
                    beforeSend: function() {
                        $('#sub_molding_id_pure').html('<option value=""></option>');
                        $('#sub_molding_id_pure_block').block({
                            message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                        });
                    }
                }).fail(e => {
                    console.log(e.responseText);
                    $('#sub_molding_id_pure_block').unblock();
                    Swal.fire('Gagal!', e.responseText, 'error');
                }).done(e => {
                    console.log(e)
                    let datanya = e.data;

                    let hasil = ''
                    datanya.forEach((r) => {
                        hasil += `<option value="${r.id}">${r.name}</option>`
                    })

                    console.log(hasil)

                    $('#sub_molding_id_pure').html(hasil)
                    $('#sub_molding_id_pure_block').unblock();
                })
            })

            $('#btn_status_pure').on('click', () => {
                let sales_order_id = $('#sales_order_id_pure').val();
                let status_pure = $('#status_pure').val();

                if (status_pure.length == 0) {
                    return $('#status_pure').focus();
                }

                $.ajax({
                    url: '{{ route('sales-order.store_status_pure') }}',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        sales_order_id: sales_order_id,
                        status_pure: status_pure
                    },
                    beforeSend: function() {
                        $('#modal_edit_pure').block({
                            message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                        })
                    }
                }).fail(e => {
                    console.log(e.responseText)
                    $('#modal_edit_pure').unblock()
                    Swal.fire('Gagal!', e.responseText, 'error')
                }).done(e => {
                    console.log(e)
                    $('#status_pure').val('')
                    $('#modal_edit_pure').unblock()
                    getStatusPure()
                })
            })

            $('#form-edit-pure').on('submit', e => {
                e.preventDefault();
                processEditPure()
            })

            $('#form-edit-skinning').on('submit', e => {
                e.preventDefault();
                processEditSkinning()
            })
        })

        function showEdit(id, metode) {
            temp_sales_order_id = id
            temp_metode = metode

            if (metode == "pure") {
                $.ajax({
                    url: `/sales-order/show/${id}/${metode}`,
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

                    $('#code_order_pure').val(e.data.code_order)
                    $('#title_pure').val(e.data.title)
                    $('#dp_pure').val(parseInt(e.data.dp))
                    $('#metode_molding_id_pure').val('');
                    $('#metode_molding').val('');
                    $('#sub_molding_id_pure').html('<option value=""></option>');
                    $('#sales_order_id_pure').val(id)
                    getStatusPure()

                    if (e.data.sub_molding) {
                        $('#metode_molding_id_pure').val(e.data.sub_molding.metode_molding.id).trigger(
                            'change');

                        setTimeout(() => {
                            console.log(e.data.sub_molding.id)
                            $('#sub_molding_id_pure').val(e.data.sub_molding.id)
                        }, 1200);
                    }

                    $('#cost_molding_pure').val(e.data.cost_molding_pure)

                    $('#modal_edit_pure').modal('show')
                    $.unblockUI();
                })
            } else {
                $.ajax({
                    url: `/sales-order/show/${id}/${metode}`,
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

                    $('#code_order_skinning').val(e.data.code_order)
                    $('#title_skinning').val(e.data.title)
                    $('#dp_skinning').val(parseInt(e.data.dp))
                    $('#panjang_skinning').val(e.data.panjang_skinning);
                    $('#lebar_skinning').val(e.data.lebar_skinning);
                    $('#stock_id').val(e.data.stock_monitor_id);
                    $('#harga_material_skinning').val(parseInt(e.data.harga_material_skinning));
                    $('#sales_order_id_skinning').val(id);
                    $('#modal_edit_skinning').modal('show')
                    $.unblockUI();
                })
            }
        }

        function askMove(id) {
            Swal.fire({
                title: 'Pindah Data?',
                text: "Anda yakin ingin memindahkan data ini ke Manufacturing?",
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
                url: "/sales-order/move/manufacturing/" + id,
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
                            window.location = "{{ route('product-design') }}"
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

        function getStatusPure() {
            if (temp_sales_order_id != null) {
                let sales_order_id = temp_sales_order_id
                $.ajax({
                    url: '/sales-order/get_status_pure/' + sales_order_id,
                    method: 'get',
                    dataType: 'json',
                    beforeSend: function() {
                        $.blockUI({
                            message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                        })
                    }
                }).fail(e => {
                    console.log(e)
                    $.unblockUI()
                    Swal.fire('Gagal!', e.responseText, 'error')
                }).done(e => {
                    console.log(e)
                    let htmlnya = ''
                    e.data.forEach(r => {
                        htmlnya += '<tr>'
                        htmlnya +=
                            `<td><button type="button" class="btn btn-danger" onclick="processDestroyStatusPure(${r.id})"><i class="fa-solid fa-trash"></i></button></td>`
                        htmlnya += `<td>${r.notes}</td>`
                        htmlnya += `<td>${r.created_at}</td>`
                        htmlnya += `<td>${r.created_name.name}</td>`
                        htmlnya += '</tr>'
                    })
                    $('#v_status_pure').html(htmlnya)
                    $.unblockUI()
                })
            }
        }

        function processDestroyStatusPure(id) {
            $.ajax({
                url: '/sales-order/destroy_status_pure/' + id,
                method: 'post',
                dataType: 'json',
                beforeSend: function() {
                    $.blockUI({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                    })
                }
            }).fail(e => {
                console.log(e)
                $.unblockUI()
                Swal.fire('Gagal!', e.responseText, 'error')
            }).done(e => {
                console.log(e)
                $.unblockUI()
                getStatusPure()
            })
        }

        function processEditPure() {
            $.ajax({
                url: `{{ route('sales-order.update_sales_order_pure') }}`,
                method: 'post',
                data: {
                    dp_pure: $('#dp_pure').val(),
                    sub_molding_id_pure: $('#sub_molding_id_pure').val(),
                    cost_molding_pure: $('#cost_molding_pure').val(),
                    sales_order_id_pure: $('#sales_order_id_pure').val(),
                },
                beforeSend: function() {
                    $('#form-edit-pure').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                    })
                }
            }).fail(e => {
                console.log(e)
                Swal.fire('Gagal!', e.responseText, 'error')
                $('#form-edit-pure').unblock()
            }).done(e => {
                console.log(e)
                $('#form-edit-pure').unblock()
                $('#modal_edit_pure').modal('hide')

                $('#title_pure').val()
                $('#dp_pure').val()
                $('#sub_molding_id_pure').val()
                $('#cost_molding_pure').val()
                $('#sales_order_id_pure').val()

                Swal.fire('Berhasil!', 'Data Berhasil disimpan!', 'success').then(() => {
                    window.location.reload();
                })
            })
        }

        function processEditSkinning() {
            $.ajax({
                url: `{{ route('sales-order.update_sales_order_skinning') }}`,
                method: 'post',
                data: {
                    title_skinning: $('#title_skinning').val(),
                    dp_skinning: $('#dp_skinning').val(),
                    panjang_skinning: $('#panjang_skinning').val(),
                    lebar_skinning: $('#lebar_skinning').val(),
                    stock_id: $('#stock_id').val(),
                    sales_order_id_skinning: $('#sales_order_id_skinning').val(),
                },
                beforeSend: function() {
                    $('#form-edit-skinning').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                    })
                }
            }).fail(e => {
                console.log(e)
                Swal.fire('Gagal!', e.responseText, 'error')
                $('#form-edit-skinning').unblock()
            }).done(e => {
                console.log(e)

                if (e.success === false) {
                    return Swal.fire('Gagal!', e.message, 'error')
                }
                $('#form-edit-skinning').unblock()
                $('#modal_edit_skinning').modal('hide')

                $('#title_skinning').val('')
                $('#dp_skinning').val('')
                $('#panjang_skinning').val('')
                $('#lebar_skinning').val('')
                $('#stock_id').val('')
                $('#sales_order_id_skinning').val('')
                $('#harga_material_skinning').val('')

                Swal.fire('Berhasil!', 'Data Berhasil disimpan!', 'success').then(() => {
                    window.location.reload();
                })
            })
        }
    </script>
@endsection
