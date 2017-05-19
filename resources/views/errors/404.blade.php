@include('layouts.general')

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
			<h1>Ups! No hemos encontrado esta página.</h1>
		</div>
	</div>
</div>

@include('partials.boton_volver_atras')


