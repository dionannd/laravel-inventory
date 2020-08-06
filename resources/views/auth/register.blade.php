@extends('layouts.login.master')

@section('title')
<title>Register</title>
@endsection

@section('content')
<div class="content d-flex justify-content-center align-items-center">
    <form class="login-form" action="{{ route('register') }}" method="POST">
        @csrf

        <div class="card mb-0">
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="icon-plus3 icon-2x text-success border-success border-3 rounded-round p-3 mb-3 mt-1"></i>
                    <h5 class="mb-0">Daftar Akun</h5>
                    <span class="d-block text-muted">Semua form harus diisi</span>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-control-feedback">
                        <i class="icon-user-check text-muted"></i>
                    </div>
                    
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="Email" autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-control-feedback">
                        <i class="icon-mention text-muted"></i>
                    </div>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-control-feedback">
                        <i class="icon-user-lock text-muted"></i>
                    </div>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required autocomplete="new-password">
                    <div class="form-control-feedback">
                        <i class="icon-lock2 text-muted"></i>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn bg-teal-400 btn-block">Daftar sekarang <i class="icon-circle-right2 ml-2"></i></button>
                </div>

                <div class="form-group text-center text-muted content-divider">
                    <span class="px-2">Sudah punya akun?</span>
                </div>
                
                <div class="text-center">
                    <a href="{{ route('login') }}">Login Kembali</a>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
