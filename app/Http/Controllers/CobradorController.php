<?php

namespace App\Http\Controllers;
use App\Cobrador;
use Illuminate\Http\Request;

class CobradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cobradores = Cobrador::all();
        return view('auth.cobradores.index', compact('cobradores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('auth.cobradores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $this->validate(request(),[
            'nombre' => 'required|string',
            'paterno' => 'required|string',
            'materno' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required'
        ]);
        try {
            $cobrador = new Cobrador;
            $cobrador->nombre = $request['nombre'];
            $cobrador->paterno = $request['paterno'];
            $cobrador->materno = $request['materno'];
            $cobrador->direccion = $request['direccion'];
            $cobrador->telefono = $request['telefono'];
            $cobrador->save();
            return redirect()->route('cobradores.index')->with('success', 'El nuevo registro se ha guardado correctamente');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cobrador = Cobrador::find($id);
        return view('auth.cobradores.edit', compact('cobrador'));
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
        $cobrador = Cobrador::find($id);

        $cobrador->nombre = $request->get('nombre');
        $cobrador->paterno = $request->get('paterno');
        $cobrador->materno = $request->get('materno');
        $cobrador->direccion = $request->get('direccion');
        $cobrador->telefono = $request->get('telefono');
       

        $cobrador->save();
    
        return redirect()->route('cobradores.edit', $id)->with('success','El registro se ha modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cobrador= Cobrador::find($id);
        $cobrador->delete();
         return redirect()->route('cobradores.index')->with('success', 'El registro se ha eliminado correctamente');
    }
}
