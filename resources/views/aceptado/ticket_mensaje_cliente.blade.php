@extends('layouts.general')

@section('title')
	<title>¡Gracias por tu reserva! | EXMA</title>
@endsection

@section('links')
@endsection

@section('content')

	{{--
	<div class="row margenArriba">
		@if (session('tipo') == 'error')
			<div class="alert alert-danger">
				<p id="mensaje">{{ session('mensaje') }}</p>
			</div>
		@elseif (session('tipo') == 'exito')
			<div class="alert alert-success">
				<p id="mensaje">{{ session('mensaje') }}</p>
			</div>
		@endif
	</div>
	--}}

	@if (session('mensajeSector'))
		<div class="row margenArriba margenAbajo text-center">
			<h3>TU ENTRADA HA SIDO RESERVADA CON ÉXITO</h3>
			<h3>{{ session('mensajeSector') }}</h3>
		</div>

		<p>
			Este formulario es personal, cada reserva debe ser llenada con los datos correspondientes al asistente para poder habilitar su ingreso este 8 y 9 de junio de 2017.
			En caso que quiera realizar el registro de un grupo corporativo, puede enviar la lista a: <a href="mailto:gabriela@exma.com.bo">gabriela@exma.com.bo</a> o <a href="mailto:Leslie@exma.com.bo">Leslie@exma.com.bo</a> 
		</p>

		<p>
			Gracias por ser parte de la Plataforma más Grande de Mercadeo en Latinoamérica! Favor proceder a cancelar el monto de su pedido de acuerdo al método de pago seleccionado para recibir tu eTicket EXMA.
		</p>


		<p>
			Una vez realizado el pago le enviaremos la factura electrónica con los datos:
		</p>

		<p>
			Nombre: <span class="bold">{{ session('razonSocial') }}</span>
			<br>

			Nit: <span class="bold">{{ session('nit') }}</span>
			<br>
		</p>

		<p class="text-center"><strong>¡GRACIAS!</strong></p>

		<div>
			<div class="row margenArriba text-center">
				<h3>Método de Pago seleccionado:</h3>
			</div>

			<div class="row bold">
				@if (session('tipoPago') == 'Deposito o Transferencia Bancaria')
					<h4>Depósito o Transferencia Bancaria:</h4>
				@else
					<h4>{{ session('tipoPago') }}:</h4>
				@endif
			</div>

			<div class="row">
				<p>
					{{ session('mensajeTipoPago') }}
				</p>
			</div>
		</div>

		<div>

			<div class="row text-center">
				<h3>Detalles del pedido</h3>
			</div>

			<div class="row margenArriba margenAbajo">
				<div class="colIzq col-md-6">
					<span class="color-cafe">
						Número de Pedido: 
					</span>

					<span>
						EX - {{ session('sector') . ' | ' . session('idRegistro') }}
					</span>
				</div>

				<div class="colDer col-md-6">
					<span class="color-cafe">
						Fecha:
					</span>

					<span>
						{{ session('fechaActual') }}
					</span>
				</div>
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
								<td>EXMA | {{ session('sector') }}<strong> x 1</strong></td>
								<td>
									Bs. {{ session('precio') }}
								</td>
							</tr>

							<tr>
								<td><strong>Descuento</strong></td>
								<td>
									<strong>{{ session('descuento') }} %</strong>
								</td>
							</tr>

							<tr>
								<td><strong>Subtotal</strong></td>
								<td>
									<strong>Bs. {{ session('precio') * (100 - session('descuento')) / 100  }}.00</strong>
								</td>
							</tr>

							<tr>
								<td><strong>Total</strong></td>
								<td>
									<strong>Bs. {{ session('precio') * (100 - session('descuento')) / 100  }}.00</strong>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	@elseif (session('mensajeButacaSeleccionada'))
		<div class="row margenArriba">
			<div class="alert alert-danger">
				<p id="mensaje">{{ session('mensajeButacaSeleccionada') }}</p>
			</div>
		</div>
	@elseif (session('mensaje'))
		<div class="row margenArriba">
			@if (session('tipo') == 'error')
				<div class="alert alert-danger">
					<p id="mensaje">{{ session('mensaje') }}</p>
				</div>
			@elseif (session('tipo') == 'exito')
				<div class="alert alert-success">
					<p id="mensaje">{{ session('mensaje') }}</p>
				</div>
			@endif
		</div>
	@endif

	@include('partials.boton_volver')
	@include('partials.boton_brochure')

@endsection