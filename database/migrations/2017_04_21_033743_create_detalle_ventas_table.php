<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('detalleVentas', function (Blueprint $table) {
        //     $table->increments('id');

        //     // Llaves Foraneas
        //     // Venta
        //     $table->integer('idVenta')->unsigned();
        //     $table->foreign('idVenta')->references('id')->on('ventas')->onDelete('cascade');

        //     // Butaca
        //     $table->integer('idButaca')->unsigned();
        //     $table->foreign('idButaca')->references('id')->on('butacas')->onDelete('cascade');

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
        Schema::dropIfExists('detalleVentas');
    }
}
