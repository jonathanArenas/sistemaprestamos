<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagosReciboCuenta extends Model
{
    protected $table = "pagos_recibo_cuenta";
    public $timestamps = false;

    public function recibo(){
        return $this->belongsTo('App\Recibo');
    }



}
