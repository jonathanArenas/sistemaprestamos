<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;
    protected $table = 'clientes';

    protected $dates = ['deleted_at'];
    
    public function ubicaciones(){
    	return $this->hasMany('App\Ubicacion');
    }

    public function creditos(){
        return $this->hasMany('App\Credito');
    }

    public function scopeNombre($query, $nombre){
        return $query->where('nombre', 'like', $nombre.'%');
    }
    public function scopePaterno($query, $paterno){
        return $query->where('pateno', 'like', $paterno.'%');
    }
}
