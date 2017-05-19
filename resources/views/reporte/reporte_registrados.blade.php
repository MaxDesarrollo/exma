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

		td {
			padding: 10px;
		}
		

		.fila {
			height: auto;
			width: 99%;

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

		.col-1 {
			width: 7%;
			display: inline-block;
		}

		.col-2 {
			width: 15%;
			display: inline-block;
		}


		.col-3 {
			width: 24%;
			display: inline-block;
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

			background-size: contain;
		}

		.ingreso {
			background-color: green;
			color: #fff;
			text-align: center;
		}

		.salida {
			background-color: red;
			color: #fff;
			text-align: center;
		}

		.text-center {
			text-align: center;
		}
	</style>
</head>
<body>


	<div class="contenedor">

		<div class="subtitulo">
			{{ $titulo }}
		</div>

		<div class="fila margenArriba margenAbajo">

			<div class="fila">
				<div class="colIzq col-6">
					<span class="color-cafe">
						Usuario:
					</span>

					<span>
						{{ $usuario }}
					</span>
				</div>
				
				<div class="colDer col-6">
					<span class="color-cafe">
						Fecha:
					</span>

					<span>
						{{ $fechaActual }}
					</span>
				</div>
			</div>

		</div>


		<hr>
		<div class="fila">
			<div class="col-1">
				ID
			</div>

			<div class="col-3">
				Cliente
			</div>

			<div class="col-3">
				Teléfono
			</div>

			<div class="col-2 colIzq">
				Sector
			</div>

			<div class="col-3 colDer">
				Email
			</div>
		</div>

		@foreach ($registros as $registro)
		<hr>
		<div class="fila margenArriba margenAbajo">
			<div class="col-1">
				{{ $registro->id }}
			</div>

			<div class="col-3">
				{{ $registro->nombres . ' ' . $registro->apellidos }}
			</div>

			<div class="col-3">
				{{ $registro->telefono }}
			</div>

			<div class="col-2 colIzq">
				{{ $registro->sector }}
			</div>

			<div class="col-3 colDer">
				{{ $registro->emailPersonal }}
			</div>

			
		</div>
		@endforeach

		<hr>
		<div class="fila margenArriba margenAbajo">
			<div class="margenArriba">
				Cantidad: <strong>{{ $cantidad }} registros</strong>
			</div>
		</div>

	</div>

</body>
</html>