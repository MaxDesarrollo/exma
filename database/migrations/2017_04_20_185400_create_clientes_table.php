<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nombres', 20);
			$table->string('apellidos', 50);
			$table->string('nombreEmpresa');
			$table->string('cargoEmpresa')->nullable();
			$table->string('nit')->nullable();
			$table->string('razonSocial')->nullable();
			$table->string('emailPersonal')->nullable();
			$table->string('emailCorporativo')->nullable();
			$table->string('cedulaIdentidad')->unique();
			$table->string('telefono')->nullable();
			$table->string('ciudad');
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
        Schema::dropIfExists('clientes');
    }
}
