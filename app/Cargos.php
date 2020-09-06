<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargos extends Model
{
    public function desglosePagos(){
        return $this->belongsTo('App\DesglosePagos');
    }
}
