@extends('layouts.app')

@section('title')
	<title>Asistencias | EXMA</title>
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
	{{--
	<script src="{{ asset('js/panel.js') }}"></script>--}}
@endsection

@section('content')

	@if (session('mensaje'))
		<div class="container-90">
			<div class="row">
				<div class="alert alert-success">
					<p id="mensaje">{{ session('mensaje') }}</p>
				</div>
			</div>
		</div>
	@endif

	<div class="container-90">
		<div class="margenAbajo">
			<a class="btn btn-info" id="reporteAsistencia" href="{{ route('reporteAsistenciaGeneral') }}">
				Reporte General
			</a>
		</div>
	</div>

	<div class="container-90">
		<div class="page" id="">
			<div class="table-responsive">
				<table id="tablaPanel" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombre Completo</th>
							<th>Butaca</th>
							<th>Sector</th>
							<th>Reporte</th>
							<th>Estado</th>
							<th>Check</th>
						</tr>
					</thead>

					<tbody>
						@if (!empty($clientes))
							@foreach($clientes as $cliente)
								<tr>
									<td>{{ $cliente->idCliente }}</td>
									<td>{{ $cliente->nombres.' '.$cliente->apellidos }}</td>
									<td>{{ $cliente->fila . $cliente->numero }}</td>
									<td>{{ $cliente->nombre }}</td>
									<td>
										<a href="{{ route('reporteAsistencia', $cliente->idRegistro) }}" class="btn btn-warning">
											<i class="fa fa-file-pdf-o"></i>
										</a>
									</td>
									@if ($cliente->tipoAsistencia == 0)
										<td>Ausente</td>
									@else
										<td>Presente</td>
									@endif
									<td>
									@if ($cliente->tipoAsistencia == 0)
										<a data-toggle="modal" data-target="#modal" class="btn btn-success" onclick="enviar('checkin', 'Check In', {{ $cliente->id }})">
											<i class="fa fa-check"></i> Check in
										</a>
									@else
										<a data-toggle="modal" data-target="#modal" class="btn btn-danger" onclick="enviar('checkout', 'Check Out', {{ $cliente->id }})">
											<i class="fa fa-close"></i> Check out
										</a>
									@endif
									</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
				
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div id="modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			
			<!-- Modal content -->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>

					<h4 class="modal-title" id="tituloModal"></h4>
				</div>

				<div class="modal-body">
					<label for="" id="lblMensaje"></label>
				</div>

				<div class="modal-footer">
					@if (!empty($cliente))
						@if ($cliente->tipoAsistencia == 0)
							<a class="btn btn-info" id="btnAceptar" href="{{ route('asistencia', $cliente->id) }}">
								Aceptar
							</a>
						@else
							<a class="btn btn-info" id="btnAceptar" href="{{ route('asistencia', $cliente->id) }}">
								Aceptar
							</a>
						@endif
					@endif
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				</div>
			</div>

		</div>
	</div>

@endsection


