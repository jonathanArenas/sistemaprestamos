<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grupo;
use App\Desembolso;
use App\PrestamoGrupal;
use App\PrestamoDiario;
use Carbon\Carbon;
use App\PrestamosTrait;
use Illuminate\Support\Facades\DB;


class PrestamoGrupalController extends Controller
{
      use PrestamosTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    $prestamosGrupales = DB::table('prestamos_grupales')
            ->join('desembolsos', 'prestamos_grupales.id_desembolso', '=', 'desembolsos.id')
            ->join('grupos', 'prestamos_grupales.id_grupo', '=', 'grupos.id')
            ->select('prestamos_grupales.*', 'desembolsos.monto', 'desembolsos.prestamista', 'grupos.zona', 'grupos.seccion')
            ->get();
    return view('auth.prestamo.grupal.index', compact('prestamosGrupales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grupos = Grupo::all();
        return view('auth.prestamo.grupal.create', compact('grupos'));
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
            'prestamista' => 'required|string',
            'desembolso' => 'required|string',
            'date' => 'nullable|string',
            'id' => 'required',
        ]);
        $idGrupo = explode("-", $credentials['id']);
        //verificamos si la fecha esta vacia, si esta vacia se tomara como fecha la del dia de hoy
        if($credentials['date'] == null){
            $date = Carbon::now('America/Mexico_City');
        }else{
            $date = Carbon::parse($credentials['date']);
        }
        $date->toDateTimeString();
        $date->format('d-m-Y');
        //creamos un objeto de tipo desemboldo para guardar un nuevo registro
        $desembolso = new Desembolso;
        $desembolso->monto = $credentials['desembolso'];
        $desembolso->prestamista = $credentials['prestamista'];
        $desembolso->save();
        //creamos un objeto de tipo PrestamoGrupal para guardar un nuevo registro
        $prestamoGrupal = new PrestamoGrupal;
        $prestamoGrupal->prestamo_key = $credentials['id'] ;
        $prestamoGrupal->fecha = $date;
        $prestamoGrupal->id_grupo = $idGrupo[0];
        $prestamoGrupal->id_desembolso = $desembolso->id;
        $prestamoGrupal->save();
        //return $credentials;
        $Array = array();

        $requestArray = $request->toArray();
        unset($requestArray['_token'], $requestArray['prestamista'], $requestArray['desembolso'], $requestArray['date'], $requestArray['id']);
        //$requestArray = var_dump($requestArray);
        //return $requestArray;
        foreach ($requestArray as $key => $value) { //iteramos el array
            $Array[] = array(
                'id' => $key,
                'monto' => $value); //cada propiedad del objeto array se hace indipendiente para interar
        }
        
        foreach ($Array as $key => $value) {
            $this->storePrestamoIndividual($value, $date, $prestamoGrupal->id);
        }
        return redirect()->route('grupal.index')->with('success', 'el prestamo grupal '. $prestamoGrupal->prestamo_key .' se ha creado correctamente');
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
      
}
