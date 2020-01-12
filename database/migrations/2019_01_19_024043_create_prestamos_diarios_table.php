<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestamosDiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PRESTAMOS_DIARIOS', function (Blueprint $table) {
            $table->increments('num');
            $table->double('monto');
            $table->double('interes');
            $table->double('total_pagar');
            $table->date('fecha_desde');
            $table->date('fecha_hasta');
            $table->enum('estatus', ['OTORGANDO','PAGANDO','PAGADO']);
            $table->integer('id_cliente')->unsigned();
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_cliente')->references('id')->on('CLIENTES');
            $table->foreign('id_usuario')->references('id')->on('USUARIOS');
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
        Schema::dropIfExists('PRESTAMOS_DIARIOS');
    }
}
