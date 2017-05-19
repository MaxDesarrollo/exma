<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@index');
Route::get('volver_atras', 'RegistroController@volverAtras');


// 	MENSAJES
// Route::get('asientoRegistrado', function() {
// 	return view('aceptado.ticket_mensaje_cliente');
// });
Route::get('asientoRegistrado', [
	'as' => 'asientoRegistrado',
	'uses' => 'RegistroController@asientoRegistrado'
]);

// Route::get('asientoRegistro/vip', [
// 	'as' => 'asientoRegistroVip',
// 	'uses' => 'RegistroController@asientoRegistradoVip'
// ]);

// Route::get('asientoRegistro/Business', [
// 	'as' => 'asientoRegistroBusiness',
// 	'uses' => 'RegistroController@asientoRegistroBusiness'
// ]);



Route::get('registro/{sector?}', [
	'as' => 'registro',
	'uses' => 'RegistroController@index'
]);

// CUANDO EL ADMINISTRADOR VA A LA PAGINA REGISTRO
Route::get('registro/admin/{descuento}/{sector?}', [
	'as' => 'registroAdmin',
	'uses' => 'AdminController@indexAdmin'
])->middleware('auth');

Route::post('registrando', 'RegistroController@store');

// PARA SELECCIONAR SU ASIENTO
Route::post('registro_asiento', [
	'as' => 'registro_asiento',
	'uses' => 'RegistroController@asientoIndex'
]);
Route::post('registrando_asiento', 'RegistroController@asientoStore');


Route::get('verificar_registro_asiento', [
	'as' => 'verificar_registro_asiento',
	'uses' => 'RegistroController@verificarAsientoIndex'
]);
Route::post('verificando_registro_asiento', 'RegistroController@verificarAsientoStore');

// RUTA PARA IR A REGISTRO ASIENTO PERO PARA EL ADMINISTRADOR
Route::get('registro_asiento_admin/{ci}', [
	'as' => 'registro_asiento_admin',
	'uses' => 'AdminController@asientoIndexAdmin'
])->middleware('auth');


// PARA QUE EL ADMINISTRADOR PUEDA GESTIONAR LOS ASIENTOS DEL CLIENTE
Route::get('butaca/admin/reasignar/{id}', [
	'as' => 'reasignarButaca',
	'uses' => 'AdminController@reasignarButaca'
])->middleware('auth');

Route::get('butaca/admin/eliminar/{id}', [
	'as' => 'eliminarButaca',
	'uses' => 'AdminController@eliminarButaca'
])->middleware('auth');

// PARA QUE EL ADMINISTRADOR PUEDA ENVIAR MENSAJES A LOS CLIENTES
Route::get('mensaje/admin/registro/{id}', [
	'as' => 'enviarMensajeRegistro',
	'uses' => 'AdminController@enviarMensajeRegistro'
]);

Route::get('mensaje/admin/pago/{id}', [
	'as' => 'enviarMensajePago',
	'uses' => 'AdminController@enviarMensajePago'
]);

Route::get('mensaje/admin/ticket/{id}', [
	'as' => 'enviarMensajeTicket',
	'uses' => 'AdminController@enviarMensajeTicket'
]);


// PARA EL ADMINISTRADOR
// Panel
Route::get('panel', [
	'as'=>'panel',
	'uses'=>'AdminController@panel'
])->middleware('auth');

// // Para ver todos los clientes que ya tienen entradas
// // Falta poner el middleware
// Route::get('panel/clientes', [
// 	'as' => 'clientes',
// 	'uses' => 'AdminController@clientes'
// ]);

// // PARA VER LOS CLIENTES QUE YA ESTAN DENTRO DEL EVENTO
// // Falta poner el middleware
// Route::get('panel/asistentes', [
// 	'as' => 'asistentes',
// 	'uses' => 'AdminController@asistentes'
// ]);


// Para ver todos los clientes que ya tienen entradas
// Falta poner el middleware
Route::get('panel/asistencias', [
	'as' => 'asistencias',
	'uses' => 'AdminController@asistentes'
])->middleware('auth');


// Cliente pagado
Route::get('pagar/{id}', [
	'as' => 'pagar',
	'uses' => 'AdminController@pagar'
])->middleware('auth');

// Eliminar alguna reserva de entrada
Route::get('eliminar/{id}', [
	'as' => 'eliminar',
	'uses' => 'AdminController@eliminar'
])->middleware('auth');

// Check in y Check out
Route::get('asistencia/{id}', [
	'as' => 'asistencia',
	'uses' => 'AdminController@asistencia'
]);


// Para los reportes
Route::get('reportes', [
	'as' => 'reportes',
	'uses' => 'ReporteController@index'
])->middleware('auth');

