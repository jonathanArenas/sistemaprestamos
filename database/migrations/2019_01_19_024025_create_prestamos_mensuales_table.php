<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestamosMensualesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PRESTAMOS_MENSUALES', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->increments('id');
            $table->integer('mensualidad')->unsigned();
            $table->integer('porcentaje')->unsigned();
            $table->date('fecha_desde');
            $table->date('fecha_hasta');
            $table->integer('id_desembolso')->unsigned()->unique();
            $table->integer('id_cliente')->unsigned();
            $table->foreign('id_desembolso')->references('id')->on('DESEMBOLSOS');
            $table->foreign('id_cliente')->references('id')->on('CLIENTES'); 
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
        Schema::dropIfExists('PRESTAMOS_MENSUALES');
    }
}
