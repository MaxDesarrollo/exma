<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Registro;
use App\Cliente;
use App\User;
use App\SectorEvento;

use DB;

class ImportController extends Controller
{
	//
	public function import() {

		try {

			$cont = 0;
			$contTodos = 0;

			\Excel::load(storage_path().'\app\inscripcionExma.xlsx', function($reader) {

				$cont = 0;
				$contTodos = 0;

				// dd($reader);

				$reader->each(function($registro) use ($cont, $contTodos) {



					// VERIFICO PRIMERO SI YA ESTA ESTE REGISTRO EN LA BASE DE DATOS
					$cli = DB::table('clientes')
							->where('cedulaIdentidad', $registro->cedulaidentidad)
							->select('clientes.id')
							->first();



					if (empty($cli)) {
						if ($registro->nombres != null) {
							// CAMBIO LOS DATOS PARA QUE ENCAJEN CON LA BASE DE DATOS
							// Consigo el id del Sector Evento en base al sector
							$idSectorEvento = SectorEvento::select('sectores_eventos.id')
												->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
												->where('nombre', $registro->sector)
												->first();

							// if (strtolower($registro->sector) == "vip") {
							// 	$idSectorEvento = 1;
							// }
							// else if (strtolower($registro->sector) == "business") {
							// 	$idSectorEvento = 2;
							// }

							// Para cambiar el formato de pagado
							if (strtolower($registro->pagado) == "si") {
								$registro->pagado = 1;
							}
							else {
								$registro->pagado = 0;
							}

							// Para asignar una contraseña, creo que no sirve pero bueno
							if (strtolower($registro->pagado) == "si") {
								$password = \Hash::make(rand(10000, 99999));
							}
							else {
								$password = null;
							}

							// Para cambiar el formato de Ciudad, de siglas a palabras
							switch ($registro->ciudad) {
								case "SCZ":
									$registro->ciudad = "Santa Cruz";
									break;
								case "BN":
									$registro->ciudad = "Beni";
									break;
								case "OR":
									$registro->ciudad = "Oruro";
									break;
								case "PTS":
									$registro->ciudad = "Potosí";
									break;
								case "SCE":
									$registro->ciudad = "Sucre";
									break;
								case "LPZ":
									$registro->ciudad = "La Paz";
									break;
								case "TJA":
									$registro->ciudad = "Tarija";
									break;
								case "CBBA":
									$registro->ciudad = "Cochabamba";
									break;
								case "PA":
									$registro->ciudad = "Pando";
									break;
								default:
									break;
							}

							// Para cambiar el formato del tipo de pago, de una palabra a una frase
							switch ($registro->tipopago) {
								case strtoupper("DEPOSITO"):
									$registro->tipopago = "Depósito o Transferencia Bancaria";
									break;
								case strtoupper("CHEQUE"):
									$registro->tipopago = "Pago mediante cheque";
									break;
								case strtoupper("EFECTIVO"):
									$registro->tipopago = "Pago en efectivo";
									break;
								default:
									break;
							}

							// Consigo el precio porque el precio del excel ya esta descuentado
							$precio = SectorEvento::select('sectores_eventos.precio')
										->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
										->where('nombre', $registro->sector)
										->first();

							// dd($precio->precio);

							// Cambio el formato del descuento, el % devuelve ya en decimal (30% es 0.3), entonces multiplico por 100
							// $registro->porcentajedescuento = str_replace("%", "", $registro->porcentajedescuento);

							$registro->porcentajedescuento *= 100;

							// $registro->precio = str_replace(",", "", $registro->precio);

							// if ($registro->cedulaidentidad == null) {
							// 	// $registro->cedulaidentidad = ;
							// }

							// CONSIGO EL ID DEL USUARIO QUE LO CONSIGUIO
							$username = User::where(strtoupper('name'), strtoupper($registro->usuario))->firstOrFail();

							// dd($registro);

							$cliente = Cliente::create([
								'nombres'           	=> $registro->nombres,
								'apellidos'         	=> $registro->apellidos,
								'nombreEmpresa'     	=> $registro->nombreempresa,
								'cargoEmpresa'      	=> $registro->cargoempresa,
								'nit'               	=> $registro->nit,
								'razonSocial'       	=> $registro->razonsocial,
								'emailPersonal'     	=> $registro->emailpersonal,
								'emailCorporativo'  	=> $registro->emailcorporativo,
								'cedulaIdentidad'   	=> $registro->cedulaidentidad,
								'telefono'          	=> $registro->telefono,
								'ciudad'            	=> $registro->ciudad
							]);

							Registro::create([
								'fechaRegistro'     	=> $registro->fecharegistro,
								'horaRegistro'      	=> $registro->horaregistro,
								'tipoPago'          	=> $registro->tipopago,
								'precio'				=> $precio->precio,
								// El precio se puede sacar de la bd, el problema es que ya le metieron el descuento
								// 'precio'            	=> $registro->precio,
								'porcentajeDescuento'	=> $registro->porcentajedescuento,
								'pagado'				=> $registro->pagado,
								'fechaPago'				=> $registro->fechapago,
								'habilitado'			=> 1,
								'idSectorEvento'		=> $idSectorEvento->id,
								'idCliente'				=> $cliente->id,
								'idButaca'				=> null,
								'password'				=> $password,
								'idUser'				=> $username->id
							]);

							$cont++;
						}
					}
					$contTodos++;


				});
			});

			$mensaje = "Registros subidos exitosamente a la base de datos";
			return redirect('panel')->with('mensaje', $mensaje)->with('tipo', 'exito');

			if ($cont == 0) {
				$mensaje = "Todos los registros del archivo ya estaban subidos";
				return redirect('panel')->with('mensaje', $mensaje)->with('tipo', 'error');
			}
			else if ($cont < $contTodos) {
				$mensaje = "Registros subidos exitosamente a la base de datos (Algunos datos ya estaban insertados)";
				return redirect('panel')->with('mensaje', $mensaje)->with('tipo', 'exito');
			}
			else if ($cont == $contTodos) {
				$mensaje = "Registros subidos exitosamente a la base de datos";
				return redirect('panel')->with('mensaje', $mensaje)->with('tipo', 'exito');
			}

			$mensaje = "Registros subidos exitosamente a la base de datos";
			return redirect('panel')->with('mensaje', $mensaje)->with('tipo', 'exito');

			// return redirect()->back()->with('mensaje', $mensaje)->with('tipo', 'exito');
			// return "Registros subidos";

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	public function export() {

		try {

			// SI EL USUARIO NO ES ADMINISTRADOR LO REDIRECCIONO A LOGIN
			if (\Auth::user()->tipoUsuario == "Vendedor") {

				$mensaje = "No tiene autorización para entrar aquí.";
				return redirect('login')->with('mensaje', $mensaje);

			}


			\Excel::create('reporte', function($excel) {

				$excel->sheet('Clientes', function($sheet) {

					// $clientes = Cliente::all();

					$clientes = Cliente::select('id as ID', 'nombres as Nombres', 'apellidos as Apellidos', 'nombreEmpresa as Empresa', 'cargoEmpresa as Cargo', 'nit as NIT', 'razonSocial as Razón Social', 'emailPersonal as e-mail Personal', 'emailCorporativo as e-mail Corporativo', 'cedulaIdentidad as CI', 'telefono as Teléfono', 'ciudad as Ciudad')->get();

					$sheet->fromArray($clientes);
				});

				$excel->sheet('Registros', function($sheet) {

					$registros = Registro::select('id as ID', 'fechaRegistro as Fecha', 'horaRegistro as Hora', 'tipoPago as Tipo de Pago', 'precio as Precio (Bs.)', 'pagado as Pagado', 'fechaPago as Fecha de Pago', 'habilitado as Habilitado', 'idSectorEvento as Sector', 'idCliente as Cliente', 'idButaca as Butaca', 'porcentajeDescuento as Descuento (%)', 'idUser as Usuario')->get();

					foreach ($registros as $registro) {

						$registroBD = DB::table('registros')
									->leftjoin('users', 'users.id', 'registros.idUser')
									->join('sectores_eventos', 'sectores_eventos.id', 'registros.idSectorEvento')
									->join('sectores', 'sectores.id', 'sectores_eventos.idSector')
									->join('clientes', 'clientes.id', 'registros.idCliente')
									->leftjoin('butacas', 'butacas.id', 'registros.idButaca')
									->where('registros.id', $registro->ID)
									->select( 	'sectores.nombre as Sector', 
												DB::raw("CONCAT(clientes.nombres, ' ', clientes.apellidos) as Cliente"),
												DB::raw("CONCAT(butacas.fila, butacas.numero) as Butaca"),
												'users.name as Usuario'
									)
									->first();

						if ($registro->Pagado == 1) {
							$registro->Pagado = "Si";
						}
						else {
							$registro->Pagado = "No";
						}

						if ($registro->Habilitado == 1) {
							$registro->Habilitado = "Si";
						}
						else {
							$registro->Habilitado = "No";
						}

						$registro->Sector = $registroBD->Sector;
						$registro->Cliente = $registroBD->Cliente;
						$registro->Butaca = $registroBD->Butaca;

						if ($registroBD->Usuario == null) {
							$registro->Usuario = "Web";
						}
						else {
							$registro->Usuario = $registroBD->Usuario;
						}
					}

					$sheet->fromArray($registros);
				});

			})->download('xlsx');

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}
}
