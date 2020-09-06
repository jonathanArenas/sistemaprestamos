<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesglosePagos extends Model
{
    protected $table = 'pagos_desglose';

    protected $dates = ['fecha'];
    
    protected $casts = ['fecha' => 'date:d/m/Y'];

    public function cargos(){
    	return $this->hasMany('App\Cargos');
    }

    public function credito(){
        return $this->belongsTo('App\Credito');
    }

    public function getVigenteAttribute($value){
        return '$'.number_format($value,2,'.',',');
    }

    public function getAlCapitalAttribute($value){
        return '$'.number_format($value,2,'.',',');
    }

    public function getAlInteresAttribute($value){
        return '$'.number_format($value,2,'.',',');
    }

    public function getTotalPagoAttribute($value){
        return '$'.number_format($value,2,'.',',');
    }

    public function getRecargosAttribute($value){
        return '$'.number_format($value,2,'.',',');
    }
    public function getTotalPagarAttribute($value){
        return '$'.number_format($value,2,'.',',');
    }

}
