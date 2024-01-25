<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ env('APP_NAME') }} - Tracking</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Template Main CSS File -->
    <link href="{{ asset('boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    @vite(['resources/css/landing/style.css', 'resources/js/landing/main.js'])

    <!-- =======================================================
  * Template Name: Siimple
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/free-bootstrap-landing-page/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div class="hero-container">
            <a href="/"><img src="{{ asset('img/logo.png') }}" alt="" class="img-fluid"
                    style="max-width: 100px; margin-top: 100px;"></a>
            <h1>Welcome to {{ env('APP_NAME') }}</h1>
            <h2>Track your order here</h2>

            <form action="/" method="get" class="php-email-form">
                @csrf
                <div class="row">
                    <div class="col-12 form-group">
                        <input type="text" name="code_order" class="form-control text-center" id="code_order"
                            placeholder="Enter your Code Order..." minlength="12" maxlength="12"
                            value="{{ old('code_order') }}" required>
                    </div>
                </div>
                <div class="text-center mt-5"><button type="submit">Search</button></div>
            </form>

            @if ($found === false)
                <div class="alert alert-danger mt-5">
                    Data Not Found
                </div>
            @endif
        </div>
    </section>

    @if ($found != null)
        <main id="main">

            <!-- ======= Search Section ======= -->
            <section id="search" class="why-us section-bg">
                <div class="container">
                    <div class="row">
                        <div class="col mb-5">
                            <h1 class="text-center mb-3"><strong>Kode Order:</strong><br />{{ $sales->code_order }}</h1>
                            <h2 class="text-center mb-3"><strong>Status Pembayaran:</strong><br />
                                @if ($sales->is_lunas === true)
                                    <badge class="badge bg-success">LUNAS</badge>
                                @else
                                    <badge class="badge bg-warning">PENDING</badge>
                                @endif
                            </h2>
                        </div>
                    </div>

                    <div class="row mt-5">
                        @foreach ($data as $d)
                            <div class="col-12 col-lg-3 col-md-6 mb-5">
                                <div class="card">
                                    <div class="card-icon">
                                        <i class="{{ $d['icon'] }} {{ $d['success'] ? 'bg-success' : '' }}"></i>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ strtoupper($d['status']) }}</h5>
                                        <p class="card-text text-center">
                                            Created at:<br />{{ $d['dt'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </section>

        </main>
    @endif

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>PT. Sistegra Emran Sentosa</span></strong>. Created for Hybon Team
            </div>
            {{-- <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/free-bootstrap-landing-page/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div> --}}
        </div>
    </footer><!-- End #footer -->

    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>



</body>

</html>
