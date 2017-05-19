<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectoresEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectores_eventos', function (Blueprint $table) {
            $table->increments('id');

            // LLAVES FORANEAS
            // $table->integer('idSector');
            // $table->integer('idEvento');
            
            $table->integer('idSector')->unsigned();
            $table->foreign('idSector')->references('id')->on('sectores')->onDelete('cascade');

            $table->integer('idEvento')->unsigned();
            $table->foreign('idEvento')->references('id')->on('eventos')->onDelete('cascade');
            
            $table->decimal('precio', '10', '2');
            $table->string('imagen')->nullable();
            $table->string('urlInscripcion');
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
       Schema::dropIfExists('sectores_eventos');
    }
}
