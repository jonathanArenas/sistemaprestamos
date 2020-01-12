<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';
    public $incrementing = false;

    public function cliente(){
    	return $this->belongsToMany(Cliente::class);
    }
}
