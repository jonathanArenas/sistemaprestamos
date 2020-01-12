<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosPrestamosGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PAGOS_PRESTAMOS_GRUPALES', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('num_prestamo')->unsigned();
            $table->date('fecha');
            $table->double('monto');
            $table->integer('id_usuario')->unsigned();
            $table->integer('id_cobrador')->unsigned();
            $table->timestamps();
            $table->foreign('num_prestamo')->references('id')->on('PRESTAMOS_GRUPALES');
            $table->foreign('id_usuario')->references('id')->on('USUARIOS');
            $table->foreign('id_cobrador')->references('id')->on('COBRADORES');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PAGOS_PRESTAMOS_GRUPALES');
    }
}
