@extends('layouts.general')

@section('title')
	<title>Reserva tu entrada | EXMA</title>
@endsection

@section('links')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/registro.css') }}">
@endsection

@section('scripts')
	<script src="{{ asset('js/registro.js') }}" ></script>
@endsection

@section('content')
	

	<div class="row margenArriba">
		{{-- <div class="col-xs-2">
							<!--<div class="logoExma"></div>-->
							<img src="{{ url('/').'/img/EXMA-para fondo blanco.png' }}">
						</div> --}}

		<div class="col-xs-12">
			<div class="well aviso">
				Este formulario es personal, cada asistente a EXMA Bolivia debe llenar sus datos correspondientes para poder habilitar su ingreso al evento el 8 y 9 de Junio del 2017, independientemente de que pertenezca o no a un grupo corporativo.
			</div>
		</div>
	</div>

	@if (session('tipo') == 'error')
		<div class="alert alert-danger">
			<p id="mensaje">{{ session('mensaje') }}</p>
		</div>
	@elseif (session('tipo') == 'exito')
		<div class="alert alert-success">
			<p id="mensaje">{{ session('mensaje') }}</p>
		</div>
	@endif

	@if (session('mensajeDescuento'))
		<div class="alert alert-info">
			<p id="mensaje">{{ session('mensajeDescuento') }}</p>
		</div>
	@endif

	
	<form action="{{ action('RegistroController@store') }}" method="post" id="formulario">
		<div class="row">

			<div class="col-md-6 col-md-offset-3">
				<h3>Detalles de facturación</h3>

				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="form-group">
					<label for=txtCiudad>Ciudad <span class="campoObligatorio">*</span></label>

					<select class="form-control" id="txtCiudad" name="txtCiudad" onclick="verificarCiudad()">
						<option value="Santa Cruz">Santa Cruz</option>
						<option value="Beni">Beni</option>
						<option value="Chuquisaca">Chuquisaca</option>
						<option value="Cochabamba">Cochabamba</option>
						<option value="La Paz">La Paz</option>
						<option value="Oruro">Oruro</option>
						<option value="Pando">Pando</option>
						<option value="Potosi">Potosí</option>
						<option value="Tarija">Tarija</option>
						<option value="Otros">Otros</option>
					</select>
				</div>

				<div class="form-group">
					<input type="text" id="txtCiudadOtros" name="txtCiudadOtros" class="form-control esconder" >
				</div>

				<div class="row">
					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label for="txtNombres">Nombre(s) del Participante <span class="campoObligatorio">*</span></label>
							<input class="form-control" type="text" id="txtNombres" name="txtNombres" title="Se necesita el nombre del participante" required />
						</div>
					</div>

					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label for="txtApellidos">Apellido(s) del Participante <span class="campoObligatorio">*</span></label>
							<input class="form-control" type="text" id="txtApellidos" name="txtApellidos" title="Se necesita el(los) apellido(s) del participante" required />
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label for="txtNombreEmpresa">Nombre de la Empresa <span class="campoObligatorio">*</span></label>
							<input class="form-control" type="text" id="txtNombreEmpresa" name="txtNombreEmpresa" title="Se necesita el nombre de la Empresa" required />
						</div>
					</div>

					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label for="txtCargoEmpresa">Cargo en la Empresa <span class="campoObligatorio">*</span></label>
							<input class="form-control" type="text" id="txtCargoEmpresa" name="txtCargoEmpresa" title="Se necesita el cargo de la Empresa" required />
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label for="txtNit">Número de NIT <span class="campoObligatorio">*</span></label>
							<input class="form-control" type="text" id="txtNumeroNit" name="txtNumeroNit" pattern="[0-9]{1,}" required />
						</div>
					</div>

					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label for="txtRazonSocial">Razón Social <span class="campoObligatorio">*</span></label>
							<input class="form-control" type="text" id="txtRazonSocial" name="txtRazonSocial" required />
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label for="txtEmailPersonal">Email Personal <span class="campoObligatorio">*</span></label>
							<input class="form-control" type="email" id="txtEmailPersonal" name="txtEmailPersonal" required />
						</div>
					</div>

					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label for="txtEmailCorporativo">Email Corporativo</label>
							<input class="form-control" type="email" id="txtEmailCorporativo" name="txtEmailCorporativo" />
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label for="txtCedulaIdentidad">Cédula de Identidad <span class="campoObligatorio">*</span></label></label>
							<input class="form-control" type="text" id="txtCedulaIdentidad" name="txtCedulaIdentidad" pattern="[0-9]{5,10}" required />
						</div>
					</div>

					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label for="txtTelefono">Teléfono <span class="campoObligatorio">*</span></label>
							<input class="form-control" type="text" id="txtTelefono" name="txtTelefono" pattern="[0-9]{7,8}" required />
						</div>
					</div>
				</div>

				@if (strtoupper($sector) == "VIP") 
					<input type="hidden" class="form-control" type="text" id="txtSector" name="txtSector" value="1" pattern="[1-2]{1}" required />
				@elseif (strtoupper($sector) == "BUSINESS")
					<input type="hidden" class="form-control" type="text" id="txtSector" name="txtSector" value="2" pattern="[1-2]{1}" required />
				@endif
			</div>

			<input type="hidden" name="txtDescuento" id="txtDescuento" value="{{ $descuento }}">
		</div>

		<!-- MI PEDIDO -->
		<div class="row">
			<div class="col-xs-12">
				<h3>Tu Pedido</h3>
			</div>

			<div class="col-xs-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th><strong>Producto</strong></th>
								<th><strong>Total</strong></th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>EXMA | {{ strtoupper($sector) }}<strong> x 1</strong></td>
								<td>
									Bs. {{ $precio }}
								</td>
							</tr>

							<tr>
								<td><strong>Descuento</strong></td>
								<td>
									<strong>{{ $descuento }} %</strong>
								</td>
							</tr>

							<tr>
								<td><strong>Subtotal</strong></td>
								<td>
									<strong>Bs. {{ $precioDescuentado }}.00</strong>
								</td>
							</tr>

							<tr>
								<td><strong>Total</strong></td>
								<td>
									<strong>Bs. {{ $precioDescuentado }}.00</strong>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- FORMAS DE PAGO -->
		<div class="row">
			<div class="col-xs-12">
				<div class="well">
					<!-- Opcion 1 de Pago -->
					<div class="radio">
						<input type="radio" name="rbPago" id="rbPago1" class="tipoPago" checked="" value="Depósito o Transferencia Bancaria">
						<label for="rbPago1">
							Depósito o Transferencia Bancaria
						</label>
						<!-- <label>
							<input type="radio" name="rbPago" id="rbPago1" checked="" value="Deposito o Transferencia Bancaria">Deposito o Transferencia Bancaria
						</label> -->
					</div>

					<div class="alert alert-info" id="avisoPago1" >
						Transferencia bancaria a la cuenta BNB: 2501352031 en Bs. a nombre de Gabriela Thellaeche. C.I. 4806225, una vez procesada la transacción enviar el comprobante a pagos@exma.com.bo para dar de alta su reserva.
					</div>

					<!-- Opcion 2 de Pago -->
					<div class="radio">
						<input type="radio" name="rbPago" id="rbPago2" class="tipoPago" checked="" value="Pago mediante cheque">
						<label for="rbPago2">
							Pago mediante cheque
						</label>
						<!-- <label>
							<input type="radio" name="rbPago" id="rbPago2" checked="" value="Pago mediante cheque">Pago mediante cheque
						</label> -->
					</div>

					<div class="alert alert-info" id="avisoPago2" >
						Emisión de cheques a nombre de Gabriela Thellaeche Vargas.
					</div>

					<!-- Opcion 3 de Pago -->
					<div class="radio">
						<input type="radio" name="rbPago" id="rbPago3" class="tipoPago" checked="checked" value="Pago en efectivo">
						<label for="rbPago3">
							Pago en efectivo
						</label>
						<!-- <label>
							<input type="radio" name="rbPago" id="rbPago3" checked="checked" value="Pago en efectivo">Pago en efectivo
						</label> -->
					</div>

					<div class="alert alert-info" id="avisoPago3" >
						Te esperamos en nuestras oficinas corporativas para que realices tu pago directo, estamos ubicados en la Av. Beni entre 3er y 4to anillo C/Bolpebra (7 este) Edificio Blanco Nro. 5 Piso 3. Atendemos de Lunes a Viernes de 08 a 12.30 hrs. y de 14 a 19 hrs.
					</div>
				</div>
			</div>
		</div>

		<!-- BOTONES -->
		<div class="row">

			<div class="col-md-6 col-md-offset-3">
				<!-- Comprar Entrada -->
				<div class="row" id="fondo">
					<div class="col-md-2"></div>
					<div class="col-md-8 col-xs-12">
						<input type="submit" value="RESERVAR ENTRADA" id="btnComprar" class="letra-responsive" >
					</div>
				</div>
			</div>

		</div>

		@include('partials.boton_volver')

	</form>

	
@endsection


