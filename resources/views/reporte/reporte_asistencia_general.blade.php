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

			/*background-color: #000;*/
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
	</style>
</head>
<body>


	<div class="contenedor">
		<div class="subtitulo">
			Asistencia General
		</div>

		<div class="fila margenArriba margenAbajo">

			<div class="colDer">
				<span class="color-cafe">
					Fecha:
				</span>

				<span>
					{{ $fechaActual }}
				</span>
			</div>
		</div>

		{{--
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
		--}}

		<hr>
		<div class="fila">
			<div class="col-3">
				Cliente
			</div>

			<div class="col-3">
				Asistencia
			</div>

			<div class="col-3 colDer">
				Fecha
			</div>

			<div class="col-3 colDer">
				Hora
			</div>
		</div>

		@foreach ($asistencias as $asistencia)
		<hr>
		<div class="fila margenArriba margenAbajo">
			<div class="col-3">
				{{ $asistencia->nombres . ' ' . $asistencia->apellidos }}
			</div>

			@if ($asistencia->tipoAsistencia == 1)
				<div class="col-3 ingreso">
					Ingreso
				</div>
			@else 
				<div class="col-3 salida">
					Salida
				</div>
			@endif

			<div class="col-3 colDer">
				{{ $asistencia->fechaAsistencia }}
			</div>

			<div class="col-3 colDer">
				{{ $asistencia->horaAsistencia }}
			</div>
		</div>
		@endforeach
	</div>

</body>
</html>