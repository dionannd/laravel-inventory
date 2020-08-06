@extends('layouts.login.master')

@section('content')
<!-- Content area -->
<div class="content d-flex justify-content-center align-items-center">

    <!-- Password recovery form -->
    <form class="login-form" method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <div class="card mb-0">
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="icon-spinner11 icon-2x text-warning border-warning border-3 rounded-round p-3 mb-3 mt-1"></i>
                    <h5 class="mb-0">Password Recovery</h5>
                    <span class="d-block text-muted">We'll send you instructions in email</span>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-right">
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Your email" required autofocus>
                    
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-control-feedback">
                        <i class="icon-mail5 text-muted"></i>
                    </div>
                </div>

                <button type="submit" class="btn bg-blue btn-block"><i class="icon-spinner11 mr-2"></i> Reset password</button>
                <a class="btn bg-blue btn-block"><i class="icon-spinner11 mr-2"></i> Back to login</a>
            </div>
        </div>
    </form>
    <!-- /password recovery form -->

</div>
<!-- /content area -->
@endsection
