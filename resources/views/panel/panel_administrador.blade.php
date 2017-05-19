@extends('layouts.app')

@section('title')
	<title>Panel | EXMA</title>
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
		@if (session('tipo') == "exito")
			<div class="container-90">
				<div class="row">
					<div class="alert alert-success">
						<p id="mensaje">{{ session('mensaje') }}</p>
					</div>
				</div>
			</div>
		@elseif (session('tipo') == "error")
			<div class="container-90">
				<div class="row">
					<div class="alert alert-danger">
						<p id="mensaje">{{ session('mensaje') }}</p>
					</div>
				</div>
			</div>
		@endif
	@endif
	
	{{--
	<div class="container-90">
		<div class="row margenAbajo">
			<a class="btn btn-info" id="reporteAsistencia" href="{{ route('reporteAsistencia') }}">
				Reporte General
			</a>
		</div>
	</div>
	--}}

	<div class="container-90">
		<div class="page">
			<div class="table-responsive">
				<table id="tablaPanel" class="table table-striped table-bordered table-hover display">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombre Completo</th>
							<th>Correo</th>
							<th>Sector</th>
							<th>PDF</th>
							<!--<th>Estado</th>-->
							<th>Pagar</th>
							<th>Eliminar</th>
							<th>Butaca</th>
							<th>Usuario</th>
							<th>Mensajes</th>
						</tr>
					</thead>

					<tbody>
						@if (!empty($registros))
							@foreach($registros as $registro)
								<tr>
									<td>{{ $registro->id }}</td>
									<td>{{ $registro->nombres.' '.$registro->apellidos }}</td>
									@if (!empty($registro->emailPersonal))
										<td>{{ $registro->emailPersonal }}</td>
									@else
										<td>{{ $registro->emailCorporativo }}</td>
									@endif
									<td>{{ $registro->nombre }}</td>
									<td>
										<a href="{{ route('reporteRegistro', $registro->id) }}" class="btn btn-warning">
											<i class="fa fa-file-pdf-o"></i>
										</a>
									</td>
									<!--<td></td>-->
									@if ($registro->habilitado == 0) 
										<td></td>
										<td>
											Eliminado
										</td>
										<td></td>
									@elseif ($registro->pagado == 0)
										<td>
											<a data-toggle="modal" data-target="#modal" class="btn btn-success" onclick="enviar('pagar', 'Pagar', {{ $registro->id }})"><i class="fa fa-usd"></i> Pagar</a>
										</td>
										<td>
											<a data-toggle="modal" data-target="#modal" class="btn btn-danger" onclick="enviar('eliminar', 'Eliminar', {{ $registro->id }})"><i class="fa fa-trash"></i> Eliminar</a>
										</td>
										<td></td>
									@elseif ($registro->pagado == 1)
										<td>
											Ya pagado
										</td>
										<td></td>
										<td>
											@if ($registro->idButaca != null)
												{{ $registro->fila . $registro->numero }} | 
											@endif
											<a data-toggle="modal" data-target="#modalButaca" class="btn btn-info" onclick="enviar('gestionar', 'Gestionar Butacas', {{ $registro->id }})">
												Gestionar
											</a>
										</td>
									@endif
									@if (!empty($registro->nombreUsuario))
										<td>{{ $registro->nombreUsuario }}</td>
									@else
										<td>Web</td>
									@endif
									
									@if ($registro->habilitado == 0) 
										<td></td>
									@else
										<td>
											<a data-toggle="modal" data-target="#modalMensaje" class="btn btn-primary" onclick="enviar('mensajes', 'Enviar Mensaje', {{ $registro->id }})">
												Enviar
											</a>
										</td>
									@endif
										
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
					<button type="button" class="btn btn-info"><a id="btnAceptar" href="{{ route('pagar', '0') }}" class="link">Aceptar</a></button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				</div>
			</div>

		</div>
	</div>

	<!-- Modal para la gestion de butacas -->
	<div id="modalButaca" class="modal fade" role="dialog">
		<div class="modal-dialog">
			
			<!-- Modal content -->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>

					<h4 class="modal-title" id="tituloModalButaca"></h4>
				</div>

				<div class="modal-body container">
					<label for="" id="lblMensajeButaca"></label>

					<div class="row margenArriba">
						<div class="radio col-xs-12">

							<input type="radio" id="rbReasignarButaca" name="rbButaca" value="reasignar" onclick="gestionButaca('reasignar')" checked="checked" class="gestionButaca" >
							<label for="rbReasignarButaca">Reasignar</label>


							<input type="radio" id="rbEliminarButaca" name="rbButaca" value="eliminar" onclick="gestionButaca('eliminar')" class="gestionButaca" >
							<label for="rbEliminarButaca">Eliminar</label>

						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-info"><a id="btnAceptarButaca" href="{{ route('reasignarButaca', '0') }}" class="link">Aceptar</a></button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				</div>
			</div>

		</div>
	</div>

	<!-- Modal para reenviar los mensajes -->
	<div id="modalMensaje" class="modal fade" role="dialog">
		<div class="modal-dialog">
			
			<!-- Modal content -->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>

					<h4 class="modal-title" id="tituloModalMensaje"></h4>
				</div>

				<div class="modal-body container">
					<label for="" id="lblMensajeMensaje"></label>

					<div class="row margenArriba">
						<div class="radio col-xs-12">

							<input type="radio" id="rbMensajeRegistro" name="rbEnviarMensaje" value="registro" onclick="enviarMensaje('registro')" checked="checked" class="gestionButaca" >
							<label for="rbMensajeRegistro">Registro</label>


							<input type="radio" id="rbMensajePago" name="rbEnviarMensaje" value="pago" onclick="enviarMensaje('pago')" class="gestionButaca" >
							<label for="rbMensajePago">Pago</label>

							<input type="radio" id="rbMensajeTicket" name="rbEnviarMensaje" value="ticket" onclick="enviarMensaje('ticket')" class="gestionButaca" >
							<label for="rbMensajeTicket">Ticket</label>

						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-info"><a id="btnAceptarMensaje" href="{{ route('enviarMensajeRegistro', '0') }}" class="link">Aceptar</a></button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				</div>
			</div>

		</div>
	</div>

@endsection


