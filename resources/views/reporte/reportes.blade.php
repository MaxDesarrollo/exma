@extends('layouts.app')

@section('title')
	<title>Reportes | EXMA</title>
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
@endsection

@section('content')

	<div class="container-90">
		<div class="page">
			<div class="table-responsive">
				<table id="tablaPanel" class="table table-striped table-bordered table-hover display">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombre</th>
							<th>Reporte (PDF)</th>
							<th>Reporte (Excel)</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>1</td>
							<td>Todos los registrados</td>
							<td>
								<a href="{{ route('reporteRegistrados') }}" class="btn btn-warning">
									<i class="fa fa-file-pdf-o"></i>
								</a>
							</td>
							<td>
								<a href="{{ route('reporteRegistradosExcel') }}" class="btn btn-success">
									<i class="fa fa-file-excel-o"></i>
								</a>
							</td>
						</tr>

						<tr>
							<td>2</td>
							<td>Todos los registrados pagados</td>
							<td>
								<a href="{{ route('reporteRegistradosPagados') }}" class="btn btn-warning">
									<i class="fa fa-file-pdf-o"></i>
								</a>
							</td>
							<td>
								<a href="{{ route('reporteRegistradosPagadosExcel') }}" class="btn btn-success">
									<i class="fa fa-file-excel-o"></i>
								</a>
							</td>
						</tr>

						<tr>
							<td>3</td>
							<td>Registrados no pagados</td>
							<td>
								<a href="{{ route('reporteRegistradosNoPagados') }}" class="btn btn-warning">
									<i class="fa fa-file-pdf-o"></i>
								</a>
							</td>
							<td>
								<a href="{{ route('reporteRegistradosNoPagadosExcel') }}" class="btn btn-success">
									<i class="fa fa-file-excel-o"></i>
								</a>
							</td>
						</tr>

						<tr>
							<td>4</td>
							<td>Pagados sin butaca</td>
							<td>
								<a href="{{ route('reportePagadosSinTicket') }}" class="btn btn-warning">
									<i class="fa fa-file-pdf-o"></i>
								</a>
							</td>
							<td>
								<a href="{{ route('reportePagadosSinTicketExcel') }}" class="btn btn-success">
									<i class="fa fa-file-excel-o"></i>
								</a>
							</td>
						</tr>
						
						<tr>
							<td>5</td>
							<td>Pagados con butaca</td>
							<td>
								<a href="{{ route('reportePagadosConTicket') }}" class="btn btn-warning">
									<i class="fa fa-file-pdf-o"></i>
								</a>
							</td>
							<td>
								<a href="{{ route('reportePagadosConTicketExcel') }}" class="btn btn-success">
									<i class="fa fa-file-excel-o"></i>
								</a>
							</td>
						</tr>
						
						<tr>
							<td>6</td>
							<td>Asistencia General</td>
							<td>
								<a href="{{ route('reporteAsistenciaGeneral') }}" class="btn btn-warning">
									<i class="fa fa-file-pdf-o"></i>
								</a>
							</td>
							<td>
								<a href="{{ route('reporteAsistenciaGeneralExcel') }}" class="btn btn-success">
									<i class="fa fa-file-excel-o"></i>
								</a>
							</td>
						</tr>
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
					<button type="button" class="btn btn-info"><a id="btnAceptar" href="{{ route('pagar', '0') }}">Aceptar</a></button>
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
					<button type="button" class="btn btn-info"><a id="btnAceptarButaca" href="{{ route('reasignarButaca', '0') }}">Aceptar</a></button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				</div>
			</div>

		</div>
	</div>

	<!-- Modal para la gestion de butacas -->
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

							<input type="radio" id="rbMensajeRegistro" name="rbButaca" value="registro" onclick="enviarMensaje('registro')" checked="checked" class="gestionButaca" >
							<label for="rbMensajeRegistro">Registro</label>


							<input type="radio" id="rbMensajePago" name="rbButaca" value="pago" onclick="enviarMensaje('pago')" class="gestionButaca" >
							<label for="rbMensajePago">Pago</label>

							<input type="radio" id="rbMensajeTicket" name="rbButaca" value="ticket" onclick="enviarMensaje('ticket')" class="gestionButaca" >
							<label for="rbMensajeTicket">Ticket</label>

						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-info"><a id="btnAceptarMensaje" href="{{ route('enviarMensajeRegistro', '0') }}">Aceptar</a></button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				</div>
			</div>

		</div>
	</div>

@endsection


