<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CreditosTrait;
use Illuminate\Support\Facades\DB;
use App\Catalogo;
class CreditoController extends Controller{
   public function __construct(){
      $this->middleware('auth');
   }
   
   use CreditosTrait;
  

   public function generar($id = null){//recibimos un id del catalogo prestamos
      $zonas = DB::table('zonas')->select('zonas.nombre')->orderBy('nombre')->distinct()->get();

      $catalogo = Catalogo::find($id);
      $intereses = array('SIMPLE','COMPUESTO','MIXTO');
      $defineTiempo = array('DIAS','MESES','AÑOS');
      $periodicidad = array('DIARIO', 'SEMANAL', 'QUINCENAL', 'MENSUAL', 'ANUAL');
      return view('auth.prestamo.create', compact('zonas','catalogo','intereses','defineTiempo','periodicidad') );
   }

   public function store(){

   }
   
   public function show(){

   }

   public function delete(){

   }

}
