<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eventos', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nombre');
			$table->integer('capacidad');
			$table->date('fechaInicial');
			$table->date('fechaFinal');
			$table->string('ciudad');

			// LLAVES FORANEAS
			// $table->integer('idSalon');
			
			$table->integer('idSalon')->unsigned();
			$table->foreign('idSalon')->references('id')->on('salones')->onDelete('cascade');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('eventos');
	}
}
