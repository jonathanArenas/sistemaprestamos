<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapitalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CAPITAL', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->increments('id');
            $table->double('monto');
            $table->enum('concepto', ['INGRESO', 'EGRESO']);
            $table->date('fecha');
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
        Schema::dropIfExists('CAPITAL');
    }
}
