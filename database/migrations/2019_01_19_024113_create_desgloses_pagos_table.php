<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesglosesPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DESGLOSES_PAGOS', function (Blueprint $table) {
            $table->integer('num_prestamo')->unsigned();
            $table->integer('num_pago');
            $table->date('fecha');
            $table->double('balance');
            $table->double('cuata');
            $table->double('demora');
            $table->double('total');
            $table->double('monto');
            $table->foreign('num_prestamo')->references('num')->on('PRESTAMOS_DIARIOS');
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
        Schema::dropIfExists('DESGLOSES_PAGOS');
    }
}
