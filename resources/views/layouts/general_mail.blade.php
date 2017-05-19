<html lang="en">
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
		
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ asset('css/general.css') }}">
		<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

		@yield('links')
	</head>

	<body>

		@yield('navbar')

		<div class="container-95">
			@yield('content')
		</div>

		<div class="loader-fondo">
			<div class="loader"></div>
		</div>

		@yield('modals')

		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="{{ asset('js/general.js') }}"></script>

		<script>
			window.Laravel = {!! json_encode([
				'csrfToken' => csrf_token(),
			]) !!};
		</script>
		
		@yield('scripts')
		
	</body>
</html>