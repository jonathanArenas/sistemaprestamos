<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $table = 'zonas';

    public function Ubicaciones(){
        return $this->hasMany('App\Ubicacion');
    }
}
