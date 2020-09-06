<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatalogoRequest;
use App\Catalogo;



class CatalogoController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware(['auth', 'role:SuperUser|Prestamista']);
    }


    public function index(){
        $catalogos = Catalogo::all();
        return view('auth.catalogo.index', compact('catalogos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('auth.catalogo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CatalogoRequest $request){
        $data = $request->validated();
    
        
            try{
                $tarifa_cargos = floatval(str_replace('$','', $data['tarifa_cargos']));

                $catalogo = new Catalogo;
                $catalogo->nombre = $data['nombre']; 
                $catalogo->interes = $data['interes'];
                $catalogo->porcentaje = $data['porcentaje'];
                $catalogo->num_plazodevolucion = $data['num_plazoDevolucion'];
                $catalogo->time_plazodevolucion = $data['time_plazoDevolucion'];
                $catalogo->no_cobranza = $data['no_cobranza'];
                $catalogo->tarifa_cargos = $tarifa_cargos;
                $catalogo->creo_id_usuario = auth()->user()->id;
                $catalogo->save();
                return redirect()->route('catalogo.index')->with('success', 'El nuevo concepto de prestamo se ha agregado correctamete');
            } catch (Exception $e) {
                return $e->getMessage();
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $catalogo = Catalogo::find($id);
        $intereses = array('SIMPLE','COMPUESTO');
        $timeDevolucion = array('DIAS', 'MESES', 'AÑOS');
        $array_no_cobranza = array('NINGUNO','LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'SABADO','DOMINGO');
        //$periodicidad = array('DIARIO', 'SEMANAL', 'QUINCENAL', 'MENSUAL', 'ANUAL');
        return view('auth.catalogo.edit', compact('catalogo', 'intereses', 'timeDevolucion','array_no_cobranza'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CatalogoRequest $request, $id){
        $data = $request->validated();
        try{
            $tarifa_cargos = floatval(str_replace('$','', $data['tarifa_cargos']));
            $catalogo = Catalogo::find($id);
            $catalogo->nombre = $data['nombre']; 
            $catalogo->interes = $data['interes'];
            $catalogo->porcentaje = $data['porcentaje'];
            $catalogo->num_plazodevolucion = $data['num_plazoDevolucion'];
            $catalogo->time_plazodevolucion = $data['time_plazoDevolucion'];
            $catalogo->no_cobranza = $data['no_cobranza'];
            $catalogo->tarifa_cargos = $tarifa_cargos;
            $catalogo->save();
            return redirect()->route('catalogo.index')->with('success', 'Se ha actualizado el concepto de prestamo en nuestro catalogo');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $catalogo = Catalogo::find($id);

        $catalogo->delete();
        return redirect()->route('catalogo.index')->with('success', 'El prestamo se ha eliminado correctamente del catalogo');
    }
}
