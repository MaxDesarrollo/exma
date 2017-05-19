@extends('layouts.general_mail')

@section('title')
	<title>Selecciona tu asiento | EXMA</title>
@endsection

@section('links')
	<link rel="stylesheet" href="{{ asset('css/registro_asiento.css') }}">
@endsection

@section('scripts')
	<script src="{{ asset('js/registro_asiento.js') }}" ></script>
@endsection

@section('navbar')
	<div class="navbar navbar-default navbar-fixed-top" id="navegador" tabindex="1">
		<form id="formulario" action="{{ action('RegistroController@asientoStore') }}" method="post" class="navbar-form" >

			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			{{-- <label id="lblIdCliente" name="lblIdCliente" >{{ $registro->idCliente }}</label> --}}

			<div class="">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarAsiento" id="btnCollapseNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<div class="container-fluid row">
				<div class="inline">
					<div class="collapse navbar-collapse" id="navbarAsiento">
								
						<!-- Trigger el modal -->
						<span class="btn btn-info navbar-btn" id="imgVistaGeneral" >
						<i class="fa fa-map-o"></i> Vista General</span>

						<label id="lblClienteNombres" name="lblClienteNombres" >{{ $registro->nombres }}</label>
						<label id="lblClienteApellidos" name="lblClienteApellidos" >{{ $registro->apellidos }}</label>

						<strong>, Sector: </strong>
						<label id="lblSector" name="lblSector" class="{{ 'asiento' . $registro->nombreSector }}">{{ $registro->nombreSector }}</label>
								
					</div>
					
				</div>

				<div class="inline" id="navbar2">
					<strong>Butaca: </strong>
					<label id="lblAsientoSeleccionado" name="lblAsientoSeleccionado" value="No">No</label>

					<input type="submit" id="btnSubmit" class="btn btn-success navbar-btn" value="Finalizar registro" />
				</div>
			</div>

			<input type="hidden" id='asientoSeleccionado' name="asientoSeleccionado" value='' readonly="readonly" required />
			<input type="hidden" id="txtIdCliente" name="txtIdCliente" value="{{ $registro->idCliente }}" />
			<input type="hidden" id="txtIdSector" name="txtIdSector" value="{{ $registro->idSector }}" />
		</form>
	</div>
@endsection

@section('content')

	@if (session('mensajeButacaSeleccionada')) 
		<!-- Modal -->
		<div id="registroModal" class="modal" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Butaca ya seleccionada</h4>
					</div>
					<div class="modal-body container">

						<div class="row">
							<p class="col-xs-12">
								{{ $mensajeButacaSeleccionada }}
							</p>
						</div>

					</div>
					<div class="modal-footer">

						<button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
						
					</div>
				</div>

			</div>
		</div>
	@endif

	<div id="espacio-blanco"></div>

	<div class="row">
		<div class="tabla" >
			<table id='tblAsientos'></table>
		</div>
	</div>
	
	<div id="asientosOcupados">
		<label id="lblAsientosOcupados">
			@foreach ($asientosOcupados as $asientoOcupado)
				@if ($asientoOcupado->numero < 10)
					{{ trim($asientoOcupado->fila . '0' . $asientoOcupado->numero) }},
				@else
					{{ trim($asientoOcupado->fila . $asientoOcupado->numero) }},
				@endif
			@endforeach
		</label>

		<label id="lblClientesAsientosOcupados">
			@foreach ($asientosOcupados as $asientoOcupado)
				{{ trim($asientoOcupado->nombreCliente . ' ' . $asientoOcupado->apellidoCliente) }},
			@endforeach
		</label>

		<label id="lblClientesCargoEmpresaAsientosOcupados">
			@foreach ($asientosOcupados as $asientoOcupado)
				{{ trim($asientoOcupado->cargoEmpresa) }},
			@endforeach
		</label>

		<label id="lblClientesNombreEmpresaAsientosOcupados">
			@foreach ($asientosOcupados as $asientoOcupado)
				{{ trim($asientoOcupado->nombreEmpresa) }},
			@endforeach
		</label>
	</div>

@endsection

@section('modals')
	<!-- Modal -->
	<div id="modalVistaGeneral" class="modalAsientos">
		<!-- Boton de cerrar -->
		<span onclick="esconder('modalVistaGeneral')" class="close" id="btnCerrarVistaGeneral">&times;</span>

		<!-- Imagen en el modal content -->
		<img class="modal-content" id="imgModal" src="{{ asset('img/asientosGeneral.jpg') }}" alt="Vista General del evento">

		<!-- Texto de la imagen -->
		<div id="caption"></div>
	</div>

	<!-- Modal para mostrar la info de los asientos ocupados -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
			<!-- Contenido del Modal -->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>

					<h4 class="modal-title">Datos del Participante</h4>
				</div>

				<div class="modal-body">
					<p id="txtModalCliente">Texto en el modal</p>
					<p id="txtModalInfoCargoEmpresa">Texto en el modal</p>
					<p id="txtModalInfoNombreEmpresa">Texto en el modal</p>
				</div>

				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>


	<!-- Modal Aviso de como seleccionar asientos -->
	<div id="avisoModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">¡Selecciona tu butaca!</h4>
				</div>
				<div class="modal-body container">

					<div class="row">
						<p class="col-xs-12">
							En esta página podrás seleccionar tu asiento. Revisa todo el mapa, ¡Que es grande! Una vez seleccionado tu asiento apreta el botón "Finalizar registro".
						</p>

						<p class="col-xs-12">
							Para ver el mapa general del lugar, presiona en "Vista General" (Si estás en un móvil, primero apreta el botón superior derecho).
						</p>
					</div>

					<div class="row">
						<div class="col-xs-12">
							<img src="{{ asset('img/sillas2/sillasDesabilitadaDerecha.png') }}" alt="sillasDeshabilitada" class="imgPeq">
							<span> Sillas Deshabilitadas</span>
						</div>

						<div class="col-xs-12">
							<img src="{{ asset('img/sillas2/sillasOcupadaDerecha.png') }}" alt="sillasOcupada" class="imgPeq">
							<span> Sillas Ocupadas</span>
						</div>

						<div class="col-xs-12">
							<img src="{{ asset('img/sillas2/sillasLibreDerecha.png') }}" alt="sillasLibre" class="imgPeq">
							<span> Sillas Libres</span>
						</div>

						<div class="col-xs-12">
							<img src="{{ asset('img/sillas2/sillasSeleccionadaDerecha.png') }}" alt="sillaSeleccionada" class="imgPeq">
							<span> Silla Seleccionada</span>
						</div>
					</div>

				</div>
				<div class="modal-footer">

					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					
				</div>
			</div>

		</div>
	</div>
@endsection