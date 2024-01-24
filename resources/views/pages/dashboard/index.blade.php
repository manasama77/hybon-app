@extends('layouts.adminlte.master')

@section('isi_aku_mas')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-indigo">
                            <div class="inner">
                                <h3>{{ number_format($income, 0) }}</h3>
                                <p>INCOME</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-money-bill"></i>
                            </div>
                            {{-- <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a> --}}
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-lightblue">
                            <div class="inner">
                                <h3>{{ number_format($expense, 0) }}</h3>
                                <p>EXPENSE</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-money-bill"></i>
                            </div>
                            {{-- <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a> --}}
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-navy">
                            <div class="inner">
                                <h3>{{ number_format($order, 0) }}</h3>
                                <p>TOTAL ORDER</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-money-bill"></i>
                            </div>
                            {{-- <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a> --}}
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3>{{ number_format($paid, 0) }}</h3>
                                <p>PAID ORDER</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-money-bill"></i>
                            </div>
                            {{-- <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a> --}}
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-fuchsia">
                            <div class="inner">
                                <h3>{{ number_format($unpaid, 0) }}</h3>
                                <p>UNPAID ORDER</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-money-bill"></i>
                            </div>
                            {{-- <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a> --}}
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-pink">
                            <div class="inner">
                                <h3>{{ number_format($rfs, 0) }}</h3>
                                <p>RFS ORDER</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-money-bill"></i>
                            </div>
                            {{-- <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
