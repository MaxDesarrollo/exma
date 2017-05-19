<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
//use App\Http\Requests;

use App\Cliente;
use App\Registro;
use App\Asistencia;
use App\SectorEvento;
use App\Descuento;

use \PDF;
use DB;

use \Milon\Barcode\DNS2D;
use Carbon\Carbon;

class RegistroController extends Controller
{
	// PARA MOSTRAR PAGINA DE REGISTRO
	public function index($sector = null) {

		try {

			// SI LA URL NO LLEGA CON VIP O BUSINESS, LO MANDO A BUSINESS
			if ($sector == null || ($sector != 'vip' && $sector != 'business')) {
				$sector = 'business';
			}

			// AGARRO EL DESCUENTO ACTUAL
			$descuento = DB::table('descuentos')
							->where([
								['fechaInicial', '<=', Carbon::now('America/La_Paz')->format('Y-m-d')],
								['fechaFinal', '>=', Carbon::now('America/La_Paz')->format('Y-m-d')]
							])
							->first();

			// $descuento->habilitado = Carbon::now('America/La_Paz');

			// dd($descuento);

			$descuento = Descuento::findOrFail($descuento->id);

			// VERIFICO QUE HAYA DESCUENTO, SINO ES CERO, LO INGRESO EN $DESC
			if (empty($descuento)) {
				$desc = 0;
			}
			else {
				$desc = intval($descuento->porcentajeDescuento);
			}

			// BUSCO EL SECTOR DEL EVENTO PARA EL PRECIO
			$sectorEvento = DB::table('sectores_eventos')
									->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
									->where(strtolower('sectores.nombre'), $sector)
									->select('sectores_eventos.id')
									->first();

			$sectorEvento = SectorEvento::findOrFail($sectorEvento->id);

			// REALIZO LA OPERACION PARA DARME EL PRECIO YA CON EL DESCUENTO
			$precio = $sectorEvento->precio;
			$precioDescuentado = $precio - ($precio * $desc / 100);
			
			$descuento = $descuento->porcentajeDescuento; 

			// CONSIGO TODOS LOS DESCUENTOS PARA EL ADMINISTRADOR
			$descuentos = DB::table('descuentos')
							->orderBy('porcentajeDescuento')
							->get();

			return view('registro', compact('sector', 'precioDescuentado', 'precio', 'descuento', 'descuentos'));

		}
		catch (Exception $ex) {

			// throw $ex;

			return response()->view('errors.error');

		}

	}

	// function getDescuento() {
	// 	// AGARRO EL DESCUENTO ACTUAL
	// 	$descuento = DB::table('descuentos')
	// 					->where([
	// 						['fechaInicial', '<', Carbon::now('America/La_Paz')],
	// 						['fechaFinal', '>', Carbon::now('America/La_Paz')]
	// 					])
	// 					->first();

	// 	return $descuento;
	// }

