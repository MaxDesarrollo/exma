<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;

use App\Registro;
use App\Asistencia;


class ReporteController extends Controller
{
    //
    function index() {

    	try {

			// SI EL USUARIO NO ES ADMINISTRADOR LO REDIRECCIONO A LOGIN
			if (\Auth::user()->tipoUsuario == "Vendedor") {

				$mensaje = "No tiene autorización para entrar aquí.";

				return redirect('login')->with('mensaje', $mensaje);

			}

	    	// CONSIGO TODOS LOS DESCUENTOS PARA EL ADMINISTRADOR
			$descuentos = DB::table('descuentos')
							->orderBy('porcentajeDescuento')
							->get();

	    	return view('reporte.reportes', compact('descuentos'));

    	}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}
    }

    // PARA HACER EL PDF DEL REGISTRO DE UN CLIENTE
	function reporteRegistro($id) {

		try {

			// BUSCO EL REGISTRO PERO CON EL NOMBRE DEL SECTOR Y CON DATOS DEL CLIENTE
			$registro = DB::table('registros')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
							->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
							->where([
								['registros.id', $id]
							])
							->select('registros.id', 'registros.idCliente', 'clientes.nombres', 'clientes.apellidos', 'clientes.emailPersonal', 'sectores.nombre as nombreSector', 'clientes.cargoEmpresa', 'clientes.nit', 'clientes.razonSocial', 'clientes.emailCorporativo', 'clientes.cedulaIdentidad', 'registros.tipoPago', 'registros.idSectorEvento', 'registros.precio', 'registros.porcentajeDescuento', 'clientes.nombreEmpresa')
							->first();

			$precio = $registro->precio;
			$precioDescuentado = $precio - ($precio * $registro->porcentajeDescuento / 100);
			// dd($precioDescuentado);

			$fechaActual = Carbon::now('America/La_Paz');

			// GENERA EL PDF Y SE DESCARGA
			$pdf = \PDF::loadView('reporte.reporte_registro', compact('registro', 'fechaActual', 'precioDescuentado'));
			return $pdf->download('reporte ' . $registro->nombres . ' ' . $registro->apellidos . '.pdf');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	// PARA CREAR UN PDF CON UN REPORTE GENERAL DE TODAS LAS ASISTENCIAS DE TODAS LAS PERSONAS
	function reporteAsistenciaGeneral() {

		try {

			$asistencias = DB::table('asistencias')
								->join('registros', 'registros.id', 'asistencias.idRegistro')
								->join('clientes', 'clientes.id', 'registros.idCliente')
								->orderBy('asistencias.id')
								->where('asistencias.fechaAsistencia', '!=', null)
								->get();

			$fechaActual = Carbon::now('America/La_Paz');

			// CARGO EL PDF CON LAS ASISTENCIAS Y LA FECHA ACTUAL PARA SABER A QUE HORA FUE SACADO EL REPORTE, Y SE DESCARGA EL ARCHIVO
			$pdf = \PDF::loadView('reporte.reporte_asistencia_general', compact('asistencias', 'fechaActual'));
			return $pdf->download('reporteAsistenciaGeneral.pdf');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	// PARA CREAR UN PDF CON UN REPORTE DE LA ASISTENCIA DE UN CLIENTE
	function reporteAsistencia($id) {

		try {

			$asistencias = DB::table('asistencias')
								->join('registros', 'registros.id', 'asistencias.idRegistro')
								->orderBy('asistencias.id')
								->where([
									['asistencias.fechaAsistencia', '!=', null],
									['registros.id', $id]
								])
								->get();

			$fechaActual = Carbon::now('America/La_Paz');

			$nombreCliente = DB::table('registros')
								->join('clientes', 'clientes.id', 'registros.idCliente')
								->where([
									['registros.id', $id],
									['registros.habilitado', true]
								])
								->select('clientes.nombres', 'clientes.apellidos')
								->first();

			// CARGO EL PDF CON TODAS LAS ASISTENCIAS DEL CLIENTE Y LA FECHA EN QUE FUE CARGADO EL REPORTE, Y SE DESCARGA EL ARCHIVO
			$pdf = \PDF::loadView('reporte.reporte_asistencia', compact('asistencias', 'fechaActual', 'nombreCliente'));
			return $pdf->download('reporteAsistencia ' . $nombreCliente->nombres . ' ' . $nombreCliente->apellidos . '.pdf');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}


	function reporteRegistrados() {

		try {

			$registros = DB::table('registros')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
							->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
							->where('registros.habilitado', true)
							->select(
								'registros.id', 
								'clientes.nombres', 
								'clientes.apellidos', 
								'sectores.nombre as sector',
								'clientes.telefono',
								'clientes.emailPersonal',
								'clientes.emailCorporativo')
							->orderBy('registros.id')
							->get();

			$fechaActual = Carbon::now('America/La_Paz');
			$usuario = \Auth::user()->name;
			$titulo = "REGISTRADOS";
			$cantidad = count($registros);

			// CARGO EL PDF CON TODOS LOS REGISTRADOS Y LA FECHA EN QUE FUE CARGADO EL REPORTE, Y SE DESCARGA EL ARCHIVO
			$pdf = \PDF::loadView('reporte.reporte_registrados', compact('registros', 'fechaActual', 'usuario', 'titulo', 'cantidad'));
			return $pdf->download('Reporte Registrados.pdf');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}
	}

	function reporteRegistradosPagados() {

		try {

			$registros = DB::table('registros')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
							->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
							->where([
								['registros.habilitado', true],
								['registros.pagado', true]
							])
							->select('registros.id',
								'clientes.nombres',
								'clientes.apellidos',
								'sectores.nombre as sector',
								'clientes.telefono',
								'clientes.emailPersonal',
								'clientes.emailCorporativo')
							->orderBy('registros.id')
							->get();

			$fechaActual = Carbon::now('America/La_Paz');
			$usuario = \Auth::user()->name;
			$titulo = "REGISTRADOS PAGADOS";
			$cantidad = count($registros);

			// CARGO EL PDF CON TODOS LOS REGISTRADOS Y LA FECHA EN QUE FUE CARGADO EL REPORTE, Y SE DESCARGA EL ARCHIVO
			$pdf = \PDF::loadView('reporte.reporte_registrados', compact('registros', 'fechaActual', 'usuario', 'titulo', 'cantidad'));
			return $pdf->download('Reporte Registrados pagados.pdf');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	function reporteRegistradosNoPagados() {

		try {

			$registros = DB::table('registros')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
							->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
							->where([
								['registros.habilitado', true],
								['registros.pagado', false]
							])
							->select('registros.id',
								'clientes.nombres',
								'clientes.apellidos',
								'sectores.nombre as sector',
								'clientes.telefono',
								'clientes.emailPersonal',
								'clientes.emailCorporativo')
							->orderBy('registros.id')
							->get();

			$fechaActual = Carbon::now('America/La_Paz');
			$usuario = \Auth::user()->name;
			$titulo = "REGISTRADOS SIN PAGAR";
			$cantidad = count($registros);

			// CARGO EL PDF CON TODOS LOS REGISTRADOS Y LA FECHA EN QUE FUE CARGADO EL REPORTE, Y SE DESCARGA EL ARCHIVO
			$pdf = \PDF::loadView('reporte.reporte_registrados', compact('registros', 'fechaActual', 'usuario', 'titulo', 'cantidad'));
			return $pdf->download('Reporte Registrados sin pagar.pdf');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

		// dd($registros);

	}

	function reportePagadosConTicket() {

		try {

			$registros = DB::table('registros')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
							->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
							->join('butacas', 'butacas.id', 'registros.idButaca')
							->where([
								['registros.habilitado', true],
								['registros.pagado', true],
								['registros.idButaca', '!=', null]
							])
							->select('registros.id', 
								'clientes.nombres', 
								'clientes.apellidos', 
								'sectores.nombre as sector', 
								'butacas.fila', 
								'butacas.numero',
								'clientes.telefono',
								'clientes.emailPersonal',
								'clientes.emailCorporativo')
							->orderBy('registros.id')
							->get();

			$fechaActual = Carbon::now('America/La_Paz');
			$usuario = \Auth::user()->name;
			$titulo = "REGISTRADOS PAGADOS CON TICKET";
			$cantidad = count($registros);

			// CARGO EL PDF CON TODOS LOS REGISTRADOS Y LA FECHA EN QUE FUE CARGADO EL REPORTE, Y SE DESCARGA EL ARCHIVO
			$pdf = \PDF::loadView('reporte.reporte_pagados', compact('registros', 'fechaActual', 'usuario', 'titulo', 'cantidad'));
			return $pdf->download('Reporte Pagados con Ticket.pdf');

			// dd($registros);

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	function reportePagadosSinTicket() {

		try {

			$registros = DB::table('registros')
							->join('clientes', 'clientes.id', 'registros.idCliente')
							->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
							->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
							->where([
								['registros.habilitado', true],
								['registros.pagado', true],
								['registros.idButaca', null]
							])
							->select('registros.id',
								'clientes.nombres',
								'clientes.apellidos',
								'sectores.nombre as sector',
								'clientes.telefono',
								'clientes.emailPersonal',
								'clientes.emailCorporativo')
							->orderBy('registros.id')
							->get();

			$fechaActual = Carbon::now('America/La_Paz');
			$usuario = \Auth::user()->name;
			$titulo = "REGISTROS PAGADOS SIN TICKET";
			$cantidad = count($registros);

			// CARGO EL PDF CON TODOS LOS REGISTRADOS Y LA FECHA EN QUE FUE CARGADO EL REPORTE, Y SE DESCARGA EL ARCHIVO
			$pdf = \PDF::loadView('reporte.reporte_registrados', compact('registros', 'fechaActual', 'usuario', 'titulo', 'cantidad'));
			return $pdf->download('Reporte Pagados sin Ticket.pdf');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}



	//////////////// SECCION EXCEL
	// CREO UN EXCEL MOSTRANDO TODOS LOS REGISTRADOS, NO IMPORTA SI PAGARON O NO
	function reporteRegistradosExcel() {

		try {

			\Excel::create('Reporte Registrados', function($excel) {

				$excel->sheet('Registros', function($sheet) {

					$registros = Registro::join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
										->join('clientes', 'clientes.id', 'registros.idCliente')
										->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
										->where('registros.habilitado', true)
										->select(
												'registros.id as ID', 
												DB::raw("CONCAT(clientes.nombres, ' ', clientes.apellidos) as Cliente"),
												'sectores.nombre as Sector',
												'clientes.telefono',
												'clientes.emailPersonal',
												'clientes.emailCorporativo')
										->orderBy('registros.id')
										->get();

					$sheet->fromArray($registros);
				});

			})->download('xlsx');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	// CREO UN EXCEL CON LOS REGISTRADOS QUE PAGARON
	function reporteRegistradosPagadosExcel() {

		try {

			\Excel::create('Reporte Registrados Pagados', function($excel) {

				$excel->sheet('Pagados', function($sheet) {

					$registros = Registro::join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
										->join('clientes', 'clientes.id', 'registros.idCliente')
										->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
										->where([
											['registros.habilitado', true],
											['registros.pagado', true]
										])
										->select(
												'registros.id as ID', 
												DB::raw("CONCAT(clientes.nombres, ' ', clientes.apellidos) as Cliente"),
												'sectores.nombre as Sector',
												'clientes.telefono',
												'clientes.emailPersonal',
												'clientes.emailCorporativo')
										->orderBy('registros.id')
										->get();

					$sheet->fromArray($registros);
				});

			})->download('xlsx');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	// CREO UN EXCEL CON LOS REGISTRADOS NO PAGADOS
	function reporteRegistradosNoPagadosExcel() {

		try {

			\Excel::create('Reporte Registrados no Pagados', function($excel) {

				$excel->sheet('No Pagados', function($sheet) {

					$registros = Registro::join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
										->join('clientes', 'clientes.id', 'registros.idCliente')
										->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
										->where([
											['registros.habilitado', true],
											['registros.pagado', false]
										])
										->select(
												'registros.id as ID', 
												DB::raw("CONCAT(clientes.nombres, ' ', clientes.apellidos) as Cliente"),
												'sectores.nombre as Sector',
												'clientes.telefono',
												'clientes.emailPersonal',
												'clientes.emailCorporativo')
										->orderBy('registros.id')
										->get();

					$sheet->fromArray($registros);
				});

			})->download('xlsx');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	// CREO UN EXCEL CON LOS REGISTROS PAGADOS QUE NO SELECCIONARON SUS TICKETS
	function reportePagadosSinTicketExcel() {

		try {

			\Excel::create('Reporte Pagados sin Ticket', function($excel) {

				$excel->sheet('Sin Ticket', function($sheet) {

					$registros = Registro::join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
										->join('clientes', 'clientes.id', 'registros.idCliente')
										->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
										->where([
											['registros.habilitado', true],
											['registros.pagado', true],
											['registros.idButaca', null]
										])
										->select(
												'registros.id as ID', 
												DB::raw("CONCAT(clientes.nombres, ' ', clientes.apellidos) as Cliente"),
												'sectores.nombre as Sector',
												'clientes.telefono',
												'clientes.emailPersonal',
												'clientes.emailCorporativo')
										->orderBy('registros.id')
										->get();

					$sheet->fromArray($registros);
				});

			})->download('xlsx');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	// CREO UN EXCEL CON LOS REGISTROS PAGADOS LISTOS PARA EL EVENTO (CON TICKET)
	function reportePagadosConTicketExcel() {

		try {

			\Excel::create('Reporte Pagados con Ticket', function($excel) {

				$excel->sheet('Con Ticket', function($sheet) {

					$registros = Registro::join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
										->join('clientes', 'clientes.id', 'registros.idCliente')
										->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
										->join('butacas', 'butacas.id', 'registros.idButaca')
										->where([
											['registros.habilitado', true],
											['registros.pagado', true],
											['registros.idButaca', '!=', null]
										])
										->select(
												'registros.id as ID', 
												DB::raw("CONCAT(clientes.nombres, ' ', clientes.apellidos) as Cliente"),
												'sectores.nombre as Sector',
												DB::raw("CONCAT(butacas.fila, butacas.numero) as Butaca"),
												'clientes.telefono',
												'clientes.emailPersonal',
												'clientes.emailCorporativo')
										->orderBy('registros.id')
										->get();

					$sheet->fromArray($registros);
				});

			})->download('xlsx');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	// PARA CREAR UN EXCEL CON UN REPORTE GENERAL DE TODAS LAS ASISTENCIAS DE TODAS LAS PERSONAS
	function reporteAsistenciaGeneralExcel() {

		try {

			\Excel::create('Reporte Asistencia General', function($excel) {

				$excel->sheet('Asistencias', function($sheet) {

					$asistencias = Asistencia::join('registros', 'registros.id', 'asistencias.idRegistro')
										->join('clientes', 'clientes.id', 'registros.idCliente')
										->where('asistencias.fechaAsistencia', '!=', null)
										->select(
												DB::raw("CONCAT(clientes.nombres, ' ', clientes.apellidos) as Cliente"),
												'asistencias.tipoAsistencia as Asistencia',
												'asistencias.fechaAsistencia as Fecha',
												'asistencias.horaAsistencia as Hora',
												'clientes.telefono',
												'clientes.emailPersonal',
												'clientes.emailCorporativo')
										->get();

					foreach ($asistencias as $asistencia) {
						if ($asistencia->Asistencia == 1) {
							$asistencia->Asistencia = "Ingreso";
						}
						else {
							$asistencia->Asistencia = "Salida";
						}
					}

					$sheet->fromArray($asistencias);
				});

			})->download('xlsx');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}
}
