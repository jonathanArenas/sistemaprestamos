<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesembolsosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DESEMBOLSOS', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->increments('id');
            $table->double('monto');
            $table->date('fecha');
            $table->enum('prestario', ['VICTOR','OMAR','EMPRESA']);
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
        Schema::dropIfExists('DESEMBOLSOS');
    }
}
