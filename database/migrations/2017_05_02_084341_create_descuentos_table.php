<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescuentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descuentos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('descripcion');
            $table->integer('porcentajeDescuento');
            $table->date('fechaInicial')->nullable();
            $table->date('fechaFinal')->nullable();
            $table->boolean('habilitado');

            // LLAVE FORANEAS
            $table->integer('idEvento')->unsigned();
            $table->foreign('idEvento')->references('id')->on('eventos')->onDelete('cascade');

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
        Schema::dropIfExists('descuentos');
    }
}
