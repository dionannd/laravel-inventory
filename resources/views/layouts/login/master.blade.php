<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="extr-page">
    <head>
        <meta charset="utf-8">
        <title> @yield('title')</title>
        <meta name="description" content="myInvent">
        <meta name="author" content="Urappsdev">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
        <!-- #CSS Links -->
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/smartadmin-production-plugins.min.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/smartadmin-production.min.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/smartadmin-skins.min.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/smartadmin-rtl.min.css') }}"> 

        <link rel="shortcut icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" type="image/x-icon">

        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
        
        <link rel="apple-touch-icon" href="{{ asset('assets/img/splash/sptouch-icon-iphone.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/splash/touch-icon-ipad.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/img/splash/touch-icon-iphone-retina.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/img/splash/touch-icon-ipad-retina.png') }}">
        
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        
        <link rel="apple-touch-startup-image" href="{{ asset('assets/img/splash/ipad-landscape.png') }}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
        <link rel="apple-touch-startup-image" href="{{ asset('assets/img/splash/ipad-portrait.png') }}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
        <link rel="apple-touch-startup-image" href="{{ asset('assets/img/splash/iphone.png') }}" media="screen and (max-device-width: 320px)">

    </head>
    
    <body class="animated fadeInDown">
        <div id="main" role="main">

            <div id="content" class="container">

                @yield('content')

            </div>

        </div>

        <!--================================================== -->	

        <script src="{{ asset('assets/js/plugin/pace/pace.min.js') }}"></script>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script> if (!window.jQuery) { document.write('<script src="assets/js/libs/jquery-2.1.1.min.js"><\/script>');} </script>
        
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script> if (!window.jQuery.ui) { document.write('<script src="assets/js/libs/jquery-ui-1.10.3.min.js"><\/script>');} </script>

        <script src="{{ asset('assets/js/app.config.js') }}"></script>
        <script src="{{ asset('assets/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>
        <!--[if IE 8]>
            <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
        <![endif]-->
        <!-- MAIN APP JS FILE -->
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
        <script type="text/javascript">
            runAllForms();

            $(function() {
                // Validation
                $("#login-form").validate({
                    // Rules for form validation
                    rules : {
                        email : {
                            required : true,
                            email : true
                        },
                        password : {
                            required : true,
                            minlength : 3,
                            maxlength : 20
                        }
                    },

                    // Messages for form validation
                    messages : {
                        email : {
                            required : 'Please enter your email address',
                            email : 'Please enter a VALID email address'
                        },
                        password : {
                            required : 'Please enter your password'
                        }
                    },

                    // Do not change code below
                    errorPlacement : function(error, element) {
                        error.insertAfter(element.parent());
                    }
                });
            });
        </script>
    </body>
</html>