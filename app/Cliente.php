<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    public function ubicaciones(){
    	return $this->hasMany('App\Ubicacion');
    }

    public function creditos(){
        return $this->hasMany('App\Credito');
    }
}
