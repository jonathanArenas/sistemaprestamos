<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Grupo;
use Illuminate\Http\Request;
use App\PrestamosTrait;


class ClienteController extends Controller
{
    use PrestamosTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('auth.cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grupos = Grupo::all();
        
        return view('auth.cliente.create', compact('grupos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $this->validate(request(),[
            'grupo' => 'required|string|max:5|min:4',
            'nombre' => 'required|string',
            'paterno' => 'required|string',
            'materno' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string|max:13|min:10',
            'documento_I' => 'required|string|max:2|min:2',
        ]);
        try {
            $cliente = new Cliente;
            $cliente->grupo_id = $credentials['grupo'];
            $cliente->nombre = $credentials['nombre'];
            $cliente->paterno =$credentials['paterno'];
            $cliente->materno = $credentials['materno'];
            $cliente->direccion = $credentials['direccion'];
            $cliente->telefono = $credentials['telefono'];
            $cliente->documento_I = $credentials['documento_I'];
            $cliente->estatus = 'NUEVO';
            $cliente->save();
            return redirect()->route('cliente.index')->with('success', 'el cliente se ha creado correctamente');
        } catch (Exception $e) {
            
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function showAjax(Request $request){

    if($request->ajax()){
        $output = '';
        $query = $request->get('query');
        if($query != '')    {
               $data = Cliente::where('nombre', 'like', $query.'%')
                 ->orWhere('paterno', 'like', $query.'%')
                 ->orWhere('materno', 'like', $query.'%')
                 ->orderBy('id', 'desc')
                 ->get();
                return response()->json(['data' =>  $data]);
          }else{
               $data = Cliente::all();
               return  response()->json(['data' =>  $data]);  
          }
    }else{

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
        $cliente = Cliente::find($id);
        $g = Grupo::find($cliente->grupo_id);
        $grupos = Grupo::all();
        return view('auth.cliente.edit', compact('cliente','grupos','g'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        $cliente->nombre = $request->get('nombre');
        $cliente->grupo_id = $request->get('grupo');
        $cliente->paterno = $request->get('paterno');
        $cliente->materno = $request->get('materno');
        $cliente->direccion = $request->get('direccion');
        $cliente->telefono = $request->get('telefono');
        $cliente->estatus = $request->get('estatus');
        $cliente->documento_I = $request->get('documento_I');

        $cliente->save();
    
        return redirect()->route('cliente.edit', $id)->with('success','El cliente se ha modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        $cliente->delete();
         return redirect()->route('cliente.index')->with('success', 'El cliente se ha eliminado correctamente');
    }

    public function clientesGrupo(Request $request){
        $keyEstatus = array();

        $credentials = $this->validate(request(),[
            'grupo' => 'required|string|max:4|min:3',   
        ]);

        $clientes = Cliente::where('grupo_id', $credentials['grupo'])->get();
        
        if(count($clientes) > 0){
          foreach ($clientes as $key => $cliente) {
            $prestamoIndividualkey = $this->getLatestKeyForPrestamoIndividual($cliente->id);
            $keyIndividual[] = $prestamoIndividualkey; 
            }  
        }else{
            $keyIndividual[] = null; 
        }
  
        $prestamoGrupokey = $this->getLatestKeyForPrestamoGrupal($credentials['grupo']);//llamamos a la funcion para obtener una key para el nuevo prestamo  a través de Trait
        return response()->json(['clientes' =>  $clientes , 'grupokey' =>  $prestamoGrupokey, 'keyIndividual' => $keyIndividual]);
    }
}
