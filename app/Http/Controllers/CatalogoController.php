<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Catalogo;


class CatalogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }


    public function index()
    {
        $catalogos = Catalogo::all();
        return view('auth.catalogo.index', compact('catalogos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.catalogo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate(Request(), [
                'nombre' => 'required|string',
                'interes' => 'required|string',
                'porcentaje' => 'required',
                'plazo' => 'required',
                'define_tiempo' =>'required',
                'periodicidad_cobro' => 'required',
            ]);

            try{
                $catalogo = new Catalogo;
                $catalogo->nombre = $data['nombre']; 
                $catalogo->interes = $data['interes'];
                $catalogo->porcentaje = $data['porcentaje'];
                $catalogo->plazo = $data['plazo'];
                $catalogo->define_tiempo = $data['define_tiempo'];
                $catalogo->periodicidad_cobro = $data['periodicidad_cobro'];
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
        $catalogo = Catalogo::find($id);
        $intereses = array('SIMPLE','COMPUESTO','MIXTO');
        $defineTiempo = array('DIAS','MES','AÑO');
        $periodicidad = array('DIARIO', 'SEMANAL', 'QUINCENAL', 'MENSUAL', 'ANUAL');
        return view('auth.catalogo.edit', compact('catalogo', 'intereses', 'defineTiempo', 'periodicidad'));
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
        $data = $this->validate(Request(), [
            'nombre' => 'required|string',
            'interes' => 'required|string',
            'porcentaje' => 'required',
            'plazo' => 'required',
            'define_tiempo' =>'required',
            'periodicidad_cobro' => 'required',
        ]);

        try{
            $catalogo = Catalogo::find($id);
            $catalogo->nombre = $data['nombre']; 
            $catalogo->interes = $data['interes'];
            $catalogo->porcentaje = $data['porcentaje'];
            $catalogo->plazo = $data['plazo'];
            $catalogo->define_tiempo = ($data['define_tiempo'] == 'AÑO')? 'ANIO': $data['define_tiempo'] ;
            $catalogo->periodicidad_cobro = $data['periodicidad_cobro'];
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
    public function destroy($id)
    {
        $catalogo = Catalogo::find($id);

        $catalogo->delete();
        return redirect()->route('catalogo.index')->with('success', 'El prestamo se ha eliminado correctamente del catalogo');
    }
}
