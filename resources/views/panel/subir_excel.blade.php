@extends('layouts.general')

@section('title')
	<title>Importar Excel | EXMA</title>
@endsection

@section('links')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/panel.css') }}">
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}">
@endsection

@section('scripts')
	<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
	<script src="{{ asset('js/tablas.js') }}"></script>
	
	<script src="{{ asset('js/subir_excel.js') }}"></script>
@endsection

@section('content')
	@if (session('mensaje'))
		@if (session('tipo'))
			<div class="container-90">
				<div class="row">
					<div class="alert alert-danger">
						<p id="mensaje">{{ session('mensaje') }}</p>
					</div>
				</div>
			</div>
		@else
			<div class="container-90">
				<div class="row">
					<div class="alert alert-info">
						<p id="mensaje">{{ session('mensaje') }}</p>
					</div>
				</div>
			</div>
		@endif
	@endif

	<div class="">
		<form action="{{ action('StorageController@save') }}" enctype="multipart/form-data" method="post" id="formulario">
			<div class="">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="row">
					<div class="col-xs-12 col-md-6 col-md-offset-3">
						<div class="form-group">
							<input type="file" name="fileExcel" id="fileExcel" class="form-control">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12 col-md-4 col-md-offset-4">
						<button type="submit" class="form-control btn btn-primary">Subir</button>
					</div>
				</div>
			</div>
		</form>
	</div>

	@if (!empty($datos))
		
		<div class="table-responsive">

			<table class="table table-hover table-bordered" id="tablaPanel">
				<thead>
					<th>Cliente</th>
					<th>CI</th>
					<th>Fecha de Registro</th>
					<th>Sector</th>
					<th>Tipo de Pago</th>
					<th>Precio</th>
					<th>Descuento</th>
				</thead>

				<tbody>
					@foreach($datos as $dato)
						@if ($dato->cedulaidentidad != null)
							<tr>
								<td>{{ $dato->nombres . ' ' . $dato->apellidos }}</td>
								<td>{{ $dato->cedulaidentidad }}</td>
								<td>{{ $dato->fecharegistro }}</td>
								<td>{{ $dato->sector }}</td>
								<td>{{ $dato->tipopago }}</td>
								<td>Bs. {{ $dato->precio }}</td>
								{{--
								<!-- @if (strtolower($dato->sector) == "vip")
									<td>Bs. 4000.00</td>
								@elseif (strtolower($dato->sector) == "business")
									<td>Bs. 3000.00</td>
								@endif -->
								--}}
								<td>{{ $dato->porcentajedescuento * 100 }} %</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>

		</div>

		<div class="container">
			<div class="row">
				<a href="{{ route('subir_registros') }}" class="btn btn-primary col-xs-12 col-md-6 col-md-offset-3" onclick="cargando()">
					Procesar
				</a>
			</div>
		</div>

	@endif

@endsection