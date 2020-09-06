<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Ubicacion;
use App\Zona;
use App\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UbicacionController;
use Barryvdh\DomPDF\Facade as PDF;


class ClienteController extends Controller
{
   

    public function __construct(){
        $this->middleware(['auth', 'role:SuperUser|Prestamista|Administrador']);
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::orderBy('id', 'desc')->take(7)->get();
        return view('auth.cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zonas = DB::table('zonas')->select('zonas.nombre')->orderBy('nombre')->distinct()->get();
        return view('auth.cliente.create', compact('zonas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteRequest $request){
        $data = $request->validated();
        try {
            $cliente = new Cliente;
            $cliente->nombre = $data['nombre'];
            $cliente->paterno =$data['paterno'];
            $cliente->materno = $data['materno'];
            $cliente->telefono = $data['telefono'];
            $cliente->email = $data['email'];
            $cliente->documento_I = $data['documento_I'];
            $cliente->creo_id_usuario = auth()->user()->id;
            if($cliente->save()){
                $ubicacion = UbicacionController::store($data, $cliente->id);
            }
            return redirect()->route('cliente.index')->with('success', 'el cliente se ha creado correctamente');
        } catch (Exception $e) {
            return $e;
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    
    }
    
    public function showAjax(Request $request){
        if($request->ajax()){
            $data = $this->validate(Request(),[ 
             'query' => 'nullable|string',
             'type' => 'required|string',
             ]);
            $query = $data['query'];
            $type = $data['type'];
            if($query != '' && $type == 'showName'){
                $data = DB::select('call getClienteAcreditaStatusByFullName(?)', array($query));
                return response()->json(['data' =>  $data]);
            }elseif($query != '' && $type == 'showZona' ){
                $cliente_id = Ubicacion::select('cliente_id')->where('zona_id', $query)->get();
                //$zona->clientes;
                $cliente = DB::select('call getClientesAcreditaStatusById(?)', array($cliente_id));

                return response()->json(['data' =>  $cliente],200);
            }elseif($query !='' && $type == 'buscador'){
                $data = Cliente::where('nombre', 'like', $query.'%')
                ->orWhere('paterno', 'like', $query.'%')
                ->orWhere('materno', 'like', $query.'%')
                ->orderBy('id', 'desc')
                ->get();
                return response()->json(['data' =>  $data],200);
            }elseif($query == '' && $type == 'buscador'){
                $data = Cliente::orderBy('id', 'desc')->take(7)->get();
                return  response()->json(['data' =>  $data]); 
            }else{
                return response()->json(['data' => false]);   
            }
        }
        
}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        $ubicacion = $cliente->ubicaciones;
        $zona = Ubicacion::find($ubicacion[0]->id)->zona;
        $zonas = DB::table('zonas')->select('zonas.nombre')->orderBy('nombre')->distinct()->get();
        return view('auth.cliente.edit', compact('cliente','ubicacion', 'zonas', 'zona'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClienteRequest $request, $id)
    {
        $data = $request->validated();
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->nombre = $data['nombre'];
            $cliente->paterno =$data['paterno'];
            $cliente->materno = $data['materno'];
            $cliente->telefono = $data['telefono'];
            $cliente->email = $data['email'];
            $cliente->documento_I = $data['documento_I'];
            $ubicacion = $cliente->ubicaciones;
            if($cliente->save()){
                 UbicacionController::update($data, $ubicacion[0]->id);
            }
            return redirect()->route('cliente.index')->with('success', 'el cliente se ha actualizado correctamente');
        } catch (Exception $e) {
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $permisso = Auth()->user()->hasRole(['SuperUser', 'Prestamista']);
            if($permisso){
                $cliente = Cliente::find($id);
                $cliente->delete();
                return redirect()->route('cliente.index')->with('success', 'El cliente se ha eliminado correctamente');
            }else{
                throw new \Exception;
            }
        } catch (\Exception $e) {
            return abort('500');
        }
        
    }

    public function pdfStream($id){
        
        $cliente = Cliente::findOrFail($id);
        //return view('auth.cliente.pdf', compact('cliente'));
        //return view('auth.cliente.pdf', compact('cliente'));
        $ubicacion = $cliente->ubicaciones;
    
        $zonas = DB::table('zonas')->select('zonas.nombre')->orderBy('nombre')->distinct()->get();
        $PDF = PDF::loadView('auth.cliente.pdf', compact('cliente', 'ubicacion'));
        return $PDF->stream();
    }

    public function pdfDowloand(){

    }

    /*public function clientesGrupo(Request $request){
        $keyEstatus = array();

        $data = $this->validate(request(),[
            'grupo' => 'required|string|max:4|min:3',   
        ]);

        $clientes = Cliente::where('grupo_id', $data['grupo'])->get();
        
        if(count($clientes) > 0){
          foreach ($clientes as $key => $cliente) {
            $prestamoIndividualkey = $this->getLatestKeyForPrestamoIndividual($cliente->id);
            $keyIndividual[] = $prestamoIndividualkey; 
            }  
        }else{
            $keyIndividual[] = null; 
        }
  
        $prestamoGrupokey = $this->getLatestKeyForPrestamoGrupal($data['grupo']);//llamamos a la funcion para obtener una key para el nuevo prestamo  a través de Trait
        return response()->json(['clientes' =>  $clientes , 'grupokey' =>  $prestamoGrupokey, 'keyIndividual' => $keyIndividual]);
    }*/
}
