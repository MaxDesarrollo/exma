@extends('layouts.app')

@section('title')
	<title>Asistencias</title>
@endsection

@section('links')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/panel.css') }}">
@endsection

@section('content')

	{{-- dd($clientes) --}}

	<div class="page" id="inscrito">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Nombre Completo</th>
						<th>Butaca</th>
						<th>Sector</th>
						<th>PDF</th>
						<th>Estado</th>
						<th>Check in</th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					@foreach($clientes as $cliente)
						<tr>
							<td>{{ $cliente->idCliente }}</td>
							<td>{{ $cliente->nombres.' '.$cliente->apellidos }}</td>
							<td>{{ $cliente->fila . $cliente->numero }}</td>
							<td>{{ $cliente->nombre }}</td>
							<td>
								<a href="" class="btn btn-warning">
									<i class="fa fa-file-pdf-o"></i>
								</a>
							</td>
							<td></td>
							<td>
								<a onClick="return confirm('En verdad desea realizar el Cobro?')" href="{{ route('asistencia', $cliente->id) }}" class="btn btn-success" id='btnPagar'>
									<i class="fa fa-usd"></i> Check in
								</a>
							</td>
							<td></td>

						</tr>
					@endforeach
				</tbody>
			</table>
			
		</div>
	</div>

@endsection


