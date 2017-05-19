@extends('layouts.general')

@section('title')
	<title>Verificación de registro de asiento | EXMA</title>
@endsection

@section('links')
@endsection

@section('content')
<div class="margenArriba"></div>

<div class="container">

	@if (!session('mensajeAdmin')) 
		<div class="row">
			<div class="col-xs-12 alert alert-info texto-center">
				<span>Escriba su contraseña para poder seleccionar su asiento</span>
			</div>
		</div>
	@endif

	@if (session('mensaje'))
		<div class="alert alert-danger">
			<p id="mensaje">{{ session('mensaje') }}</p>
		</div>
	@endif

	@if (session('mensajeAdmin'))
		<div class="alert alert-info">
			<p id="mensaje">{{ session('mensajeAdmin') . ' ' . session('password') }}</p>
		</div>
	@endif

	<div class="row">

		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">

				<div class="panel-heading">Verificación de seleccion de asientos</div>
				<div class="panel-body">

					<form class="form-horizontal" role="form" method="POST" action="{{ action('RegistroController@asientoIndex') }}">
						{{ csrf_field() }}

						<div class="form-group">
							<div class="row">
								<label for="txtCI" class="col-md-4 control-label">Cédula de Identidad</label>

								<div class="col-md-6">
									<input id="txtCI" type="text" class="form-control" name="txtCI" required>
								</div>
							</div>

							<div class="row">
								<label for="txtPassword" class="col-md-4 control-label">Contraseña</label>

								<div class="col-md-6">
									<input id="txtPassword" type="password" class="form-control" name="txtPassword" required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Verificar
								</button>
							</div>
						</div>
					</form>

				</div>

			</div>
		</div>

	</div>

</div>
@endsection
