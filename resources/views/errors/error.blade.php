@include('layouts.general_mail')

@section('links')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/panel.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}">
@endsection

@section('scripts')
	<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

	<script src="{{ asset('js/tablas.js') }}"></script>
	{{--
	<script src="{{ asset('js/panel.js') }}"></script>--}}
@endsection


<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h1>Lo siento. Hubo un error al momento de registrar su acción. Por favor vuelva a intentarlo de nuevo.</h1>

			@if (Auth::check())
				<h3>Nota: Es posible que la acción se haya realizado de manera incompleta. Verifique si hubo cambios</h3>
			@endif
		</div>
	</div>
</div>

@if (Auth::check())
	@include('partials.boton_volver_panel')
@else
	@include('partials.boton_volver')
@endif
