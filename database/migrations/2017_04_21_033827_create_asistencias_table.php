<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->increments('id');

            $table->date('fechaAsistencia')->nullable();
            $table->time('horaAsistencia')->nullable();
            // $table->enum('tipoAsistencia', ['check in', 'check out']);
            $table->boolean('tipoAsistencia');

            // YO ESTOY AGREGANDO
            $table->boolean('estadoActivo');

            // LLAVES FORANEAS
            // $table->integer('idRegistro');

            $table->integer('idRegistro')->unsigned();
            $table->foreign('idRegistro')->references('id')->on('registros')->onDelete('cascade');

            

            // $table->boolean('estado')->default(0);

            // $table->date('fecha')->nullable();
            // $table->time('hora')->nullable();
            // //$table->time('horaSalida')->nullable();

            // // LLave Foraneas
            // // Detalle Ventas
            // $table->integer('idDetalleVenta')->unsigned();
            // $table->foreign('idDetalleVenta')->references('id')->on('detalleVentas')->onDelete('cascade');

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
        Schema::dropIfExists('asistencias');
    }
}
