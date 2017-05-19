<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('ventas', function (Blueprint $table) {
        //     $table->increments('id');

        //     $table->decimal('precio', 10, 2);
        //     $table->datetime('fechaPago');
        //     $table->boolean('estadoPago')->default(0);

        //     // Llaves foraneas
        //     // Registro
        //     $table->integer('idRegistro')->unsigned();
        //     $table->foreign('idRegistro')->references('id')->on('registros')->onDelete('cascade');

        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
