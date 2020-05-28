<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zona;
use App\Ubicacion;
class UbicacionController extends Controller
{
 
    public static function store($data, $id){
        $idZona = Self::getZona($data);
        $ubicacion = new Ubicacion;
        $ubicacion->cod_postal = $data['postal'];
        $ubicacion->estado = $data['estado'];
        $ubicacion->municipio = $data['municipio'];
        $ubicacion->colonia = $data['colonia'];
        $ubicacion->direccion = $data['direccion'];
        $ubicacion->num_int = $data['num_int'];
        $ubicacion->num_ext = $data['num_ext'];
        $ubicacion->estatus = 'ALTA';
        $ubicacion->cliente_id = $id;
        $ubicacion->zona_id = $idZona;
        $ubicacion->save();
    }

    public static function update($data, $id){
        $idZona = Self::getZona($data);
        $ubicacion = Ubicacion::find($id);
        $ubicacion->cod_postal = $data['postal'];
        $ubicacion->estado = $data['estado'];
        $ubicacion->municipio = $data['municipio'];
        $ubicacion->colonia = $data['colonia'];
        $ubicacion->direccion = $data['direccion'];
        $ubicacion->num_int = $data['num_int'];
        $ubicacion->num_ext = $data['num_ext'];
        $ubicacion->estatus = 'ALTA';
        $ubicacion->zona_id = $idZona;
        $ubicacion->save();
    }

    public static function getZona($data){
        $zona = Zona::Where('nombre', $data['zona'])->where('seccion', $data['seccion'])->get();
        return $zona[0]->id;
    }
}
