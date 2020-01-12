<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestamosGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PRESTAMOS_GRUPALES', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->increments('id');
            $table->date('fecha');
            $table->char('id_grupo', 5);
            $table->integer('id_desembolso')->unsigned()->unique();
            $table->foreign('id_grupo')->references('id')->on('GRUPOS');
            $table->foreign('id_desembolso')->references('id')->on('DESEMBOLSOS');
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
        Schema::dropIfExists('PRESTAMOS_GRUPALES');
    }
}
