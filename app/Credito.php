<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
protected $table = 'credito';

public function cliente(){
    return $this->belongsTo('App\Cliente');
}
}
