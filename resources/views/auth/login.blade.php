@extends('layouts.login.master')

@section('title', 'Login')

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
        <h1 class="txt-color-red login-header-big">my<b>Invent</b></h1>
        <div class="hero">

            <div class="pull-left login-desc-box-l">
                <h4 class="paragraph-header">Aplikasi untuk catatan barang. Pemasukan maupun pengurangan serta transaksi dan laporan!</h4>
                <div class="login-app-icons">
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm">Frontend Template</a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm">Find out more</a>
                </div>
            </div>
            
            <img src="assets/img/demo/iphoneview.png" class="pull-right display-image" alt="" style="width:210px">

        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <h5 class="about-heading">Tentang myInvent - Apa yang anda butuhkan?</h5>
                <p>
                    Aplikai ini siap memenuhi kebutuhan anda yang ingin membuat catatan maupun laporan pemasukan - pengeluaran barang secara aman dan terpercaya.
                </p>
            </div>
        </div>

    </div>
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
        <div class="well no-padding">
            <form action="{{ route('login') }}" id="login-form" class="smart-form client-form" method="POST">
                @csrf

                <header class="text-center">
                    Masuk untuk melanjutkan
                </header>

                <fieldset>
                    <section class="form-group-feedback">
                        <label class="label" for="email">Email</label>
                        <label class="input"> <i class="icon-append fa fa-user"></i>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required>
                        <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Silahkan masukan email</b></label>
                    </section>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <section class="form-group-feedback">
                        <label class="label" for="password">Password</label>
                        <label class="input"> <i class="icon-append fa fa-lock"></i>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                            <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Masukan password</b> </label>
                    </section>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </fieldset>
                <footer>
                    <button type="submit" class="btn btn-primary">
                        Masuk
                    </button>
                </footer>
            </form>
        </div>
    </div>
    <p class="text-center mb-2">
        &copy; {{ date('Y')  }} - Urappsdev | All Rights Reserved.
    </p>
</div>
@endsection