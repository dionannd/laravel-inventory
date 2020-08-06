@extends('layouts.login.master')

@section('title')
    <title>Login</title>
@endsection

@section('content')
<!-- Content area -->
<div class="content d-flex justify-content-center align-items-center">

    <!-- Login form -->
    <form class="login-form" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="card mb-0">
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="icon-reading icon-2x text-warning-400 border-warning-400 border-3 rounded-round p-3 mb-3 mt-1"></i>
                    <h5 class="mb-0">Login to your Acount</h5>
                    <span class="d-block text-muted">Enter your acount in below</span>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required autofocus>
                    
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-control-feedback">
                        <i class="icon-user text-muted"></i>
                    </div>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                    
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-control-feedback">
                        <i class="icon-lock2 text-muted"></i>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 ml-2"></i></button>
                </div>

                <div class="text-center">
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                </div>
            </div>
        </div>
    </form>
    <!-- /login form -->

</div>
<!-- /content area -->
@endsection
