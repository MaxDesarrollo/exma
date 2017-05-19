<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCamposButacasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('butacas', function (Blueprint $table) {
            // LAS FOREIGN KEYS
            $table->integer('idSectorEvento')->unsigned();
            $table->foreign('idSectorEvento')->references('id')->on('sectores_eventos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('butacas', function (Blueprint $table) {
            // $table->dropColumn('idCliente');
            // $table->dropColumn('idSectorEvento');
            // $table->dropColumn('idButaca');
        });
    }
}
