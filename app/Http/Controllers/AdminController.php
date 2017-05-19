<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// MODELOS
use App\Cliente;
use App\Venta;
use App\Registro;
use App\Asistencia;
use App\Descuento;
use App\SectorEvento;

use App\Mail\EnviarCorreo;
use DB;

// PARA LA HORA Y LA FECHA
use Carbon\Carbon;

use \Milon\Barcode\DNS2D;

class AdminController extends Controller
{
	// public static function getDescuento() {
	// 	// AGARRO EL DESCUENTO ACTUAL
	// 	$descuento = DB::table('descuentos')
	// 					->where([
	// 						['fechaInicial', '<', Carbon::now('America/La_Paz')],
	// 						['fechaFinal', '>', Carbon::now('America/La_Paz')]
	// 					])
	// 					->first();

	// 	return $descuento;
	// }


	// CUANDO EL ADMINISTRADOR VA A LA PAGINA DE REGISTRO DESDE 'REGISTRO DE CLIENTE'
	public function indexAdmin($descuento, $sector = null) {

		try {

			// BUSCO EL DESCUENTO QUE ME PIDIERON
			$descuentos = DB::table('descuentos')
							->where('porcentajeDescuento', $descuento)
							->first();

			// SI NO EXISTE TAL DESCUENTO LO REDIRECCIONO A LA ANTERIOR PAGINA
			if (empty($descuentos)) {

				$mensajeDescuento = "No existe tal descuento";

				return redirect()->back()->with('mensajeDescuento', $mensajeDescuento);

			}

			// LO MISMO QUE EL METODO INDEX, SOLO QUE VERIFICO EL DESCUENTO DEL ADMINISTRADOR
			// SI LA URL NO LLEGA CON VIP O BUSINESS, LO MANDO A BUSINESS
			if ($sector == null || ($sector != 'vip' && $sector != 'business')) {
				$sector = 'business';
			}

			$desc = $descuento;

			// BUSCO EL SECTOR DEL EVENTO PARA EL PRECIO
			$sectorEvento = DB::table('sectores_eventos')
								->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
								->where(strtolower('sectores.nombre'), $sector)
								->select('sectores_eventos.id', 'sectores_eventos.precio')
								->first();

			// REALIZO LA OPERACION PARA DARME EL PRECIO YA CON EL DESCUENTO
			$precio = $sectorEvento->precio;
			$precioDescuentado = $precio - ($precio * $desc / 100);

			// CONSIGO TODOS LOS DESCUENTOS PARA EL ADMINISTRADOR
			$descuentos = DB::table('descuentos')
							->orderBy('porcentajeDescuento')
							->get();

			// $descuentos = $this->getDescuento();

			return view('registro', compact('sector', 'mensaje', 'precioDescuentado', 'precio', 'descuento', 'descuentos'));

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}
	}

