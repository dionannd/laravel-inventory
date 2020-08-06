@extends('layouts.login.master')

@section('title')
    <title>Register</title>
@endsection

@section('content')
<!-- Content area -->
<div class="content d-flex justify-content-center align-items-center">

    <!-- Registration form -->
    <form class="login-form" action="index.html">
        
        <div class="card mb-0">
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="icon-plus3 icon-2x text-success border-success border-3 rounded-round p-3 mb-3 mt-1"></i>
                    <h5 class="mb-0">Create account</h5>
                    <span class="d-block text-muted">All fields are required</span>
                </div>

                <div class="form-group text-center text-muted content-divider">
                    <span class="px-2">Your credentials</span>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="text" class="form-control" placeholder="Username">
                    <div class="form-control-feedback">
                        <i class="icon-user-check text-muted"></i>
                    </div>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="password" class="form-control" placeholder="Your email">
                    <div class="form-control-feedback">
                        <i class="icon-mention text-muted"></i>
                    </div>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="password" class="form-control" placeholder="Password">
                    <div class="form-control-feedback">
                        <i class="icon-user-lock text-muted"></i>
                    </div>
                </div>

                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="password" class="form-control" placeholder="Password Confirm">
                    <div class="form-control-feedback">
                        <i class="icon-user-lock text-muted"></i>
                    </div>
                </div>

                <button type="submit" class="btn bg-teal-400 btn-block">Register <i class="icon-circle-right2 ml-2"></i></button>
            </div>
        </div>
    </form>
    <!-- /registration form -->

</div>
<!-- /content area -->
@endsection
