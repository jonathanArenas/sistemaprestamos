<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
protected $table = 'credito';
protected $primaryKey = 'num';
protected $dates = ['fecha_desde', 'fecha_hasta', 'fecha'];
protected $casts = ['fecha_desde' => 'date:d/m/Y', 
                    'fecha_hasta' => 'date:d/m/Y'];

    
    public function cliente(){
        return $this->belongsTo('App\Cliente');
    }

    public function desglosePagos(){
        return $this->hasMany('App\DesglosePagos');
    }


    function getNumAttribute($value) {
        return str_pad($value,10,'0',STR_PAD_LEFT);
    }
    function getVinculadoAttribute($value) {
        if($value == "NO"){
            return $value;
        }else{
            return str_pad($value,10,'0',STR_PAD_LEFT);
        }
       
    }

    public function getVigenteAttribute($value){
        return '$'.number_format($value,2,'.',',');
    }

    public function getCapitalSolicitadoAttribute($value){
        return '$'.number_format($value,2,'.',',');
    }

    public function getTotalPagarAttribute($value){
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

    public function getIdAttribute($value){ //id model recibo by query builder
        return str_pad($value,10,'0',STR_PAD_LEFT);
    }

    public function getTotalAttribute($value){
        return  '$'.number_format($value,2,'.',',');
    }


}
