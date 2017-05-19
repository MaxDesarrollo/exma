<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('registros', function (Blueprint $table) {
			$table->increments('id');

			$table->Date('fechaRegistro');
			$table->Time('horaRegistro')->nullable();

			// PAGO
			$table->string('tipoPago');
			$table->decimal('precio', '10', '2');
			$table->boolean('pagado');
			$table->Date('fechaPago')->nullable();

			// SI ESTA ELIMINADO
			$table->boolean('habilitado');

			// // LAS FOREIGN KEYS
			// // $table->integer('idCliente');
			// // $table->integer('idSectorEvento');
			// // $table->integer('idButaca');
			// $table->integer('idCliente')->unsigned();
			// $table->integer('idCliente')->references('id')->on('clientes')->onDelete('cascade');

			// $table->integer('idSectorEvento')->unsigned();
			// $table->integer('idSectorEvento')->references('id')->on('sectores_eventos')->onDelete('cascade');

			// $table->integer('idButaca')->unsigned();
			// $table->integer('idButaca')->references('id')->on('butacas')->onDelete('cascade');


			// // Llaves Foraneas
			// // Cliente
			// $table->integer('idCliente')->unsigned();
			// $table->foreign('idCliente')->references('id')->on('clientes')->onDelete('cascade');

			// // Sector
			// $table->integer('idSector')->unsigned();
			// $table->foreign('idSector')->references('id')->on('sectores')->onDelete('cascade');
			
			$table->timestamps();
		});

        DB::update("ALTER TABLE registros AUTO_INCREMENT = 1001;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('registros');
	}
}
