<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    public function grupo(){
    	return $this->hasOne(Grupo::class, 'id');
    }
}