	public function store(Request $request) {
		
		try {

			// BUSCO AL CLIENTE PARA SABER SI YA EXISTE O NO
			$cliente = DB::table('clientes')
							->where('clientes.cedulaIdentidad', $request->input('txtCedulaIdentidad'))
							->select('id')
							->first();

			// SI ES VACIO SIGINIFICA QUE TODAVIA NO EXISTE
			// SI HAY, NO ENTRA AL IF Y SE USA LOS DATOS DE LA BD
			if (empty($cliente)) {

				// CREO UN NUEVO CLIENTE
				$cliente = new Cliente;

				$cliente->nombres			= $request->input('txtNombres');
				$cliente->apellidos			= $request->input('txtApellidos');
				$cliente->nombreEmpresa		= $request->input('txtNombreEmpresa');
				$cliente->cargoEmpresa		= $request->input('txtCargoEmpresa');
				$cliente->nit				= $request->input('txtNumeroNit');
				$cliente->razonSocial		= $request->input('txtRazonSocial');
				$cliente->emailPersonal		= $request->input('txtEmailPersonal');
				$cliente->emailCorporativo	= $request->input('txtEmailCorporativo');
				$cliente->cedulaIdentidad	= $request->input('txtCedulaIdentidad');
				$cliente->telefono			= $request->input('txtTelefono');

				if ($request->input('txtCiudad') == "Otros") {
					$cliente->ciudad		= $request->input('txtCiudadOtros');
				}
				else {
					$cliente->ciudad		= $request->input('txtCiudad');
				}

				$cliente->save();

			}

			// BUSCO SI HAY UN REGISTRO DEL CLIENTE, Y SI HAY, SI ES HABILITADO
			$registro = DB::table('registros')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->where([
								['clientes.cedulaIdentidad', $request->input('txtCedulaIdentidad')],
								['registros.habilitado', 1]
							])
							->select('registros.id')
							->first();

			// SI EL REGISTRO ES VACIO HAY QUE CREAR UNO NUEVO
			if (empty($registro)) {

				// BUSCO EL SECTOR DEL EVENTO
				// DE POR SI AGARRO EXMA COMO EVENTO PORQUE SE QUE EXMA ES ID = 1
				$sectorEvento = DB::table('sectores_eventos')
									->join('eventos', 'eventos.id', 'sectores_eventos.idEvento')
									->where([
										['eventos.nombre', 'EXMA'],
										['sectores_eventos.idSector', $request->input('txtSector')]
									])
									->select('sectores_eventos.id', 'sectores_eventos.precio')
									->first();

				// CREO UN REGISTRO PARA ESTE EVENTO PARA EL CLIENTE
				$registro = new Registro();

				$registro->idCliente			= $cliente->id;
				$registro->fechaRegistro		= Carbon::now('America/La_Paz');
				$registro->horaRegistro			= Carbon::now('America/La_Paz');

				$registro->idSectorEvento		= $sectorEvento->id;
				$registro->tipoPago        		= $request->input('rbPago');
				$registro->precio 	        	= $sectorEvento->precio;
				$registro->pagado				= false;
				$registro->porcentajeDescuento 	= $request->input('txtDescuento');
				// FECHA PAGO Y BUTACA SON NULOS POR AHORA
				$registro->habilitado			= true;
				if (\Auth::check()) {
					$registro->idUser			= \Auth::id();
				}
				else {
					$registro->idUser			= null;
				}

				$registro->save();

				// BUSCO DE NUEVO REGISTRO PARA METER OTROS DATOS ADICIONALES
				// DEL CLIENTE Y DEL SECTOR
				$registro = DB::table('registros')
							->join('clientes', 'registros.idCliente', 'clientes.id')
							->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
							->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
							->where([
								['habilitado', true],
								['registros.id', $registro->id]
							])
							->select('registros.id', 'registros.idCliente', 'clientes.nombres', 'clientes.apellidos', 'clientes.emailPersonal', 'sectores.nombre as nombreSector', 'registros.tipoPago', 'clientes.cargoEmpresa', 'clientes.nit', 'clientes.razonSocial', 'clientes.emailCorporativo', 'clientes.cedulaIdentidad', 'registros.idSectorEvento', 'registros.precio', 'registros.porcentajeDescuento', 'clientes.nombreEmpresa')
							->first();

				// AGARRO EL DESCUENTO ACTUAL
				$descuento = DB::table('descuentos')
								->where([
									['fechaInicial', '<=', Carbon::now('America/La_Paz')->format('Y-m-d')],
									['fechaFinal', '>=', Carbon::now('America/La_Paz')->format('Y-m-d')]
								])
								->first();

				// $descuento = $this->getDescuento();

				//$descuento = Descuento::findOrFail($descuento->id);

				// VERIFICO QUE HAYA DESCUENTO, SINO ES CERO
				if (empty($descuento)) {
					$desc = 0;
				}
				else {
					$desc = intval($descuento->porcentajeDescuento);
				}

				// CREO VARIABLES $PRECIO, $DESCUENTO Y $PRECIO DESCUENTADO
				$precioDescuentado = intval($sectorEvento->precio) - (intval($sectorEvento->precio) * $desc / 100);

				//$precio = $sectorEvento->precio;
				$descuento = $descuento->porcentajeDescuento; 

				$fechaActual = Carbon::now('America/La_Paz');

				// GENERA EL PDF
				$data = [
					'nombre' => $registro->nombres
				];
				$pdf = \PDF::loadView('reporte.reporte_registro', compact('registro', 'fechaActual', 'precioDescuentado'));

				if (!is_null($registro->emailPersonal) && !is_null($registro->emailCorporativo)) {

					// dd("entro 1");

					// ENVIA EL MENSAJE AL CLIENTE CON SU PDF
					\Mail::send('aceptado.registro_aceptado_cliente', $data, function($message) use ($registro, $pdf) {
						$message->to($registro->emailCorporativo, $registro->nombres . ' ' . $registro->apellidos);
						$message->to($registro->emailPersonal, $registro->nombres . ' ' . $registro->apellidos);
						$message->from('tickets@exma.com.bo', 'EXMA Bolivia');
						$message->bcc('gustavo@exma.com.bo');
						$message->subject($registro->nombres . ' Tu entrada ha sido reservada en EXMA Bolivia');
						$message->attachData($pdf->output(), 'Registro ' . $registro->nombres . ' ' . $registro->apellidos . '.pdf');
					});

				}
				else if (!is_null($registro->emailPersonal) || !is_null($registro->emailCorporativo)) {

					// dd("entro 2");

					// ENVIA EL MENSAJE AL CLIENTE CON SU PDF
					\Mail::send('aceptado.registro_aceptado_cliente', $data, function($message) use ($registro, $pdf) {
						if (is_null($registro->emailPersonal)) {
							$message->to($registro->emailCorporativo, $registro->nombres . ' ' . $registro->apellidos);
						}
						else {
							$message->to($registro->emailPersonal, $registro->nombres . ' ' . $registro->apellidos);
						}
						$message->from('tickets@exma.com.bo', 'EXMA Bolivia');
						$message->bcc('gustavo@exma.com.bo');
						$message->subject($registro->nombres . ' Tu entrada ha sido reservada en EXMA Bolivia');
						$message->attachData($pdf->output(), 'Registro ' . $registro->nombres . ' ' . $registro->apellidos . '.pdf');
					});

				}

				// CREO EL MENSAJE DE BIENVENIDA DEPENDE DEL SECTOR
				if ($registro->nombreSector == "VIP") {
					$mensajeSector = "BIENVENIDO A LA EXPERIENCIA VIP";
				}
				else if ($registro->nombreSector == "Business") {
					$mensajeSector = "BIENVENIDO A EXMA BUSINESS";
				}

				// CREO EL MENSAJE DEPENDE DEL TIPO DE PAGO
				if ($registro->tipoPago == "Depósito o Transferencia Bancaria") {
					$mensajeTipoPago = "Transferencia bancaria a la cuenta BNB: 2501352031 en Bs. a nombre de Gabriela Thellaeche. C.I. 4806225, una vez procesada la transacción enviar el comprobante a pagos@exma.com.bo para dar de alta su reserva.";
				}
				else if ($registro->tipoPago == "Pago mediante cheque") {
					$mensajeTipoPago = "Emisión de cheques a nombre de Gabriela Thellaeche Vargas.";
				}
				else if ($registro->tipoPago == "Pago en efectivo") {
					$mensajeTipoPago = "Te esperamos en nuestras oficinas corporativas para que realices tu pago directo, estamos ubicados en la Av. Beni entre 3er y 4to anillo C/Bolpebra (7 este) Edificio Blanco Nro. 5 Piso 3. Atendemos de Lunes a Viernes de 08 a 12.30 hrs. y de 14 a 19 hrs.";
				}

				// REDIRECCIONO A LA PAGINA DE AGRADECIMIENTO POR REGISTRARSE CON LOS DATOS
				return redirect('asientoRegistrado')
						->with('mensajeSector', $mensajeSector)
						->with('mensajeTipoPago', $mensajeTipoPago)
						->with('razonSocial', $registro->razonSocial)
						->with('nit', $registro->nit)
						->with('sector', $registro->nombreSector)
						->with('idRegistro', $registro->id)
						->with('fechaActual', $fechaActual)
						->with('precio', $registro->precio)
						->with('descuento', $registro->porcentajeDescuento)
						->with('tipoPago', $registro->tipoPago)
						->with('precioDescuentado', $precioDescuentado);

			}
			else {

				// YA EXISTE UN CLIENTE CON REGISTRO HABILITADO, ASI QUE LO REDIRECCIONA
				$mensaje = "No puede registrar este cliente, ya tiene un registro para este evento";

				return redirect()->back()->with('mensaje', $mensaje)->with('tipo', 'error')->withInput();

			}

		}
		catch (Exception $ex) {

			throw $ex;

			// return response()->view('errors.error');

		}
	}

