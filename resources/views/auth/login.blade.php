@extends('layouts.app')

@section('title')
	<title>Login | EXMA</title>
@endsection

@section('links')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}">
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
						{{ csrf_field() }}

						{{--
						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							<label for="email" class="col-md-4 control-label">E-Mail Address</label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

								@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
						</div>
						--}}

						@if (Auth::check())
							@if (Auth::user()->tipoUsuario == "Vendedor")
								<div class="container-90">
									<div class="row">
										<div class="alert alert-info">
											<p id="mensaje">
												Usted ya está logueado con alguna cuenta. Si quiere ingresar con otra cuenta por favor salirse de la cuenta actual.
											</p>

											<p>
												Usted sólo tiene acceso al registro de cliente, al panel y a importar datos de Excel.
											</p>
										</div>
									</div>
								</div>
							@elseif (Auth::user()->tipoUsuario == "Administrador")
								<div class="container-90">
									<div class="row">
										<div class="alert alert-info">
											<p id="mensaje">Usted ya está logueado con alguna cuenta. Si quiere ingresar con otra cuenta por favor salirse de la cuenta actual.</p>
										</div>
									</div>
								</div>
							@endif
						@else
							<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
								<label for="name" class="col-md-4 control-label">Usuario</label>

								<div class="col-md-6">
									<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

									@if ($errors->has('name'))
										{{--
										<span class="help-block">
											<strong>{{ $errors->first('name') }}</strong>
										</span>
										--}}

										<strong class="color-red">Los datos no coinciden. Por favor intente de nuevo</strong>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
								<label for="password" class="col-md-4 control-label">Contraseña</label>

								<div class="col-md-6">
									<input id="password" type="password" class="form-control" name="password" required>

									@if ($errors->has('password'))
										<span class="help-block">
											{{--
											<strong>{{ $errors->first('password') }}</strong>
											--}}

											<strong class="color-red">Los datos no coinciden. Por favor intente de nuevo</strong>
										</span>
									@endif
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recuérdame
										</label>
									</div>
								</div>
							</div>

						
							<div class="form-group">
								<div class="col-md-8 col-md-offset-4">
									<button type="submit" class="btn btn-primary">
										Login
									</button>

									{{-- 
									<a class="btn btn-link" href="{{ route('password.request') }}">
										Forgot Your Password?
									</a>
									--}}
								</div>
							</div>
						@endif

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
