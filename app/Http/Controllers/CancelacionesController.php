<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CancelacionesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($folio=null){
        $zonas = DB::table('zonas')->select('zonas.nombre')->orderBy('nombre')->distinct()->get();
        return view('auth.cancelaciones.index', compact('folio', 'zonas'));
    }

}
