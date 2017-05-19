<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

	<style>
		.contenedor {
			/*width: 80%;*/
			
			/*margin-left: 7%;*/
			/*margin-right: 7%;*/

			padding: 15px;
		}
		

		.fila {
			height: auto;
			width: 100%;

			/*display: block;*/
		}

		/* DISTRIBUCION DE LAS COLUMNAS */
		.colIzq {
			/*float: left;*/
			text-align: left;
		}

		.colDer {
			/*float: right;*/
			text-align: right;
		}


		.col-4 {
			/*width: 33%;*/
			width: 32%;

			display: inline-block;
		}

		.col-6 {
			/*width: 49%;*/
			width: 48%;

			display: inline-block;
		}


		/* MARGEN Y PADDING */
		.margenArriba {
			margin-top: 15px;
		}

		.margenAbajo {
			margin-bottom: 15px;
		}

		

		/* LETRAS */
		.bold {
			font-weight: bold;
		}

		.subtitulo {
			width: 100%;

			margin-top: 15px;

			font-weight: bold;

			text-align: center;
		}

		.color-cafe {
			color: brown;
		}
		
		.fondo-negro {
			background-color: #000;
		}

		img {
			display: block;
			margin-right: 5%;
			margin-left: 5%;

			width: 90%;
			height: 100%;
		}

		.logo {
			height: 200px;

			/*background-color: #000;*/
			background-size: contain;
		}
	</style>
</head>
<body>
	{{-- dd($registro) --}}

	<div class="contenedor logo">
		{{-- <img src="{{ base_path().'/public/img/loggo-exma.png' }}"> --}}
		<img src="{{ base_path().'/public/img/EXMA-para fondo blanco.png' }}">
	</div>

	{{-- base_path().'/img/loggo-exma.png' --}}

	<div class="contenedor" >
		<h2>¡Tu entrada ha sido reservada!</h2>
		<p>
			Por favor procede a cancelar el monto de acuerdo al método pago seleccionado para recibir tu eTicket EXMA Bolivia 2017:
		</p>

		@if ($registro->tipoPago == 'Deposito o Transferencia Bancaria')
			<p>
				Transferencia bancaria a la cuenta BNB: 2501352031 en Bs. a nombre de Gabriela Thellaeche. C.I. 4806225, una vez procesada la transacción enviar el comprobante a pagos@exma.com.bo para dar de alta su reserva.
			</p>
		@elseif ($registro->tipoPago == 'Pago mediante cheque') 
			<p>
				Emisión de cheques a nombre de Gabriela Thellaeche Vargas.
			</p>
		@elseif ($registro->tipoPago == 'Pago en efectivo')
			<p>
				Te esperamos en nuestras oficinas corporativas para que realices tu pago directo, estamos ubicados en la Av. Beni entre 3er y 4to anillo C/Bolpebra (7 este) Edificio Blanco Nro. 5 Piso 3. Atendemos de Lunes a Viernes de 08 a 12.30 hrs. y de 14 a 19 hrs.
			</p>
		@endif
	</div>

	<div class="contenedor">
		<div class="subtitulo">
			Detalles de la orden
		</div>

		<div class="fila margenArriba margenAbajo">
			<div class="colIzq">
				<span class="color-cafe">
					Numero de Orden: 
				</span>

				<span>
					TS | 2167 111111
				</span>
			</div>

			<div class="colDer">
				<span class="color-cafe">
					Fecha:
				</span>

				<span>
					8 de junio del 2017
				</span>
			</div>
		</div>

		<hr>
		<div class="fila">
			<div class="col-4">
				Producto
			</div>

			<div class="col-4">
				Cantidad
			</div>

			<div class="col-4 colDer">
				Precio
			</div>
		</div>

		<hr>
		<div class="fila margenArriba margenAbajo">
			<div class="col-4">
				EXMA | {{ $registro->nombre }}
			</div>

			<div class="col-4">
				1
			</div>

			<div class="col-4 colDer">
				@if ($registro->nombre == 'VIP')
					Bs. 3200.00
				@else
					Bs. 2400.00
				@endif
			</div>
		</div>

		<hr>
		<div class="fila bold">
			<div class="col-6">
				Subtotal:
			</div>

			<div class="col-6 colDer">
				@if ($registro->nombre == 'VIP')
					Bs. 3200.00
				@else
					Bs. 2400.00
				@endif
			</div>
		</div>

		<hr>
		<div class="fila bold">
			<div class="col-6">
				Metodo de pago:
			</div>

			<div class="col-6 colDer">
				{{ $registro->tipoPago }}
			</div>
		</div>

		<hr>
		<div class="fila bold">
			<div class="col-6">
				Total:
			</div>

			<div class="col-6 colDer">
				@if ($registro->nombre == 'VIP')
					Bs. 3200.00
				@else
					Bs. 2400.00
				@endif
			</div>
		</div>

	</div>

	<div class="contenedor">
		<div class="subtitulo">
			Detalles del Cliente
		</div>

		<div class="fila">
			<div class="col-6">
				Cargo en la Empresa:
			</div>

			<div class="col-6">
				{{ $registro->cargoEmpresa }}
			</div>
		</div>

		<div class="fila">
			<div class="col-6">
				Número de NIT:
			</div>

			<div class="col-6">
				{{ $registro->nit }}
			</div>
		</div>

		<div class="fila">
			<div class="col-6">
				Razón Social:
			</div>

			<div class="col-6">
				{{ $registro->razonSocial }}
			</div>
		</div>

		<div class="fila">
			<div class="col-6">
				Email Corporativo:
			</div>

			<div class="col-6">
				{{ $registro->emailCorporativo }}
			</div>
		</div>

		<div class="fila">
			<div class="col-6">
				Cédula de Identidad:
			</div>

			<div class="col-6">
				{{ $registro->cedulaIdentidad }}
			</div>
		</div>
	</div>
</body>
</html>