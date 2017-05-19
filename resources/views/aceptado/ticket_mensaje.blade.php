@extends('layouts.general_mail')

@section('links')

@endsection

@section('content')

	<div class="row margenArriba">
		<h3>{{ $nombre }}, buena elección!</h3>
	</div>

	<div class="row">
		<p>
			Descarga tu e-ticket y ya está todo listo!
		</p>
	</div>

	<div class="row">
		<p>
			Gracias por tu tiempo.
		</p>
	</div>

	<div class="row">
		<p>
			Con cariño,
		</p>
	</div>

	<div class="row container">
		<p>
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
		</p>
	</div>

@endsection