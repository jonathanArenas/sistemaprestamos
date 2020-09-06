<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCredito;
use App\CreditosTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Catalogo;
use App\Credito;
use App\Empresa;
use App\DesglosePagos;
use App\User;
use App\Zona;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CreditoExport;

class CreditoController extends Controller{
   
   public function __construct(){
      $this->middleware(['auth', 'role:SuperUser|Prestamista|Administrador|Cobrador']);
   }
   
   use CreditosTrait;
  
   public function generar($id = null){//recibimos un id del catalogo prestamos
      if(Auth()->user()->hasAnyRole('SuperUser', 'Prestamista', 'Administrador')){
         $zonas = DB::table('zonas')->select('zonas.nombre')->orderBy('nombre')->distinct()->get();
         $prestamistas = User::role('Prestamista')->get();
         $cobradores = User::role('Cobrador')->get();
         $catalogo = Catalogo::find($id);
         $intereses = array('SIMPLE','COMPUESTO');
         $defineTiempo = array('DIAS','MESES','AÑOS');
         $no_cobranza = array('NINGUNO','LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'SABADO','DOMINGO');
         return view('auth.credito.create', compact('zonas','catalogo','intereses','defineTiempo', 'cobradores', 'prestamistas', 'no_cobranza') );
      }else{
         return abort('500');
      }
     
   }

   public function index(){
      $userRole = Auth()->user()->getRoleNames();
      $catalogos = Catalogo::all();
      if($userRole[0] == 'Prestamista'){
         $creditos = Credito::select('credito.num', 'credito.fecha_desde', 'clientes.nombre', 'clientes.paterno', 'clientes.materno','credito.capital_solicitado', 'credito.interes_type', 'credito.estatus', 'credito.express', 'credito.vinculado')
         ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')->where('otorga_id_usuario', Auth()->user()->id)->orderBy('credito.num', 'desc')->get();
      }elseif($userRole[0] == 'Cobrador'){
         $creditos = Credito::select('credito.num', 'credito.fecha_desde', 'clientes.nombre', 'clientes.paterno', 'clientes.materno','credito.capital_solicitado', 'credito.interes_type', 'credito.estatus', 'credito.express', 'credito.vinculado')
         ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')->where('id_cobrador', Auth()->user()->id)->orderBy('credito.num', 'desc')->get();
      }else{
         $creditos = Credito::select('credito.num', 'credito.fecha_desde', 'clientes.nombre', 'clientes.paterno', 'clientes.materno','credito.capital_solicitado', 'credito.interes_type', 'credito.estatus', 'credito.express', 'credito.vinculado')
         ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')->orderBy('credito.num', 'desc')->get();
      }
      return view('auth.credito.index', compact('creditos', 'catalogos'));
   }

   public function store(StoreCredito $request){
      if($request->ajax()){
         try {
            $data = $request->validated();
            $acredita = DB::select('call getClientesAcreditaStatusById(?)', array($data['id'])); 
            if($acredita[0]->estatus == "TRUE" || $acredita[0]->estatus == "EXPRESS"){
               if($acredita[0]->estatus == "EXPRESS"){
                  $express = 1;
                  $lastNumCredito = DB::select('call getLastNumCreditoCliente(?)', array($data['id']));
                  $vinculado = $lastNumCredito[0]->num;
               }else{
                  $express = 0;
                  $vinculado = "NO";
               }

               $dateRequest = $this->dateRequest($data['dateRequest']);
               $dateDevolution = $this->dateFinalDevolution($dateRequest, $data['devolucion'], $data['no_cobranza']);
               $dateRequestCopy = $dateRequest->copy();
               $tarifa_cargos = floatval(str_replace('$','', $data['tarifa_cargos']));
               $desglose = 0;
               if($data['interesType'] == "SIMPLE"){
                  $desglose = $this->simple($data['capital'], $data['porcentaje'], $dateRequestCopy,  $data['devolucion'], $data['no_cobranza']);
               }else{
                  $desglose = $this->compuesto($data['capital'], $data['porcentaje'], $dateRequestCopy, $data['devolucion'], $data['no_cobranza']);
               }
               $num_credito_cliente = Credito::where('id_cliente', '=', $data['id'])->count();
               $new_num_credito_cliente = ++$num_credito_cliente;
               $newCredito = new Credito;
               $newCredito->id_cliente = $data['id'];
               $newCredito->num_credito_cliente = $new_num_credito_cliente;
               $newCredito->otorga_id_usuario = $data['prestamista'] ;
               $newCredito->crea_id_usuario = auth()->user()->id;
               $newCredito->interes_type = $data['interesType'];
               $newCredito->porcentaje_interes = $data['porcentaje'];
               $newCredito->numero_plazodevolucion = $data['devolucion']['numberPlazo'];
               $newCredito->time_plazodevolucion = $data['devolucion']['timePlazo'];
               $newCredito->capital_solicitado = $data['capital'];
               $newCredito->interes_pagar = $desglose['totalIntereses'];
               $newCredito->total_pagar = $desglose['totalPagar'];
               $newCredito->fecha_desde = $dateRequest;
               $newCredito->fecha_hasta = $dateDevolution;
               $newCredito->estatus = 'OTORGADO';
               $newCredito->tarifa_cargos = $tarifa_cargos;
               $newCredito->express = $express;
               $newCredito->vinculado = $vinculado;
               $newCredito->id_cobrador = $data['cobrador'];
               $newCredito->save();
               $estatusDesglose = $this->storeDesglose($newCredito->num, $desglose['desglose']);
               $respuesta = array(true, $newCredito->num, $newCredito, $estatusDesglose);
               return response()->json(['data' => $respuesta]);
            }else{
               return response()->json(['data' => false]);
            }
            
         } catch (Exception $e) {
            return response()->json(['data' => false]);
         }
      }
      
   }
   
   public function show($id){
      $credito = Credito::from('credito as t1')->select('t1.num', 't1.fecha_desde', 't1.fecha_hasta', 't1.capital_solicitado','t1.num_credito_cliente', 't1.id_cliente', 't1.total_pagar', 't1.estatus',  
      DB::raw('CONCAT(t2.nombre, \' \', t2.paterno, \' \', t2.materno) as Cliente'), 't2.telefono',
      DB::raw('CONCAT(t3.nombre, \' \', t3.paterno, \' \', t3.materno) as otorga'),
      't4.direccion', 't4.num_ext', 't4.cod_postal', 't4.colonia', 't4.municipio', 't4.estado')
      ->join('clientes as t2', 't2.id', '=', 't1.id_cliente')
      ->join('usuarios  as t3', 't3.id', '=', 't1.otorga_id_usuario')
      ->join('ubicacion as t4', 't4.cliente_id', '=', 't2.id')
      ->where('num', $id)->firstOrFail();
  
      $empresa = Empresa::find(1);
      $desglose = DesglosePagos::where('num_credito', $id)->get();
      return view('auth.credito.show', compact('credito', 'empresa', 'desglose'));
   }

   public function destroy($id){
      $credito = Credito::find($id);
      $credito->estatus = "CANCELADO";
      $credito->save();
      return redirect()->route('credito.index')->with('success', 'Se ha cancelado correctamente el crédito');
   }

   public function export(CreditoExport $creditoExport ){
      return  $creditoExport->download( 'credito.xlsx');
   }

   public function shearCredito(Request $request){
      if($request->ajax()){
         $data = $this->validate(Request(), [
            'buscar' => ['required', Rule::in(['nombre', 'num'])],
            'query' => 'nullable|string',
         ]);
         if($data['buscar'] == 'nombre' && $data['query'] != ''){

            $creditos = Self::shearByAuthorizationRoleByName($data['query']);
         return response()->json(['data' => $creditos]);

         }elseif($data['buscar'] == 'num' && $data['query'] != ''){
            $creditos = Self::shearByAuthorizationRoleByNumCredit($data['query']);
         return response()->json(['data' => $creditos]);
         }else{
            $creditos = Self::showByAuthorizationRole();
            return response()->json(['data' => $creditos]);
         }
         
      }
   }

   public function  pdfStreamFichaPagos($id){
      $credito = Credito::from('credito as t1')->select('t1.num', 't1.fecha_desde', 't1.fecha_hasta', 't1.capital_solicitado','t1.num_credito_cliente', 't1.id_cliente', 't1.total_pagar',  
      DB::raw('CONCAT(t2.nombre, \' \', t2.paterno, \' \', t2.materno) as Cliente'), 't2.telefono',
      DB::raw('CONCAT(t3.nombre, \' \', t3.paterno, \' \', t3.materno) as otorga'),
      't4.direccion', 't4.num_ext', 't4.cod_postal', 't4.colonia', 't4.municipio', 't4.estado', 't4.zona_id')
      ->join('clientes as t2', 't2.id', '=', 't1.id_cliente')
      ->join('usuarios  as t3', 't3.id', '=', 't1.otorga_id_usuario')
      ->join('ubicacion as t4', 't4.cliente_id', '=', 't2.id')
      ->where('num', $id)->firstOrFail();
      $zona = Zona::find($credito->zona_id);
      $desglose = DesglosePagos::where('num_credito', $id)->get();
      $PDF = PDF::loadView('auth.credito.pdfs.fichaPagos', compact('desglose', 'credito', 'zona'))->setPaper('a4', 'landscape');
      return  $PDF->stream();
   }

   
   private function shearByAuthorizationRoleByName($query){
      $userRole = Auth()->user()->getRoleNames();
      if($userRole[0] == 'Prestamista'){
         $creditos = Credito::select('credito.num', 'credito.fecha_desde', DB::raw('CONCAT(clientes.nombre, \' \', clientes.paterno, \' \', clientes.materno) as Cliente'), 'credito.capital_solicitado', 'credito.interes_type', 'credito.estatus', 'credito.express', 'credito.vinculado')
         ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')
         ->Where(DB::raw('CONCAT_WS(clientes.nombre, clientes.paterno, clientes.materno)'), 'like', '%'.$query.'%')
         ->where('otorga_id_usuario', Auth()->user()->id)->orderBy('credito.num','desc')->get();
         return $creditos;
      }elseif($userRole[0] == 'Cobrador'){
         $creditos = Credito::select('credito.num', 'credito.fecha_desde', DB::raw('CONCAT(clientes.nombre, \' \', clientes.paterno, \' \', clientes.materno) as Cliente'), 'credito.capital_solicitado', 'credito.interes_type', 'credito.estatus',  'credito.express', 'credito.vinculado')
         ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')
         ->Where(DB::raw('CONCAT_WS(clientes.nombre,  clientes.paterno, clientes.materno)'), 'like', '%'.$query.'%')
         ->where('id_cobrador', Auth()->user()->id)->orderBy('credito.num','desc')->get();
         return $creditos;
      }else{
         $creditos = Credito::select('credito.num', 'credito.fecha_desde', DB::raw('CONCAT(clientes.nombre, \' \', clientes.paterno, \' \', clientes.materno) as Cliente'), 'credito.capital_solicitado', 'credito.interes_type', 'credito.estatus',  'credito.express', 'credito.vinculado')
         ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')
         ->Where(DB::raw('CONCAT_WS(clientes.nombre, clientes.paterno, clientes.materno)'), 'like', '%'.$query.'%')
         ->orderBy('credito.num','desc')->get();
         return $creditos;
      }
   }

   private function shearByAuthorizationRoleByNumCredit($query){
      $userRole = Auth()->user()->getRoleNames();
      if($userRole[0] == 'Prestamista'){
         $creditos = Credito::select('credito.num', 'credito.fecha_desde', DB::raw('CONCAT(clientes.nombre, \' \', clientes.paterno, \' \', clientes.materno) as Cliente'), 'credito.capital_solicitado', 'credito.interes_type', 'credito.estatus', 'credito.express', 'credito.vinculado')
         ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')->where('credito.num', $query)->where('otorga_id_usuario', Auth()->user()->id)->get();
         return $creditos;
      }elseif($userRole[0] == 'Cobrador'){
         $creditos = Credito::select('credito.num', 'credito.fecha_desde', DB::raw('CONCAT(clientes.nombre, \' \', clientes.paterno, \' \', clientes.materno) as Cliente'), 'credito.capital_solicitado', 'credito.interes_type'. 'credito.estatus', 'credito.express', 'credito.vinculado')
         ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')->where('credito.num', $query)->where('id_cobrador', Auth()->user()->id)->get();
         return $creditos;
      }else{
         $creditos = Credito::select('credito.num', 'credito.fecha_desde', DB::raw('CONCAT(clientes.nombre, \' \', clientes.paterno, \' \', clientes.materno) as Cliente'), 'credito.capital_solicitado', 'credito.interes_type', 'credito.estatus', 'credito.express','credito.vinculado')
         ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')->where('credito.num', $query)->get();
         return $creditos;
      } 
   }
   
   private function showByAuthorizationRole(){
      $userRole = Auth()->user()->getRoleNames();
      if($userRole[0] == 'Prestamista'){
         $creditos = Credito::select('credito.num', 'credito.fecha_desde', DB::raw('CONCAT(clientes.nombre, \' \', clientes.paterno, \' \', clientes.materno) as Cliente'), 'credito.capital_solicitado', 'credito.interes_type', 'credito.estatus', 'credito.express', 'credito.vinculado')
         ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')->where('otorga_id_usuario', Auth()->user()->id)->orderBy('credito.num', 'desc')->get();
      }elseif($userRole[0] == 'Cobrador'){
         $creditos = Credito::select('credito.num', 'credito.fecha_desde', DB::raw('CONCAT(clientes.nombre, \' \', clientes.paterno, \' \', clientes.materno) as Cliente'), 'credito.capital_solicitado', 'credito.interes_type', 'credito.estatus',  'credito.express','credito.vinculado')
         ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')->where('id_cobrador', Auth()->user()->id)->orderBy('credito.num', 'desc')->get();
      }else{
         $creditos = Credito::select('credito.num', 'credito.fecha_desde', DB::raw('CONCAT(clientes.nombre, \' \', clientes.paterno, \' \', clientes.materno) as Cliente'), 'credito.capital_solicitado', 'credito.interes_type', 'credito.estatus',  'credito.express','credito.vinculado')
         ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')->orderBy('credito.num', 'desc')->get();
      }
      return $creditos;
   }

}

