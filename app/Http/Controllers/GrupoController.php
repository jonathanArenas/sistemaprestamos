<?php

namespace App\Http\Controllers;
use App\Grupo;
use App\Seccion;
use Illuminate\Http\Request;

class GrupoController extends Controller
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
        $grupos = Grupo::all();
        return view('auth.group.index', compact('grupos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $secciones = Seccion::all();
        return view('auth.group.create', compact('secciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataGroup =$this->validate(request(),[
                'zona' => 'required|string',
                'seccion' => 'required|max:2'
            ]
        );
        //echo $dataGroup['zona'] ;
        $idGroup = substr($dataGroup['zona'], 0, 3).$dataGroup['seccion'];

        $groupKey = Grupo::find($idGroup);

        //return $gruopKey;
    
    if(empty($groupKey)){
            $group = new Grupo;
            $group->id = $idGroup;
            $group->zona = $dataGroup['zona'];
            $group->seccion = $dataGroup['seccion'];
            $group->save();
            return redirect()->route('grupo.create')->with('success', 'El grupo se ha creado correctame');
        }else{
            return redirect()->route('grupo.create')->with('error', 'Ya existe un grupo igual');
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
        $grupo = Grupo::find($id);
        $secciones = Seccion::all();
        return view('auth.group.edit', compact('grupo', 'secciones'));
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
        //
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

    public function clientes(Request $request){
        
        
        
    }
}