	// PARA MOSTRAR DATOS DE LOS REGISTROS EN EL PANEL
	public function panel() {

		try {

			// CONSIGO TODOS LOS REGISTROS CON LOS NOMBRES DE LOS CLIENTES
			// Y SUS BUTACAS SI TIENEN, POR ESO EL LEFTJOIN
			$registros = DB::table('registros')
							->join('clientes', 'registros.idCliente', 'clientes.id')
							->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
							->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
							->leftjoin('butacas', 'butacas.id', 'registros.idButaca')
							->leftjoin('users', 'users.id', 'idUser')
							->select('registros.id', 'registros.idCliente', 'clientes.nombres', 'clientes.apellidos', 'clientes.emailPersonal', 'clientes.emailCorporativo', 'sectores.nombre', 'registros.pagado', 'registros.habilitado', 'registros.idButaca', 'butacas.fila', 'butacas.numero', 'users.name as nombreUsuario')
							->get();

			// CONSIGO TODOS LOS DESCUENTOS PARA EL ADMINISTRADOR
			$descuentos = DB::table('descuentos')
							->orderBy('porcentajeDescuento')
							->get();

			// $descuentos = $this->getDescuento();

			return view('panel.panel_administrador', compact('registros', 'descuentos'));

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	} 

	// PARA PONER EN LA BD QUE EL CLIENTE YA PAGO SU REGISTRO
	public function pagar($id) {

		try {

			// BUSCO EL REGISTRO Y CAMBIO LOS DATOS DE QUE PAGO
			$registro = Registro::findOrFail($id);

			$registro->fechaPago = Carbon::now('America/La_Paz');
			$registro->pagado = true;

			// LE ASIGNO UNA CONTRASEÑA QUE TAMBIEN SE LA MANDARE POR CORREO
			$password = rand(10000, 99999);
			$registro->password = \Hash::make($password);

			$registro->save();

			// BUSCO AL CLIENTE
			$cliente = Cliente::findOrFail($registro->idCliente);

			$data = [
				'nombre'	=> $cliente->nombres,
				'apellidos' => $cliente->apellidos,
				'password' => $password
			];

			if (!empty($cliente->emailPersonal) && !empty($cliente->emailCorporativo)) {

				// dd("entro 1");

				// ENVIO EL CORREO AL CLIENTE
				\Mail::send('aceptado.pago_aceptado', $data, function($message) use ($cliente) {
					$message->to($cliente->emailPersonal, $cliente->nombres . ' ' . $cliente->apellidos);
					$message->to($cliente->emailCorporativo, $cliente->nombres . ' ' . $cliente->apellidos);
					$message->from('tickets@exma.com.bo', 'EXMA Bolivia');
					$message->bcc('asuarez@exma.com.bo');
					$message->subject('La compra de tu ticket EXMA Bolivia ha sido exitosa');
				});

			}
			else if (!empty($cliente->emailPersonal) || !empty($cliente->emailCorporativo)) {

				// dd("entro 2");

				// ENVIO EL CORREO AL CLIENTE
				\Mail::send('aceptado.pago_aceptado', $data, function($message) use ($cliente) {
					if (empty($cliente->emailPersonal)) {
						$message->to($cliente->emailCorporativo, $cliente->nombres . ' ' . $cliente->apellidos);
					}
					else {
						$message->to($cliente->emailPersonal, $cliente->nombres . ' ' . $cliente->apellidos);
					}
					$message->from('tickets@exma.com.bo', 'EXMA Bolivia');
					$message->bcc('asuarez@exma.com.bo');
					$message->subject('La compra de tu ticket EXMA Bolivia ha sido exitosa');
				});

			}

			// LE MANDO UN MENSAJE AVISANDO QUE TODO SALIO BIEN
			$mensaje = "El pago del cliente ha sido registrado efectivamente.";
			return redirect()->back()->with('mensaje', $mensaje)->with('tipo', 'exito');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	// PARA INHABILITAR UN REGISTRO
	public function eliminar($id) {

		try {

			// BUSCO EL REGISTRO Y DEJO EN FALSO (0) EL CAMPO HABILITADO
			$registro = Registro::findOrFail($id);

			$registro->habilitado = false;
			// $registro->idButaca = null;
			$registro->save();

			// LE AVISO QUE TODO SALIO BIEN
			$mensaje = "El registro del cliente ha sido eliminado efectivamente.";
			return redirect()->back()->with('mensaje', $mensaje)->with('tipo', 'exito');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	// PARA PODER DAR CHECK IN Y CHECK OUT MANUAL
	public function asistentes() {

		try {

			// SI EL USUARIO NO ES ADMINISTRADOR LO REDIRECCIONO A LOGIN
			if (\Auth::user()->tipoUsuario == "Vendedor") {

				$mensaje = "No tiene autorización para entrar aquí.";

				return redirect('login')->with('mensaje', $mensaje);

			}

			// AGARRA LOS DATOS DEL CLIENTE Y AGARRA SU ULTIMA ASISTENCIA PARA CONTROLAR EL CHECK IN O CHECK OUT
			$clientes = DB::table('registros')
							->join('butacas', 'butacas.id', 'registros.idButaca')
							->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
							->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->join('asistencias', 'asistencias.idRegistro', 'registros.id')
							->where([
								['asistencias.estadoActivo', true]
							])
							->select('clientes.id', 'registros.idCliente', 'clientes.nombres', 'clientes.apellidos', 'sectores.nombre', 'butacas.numero', 'butacas.fila', 'asistencias.tipoAsistencia', 'registros.id as idRegistro')
							->get();

			// CONSIGO TODOS LOS DESCUENTOS PARA EL ADMINISTRADOR
			$descuentos = DB::table('descuentos')
							->orderBy('porcentajeDescuento')
							->get();

			return view('panel.panel_clientes', compact('clientes', 'descuentos'));
			
		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}
			
	}

	// PARA INSERTAR LA ASISTENCIA DE UN CLIENTE
	public function asistencia($id) {
		
		try {

			// AVERIGUO COMO ERA LA ASISTENCIA ANTERIOR (SI INGRESO O SALIO)
			$asistenciaAnteriorId = DB::table('asistencias')
							->join('registros', 'registros.id', 'asistencias.idRegistro')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->where([
								['asistencias.estadoActivo', true],
								['clientes.id', $id]
							])
							->select('asistencias.id')
							->orderBy('asistencias.id', 'desc')
							->first();

			$asistenciaAnterior = Asistencia::findOrFail($asistenciaAnteriorId->id);

			// CREO UNA NUEVA ASISTENCIA, LA ACTUAL DEL CLIENTE
			$asistencia = new Asistencia();

			if ($asistenciaAnterior->tipoAsistencia == 1) {
				$asistencia->tipoAsistencia = 0;
			}
			else {
				$asistencia->tipoAsistencia = 1;
			}

			$asistencia->fechaAsistencia = Carbon::now('America/La_Paz');
			$asistencia->horaAsistencia = Carbon::now('America/La_Paz');
			$asistencia->idRegistro = $asistenciaAnterior->idRegistro;

			// PONGO QUE LA ULTIMA ASISTENCIA ACTIVA DEL CLIENTE ES LA NUEVA ASISTENCIA
			$asistenciaAnterior->estadoActivo = 0;
			$asistencia->estadoActivo = 1;

			$asistenciaAnterior->save();
			$asistencia->save();

			// SE AVISA QUE TODO SALIO BIEN
			$mensaje = "Se registró la asistencia del cliente al evento correctamente";
			return redirect()->back()->with('mensaje', $mensaje);

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}
	}


	// PARA GESTIONAR LAS BUTACAS DE LOS CLIENTES
	public function reasignarButaca($id) {

		try {

			$registro = DB::table('registros')
							->leftjoin('butacas', 'butacas.id', 'registros.idButaca')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->where('registros.id', $id)
							->select('registros.idButaca', 'registros.password', 'registros.id', 'clientes.cedulaIdentidad')
							->first();

			if ($registro->idButaca != null) {

				$idRegistro = $registro->id;

				$registro = Registro::findOrFail($idRegistro);
				$cliente = Cliente::findOrFail($registro->idCliente);

				$registro->idButaca = null;
				$registro->save();

				return redirect()->route('registro_asiento_admin', ['ci' => $cliente->cedulaIdentidad]);
				
			}

			return redirect()->route('registro_asiento_admin', ['ci' => $registro->cedulaIdentidad]);

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	public function eliminarButaca($id) {

		try {

			$registro = DB::table('registros')
							->leftjoin('butacas', 'butacas.id', 'registros.idButaca')
							->where([
								['registros.id', $id],
								['registros.habilitado', true]
							])
							->select('registros.id', 'registros.idButaca')
							->first();



			if ($registro->idButaca == null) {
				$mensaje = "El cliente no tenía una butaca asignada";

				return redirect()->action('AdminController@panel')->with('mensaje', $mensaje)->with('tipo', 'error');

				return redirect()->back()->with('mensaje', $mensaje);
			}

			$registro = Registro::findOrFail($registro->id);

			$registro->idButaca = null;
			$registro->save();

			$mensaje = "Butaca del cliente eliminada satisfactoriamente";
			return redirect()->back()->with('mensaje', $mensaje)->with('tipo', 'error');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}
		
	}

	public function asientoIndexAdmin($ci) {

		try {

			// BUSCA EL PAGO DEL CLIENTE
			// FALTA LA CONTRASEÑA
			$registro = DB::table('registros')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
							->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
							->where([
								['clientes.cedulaIdentidad', $ci],
								['registros.habilitado', true]
							])
							->select('registros.idCliente as idCliente', 'clientes.nombres', 'clientes.apellidos', 'sectores.nombre as nombreSector', 'sectores_eventos.idSector', 'registros.idButaca', 'registros.idSectorEvento')
							->first();
				

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
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}


	public function redireccionar($mensaje = "") {

		try {

			// CONSIGO TODOS LOS DESCUENTOS PARA EL ADMINISTRADOR
			$descuentos = DB::table('descuentos')
							->orderBy('porcentajeDescuento')
							->get();

			return redirect()->action('AdminController@panel');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}


	// PARA QUE EL ADMINISTRADOR MANDE MENSAJES AL CLIENTE
	public function enviarMensajeRegistro($id) {

		try {

			$registro = DB::table('registros')
							->join('clientes', 'registros.idCliente', 'clientes.id')
							->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
							->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
							->where([
								['habilitado', true],
								['registros.id', $id]
							])
							->select('registros.id', 'registros.idCliente', 'clientes.nombres', 'clientes.apellidos', 'clientes.emailPersonal', 'clientes.emailCorporativo', 'sectores.nombre as nombreSector', 'registros.tipoPago', 'clientes.cargoEmpresa', 'clientes.nit', 'clientes.razonSocial', 'clientes.emailCorporativo', 'clientes.cedulaIdentidad', 'registros.idSectorEvento', 'registros.precio', 'registros.porcentajeDescuento', 'clientes.nombreEmpresa')
							->first();

			// CREO VARIABLES $PRECIO, $DESCUENTO Y $PRECIO DESCUENTADO
			$precioDescuentado = intval($registro->precio) - (intval($registro->precio) * $registro->porcentajeDescuento / 100);

			$fechaActual = Carbon::now('America/La_Paz');

			// GENERA EL PDF
			$data = [
				'nombre' => $registro->nombres
			];
			$pdf = \PDF::loadView('reporte.reporte_registro', compact('registro', 'fechaActual', 'precioDescuentado'));

			if (!empty($registro->emailPersonal) && !empty($registro->emailCorporativo)) {

				// ENVIA EL MENSAJE AL CLIENTE CON SU PDF
				\Mail::send('aceptado.registro_aceptado_cliente', $data, function($message) use ($registro, $pdf) {
					$message->to($registro->emailPersonal, $registro->nombres . ' ' . $registro->apellidos);
					$message->to($registro->emailCorporativo, $registro->nombres . ' ' . $registro->apellidos);
					$message->from('tickets@exma.com.bo', 'EXMA Bolivia');
					$message->bcc('gustavo@exma.com.bo');
					$message->subject($registro->nombres . ' Tu entrada ha sido reservada en EXMA Bolivia');
					$message->attachData($pdf->output(), 'Registro ' . $registro->nombres . ' ' . $registro->apellidos . '.pdf');
				});

			}
			else if (!empty($registro->emailPersonal) || !empty($registro->emailCorporativo)) {

				// ENVIA EL MENSAJE AL CLIENTE CON SU PDF
				\Mail::send('aceptado.registro_aceptado_cliente', $data, function($message) use ($registro, $pdf) {
					if (empty($registro->emailPersonal)) {
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

			// CREA UN MENSAJE PARA EL CLIENTE Y LO DEVUELVE A LA PAGINA
			$mensaje = "Mensaje de Registro enviado correctamente";
			return redirect()->back()->with('mensaje', $mensaje)->with('tipo', 'exito');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	public function enviarMensajePago($id) {

		try {

			$registro = DB::table('registros')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->where('registros.id', $id)
							->select('registros.password', 'registros.idCliente', 'registros.pagado', 'clientes.nombres', 'clientes.apellidos', 'clientes.emailPersonal', 'clientes.emailCorporativo', 'registros.id')
							->first();

			if ($registro->pagado == 0) {
				// CREA UN MENSAJE PARA EL ADMNISTRADOR Y LO DEVUELVE A LA PAGINA
				$mensaje = "No se puede enviar porque el cliente no ha pagado todavía";

				return redirect()->back()->with('mensaje', $mensaje)->with('tipo', 'error');
			}

			$registroPass = Registro::findOrFail($registro->id);
			
			$password = rand(10000, 99999);
			$registroPass->password = \Hash::make($password);

			$registroPass->save();


			$data = [
				'nombre'	=> $registro->nombres,
				'apellidos' => $registro->apellidos,
				'password' => $password
			];

			if (!empty($registro->emailPersonal) && !empty($registro->emailCorporativo)) {

				// ENVIO EL CORREO AL CLIENTE
				\Mail::send('aceptado.pago_aceptado', $data, function($message) use ($registro) {
					$message->to($registro->emailPersonal, $registro->nombres . ' ' . $registro->apellidos);
					$message->to($registro->emailCorporativo, $registro->nombres . ' ' . $registro->apellidos);
					$message->from('tickets@exma.com.bo', 'EXMA Bolivia');
					$message->bcc('asuarez@exma.com.bo');
					$message->subject('La compra de tu ticket EXMA Bolivia ha sido exitosa');
				});

			}
			else if (!empty($registro->emailPersonal) || !empty($registro->emailCorporativo)) {

				// ENVIO EL CORREO AL CLIENTE
				\Mail::send('aceptado.pago_aceptado', $data, function($message) use ($registro) {
					if (empty($registro->emailPersonal)) {
						$message->to($registro->emailCorporativo, $registro->nombres . ' ' . $registro->apellidos);
					}
					else {
						$message->to($registro->emailPersonal, $registro->nombres . ' ' . $registro->apellidos);
					}
					$message->from('tickets@exma.com.bo', 'EXMA Bolivia');
					$message->bcc('asuarez@exma.com.bo');
					$message->subject('La compra de tu ticket EXMA Bolivia ha sido exitosa');
				});

			}

			// CREA UN MENSAJE PARA EL CLIENTE Y LO DEVUELVE A LA PAGINA
			$mensaje = "Mensaje de Pago enviado correctamente";

			return redirect()->back()->with('mensaje', $mensaje)->with('tipo', 'exito');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	public function enviarMensajeTicket($id) {

		try {

			$registro = DB::table('registros')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
							->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
							->where([
								['registros.id', $id]
							])
							->select('registros.id', 'sectores.id as idSector', 'registros.password', 'registros.idCliente', 'registros.pagado', 'registros.idButaca', 'clientes.nombres', 'clientes.apellidos', 'clientes.emailPersonal')
							->first();

			if ($registro->idButaca == null) {
				// CREA UN MENSAJE PARA EL ADMNISTRADOR Y LO DEVUELVE A LA PAGINA
				$mensaje = "No se puede enviar porque el cliente no tiene una butaca asignada todavía";
				return redirect()->back()->with('mensaje', $mensaje)->with('tipo', 'error');
			}

			$butaca = DB::table('butacas')
						->join('registros', 'registros.idButaca', 'butacas.id')
						->select('butacas.fila', 'butacas.numero')
						->first();

			$butacaCliente = $butaca->fila . $butaca->numero;

			if ($registro->idSector == 1) {
				$sector = "VIP";
			}
			else if ($registro->idSector == 2) {
				$sector = "Business";
			}

			$nombreText = trim($registro->nombres);
			$nombreText = str_replace(" ", "_", $nombreText);

			$apellidosText = trim($registro->apellidos);
			$apellidosText = str_replace(" ", "_", $apellidosText);

			$texto = ('OSBOLIVIA-' . $nombreText . "-" . $apellidosText . "-" . $sector . "-" . $registro->idCliente . "-" . $butacaCliente . "-" . $registro->id);

			$d = new DNS2D();
			$todo = $d->getBarcodePNGPath($texto, "QRCODE");

			$nombreText = trim($registro->nombres);
			$nombreText = str_replace(" ", "-", $nombreText);
			$nombreText = str_replace(".", "", $nombreText);

			$apellidosText = trim($registro->apellidos);
			$apellidosText = str_replace(" ", "-", $apellidosText);
			$apellidosText = str_replace(".", "", $apellidosText);

			$tituloQR = ('OSBOLIVIA-' . $nombreText . "-" . $apellidosText . "-" . $sector . "-" . $registro->idCliente . "-" . $butacaCliente . "-" . $registro->id);

			$nombreCliente = $registro->nombres . ' ' . $registro->apellidos;

			// CREO UN PDF
			$pdf = \PDF::loadView('ticket', compact('tituloQR', 'registro', 'nombreCliente', 'butacaCliente', 'sector'));

			// MANDO UN MENSAJE CON EL TICKET
			$data = [
				'nombre' => $registro->nombres
			];

			if (!empty($registro->emailPersonal) && !empty($registro->emailCorporativo)) {

				\Mail::send('aceptado.ticket_mensaje', $data, function($message) use ($registro, $pdf) {
					$message->to($registro->emailPersonal, $registro->nombres . ' ' . $registro->apellidos);
					$message->to($registro->emailCorporativo, $registro->nombres . ' ' . $registro->apellidos);
					$message->from('tickets@exma.com.bo', 'EXMA Bolivia');
					$message->bcc('asuarez@exma.com.bo');
					$message->subject('e-ticket ' . $registro->nombres . ' ' . $registro->apellidos . ' EXMA Bolivia');
					$message->attachData($pdf->output(), 'Ticket ' . $registro->nombres . ' ' . $registro->apellidos . '.pdf');
				});

			}
			else if (!empty($registro->emailPersonal) || !empty($registro->emailCorporativo)) {

				\Mail::send('aceptado.ticket_mensaje', $data, function($message) use ($registro, $pdf) {
					if (empty($registro->emailPersonal)) {
						$message->to($registro->emailCorporativo, $registro->nombres . ' ' . $registro->apellidos);
					}
					else {
						$message->to($registro->emailPersonal, $registro->nombres . ' ' . $registro->apellidos);
					}
					$message->from('tickets@exma.com.bo', 'EXMA Bolivia');
					$message->bcc('asuarez@exma.com.bo');
					$message->subject('e-ticket ' . $registro->nombres . ' ' . $registro->apellidos . ' EXMA Bolivia');
					$message->attachData($pdf->output(), 'Ticket ' . $registro->nombres . ' ' . $registro->apellidos . '.pdf');
				});

			}

			$mensaje = "Mensaje de ticket enviado correctamente";
			return redirect()->back()->with('mensaje', $mensaje)->with('tipo', 'exito');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

}
