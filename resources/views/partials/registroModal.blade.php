@if (Auth::check())
	<!-- Modal -->
	<div id="registroModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Registro de Cliente</h4>
				</div>
				<div class="modal-body container">

					<div class="row">
						<label class="col-xs-12" for="txtDescuento" >Descuento (%): </label>
						
						<select name="txtDescuento" id="txtDescuento" onclick="cambiarDescuento()" class="col-xs-12" >
							@foreach ($descuentos as $descuento)
								<option value="{{ $descuento->porcentajeDescuento }}">{{ $descuento->descripcion }}</option>
							@endforeach

							<!-- <option value="0">Full Price</option>
							<option value="10">10 %</option>
							<option value="20">20 %</option>
							<option value="30">30 %</option>
							<option value="50">50 %</option>
							<option value="100">Free Pass</option> -->
						</select>
						<!-- <input class="col-xs-12" type="text" id="txtDescuento" name="txtDescuento" value="0"> -->
					</div>
					
					<div class="row margenArriba">
						<label class="col-xs-12">Sector: </label>
						<div class="radio col-xs-12">

							<input type="radio" id="rbSectorVip" name="rbSector" value="vip" onclick="registroCliente('vip')">
							<label for="rbSectorVip">Vip</label>


							<input type="radio" id="rbSectorBusiness" name="rbSector" value="business" onclick="registroCliente('business')" checked="checked">
							<label for="rbSectorBusiness">Business</label>

						</div>
					</div>

				</div>
					<div class="modal-footer">

					<a href="{{ route('registroAdmin', '0/business') }}" class="btn btn-info" id="btnRegistroCliente" >
						Aceptar
					</a>

					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					
				</div>
			</div>

		</div>
	</div>
@endif