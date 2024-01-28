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
                                                        <div class="btn-group">
                                                            @if ($data->revisi_manufacturing_3 > 0)
                                                                <button type="button" class="btn btn-warning"
                                                                    onclick="showEdit('{{ $data->id }}')">
                                                                    Revisi
                                                                </button>
                                                            @endif
                                                            @if ($data->revisi_manufacturing_3 == 0)
                                                                <button type="button" class="btn btn-info"
                                                                    onclick="showEdit('{{ $data->id }}')">
                                                                    Edit
                                                                </button>
                                                            @endif
                                                            <button type="button" class="btn btn-success"
                                                                onclick="askMove('{{ $data->id }}')">
                                                                Submit
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
                            <label for="dp">DP</label>
                            <input type="number" class="form-control" id="dp" name="dp" required />
                        </div>
                        <div class="form-group">
                            <label for="photo">Upload Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*" />
                            <div class="w-100">
                                <img src="" class="img-thumbnail" alt="">
                            </div>
                        </div>

                        <hr />

                        <h2 class="text-center">MATERIAL</h2>
                        <div class="form-group">
                            <label for="stock_id">Material</label>
                            <select class="form-control" id="stock_id" name="stock_id">
                                <option value=""></option>
                            </select>
                        </div>
                        <div id="group_satuan" class="form-group" style="display: none;">
                            <label for="qty">QTY</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="qty" name="qty" />
                                <div class="input-group-append">
                                    <span class="input-group-text satuan"></span>
                                </div>
                            </div>
                        </div>
                        <div id="group_lembar" class="form-group" style="display: none;">
                            <label for="panjang">Ruang</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">P</span>
                                </div>
                                <input type="number" class="form-control" id="panjang" name="panjang" />
                                <div class="input-group-prepend">
                                    <span class="input-group-text">x</span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">L</span>
                                </div>
                                <input type="number" class="form-control" id="lebar" name="lebar" />
                                <div class="input-group-append">
                                    <span class="input-group-text satuan"></span>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="btn_tambah_material" class="btn btn-info btn-block mb-3">Tambah
                            Material</button>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><i class="fa-solid fa-cogs"></i></th>
                                        <th>Material</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Notes</th>
                                        <th>Harga Jual</th>
                                    </tr>
                                </thead>
                                <tbody id="v_material"></tbody>
                            </table>
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
        let temp_metode

        $(document).ready(function() {
            $('table').DataTable();

            $('#stock_id').on('change', () => {
                let satuan = $('#stock_id :selected').data('satuan')
                $('#satuan').text(satuan)
            })

            $('#photo').on('change', function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.img-thumbnail').attr('src', e.target.result);
                }

                reader.readAsDataURL(file);
            })

            $('#form-edit').on('submit', e => {
                e.preventDefault()

                let dp = $('#dp').val()

                let formData = new FormData()
                formData.append('photo', $('#photo')[0].files[0])
                formData.append('title', title)
                formData.append('dp', dp)

                $.ajax({
                    url: `/manufacturing-3/update/${temp_sales_order_id}`,
                    method: 'post',
                    dataType: 'json',
                    data: formData,
                    processData: false,
                    contentType: false,
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

            $('#btn_tambah_material').on('click', () => {
                let stock_id = $('#stock_id').val()
                let qty = $('#qty').val()
                let panjang = $('#panjang').val()
                let lebar = $('#lebar').val()

                if (stock_id.length == 0) {
                    return Swal.fire('Oops!', 'Material belum dipilih', 'warning')
                }

                if (temp_metode == "lembar") {
                    if (panjang.length == 0 || panjang == 0) {
                        return Swal.fire('Oops!', 'Panjang belum diisi', 'warning')
                    }
                    if (lebar.length == 0 || lebar == 0) {
                        return Swal.fire('Oops!', 'Lebar belum diisi', 'warning')
                    }
                } else {
                    if (qty.length == 0 || qty == 0) {
                        return Swal.fire('Oops!', 'QTY belum diisi', 'warning')
                    }
                }

                prosesTambahMaterial()
            })
        })

        function askMove(id) {
            Swal.fire({
                title: 'Pindah Data?',
                text: "Anda yakin ingin memindahkan data ini ke Finishing 1?",
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
                url: "/sales-order/move/finishing-1/" + id,
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
                            window.location = "{{ route('manufacturing-3') }}"
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

                let metode = e.data.metode

                $('#code_order').val(e.data.code_order)
                $('#title').val(e.data.title)
                $('#dp').val(parseInt(e.data.dp))

                if (e.data.photo_manufacturing_3) {
                    console.log(e.data.photo_manufacturing_3)
                    $('.img-thumbnail').attr('src', `/img/manufacturing/${e.data.photo_manufacturing_3}`)
                } else {
                    $('.img-thumbnail').attr('src', ``)
                }

                getMaterial()
                getListMaterial()

                $('#modal_edit').modal('show')
                $.unblockUI();
            })
        }

        function prosesTambahMaterial(id) {
            $.ajax({
                url: "{{ route('manufacturing-3.store_material') }}",
                method: "POST",
                dataType: 'json',
                data: {
                    sales_order_id: temp_sales_order_id,
                    metode: temp_metode,
                    stock_id: $('#stock_id').val(),
                    qty: $('#qty').val(),
                    panjang: $('#panjang').val(),
                    lebar: $('#lebar').val(),
                },
                beforeSend: function() {
                    $('#v_material').block({
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
                $('#v_material').unblock();

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: e.responseText
                })
            }).done(function(e) {
                $('#v_material').unblock();

                if (e.success) {
                    Swal.fire(
                        'Berhasil!',
                        e.message,
                        'success'
                    ).then((result) => {
                        $('#stock_id').val('')
                        $('#qty').val('')
                        $('#panjang').val('')
                        $('#lebar').val('')

                        getMaterial()
                        getListMaterial()
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

        function getListMaterial() {
            $.ajax({
                url: `/manufacturing-3/show-material/${temp_sales_order_id}`,
                method: "get",
                dataType: 'json',
                beforeSend: function() {
                    $('#v_material').block({
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
                $('#v_material').unblock();

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: e.responseText
                })
            }).done(function(e) {
                if (e.success) {
                    let data = e.data
                    let htmlnya = '';

                    data.forEach(el => {
                        let kode_barang = el.stock_monitor.kode_barang
                        let panjang = el.panjang
                        let lebar = el.lebar
                        let qty = el.qty
                        let satuan = el.stock_monitor.master_barang.satuan
                        let notes = el.notes
                        let metode = el.metode
                        let price = el.price

                        let isi = qty
                        if (metode == "lembar") {
                            isi = `${panjang} x ${lebar}`
                        }

                        htmlnya += `
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-danger" onclick="destroyMaterial(${el.id})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                                <td>${kode_barang}</td>
                                <td>${isi}</td>
                                <td>${satuan}</td>
                                <td>${notes}</td>
                                <td>${price}</td>
                            </tr>
                            `
                    });

                    $('#v_material').html(htmlnya)
                } else {
                    Swal.fire(
                        'Gagal!',
                        e.message,
                        'error'
                    )
                }
                $('#v_material').unblock();
            })
        }

        function destroyMaterial(id) {
            $.ajax({
                url: "{{ route('manufacturing-1.destroy-material') }}",
                method: "post",
                dataType: "json",
                data: {
                    id: id,
                },
                beforeSend: function() {
                    $('#v_material').block({
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
            }).fail(e => {
                console.log(e.responseText)
                $('#v_material').unblock();

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: e.responseText
                })
            }).done(e => {
                console.log(e)

                $('#v_material').unblock();

                if (e.success) {
                    Swal.fire(
                        'Berhasil!',
                        e.message,
                        'success'
                    ).then((result) => {
                        getMaterial()
                        getListMaterial()
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

        function getMaterial() {
            $.ajax({
                url: `{{ route('api.get_materials') }}`,
                method: "get",
                dataType: 'json',
                beforeSend: function() {
                    $('#stock_id').attr('disabled', true).html('<option value=""></option>')
                }
            }).fail(function(e) {
                $('#stock_id').attr('disabled', false)

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: e.responseText
                })
            }).done(function(e) {
                if (e.success) {
                    let data = e.data
                    let htmlnya = '<option value=""></option>';

                    data.forEach(el => {
                        let id = el.id
                        let kode_barang = el.kode_barang
                        let panjang = el.panjang
                        let lebar = el.lebar
                        let qty = el.qty
                        let satuan = el.satuan
                        let tipe_stock = el.tipe_stock
                        let ccd = "";
                        if (tipe_stock == "lembar") {
                            ccd = `(${panjang} x ${lebar})`
                        }

                        htmlnya += `
                            <option value="${id}" data-satuan="${satuan}"
                                data-tipe_stock="${tipe_stock}">
                                ${kode_barang} ${ccd}
                            </option>
                        `
                    });

                    $('#stock_id').html(htmlnya)
                } else {
                    Swal.fire(
                        'Gagal!',
                        e.message,
                        'error'
                    )
                }
                $('#stock_id').attr('disabled', false)
            })
        }
    </script>
@endsection
