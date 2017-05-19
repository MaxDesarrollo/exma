<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	{{--
	<title>{{ config('app.name', 'Laravel') }}</title>
	--}}
	@yield('title')

	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- Styles -->
<!-- 	<link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->

	@yield('links')

	<!-- Scripts -->
	<script>
		window.Laravel = {!! json_encode([
			'csrfToken' => csrf_token(),
		]) !!};
	</script>
</head>
<body>
	<div id="app">
		<nav class="navbar navbar-default navbar-static-top">
			<div class="container">
				<div class="navbar-header">

					<!-- Collapsed Hamburger -->
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>

					<!-- Branding Image -->
					<a class="navbar-brand" href="http://www.exma.com.bo">
						{{--
						<img class="logoImagen" src="{{ asset('img/EXMA-para fondo negro.png') }}">
						--}}
					</a>

					{{--
					<a class="navbar-brand" href="{{ url('/panel') }}">
						{{ config('app.name', 'Laravel') }}
					</a>
					--}}
				</div>

				<div class="collapse navbar-collapse" id="app-navbar-collapse">
					<!-- Left Side Of Navbar -->
					@if (!Auth::guest())
						<ul class="nav navbar-nav navbar-left">

							<li data-toggle="modal" data-target="#registroModal">
								<a href="" onclick="event.preventDefault();" >
									Registro de Cliente
								</a>
							</li>

							<li>
								<a href="{{ route('panel') }}">Panel</a>
							</li>
						
							<li>
								<a href="{{ route('asistencias') }}">Asistentes</a>
							</li>
					
							<li>
								<a href="{{ route('importar_excel') }}">Importar Excel</a>
							</li>
						
							<li>
								<a href="{{ route('exportar_excel') }}">Exportar Excel</a>
							</li>

							<li>
								<a href="{{ route('reportes') }}">Reportes</a>
							</li>

						</ul>
					@endif
					
					<!-- Right Side Of Navbar -->
					<ul class="nav navbar-nav navbar-right">
						<!-- Authentication Links -->
						@if (!Auth::guest())
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									{{ Auth::user()->name }} <span class="caret"></span>
								</a>

								<ul class="dropdown-menu" role="menu">
									<li>
										<a href="{{ route('logout') }}"
											onclick="event.preventDefault();
													 document.getElementById('logout-form').submit();">
											Logout
										</a>

										<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
											{{ csrf_field() }}
										</form>
									</li>
								</ul>
							</li>
						@endif
					</ul>
				</div>
			</div>
		</nav>

		@if (Auth::check())
			@include('partials.registroModal')
		@endif
		
	   @yield('content')

	   <div class="loader-fondo">
			<div class="loader"></div>
		</div>
	</div>

	<!-- Scripts -->
<!-- 	<script src="{{ asset('js/app.js') }}"></script> -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="{{ asset('js/panel.js') }}"></script>
	<script src="{{ asset('js/general.js') }}"></script>
	@yield('scripts')
</body>
</html>
