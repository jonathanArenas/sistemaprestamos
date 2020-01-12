<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCobradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('COBRADORES', function (Blueprint $table) {
            $table->engine ='InnoDB';
            $table->increments('id');
            $table->string('nombre', 45);
            $table->string('paterno', 35);
            $table->string('materno', 35);
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
        Schema::dropIfExists('COBRADORES');
    }
}
