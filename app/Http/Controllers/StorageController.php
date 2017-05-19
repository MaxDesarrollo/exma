<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class StorageController extends Controller
{
	//
	public function index($descuentos = null, $datos = null) {

		try {

			// CONSIGO TODOS LOS DESCUENTOS PARA EL ADMINISTRADOR
			$descuentos = DB::table('descuentos')
							->orderBy('porcentajeDescuento')
							->get();

			return view('panel.subir_excel', compact('descuentos', 'datos'));

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}

	}

	public function save(Request $request) {

		try {
		
			// OBTENEMOS EL EXCEL 
			$file = $request->file('fileExcel');
			$ext = $file->getClientOriginalExtension();

			if (empty($file) || $ext != "xlsx") {

				$mensaje = "No se subió un archivo Excel válido";

				return redirect('importar_excel')->with('mensaje', $mensaje)->with('tipo', 'error');

			}

			// SE OBTIENE EL NOMBRE DEL ARCHIVO, NO LO USARE, PARA QUE SOLO SE PUEDA USAR LA FUNCION DE SUBIR DATOS SI O SI CON EL NOMBRE INSCRIPCION EXMA
			$nombre = $file->getClientOriginalName();

			// SE GUARDA UN NUEVO ARCHIVO
			\Storage::disk('local')->put('inscripcionExma.xlsx', \File::get($file));

			// CONSIGO LOS DATOS QUE SE VAN A GUARDAR EN $DATOS QUE LO CONVIERTO A OBJETO
			$datos = \Excel::load(storage_path().'\app\inscripcionExma.xlsx', function($reader) {

				// $reader->each(function($registro) {
				// 	$registro->porcentajeDescuento *= 100;
				// }

				$datos = $reader->get()->toArray();

				// dd($datos);
				
			})->toObject();

			// CONSIGO TODOS LOS DESCUENTOS PARA EL ADMINISTRADOR
			$descuentos = DB::table('descuentos')
							->orderBy('porcentajeDescuento')
							->get();
							
			return view('panel.subir_excel', compact('descuentos', 'datos', 'precio'));

			$mensaje = "No se pudo cargar los datos";
			return redirect()->back()->with('mensaje', $mensaje);

		}
		catch (Exception $ex) {

			return response()->view('errors.error');

		}
		
	}
}
