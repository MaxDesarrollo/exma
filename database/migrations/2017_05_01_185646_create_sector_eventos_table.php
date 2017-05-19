<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectorEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('sectorEventos', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('idSector');
        //     $table->integer('idEvento');
        //     $table->decimal('precio', '10', '2');
        //     $table->string('imagen');
        //     $table->string('urlInscripcion');
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
        // Schema::dropIfExists('sectorEventos');
    }
}
