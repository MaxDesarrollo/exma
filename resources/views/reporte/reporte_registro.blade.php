<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

	<style>
		.contenedor { padding: 10px; }

		.fila {
			height: auto;
			width: 100%;
		}

		/* DISTRIBUCION DE LAS COLUMNAS */
		.colIzq { text-align: left; }
		.colDer { text-align: right; }

		.col-4 {
			width: 32%;
			display: inline-block;
		}

		.col-6 {
			width: 48%;
			display: inline-block;
		}


		/* MARGEN Y PADDING */
		.margenArriba { margin-top: 15px; }
		.margenAbajo { margin-bottom: 10px; }
		

		/* LETRAS */
		.bold { font-weight: bold; }

		.subtitulo {
			width: 100%;
			/*margin-top: 15px;*/

			font-weight: bold;
			text-align: center;
		}

		/* DISENHO */
		.color-cafe { color: brown; }
		.fondo-negro { background-color: #000; }

		img {
			display: block;
			margin-right: 5%;
			margin-left: 5%;

			width: 90%;
			height: 100%;
		}

		.logo {
			height: 200px;
			background-size: contain;
		}
	</style>
</head>
<body>

	<div class="contenedor logo">
		<img src="{{ base_path().'/public/img/EXMA-para fondo blanco.png' }}">
	</div>

	<div class="contenedor" >
		<h2>¡Tu entrada ha sido reservada!</h2>
		<p>
			Por favor procede a cancelar el monto de acuerdo al método de pago seleccionado para recibir tu eTicket EXMA Bolivia 2017:
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
			Detalles del pedido
		</div>

		<div class="fila margenArriba margenAbajo">
			<div class="colIzq col-6">
				<span class="color-cafe">
					Número de Pedido: 
				</span>

				<span>
					EX - {{ $registro->nombreSector . ' | ' . $registro->id }}
				</span>
			</div>

			<div class="colDer col-6">
				<span class="color-cafe">
					Fecha:
				</span>

				<span id="fecha">
					{{ $fechaActual }}
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
				EXMA | {{ $registro->nombreSector }}
			</div>

			<div class="col-4">
				1
			</div>

			<div class="col-4 colDer">
				Bs. {{ $registro->precio }}
			</div>
		</div>

		<hr>
		<div class="fila bold">
			<div class="col-6">
				Descuento:
			</div>

			<div class="col-6 colDer">
				{{ $registro->porcentajeDescuento }} %
			</div>
		</div>

		<hr>
		<div class="fila bold">
			<div class="col-6">
				Subtotal:
			</div>

			<div class="col-6 colDer">
				Bs. {{ $precioDescuentado }}.00
			</div>
		</div>

		<hr>
		<div class="fila bold">
			<div class="col-6">
				Método de pago:
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
				Bs. {{ $precioDescuentado }}.00
			</div>
		</div>

	</div>

	<div class="contenedor">
		<div class="subtitulo">
			Detalles del Cliente
		</div>

		<div class="fila">
			<div class="col-6">
				Nombre del Cliente:
			</div>

			<div class="col-6">
				{{ $registro->nombres . ' ' . $registro->apellidos }}
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

		<div class="fila">
			<div class="col-6">
				Nombre de la Empresa:
			</div>

			<div class="col-6">
				{{ $registro->nombreEmpresa }}
			</div>
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
				Email Personal:
			</div>

			<div class="col-6">
				{{ $registro->emailPersonal }}
			</div>
		</div>
	</div>
</body>
</html>