// EXCEL
// REPORTE DE RESERVA DE UN CLIENTE
Route::get('reporteRegistroExcel/{id}', [
	'as' => 'reporteRegistroExcel',
	'uses' => 'ReporteController@reporteRegistroExcel'
])->middleware('auth');
// REPORTE DE LA ASISTENCIA GENERAL
Route::get('reporteAsistenciaGeneralExcel', [
	'as' => 'reporteAsistenciaGeneralExcel',
	'uses' => 'ReporteController@reporteAsistenciaGeneralExcel'
])->middleware('auth');
// REPORTE DE LA ASISTENCIA DE UN CLIENTE
Route::get('reporteAsistenciaExcel/{id}', [
	'as' => 'reporteAsistenciaExcel',
	'uses' => 'ReporteController@reporteAsistenciaExcel'
])->middleware('auth');
// REPORTE DE LOS REGISTRADOS
Route::get('reporteRegistradosExcel', [
	'as' => 'reporteRegistradosExcel',
	'uses' => 'ReporteController@reporteRegistradosExcel'
])->middleware('auth');
// REPORTE DE LOS REGISTRADOS PAGADOS
Route::get('reporteRegistradosPagadosExcel', [
	'as' => 'reporteRegistradosPagadosExcel',
	'uses' => 'ReporteController@reporteRegistradosPagadosExcel'
])->middleware('auth');
// REPORTE DE LOS REGISTRADOS NO PAGADOS
Route::get('reporteRegistradosNoPagadosExcel', [
	'as' => 'reporteRegistradosNoPagadosExcel',
	'uses' => 'ReporteController@reporteRegistradosNoPagadosExcel'
])->middleware('auth');
// REPORTE DE LOS PAGADOS CON TICKET
Route::get('reportePagadosConTicketExcel', [
	'as' => 'reportePagadosConTicketExcel',
	'uses' => 'ReporteController@reportePagadosConTicketExcel'
])->middleware('auth');
// REPORTE DE LOS PAGADOS SIN TICKET
Route::get('reportePagadosSinTicketExcel', [
	'as' => 'reportePagadosSinTicketExcel',
	'uses' => 'ReporteController@reportePagadosSinTicketExcel'
])->middleware('auth');

// PDF
// REPORTE DE RESERVA DE UN CLIENTE
Route::get('reporteRegistro/{id}', [
	'as' => 'reporteRegistro',
	'uses' => 'ReporteController@reporteRegistro'
])->middleware('auth');
// REPORTE DE LA ASISTENCIA GENERAL
Route::get('reporteAsistenciaGeneral', [
	'as' => 'reporteAsistenciaGeneral',
	'uses' => 'ReporteController@reporteAsistenciaGeneral'
])->middleware('auth');
// REPORTE DE LA ASISTENCIA DE UN CLIENTE
Route::get('reporteAsistencia/{id}', [
	'as' => 'reporteAsistencia',
	'uses' => 'ReporteController@reporteAsistencia'
])->middleware('auth');
// REPORTE DE LOS REGISTRADOS
Route::get('reporteRegistrados', [
	'as' => 'reporteRegistrados',
	'uses' => 'ReporteController@reporteRegistrados'
])->middleware('auth');
// REPORTE DE LOS REGISTRADOS PAGADOS
Route::get('reporteRegistradosPagados', [
	'as' => 'reporteRegistradosPagados',
	'uses' => 'ReporteController@reporteRegistradosPagados'
])->middleware('auth');
// REPORTE DE LOS REGISTRADOS NO PAGADOS
Route::get('reporteRegistradosNoPagados', [
	'as' => 'reporteRegistradosNoPagados',
	'uses' => 'ReporteController@reporteRegistradosNoPagados'
])->middleware('auth');
// REPORTE DE LOS PAGADOS CON TICKET
Route::get('reportePagadosConTicket', [
	'as' => 'reportePagadosConTicket',
	'uses' => 'ReporteController@reportePagadosConTicket'
])->middleware('auth');
// REPORTE DE LOS PAGADOS SIN TICKET
Route::get('reportePagadosSinTicket', [
	'as' => 'reportePagadosSinTicket',
	'uses' => 'ReporteController@reportePagadosSinTicket'
])->middleware('auth');



// PARA SUBIR ARCHIVOS EXCEL
Route::get('importar_excel', [
	'as' => 'importar_excel',
	'uses' => 'StorageController@index'
])->middleware('auth');
Route::post('importando_excel', 'StorageController@save')->middleware('auth');


// REGISTRAR LOS REGISTROS DEL EXCEL
Route::get('subir_registros', [
	'as' => 'subir_registros',
	'uses' => 'ImportController@import'
])->middleware('auth');
// EXPORTAR DATOS A EXCEL
Route::get('exportar_excel', [
	'as' => 'exportar_excel',
	'uses' => 'ImportController@export'
])->middleware('auth');



// Para autentificacion
Auth::routes();

// Route::get('/home', 'HomeController@index');
Route::get('/home', 'HomeController@login');


// Route::get('500', function() {
// 	abort(500);
// });