
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="description" content="myInvent">
		<meta name="author" content="Urappsdev">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
		<title> @yield('title') </title>

        <!-- #CSS -->
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/smartadmin-production-plugins.min.css') }}">
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/smartadmin-production.min.css') }}">
		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/smartadmin-skins.min.css') }}">

		<!-- #FAVICONS -->
		<link rel="shortcut icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" type="image/x-icon">
		<link rel="icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" type="image/x-icon">

		<!-- #GOOGLE FONT -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

		<!-- Specifying a Webpage Icon for Web Clip 
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="{{ asset('assets/img/splash/sptouch-icon-iphone.png') }}">
		<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/splash/touch-icon-ipad.png') }}">
		<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/img/splash/touch-icon-iphone-retina.png') }}">
		<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/img/splash/touch-icon-ipad-retina.png') }}">
		
		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		
		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="{{ asset('assets/img/splash/ipad-landscape.png') }}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="{{ asset('assets/img/splash/ipad-portrait.png') }}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="{{ asset('assets/img/splash/iphone.png') }}" media="screen and (max-device-width: 320px)">

	</head>

	<body class="">

        <!-- #HEADER NAVBAR -->
		@include('layouts.pages.navbar')

        <!-- #SIDEBAR -->
		@include('layouts.pages.sidebar')

		<!-- MAIN PANEL / CONTENT -->
		<div id="main" role="main">

			@yield('content')

		</div>
		<!-- END MAIN PANEL -->

		<!-- #PAGE FOOTER -->
		@include('layouts.pages.footer')
		<!-- END PAGE FOOTER -->

		<div id="shortcut">
			<ul>
				<li>
					<a href="{{ route('finance.index') }}" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-money fa-4x"></i> <span>Akun Saldo <span class="label pull-right bg-color-blueLight">{{ App\Models\Finance::count() }}</span></span> </span> </a>
				</li>
				<li>
					<a href="{{ route('product.index') }}" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-cubes fa-4x"></i> <span>Tambah Barang</span> </span> </a>
				</li>
				<li>
					<a href="{{ route('purchase.index') }}" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-truck fa-4x"></i> <span>Pembelian Barang</span> </span> </a>
				</li>
				<li>
					<a href="{{ route('sales.index') }}" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-shopping-cart fa-4x"></i> <span>Penjualan Barang</span> </span> </a>
				</li>
				{{-- <li>
					<a href="gallery.html" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-picture-o fa-4x"></i> <span>Gallery </span> </span> </a>
				</li> --}}
				{{-- <li>
					<a href="profile.html" class="jarvismetro-tile big-cubes selected bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>My Profile </span> </span> </a>
				</li> --}}
			</ul>
		</div>

		<!--================================================== -->

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="{{ asset('assets/js/plugin/pace/pace.min.js') }}"></script>

		<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script>
			if (!window.jQuery) {
				document.write('<script src="{{ asset('assets/js/libs/jquery-2.1.1.min.js') }}"><\/script>');
			}
		</script>

		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script>
			if (!window.jQuery.ui) {
				document.write('<script src="{{ asset('assets/js/libs/jquery-ui-1.10.3.min.js') }}"><\/script>');
			}
		</script>

        <!-- #SCRIPTS -->
		<script src="{{ asset('assets/js/app.config.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js') }}"></script> 
		<script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets/js/notification/SmartNotification.min.js') }}"></script>
		<script src="{{ asset('assets/js/smartwidgets/jarvis.widget.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/sparkline/jquery.sparkline.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/select2/select2.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/msie-fix/jquery.mb.browser.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/fastclick/fastclick.min.js') }}"></script>

        <!--[if IE 8]>
		<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
		<![endif]-->

        <script src="{{ asset('assets/js/app.min.js') }}"></script>
		<script src="{{ asset('assets/js/speech/voicecommand.min.js') }}"></script>
		<script src="{{ asset('assets/js/smart-chat-ui/smart.chat.ui.min.js') }}"></script>
		<script src="{{ asset('assets/js/smart-chat-ui/smart.chat.manager.min.js') }}"></script>

		<script src="{{ asset('assets/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>

		<script src="{{ asset('assets/js/plugin/maxlength/bootstrap-maxlength.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/x-editable/moment.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/bootstrapvalidator/bootstrapValidator.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugin/jquery-form/jquery-form.min.js') }}"></script>

		<script type="text/javascript">

			$(document).ready(function() {
				
				// Set Up Pages
				pageSetUp();
				
				// Function Validate
				$('#form').bootstrapValidator();

			})
		
		</script>

		<!-- Your GOOGLE ANALYTICS CODE Below -->
		<script type="text/javascript">
			var _gaq = _gaq || [];
				_gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
				_gaq.push(['_trackPageview']);
			
			(function() {
				var ga = document.createElement('script');
				ga.type = 'text/javascript';
				ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(ga, s);
			})();

        </script>
        
        @stack('scripts')

	</body>
</html>