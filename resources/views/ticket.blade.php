<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

	<style>
		/* GENERAL */
		body { font-size: 1.2em; }

		.contenedor { padding: 15px; }
		

		.fila {
			height: auto;
			width: 100%;
		}

		.sector { padding-top: 15px; }

		/* DISTRIBUCION DE LAS COLUMNAS */
		.colIzq { text-align: left; }
		.colDer { text-align: right; }

		.col-4 {
			width: 32%;
			display: inline-block;
		}

		.col-6 {
			width: 49%;
			display: inline-block;
		}


		/* MARGEN Y PADDING */
		.margenArriba { margin-top: 35px; }
		.margenAbajo { margin-bottom: 15px; }

		
		/* LETRAS */
		.bold { font-weight: bold; }

		.subtitulo {
			width: 100%;
			margin-top: 15px;

			font-weight: bold;
			text-align: center;
		}

		/* DISENHO */
		.color-cafe { color: brown; }

		.fondo-amarillo { background-color: #FFF53C; }
		.fondo-azul { background-color: #4d4dff; }
		.fondo-negro { background-color: #000; }
		.fondo-blanco { background-color: #fff; }

		.center-texto { text-align: center; }

		
		/* ESPECIFICO */
		#qr {
			height: 400px;
			width: 400px;

			margin-top: 100px;
			margin-bottom: 100px;

			margin-right: 20%;
			margin-left: 20%;

			display: block;
		}

		#footer {
			position: absolute;
			bottom: 0;

			height: 30px;			/* Height of the footer */
			font-size: 1.2em;

			background-color: : #6cf;
		}

		.logo img {
			display: block;
			margin-right: auto;
			margin-left: auto;

			padding: 10px;
			width: 95%;
			height: 90%;

			background-size: cover;
		}

		.logo {
			height: 155px;
			width: 100%;

			background-size: contain;
		}
	</style>
</head>
<body>
	<div class="contenedor">
		<div class="fila">
			<div class="col-6">
				<div class="fila colIzq">
					<h2>
						EXMA | 
						<span class="sector">
							@if ($sector == "VIP")
								<span class="fondo-amarillo">
									VIP
								</span>
							@else
								<span class="fondo-azul">
									BUSINESS
								</span>
							@endif
						</span>
					</h2>
				</div>

				<div class="fila">
					<div class="col-6">
						<strong>Fecha:</strong>
					</div>

					<div class="col-6">
						8 y 9 de junio de 2017
					</div>
				</div>

				<div class="fila">
					<div class="col-6">
						<strong>Hora:</strong>
					</div>

					<div class="col-6">
						<span>08:00 - 19:00</span>
					</div>
				</div>

				<div class="fila">
					<div class="col-6">
						<strong>Ubicación:</strong>
					</div>

					<div class="col-6">
						<span>FEXPOCRUZ</span>
					</div>
				</div>

				<div class="fila">
					<div class="col-6">
						<strong>Número de Ticket:</strong>
					</div>

					<div class="col-6">
						<span>{{ $registro->id }}</span>
					</div>
				</div>

				<div class="fila">
					<div class="col-6">
						<strong>Dueño de Ticket:</strong>
					</div>

					<div class="col-6">
						<span>{{ $nombreCliente }}</span>
					</div>
				</div>

				<div class="fila">
					<div class="col-6">
						<strong>Butaca:</strong>
					</div>

					<div class="col-6">
						<span>{{ $butacaCliente }}</span>
					</div>
				</div>
			</div>

			<div class="col-6">
				<div class="logo margenArriba">
					<img src="{{ base_path().'/public/img/EXMA-para fondo blanco.png' }}">
				</div>
			</div>
		</div>

		<hr>

		<div class="fila">
			<div class="">
				<div class="">
					<img class="fondo-blanco" src="{{ base_path().'\public/'.$tituloQR.'.png' }}" id="qr">
				</div>
			</div>
		</div>
	</div>

	
	<div class="fila">
		<div class="center-texto" id="footer">
			<footer>Powered by OsBolivia</footer>
		</div>
	</div>
</body>
</html>