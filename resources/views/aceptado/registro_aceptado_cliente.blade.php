<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

	<style>
		.contenedor { padding: 15px; }

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
		.margenAbajo { margin-bottom: 15px; }
		

		/* LETRAS */
		.bold { font-weight: bold; }

		.subtitulo {
			width: 100%;
			margin-top: 15px;

			font-weight: bold;
			text-align: center;
		}

		.color-cafe { color: brown; }

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

	<div class="contenedor" >
		<h2>¡Tu entrada ha sido reservada!</h2>
		<br>

		<h3>Hola {{ $nombre }}</h3>
		<br>

		<div class="row">
			<p>
				Tu espacio para la 3ra versión de EXMA Bolivia este 8 y 9 de junio ha sido reservado y registrado en nuestro sistema, recuerda que cuentas con 7 días hábiles para realizar tu pago, una vez confirmemos el mismo te llegará un correo de confirmación junto a un link en el cual podrás seleccionar tu asiento y obtendrás tu e-Ticket.
			</p>
		</div>

		<div class="row">
			<p>
				Revisa tu correo una vez procedas con el pago.
			</p>
		</div>

		<div class="row">
			<p>
				Con cariño,
			</p>
		</div>

		<div class="row container">
			<p>
				<strong>
					Team Exma Bolivia
					<br>

					+591 67702060
					<br>

					+591 71011835
					<br>

					Ubicación: Av. Beni - Hamacas, calle 7 este Bolpebra # 5
					<br>

					Tienes dudas? Ingresa a nuestro chat online en: 
					<a href="www.exma.com.bo">www.exma.com.bo</a>
				</strong>
			</p>
		</div>
	</div>
	
</body>
</html>