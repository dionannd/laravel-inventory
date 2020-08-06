<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>App - Inventory</title>

        <!-- Font -->
        <link href="{{ asset('css/icons/fontawesome/styles.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/icons/material/icons.css') }}" rel="stylesheet" type="text/css">
        <!-- /font -->

        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
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
        <script src="{{ asset('js/plugins/visualization/d3/d3.min.js') }}"></script>
        <script src="{{ asset('js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
        <script src="{{ asset('js/plugins/forms/styling/switchery.min.js') }}"></script>
        <script src="{{ asset('js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
        <script src="{{ asset('js/plugins/ui/moment/moment.min.js') }}"></script>
        <script src="{{ asset('js/plugins/pickers/daterangepicker.js') }}"></script>
        <script src="{{ asset('js/plugins/ui/perfect_scrollbar.min.js') }}"></script>

        <script src="{{ asset('js/app.js') }}"></script>
        <!-- /theme JS files -->

        <!-- CSS -->
        @yield('css')
        <!-- /CSS-->

    </head>

    <body>

        <!-- Page content -->
        <div class="page-content">

            <!-- Content area -->
            <div class="content-wrapper">
               
                @yield('content')
                
            </div>
            <!-- /Content area -->
        </div>
        <!-- /Page content -->

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
        </script>
        @stack('scripts')
        <script>
            $('#myModal').on('hide.bs.modal', function(){
                $(this).find('form').trigger('reset');
            });
        </script>
    </body>
</html>