<html lang="en">
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">

		@yield('title')
		
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ asset('css/general.css') }}">
		<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

		@yield('links')
	</head>

	<body>

		<!-- <div id="content">
			<h2>This is our page title</h2>
			<p>Lorem ipsum dolor sit amet.</p>
		</div> -->

		@include('partials.navbar')

		<div class="container">
			@yield('content')
		</div>

		<!-- <div id="loader-wrapper">
			<div id="loader"></div>

			<div class="loader-section section-left"></div>
			<div class="loader-section section-right"></div>
		</div> -->

		<div class="loader-fondo">
			<div class="loader"></div>
		</div>

		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="{{ asset('js/panel.js') }}"></script>
		<script src="{{ asset('js/general.js') }}"></script>

		<script>
			window.Laravel = {!! json_encode([
				'csrfToken' => csrf_token(),
			]) !!};
		</script>
		
		@yield('scripts')
		
	</body>
</html>