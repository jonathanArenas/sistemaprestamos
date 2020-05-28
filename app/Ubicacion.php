<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'ubicacion';

    public function zona(){
        return $this->belongsTo('App\Zona');
    }

    public function clientes(){
        return $this->belongsTO('App\Cliente');
    }
}
