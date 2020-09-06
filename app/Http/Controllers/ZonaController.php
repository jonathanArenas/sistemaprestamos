<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zona;

class ZonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware(['auth', 'role:SuperUser|Prestamista|Administrador']);
    }

    public function index()
    {
        $zonas = Zona::orderBy('nombre', 'desc')->get();
        $zonasOrd = [];//array para ordenar por zonas
        foreach($zonas as $key => $value) {
            $indices =  [];
            foreach($zonas as $key => $zona) {
                if($zona->nombre == $value->nombre){
                    $indices[] = (object) $zona;  //se agrupan las zonas iguales más su sección
                    unset($zonas[$key]);
                }   
            }
            if(empty($indices)){
                continue;
            }
           $zonasOrd[] = $indices; //agregamos las zonas ordenadas
        }
       //return $zonasOrd;
       
       return view('auth.zonas.index', compact('zonasOrd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate(Request(),[
            'nombre' => 'required|string',
        ]);

        $zonafind = Zona::where('nombre', $data['nombre'])->get();

        //return $zonafind;
        if(count($zonafind)){
            return redirect()->back()->withErrors(['El nombre de la zona ya existe, puedes agregar una nueva sección para ella']);
        }else{
            $zona = new Zona;
            $zona->nombre = $data['nombre'];
            $zona->seccion = '1';
            $zona->save();
            return redirect()->route('zonas.index')->with('success', 'Se ha creado la zona con la seccion 1 por default');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $seccion = Zona::where('nombre', $id)->orderBy('id', 'desc')->take(1)->get();
        
        $zona = new Zona;
        $zona->nombre = $seccion[0]->nombre;
        $zona->seccion = ++$seccion[0]->seccion;
        $zona->save();
        return redirect()->route('zonas.index')->with('success', 'se ha añadido la seccion '. $zona->seccion.' a '.$zona->nombre.'');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showSecciones(Request $request){

        if($request->ajax()){
         
            $query = $this->validate(Request(),[
                'query' => 'required|string|regex:(^[A-Z])',
            ]);

            if($query['query'] != '')    {
                   $data =  Zona::where('nombre', $query['query'])->get();
                    return response()->json(['data' =>  $data]);
              }
        }
        
        
    }
}
