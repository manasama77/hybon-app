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
                        <form action="{{ route('user-management.proses-reset-password', $data->id) }}" method="post">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $page_title }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="{{ $data->username }}" readonly />
                                        @if ($errors->has('username'))
                                            <span class="text-danger">{{ $errors->first('username') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            required />
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Password Confirmation</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required />
                                        @if ($errors->has('password_confirmation'))
                                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <a href="{{ route('user-management') }}" class="btn btn-dark mr-1">
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
