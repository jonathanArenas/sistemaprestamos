<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CLIENTES', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->increments('id');
            $table->char('grupo_id', 5)->nullable();
            $table->string('nombre', 40);
            $table->string('paterno', 35);
            $table->string('materno', 35);
            $table->char('telefono', 13);
            $table->text('direccion');
            $table->enum('documento_I', ['SI','NO']);
            $table->enum('estatus', ['NUEVO','BAJA']);
            $table->integer('reputacion')->unsigned();
            $table->timestamps();
            $table->foreign('grupo_id')->references('id')->on('GRUPOS');       
         }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CLIENTES');
    }
}
