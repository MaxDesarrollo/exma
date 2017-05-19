<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCamposAsistenciasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		// Schema::table('asistencias', function (Blueprint $table) {
		// 	$table->boolean('estadoActivo');
		// });

		// Schema::table('asistencias', function (Blueprint $table) {
		// 	$table->integer('idRegistro')->unsigned();
  //           $table->foreign('idRegistro')->references('id')->on('registros')->onDelete('cascade');
		// });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		// Schema::table('asistencias', function (Blueprint $table) {
		// 	$table->dropColumn('estadoActivo');
		// });

		// Schema::table('asistencias', function (Blueprint $table) {
		// 	$table->dropColumn('idRegistro');
		// });
	}
}
