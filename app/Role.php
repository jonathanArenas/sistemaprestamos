<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
class Role extends Model
{
	use HasRoles;
    protected $table = 'roles';

     protected $fillable = [
        'name', 'guard_name', 'descripcion',
    ];
}
