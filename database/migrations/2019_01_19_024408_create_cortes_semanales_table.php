<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCortesSemanalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CORTES_SEMANALES', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->double('monto');
            $table->integer('id_usuario')->unsigned();
            $table->timestamps();
            $table->foreign('id_usuario')->references('id')->on('USUARIOS');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CORTES_SEMANALES');
    }
}
