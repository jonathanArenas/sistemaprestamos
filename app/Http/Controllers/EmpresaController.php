<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpresaRequest;
use App\Empresa;

class EmpresaController extends Controller
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
        $empresa = Empresa::find('1');

        return view('auth.empresa.index', compact('empresa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.empresa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpresaRequest $request)
    {
        $data = $request->validated();
        try {
            $empresa = new Empresa;
            $empresa->nombre = $data['nombre'];
            $empresa->email = $data['email'];
            $empresa->telefono = $data['telefono'];
            $empresa->cp = $data['postal'];
            $empresa->estado = $data['estado'];
            $empresa->municipio = $data['municipio'];
            $empresa->colonia = $data['colonia'];
            $empresa->direccion = $data['direccion'];
            $empresa->save();
            return redirect()->route('empresa.index')->with('success', 'Los datos se han agregado correctamente');
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
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empresa = Empresa::find($id);
        return view('auth.empresa.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmpresaRequest $request, $id)
    {
        $data = $request->validated();
        try {
            $empresa = Empresa::find($id);
            $empresa->nombre = $data['nombre'];
            $empresa->email = $data['email'];
            $empresa->telefono = $data['telefono'];
            $empresa->cp = $data['postal'];
            $empresa->estado = $data['estado'];
            $empresa->municipio = $data['municipio'];
            $empresa->colonia = $data['colonia'];
            $empresa->direccion = $data['direccion'];
            $empresa->save();
            return redirect()->route('empresa.index')->with('success', 'Los datos se han actualizado correctamente');
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
        //
    }
}
