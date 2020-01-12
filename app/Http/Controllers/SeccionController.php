<?php

namespace App\Http\Controllers;
use App\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeccionController extends Controller
{
      public function store(Request $request)
    {
    	$dataSeccion =$this->validate(request(),[
                'id' => 'required|string|max:2',
            ]
        );

        $Seccion = DB::table('secciones')->orderBy('id', 'DESC')->get();	
		$maxId = $Seccion->get(0)->id;
		++$maxId;
		
		$newSeccion = new Seccion;
		$newSeccion->id = $maxId;
		$newSeccion->save();


		$secciones = Seccion::all();
       
        return response()->json(['secciones' => $secciones ]);
    }

}
