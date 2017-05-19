@extends('layouts.general_mail')

@section('links')

@endsection

@section('content')
	<!--
	<span>
		Muchas gracias por pagar.
		Su pago se esta procesando.
		Pronto se le enviara un correo con un link para que pueda seleccionar sus asientos.
	</span>
	-->
	{{--
	<div class="row margenArriba">
		<div class="alert alert-success">
			<h3>{{ $nombre . ' ' . $apellidos }}, tu pago  ha sido completado con éxito. Entre al siguiente link para seleccionar su asiento con su contraseña:</h3>

			<span>Contraseña: {{ $password }}</span>
			<br>
			
			<a href="{{ route('verificar_registro_asiento') }}">Seleccionar asiento</a>
		</div>
	</div>
	--}}

	<div class="row">
		<h2>{{ $nombre }} bienvenido a EXMA Bolivia!</h2>
	</div>
	
	<div class="row">
		<p>
			Que felicidad! Ya estás dentro de EXMA Bolivia, tu pago se procesó correctamente, ahora solo estás a un paso para terminar el proceso y es la parte más divertida, es hora de escoger el asiento en que vas a vivir la experiencia EXMA este 8 y 9 de junio, una vez realices la selección te llegará tu e-Ticket EXMA y listo...
		</p>
	</div>

	<div class="row">
		<p>
			Recuerda que debes tener a mano el e-Ticket los días del evento ya que es tu acceso a todas las conferencias, puedes imprimirlo o simplemente guardarlo en tu celular.
		</p>
	</div>

	<div class="row">
		<p>
			Escogemos tu lugar?
		</p>
	</div>

	<div class="row">
		<p>
			Datos de acceso: <br>
			<strong> - Tu cédula de identidad</strong>
			<br>
			
			<strong> - Tu contraseña: {{ $password }}</strong>
		</p>
		
		<p>
			Ingresa <a href="{{ route('verificar_registro_asiento') }}">aquí</a>.
		</p>
	</div>

	<div class="row">
		<p>
			Nos vemos en EXMA!
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

@endsection