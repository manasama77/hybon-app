<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | {{ $page_title ?? 'Admin' }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">

    <!-- Datatables -->
    <link
        href="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css"
        rel="stylesheet">

    @yield('aku_gaya')

    @vite([])
</head>

<body class="hold-transition layout-footer-fixed sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        @include('layouts.adminlte.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.adminlte.aside')

        <!-- Content Wrapper. Contains page content -->
        @yield('isi_aku_mas')
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        @include('layouts.adminlte.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>

    <!-- Font Awesome Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"
        integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Datatables -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.js">
    </script>

    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- BlockUI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"
        integrity="sha512-eYSzo+20ajZMRsjxB6L7eyqo5kuXuS2+wEbbOkpaur+sA2shQameiJiWEzCIDwJqaB0a4a6tCuEvCOBHUg3Skg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @yield('aku_jawa')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })

        $.blockUI.defaults.baseZ = 4000;

        /*** add active class and stay opened when selected ***/
        var url = window.location;

        // for sidebar menu entirely but not cover treeview
        $('ul.nav-sidebar a').filter(function() {
            if (this.href) {
                return this.href == url || url.href.indexOf(this.href) == 0;
            }
        }).addClass('active');

        // for the treeview
        $('ul.nav-treeview a').filter(function() {
            if (this.href) {
                return this.href == url || url.href.indexOf(this.href) == 0;
            }
        }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');

        $(document).ready(function() {
            getCountSidebar()
            setInterval(() => {
                getCountSidebar()
            }, 60000);
        })

        function getCountSidebar() {
            $.ajax({
                url: '{{ route('api.get_count_sidebar') }}',
                method: 'get',
                dataType: 'json',
                beforeSend: function() {
                    $('#c_sales_order').block({
                        message: '<i class="fas fa-spinner fa-pulse"></i>',
                    })
                    $('#c_product_design').block({
                        message: '<i class="fas fa-spinner fa-pulse"></i>',
                    })
                    $('#c_manufacturing_1').block({
                        message: '<i class="fas fa-spinner fa-pulse"></i>',
                    })
                    $('#c_manufacturing_2').block({
                        message: '<i class="fas fa-spinner fa-pulse"></i>',
                    })
                    $('#c_manufacturing_3').block({
                        message: '<i class="fas fa-spinner fa-pulse"></i>',
                    })
                    $('#c_manufacturing_cutting').block({
                        message: '<i class="fas fa-spinner fa-pulse"></i>',
                    })
                    $('#c_manufacturing_infuse').block({
                        message: '<i class="fas fa-spinner fa-pulse"></i>',
                    })
                    $('#c_finishing_1').block({
                        message: '<i class="fas fa-spinner fa-pulse"></i>',
                    })
                    $('#c_finishing_2').block({
                        message: '<i class="fas fa-spinner fa-pulse"></i>',
                    })
                    $('#c_finishing_3').block({
                        message: '<i class="fas fa-spinner fa-pulse"></i>',
                    })
                    $('#c_rfs_pending').block({
                        message: '<i class="fas fa-spinner fa-pulse"></i>',
                    })
                    $('#c_rfs_lunas').block({
                        message: '<i class="fas fa-spinner fa-pulse"></i>',
                    })
                }
            }).fail(e => {
                console.log(e)
                Swal.fire(
                    'Gagal!',
                    e.message,
                    'error'
                )
                $('#c_sales_order').unblock();
                $('#c_product_design').unblock();
                $('#c_manufacturing_1').unblock();
                $('#c_manufacturing_2').unblock();
                $('#c_manufacturing_3').unblock();
                $('#c_manufacturing_cutting').unblock();
                $('#c_manufacturing_infuse').unblock();
                $('#c_finishing_1').unblock();
                $('#c_finishing_2').unblock();
                $('#c_finishing_3').unblock();
                $('#c_rfs_pending').unblock();
                $('#c_rfs_lunas').unblock();
            }).done(e => {
                console.log(e)
                $('#c_sales_order').unblock().text(e.c_sales_order)
                $('#c_product_design').unblock().text(e.c_product_design)
                $('#c_manufacturing_1').unblock().text(e.c_manufacturing_1)
                $('#c_manufacturing_2').unblock().text(e.c_manufacturing_2)
                $('#c_manufacturing_3').unblock().text(e.c_manufacturing_3)
                $('#c_manufacturing_cutting').unblock().text(e.c_manufacturing_cutting)
                $('#c_manufacturing_infuse').unblock().text(e.c_manufacturing_infuse)
                $('#c_finishing_1').unblock().text(e.c_finishing_1)
                $('#c_finishing_2').unblock().text(e.c_finishing_2)
                $('#c_finishing_3').unblock().text(e.c_finishing_3)
                $('#c_rfs_pending').unblock().text(e.c_rfs_pending)
                $('#c_rfs_lunas').unblock().text(e.c_rfs_lunas)

            })
        }
    </script>
</body>

</html>
