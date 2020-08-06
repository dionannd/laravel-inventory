@extends('layouts.login.master')

@section('title')
<title>Reset Password</title>
@endsection

@section('content')
<!-- Content area -->
<div class="content d-flex justify-content-center align-items-center">
    <!-- Password recovery form -->
    <form class="login-form" method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="card mb-0">
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="icon-spinner11 icon-2x text-warning border-warning border-3 rounded-round p-3 mb-3 mt-1"></i>
                    <h5 class="mb-0">Pemulihan Password</h5>
                    <span class="d-block text-muted">Silahkan cek email</span>
                </div>
                <div class="form-group form-group-feedback form-group-feedback-right">
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukan Email" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-control-feedback">
                        <i class="icon-mail5 text-muted"></i>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn bg-blue btn-block"><i class="icon-spinner11 mr-2"></i> Reset password</button>
                </div>
                <div class="text-center">
                    <a href="javascript:history.back()"><i class="icon-circle-left2"></i> kembali Login</a>
                </div>
            </div>
        </div>
    </form>
    <!-- /password recovery form -->

</div>
<!-- /content area -->
@endsection
