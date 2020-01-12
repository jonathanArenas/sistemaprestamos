<?php

namespace App\Http\Controllers;

use App\Permiso;

use Illuminate\Http\Request;

class PermisoController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permisos = Permiso::all();

        return view('auth.permisos.index', compact('permisos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.permisos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $permiso = new Permiso;
        $permiso->name = $request->get('name');
        $permiso->guard_name  = 'web';
        $permiso->descripcion = $request->get('descripcion');
        $permiso->save();
        return redirect()->route('permiso.create')->with('success', 'El permiso se ha creado correctame');
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
        $permiso = Permiso::find($id);

        return view('auth.permisos.edit', compact('permiso', 'id'));
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
                        
        $permiso = Permiso::find($id);

        $permiso->name = $request->get('name');
        $permiso->descripcion = $request->get('descripcion');
        $permiso->save();
    
        return redirect()->route('permiso.edit', $id)->with('success','El permiso se ha modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permiso = Permiso::find($id);
        $permiso->delete();
         return redirect()->route('permiso.index')->with('success', 'El permiso se ha eliminado correctamente');
    }
}
