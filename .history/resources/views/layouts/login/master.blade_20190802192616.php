<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login</title>

        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/layout.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/components.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/colors.min.css') }}" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->

        <!-- Core JS files -->
        <script src="{{ asset('js/main/jquery.min.js') }}"></script>
        <script src="{{ asset('js/main/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/plugins/loaders/blockui.min.js') }}"></script>
        
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script src="{{ asset('js/app.js') }}"></script>
        <!-- /theme JS files -->

    </head>

<body class="bg-slate-800">

    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content-wrapper">

            @yield('content')

        </div>
    </div>

</body>
</html>