	public function asientoIndex(Request $request) {

		try {

			// BUSCA EL PAGO DEL CLIENTE
			// FALTA LA CONTRASEÑA
			$registro = DB::table('registros')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
							->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
							->where([
								['clientes.cedulaIdentidad', $request->input('txtCI')],
								['registros.habilitado', true]
							])
							->select('registros.idCliente as idCliente', 'clientes.nombres', 'clientes.apellidos', 'sectores.nombre as nombreSector', 'sectores_eventos.idSector', 'registros.idButaca', 'registros.idSectorEvento', 'registros.password')
							->first();

			// PREGUNTO SI HAY PAGO DEL CLIENTE Y SI NO TIENE ASIENTO ASIGNADO
			if (empty($registro)) {

				$mensaje = "La cédula de Identidad o la contraseña están mal. Intente de nuevo por favor.";

			}
			else if (!empty($registro) && $registro->idButaca == null && \Hash::check($request->input('txtPassword'), $registro->password)) {
				

				$asientosOcupados = DB::table('registros')
										->join('butacas', 'butacas.id', 'registros.idButaca')
										->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
										->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
										->join('clientes', 'clientes.id', 'registros.idCliente')
										->where('registros.idSectorEvento', $registro->idSectorEvento)
										->select('registros.id as idRegistro', 'butacas.numero', 'butacas.fila', 'clientes.nombres as nombreCliente', 'clientes.apellidos as apellidoCliente', 'clientes.cargoEmpresa', 'clientes.nombreEmpresa')
										->orderBy('butacas.numero', 'asc')
										->get();

				// CONSIGO TODOS LOS DESCUENTOS PARA EL ADMINISTRADOR
				$descuentos = DB::table('descuentos')
						->orderBy('porcentajeDescuento')
						->get();

				return view('registro_asiento', compact('registro', 'asientosOcupados', 'descuentos'));

			}
			else if ($registro->idButaca != null) {

				$mensaje = "Usted ya tiene un asiento asignado, no puede escoger mas asientos.";

			}

			return redirect()->back()->with('mensaje', $mensaje);

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	public function asientoStore(Request $request) {

		try {
			

			// VERIFICO SI ALGUIEN YA INSERTO ESA BUTACA
			$butacaSeleccionada = DB::table('registros')
									->join('butacas', 'butacas.id', 'registros.idButaca')
									->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
									->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
									->where([
										['butacas.fila', substr($request->input('asientoSeleccionado'), 0, 1)],
										['butacas.numero', substr($request->input('asientoSeleccionado'), 1, 3)],
										['sectores.id', $request->input('txtIdSector')]
									])
									->select('registros.id')
									->first();

			

			if (!empty($butacaSeleccionada)) {

				$mensaje = "Ya se seleccionó esa butaca. Por favor seleccionar otra";
				return redirect('asientoRegistrado')->with('mensaje', $mensaje)->with('tipo', 'error');

			}


			// BUSCO SI YA TIENE UNA BUTACA ASIGNADA EL CLIENTE
			$asiento = DB::table('butacas')
							->join('registros', 'registros.idButaca', 'butacas.id')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->where('registros.idCliente', $request->input('txtIdCliente'))
							->select('registros.id')
							->first();

			if (empty($asiento)) {

				$cliente = Cliente::findOrFail($request->input('txtIdCliente'));

				$filaButaca = substr($request->input('asientoSeleccionado'), 0, 1);
				$numeroButaca = substr($request->input('asientoSeleccionado'), 1, 3);
				$butacaCliente = $filaButaca . $numeroButaca;

				$butaca = DB::table('butacas')
							->where([
								['fila', $filaButaca],
								['numero', $numeroButaca]
							])
							->first();				

				$registro = DB::table('registros')
								->join('clientes', 'clientes.id', 'registros.idCliente')
								->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
								->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
								->where([
									['clientes.id', $request->input('txtIdCliente')],
									['registros.habilitado', true]
								])
								->select('registros.id', 'sectores.id as idSector', 'clientes.nombres', 'clientes.apellidos', 'registros.idCliente', 'clientes.emailPersonal')
								->first();

				$sector = "Business";

				if ($registro->idSector == 1) {
					$sector = "VIP";
				}
				else if ($registro->idSector == 2) {
					$sector = "Business";
				}

				$registro = Registro::findOrFail($registro->id);
				$registro->idButaca = $butaca->id;
				$registro->save();

				$asistencia = DB::table('asistencias')
								->where([
									['asistencias.idRegistro', $registro->id]
								])
								->count();

				if ($asistencia == 0) {

					$asistencia = new Asistencia();

					$asistencia->idRegistro = $registro->id;
					$asistencia->fechaAsistencia = null;
					$asistencia->horaAsistencia = Carbon::now('America/La_Paz');
					$asistencia->tipoAsistencia = 0;
					$asistencia->estadoActivo = 1;

					$asistencia->save();
					
				}
					

				$nombreText = trim($cliente->nombres);
				$nombreText = str_replace(" ", "_", $nombreText);

				$apellidosText = trim($cliente->apellidos);
				$apellidosText = str_replace(" ", "_", $apellidosText);

				$texto = ('OSBOLIVIA-' . $nombreText . "-" . $apellidosText . "-" . $sector . "-" . $cliente->id . "-" . $butacaCliente . "-" . $registro->id);

				$nombreText = trim($cliente->nombres);
				$nombreText = str_replace(" ", "-", $nombreText);
				$nombreText = str_replace(".", "", $nombreText);


				$apellidosText = trim($cliente->apellidos);
				$apellidosText = str_replace(" ", "-", $apellidosText);
				$apellidosText = str_replace(".", "", $apellidosText);

				$tituloQR = ('OSBOLIVIA-' . $nombreText . "-" . $apellidosText . "-" . $sector . "-" . $cliente->id . "-" . $butacaCliente . "-" . $registro->id);

				// dd($texto);
				$nombreCliente = $cliente->nombres . ' ' . $cliente->apellidos;

				$d = new DNS2D();
				$todo = $d->getBarcodePNGPath($texto, "QRCODE");

				// CREO UN PDF
				$pdf = \PDF::loadView('ticket', compact('tituloQR', 'registro', 'nombreCliente', 'butacaCliente', 'sector'));

				// MANDO UN MENSAJE CON EL TICKET
				$data = [
					'nombre' => $cliente->nombres
				];

				if ($cliente->emailPersonal != null && $cliente->emailCorporativo != null) {

					\Mail::send('aceptado.ticket_mensaje', $data, function($message) use ($cliente, $pdf) {
					$message->to($cliente->emailPersonal, $cliente->nombres . ' ' . $cliente->apellidos);
					$message->to($cliente->emailCorporativo, $cliente->nombres . ' ' . $cliente->apellidos);
					$message->from('tickets@exma.com.bo', 'EXMA Bolivia');
					$message->bcc('asuarez@exma.com.bo');
					$message->subject('e-ticket ' . $cliente->nombres . ' ' . $cliente->apellidos . ' EXMA Bolivia');
					$message->attachData($pdf->output(), 'Ticket ' . $cliente->nombres . ' ' . $cliente->apellidos . '.pdf');

					});
				}
				else if ($cliente->emailPersonal != null || $cliente->emailCorporativo != null) {

					\Mail::send('aceptado.ticket_mensaje', $data, function($message) use ($cliente, $pdf) {
						if (empty($cliente->emailPersonal)) {
							$message->to($cliente->emailCorporativo, $cliente->nombres . ' ' . $cliente->apellidos);
						}
						else {
							$message->to($cliente->emailPersonal, $cliente->nombres . ' ' . $cliente->apellidos);
						}
						$message->from('tickets@exma.com.bo', 'EXMA Bolivia');
						$message->bcc('asuarez@exma.com.bo');
						$message->subject('e-ticket ' . $cliente->nombres . ' ' . $cliente->apellidos . ' EXMA Bolivia');
						$message->attachData($pdf->output(), 'Ticket ' . $cliente->nombres . ' ' . $cliente->apellidos . '.pdf');
					});

				}

				if (\Auth::check()) {
					$mensaje = "Se seleccionó el asiento de manera correcta.";
				}
				else {
					$mensaje = "Muchas gracias por seleccionar su asiento. Se le enviará un correo con su ticket.";
				}
				return redirect('asientoRegistrado')->with('mensaje', $mensaje)->with('tipo', 'exito');

			}
			else {

				$mensaje = "El cliente ya tiene un asiento asignado. No puede registrar otro asiento.";

				return redirect('asientoRegistrado')->with('mensaje', $mensaje)->with('tipo', 'error');
			}

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	public function verificarAsientoIndex() {
		// CONSIGO TODOS LOS DESCUENTOS PARA EL ADMINISTRADOR
		$descuentos = DB::table('descuentos')
						->orderBy('porcentajeDescuento')
						->get();

		return view('verificar_registro_asiento', compact('descuentos'));
	}

	public function verificarAsientoStore(Request $request) {

		return redirect()->route('registro_asiento', ['ci' => $request->input('txtCI')]);
		
	}


	public function volverAtras() {

		return redirect()->back();

	}


	public function asientoRegistrado() {

		// CONSIGO TODOS LOS DESCUENTOS PARA EL ADMINISTRADOR
		$descuentos = DB::table('descuentos')
						->orderBy('porcentajeDescuento')
						->get();

		// dd($descuentos);

		return view('aceptado.ticket_mensaje_cliente', compact('descuentos'));

	}
}
