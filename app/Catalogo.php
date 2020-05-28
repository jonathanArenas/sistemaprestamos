<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Catalogo extends Model
{ 
    use SoftDeletes;
    protected $table = 'catalogo';

    protected $dates = ['deleted_at'];
}
