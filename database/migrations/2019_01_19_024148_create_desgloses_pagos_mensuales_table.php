<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesglosesPagosMensualesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DESGLOSES_PAGOS_MENSUALES', function (Blueprint $table) {
            $table->integer('id_prestamo')->unsigned();
            $table->date('fecha');
            $table->double('balance');
            $table->integer('porcentaje');
            $table->double('total_interes');
            $table->double('cuata');
            $table->double('total');
            $table->double('monto');
            $table->foreign('id_prestamo')->references('id')->on('PRESTAMOS_MENSUALES');
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
        Schema::dropIfExists('DESGLOSES_PAGOS_MENSUALES');
    }
}
