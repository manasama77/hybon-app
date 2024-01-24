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
                    <div class="col-12 col-md-4 offset-md-4">
                        <form action="{{ route('data-reference.metode-molding.store') }}" method="post">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $page_title }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Nama Metode Molding</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name') }}" required />
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <a href="{{ route('data-reference.metode-molding') }}" class="btn btn-dark mr-1">
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
        $(document).ready(function() {})
    </script>
@endsection
