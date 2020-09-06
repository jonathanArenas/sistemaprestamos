<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionesController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','role:SuperUser|Prestamista|Administrador']);
    }

    public function index(){
        return view('auth.configuraciones');
    }
}
