<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    protected $table = "recibo";
    protected $dates = ['fecha'];
    protected $casts = ['fecha' => 'date:d/m/Y'];
    public function desglosePagos(){
        return $this->belongsToMany('App\DesglosePagos');
    }

    public function getIdAttribute($value){
        return str_pad($value,10,'0',STR_PAD_LEFT);
    }

    public function getTotalAttribute($value){
        return '$'.number_format($value,2,'.',',');
    }
    
    public function getEfectivoAttribute($value){
        return '$'.number_format($value,2,'.',',');
    }

    public function getResiduoAttribute($value){
        return '$'.number_format($value,2,'.',',');
    }
}
