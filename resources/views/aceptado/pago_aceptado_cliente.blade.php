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

	<div class="row margenArriba">
		<div class="alert alert-success">
			<h3>{{ $cliente->nombres . ' ' . $cliente->apellidos }}, tu pago ha sido completado con éxito. Entra a este link para seleccionar tu asiento:</h3>

			<a href="">
		</div>
	</div>

	

@endsection