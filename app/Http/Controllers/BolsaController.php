<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BolsaController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $zonas = DB::table('zonas')->select('zonas.nombre')->orderBy('nombre')->distinct()->get();
        return view('auth.deudores.index', compact('zonas'));
    }
}
