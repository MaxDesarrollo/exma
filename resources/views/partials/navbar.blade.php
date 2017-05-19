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
					<img class="logoImagen" src="{{ asset('img/logoEXMA.png') }}">
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
</div>