<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCamposRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registros', function (Blueprint $table) {
            // LAS FOREIGN KEYS
            $table->integer('idSectorEvento');
            
            $table->integer('idCliente')->unsigned();
            $table->foreign('idCliente')->references('id')->on('clientes')->onDelete('cascade');

            $table->integer('idButaca')->unsigned()->nullable();
            $table->foreign('idButaca')->references('id')->on('butacas')->onDelete('cascade');


            // AUMENTE DESCUENTO EL 2/05/2017
            // LO PONGO PARA HABILITAR EL DESCUENTO DISTINTO QUE PONDRIA EL ADMINISTRADOR
            $table->integer('porcentajeDescuento')->default(0);

            $table->string('password')->nullable();

            // En vez de agregar el id, porque puedo poner que fue por excel
            // $table->string('usuario')->nullable();

            $table->integer('idUser')->unsigned()->nullable();
            $table->foreign('idUser')->references('id')->on('users');
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
        // Schema::table('registros', function (Blueprint $table) {
        //     $table->dropColumn('pagado');
        //     $table->dropColumn('habilitado');

        //     $table->dropColumn('tipoPago');
        // });

        // Schema::table('registros', function (Blueprint $table) {
        //     $table->dropColumn('idCliente');
        //     $table->dropColumn('idSectorEvento');
        //     $table->dropColumn('idButaca');
        // });
    }
}
