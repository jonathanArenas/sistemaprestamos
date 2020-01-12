<?php 
namespace App;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\PrestamoDiario;
use App\PrestamoGrupal;
use App\DesglosePagoDiarios;
use App\Cliente;

trait PrestamosTrait{

	//función para mostrar un detalle de los pagos de los prestanos individuales
	public function desgloseIndividual($idCliente,$monto, $fecha = null){

	   	$numPago = 1; //ACUMULADOR DE PAGOS
	   	$totalDePagos = 22; //TOTAL DE PAGOS QUE REALIZAN
	   	$fee = (($monto + ($monto * .10))/$totalDePagos);//
	   	$totalPagar = $totalDePagos * $fee; 
	   	if($fecha != null){
			$date = Carbon::parse($fecha);//("Y-m-d");//
	   	}else{
	   		$date = Carbon::now('America/Mexico_City');
	   	} 
		$date->toDateTimeString();// Convertimos la fecha en un String
		$desglose = array();//array contenedor para los pagos
	   	for($i=1; $i < 31 ; $i++){//CONSIDERANDO EL TOTAL DE DIAS QUE PUEDE TENER COMO MÁXIMO UN MES
	   		$date = $date->addDay();
	   		if($date->isSunday()){
		   		continue;
		   	}else{
		   		$restantePagoEfectuado = $totalPagar -$fee;
		   		$dia = $date->format('d-m-Y');
		   		$pago = array(
		   			"pago" => $numPago,
		   			"fecha" => $dia,
		   			"balance" => $totalPagar,
		   			"cuata" => $fee,
		   			"resta" => $restantePagoEfectuado,
		   			"abono" => $fee
		   		);
		   		$desglose[] = $pago;
		   		$totalPagar = $totalPagar-$fee; 	
	   		}
		   	if($numPago == $totalDePagos){
		   		break;
		   	}
		   	$numPago++;
	   	}
	   	//var_dump($desglose);
	   	return view('auth.prestamo.desgloseIndividual', compact('desglose'));
	}


	public function storeDesgloseIndividual($idPrestamoIndividual, $montoPrestamoIndividual, $fecha){

	   	$numPago = 1; //ACUMULADOR DE PAGOS A REALIZAR
	   	$totalDePagos = 22; //TOTAL DE PAGOS QUE REALIZAN
	   	$fee = (($montoPrestamoIndividual + ($montoPrestamoIndividual * .10))/$totalDePagos);//
	   	$totalPagar = $totalDePagos * $fee;  	
		$date = Carbon::parse($fecha);//("Y-m-d");//
		$date->toDateTimeString();// Convertimos la fecha en un String
		//return $date;
	   	for($i=1; $i < 31 ; $i++){//CONSIDERANDO EL TOTAL DE DIAS QUE PUEDE TENER COMO MÁXIMO UN MES
	   		
	   		$date = $date->addDay();
	   		if($date->isSunday()){
		   		continue;
		   	}else{
		   		
		   		$dia = $date;
		   		$desgloseIndividual = new DesglosePagoDiarios;
		   		$desgloseIndividual->num_prestamo = $idPrestamoIndividual ;
		   		$desgloseIndividual->num_pago = $numPago;
		   		$desgloseIndividual->fecha = $dia;
		   		$desgloseIndividual->balance = $totalPagar;
		   		$desgloseIndividual->cuata = $fee;
		   		$desgloseIndividual->save();		
		   		$totalPagar = $totalPagar-$fee; 
	   		}			
		   	if($numPago == $totalDePagos){
		   		break;
		   	}
		   	$numPago++;
		   	
	   	}
	}

	public function storePrestamoIndividual($cliente, $fecha, $idPrestamoGrupo){

	   	$numPago = 1; //ACUMULADOR DE PAGOS
	   	$totalDePagos = 22; //TOTAL DE PAGOS QUE REALIZAN
	   	$fee = (($cliente['monto'] + ($cliente['monto'] * .10))/$totalDePagos);//monto a pagar por día
	   	$totalPagar = $totalDePagos * $fee;
	   	$prestamoKey = $this->getLatestKeyForPrestamoIndividual($cliente['id']);
	   	$fecha = explode(" ", $fecha); 
	   	$fechaHasta = $this->fechaHasta($fecha[0]); 

	   	$prestamoIndividual = new PrestamoDiario;
	   	$prestamoIndividual->prestamo_key = $prestamoKey['prestamoKey'];
	   	$prestamoIndividual->id_prestamo_grupal = $idPrestamoGrupo;
	   	$prestamoIndividual->monto = $cliente['monto'];
	   	$prestamoIndividual->interes = 5;
	   	$prestamoIndividual->total_pagar = $totalPagar;
	   	$prestamoIndividual->fecha_desde = $fecha[0];
	   	$prestamoIndividual->fecha_hasta = $fechaHasta;
	   	$prestamoIndividual->estatus = 'OTORGADO';
	   	$prestamoIndividual->id_cliente = $cliente['id'];
	   	$prestamoIndividual->id_usuario = auth()->user()->id;
	   	$prestamoIndividual->save();

	   	echo $this->storeDesgloseIndividual($prestamoIndividual->num, $prestamoIndividual->monto, $fecha[0]);

	}

	public function getLatestKeyForPrestamoGrupal($idGrupo = null){
		#SELECT prestamo_key  FROM bd_prueba_prestamos.prestamos_grupales where id_grupo = 'ALT1' and created_at = ( select Max(created_at) from bd_prueba_prestamos.prestamos_grupales );
		#consulta para bucar la key del prestamo por el id del grupo y el ultimo registro del prestamo solicitado 
		$prestamoKey = DB::table('prestamos_grupales')->select('prestamo_key')
                ->where([
                	['id_grupo', '=', $idGrupo], 
                	['created_at', '=', DB::raw('(SELECT MAX(created_at) FROM prestamos_grupales WHERE id_grupo = "'.$idGrupo.'")')],
                	])
                ->get();
        if (!$prestamoKey->count()){
        	return $prestamoKey = $idGrupo.'-1';
        }else{
        	
        	$explodePrestamoKey = explode('-', $prestamoKey[0]->prestamo_key);
        	$explodePrestamoKey[1]++;
        	$prestamoKey = $explodePrestamoKey[0].'-'.$explodePrestamoKey[1];
			return $prestamoKey;
        }          
	}



	public function getLatestKeyForPrestamoIndividual($idCliente = null){
		#SELECT prestamo_key, estatus  FROM bd_prueba_prestamos.prestamos_diarios where prestamo_key Like "1%" and created_at = ( select Max(created_at) from bd_prueba_prestamos.prestamos_diarios );
		if ($idCliente == null) {
			return null;
		}
			$cliente = Cliente::find($idCliente);
			$explodeClienteNom = substr($cliente->nombre, 0, 3);
		//return $explodeClienteNom;

		$prestamoKey = DB::table('prestamos_diarios')->select('prestamo_key', 'estatus')
                ->where([
                	['id_cliente', '=', $idCliente],
                	['created_at', '=', DB::raw('(select Max(created_at) from prestamos_diarios where id_cliente = '.$idCliente.')')],
                	])
                ->get();
        //return $prestamoKey[0]->estatus;
        if (!$prestamoKey->count()){
        	$key = array(
        		'prestamoKey' => $explodeClienteNom.'-'.$idCliente.'-1',
        		'estatus' => 'SIN ACTIVIDAD',
        	);
        	return $key;
        }else{
        	$explodePrestamoKey = explode('-', $prestamoKey[0]->prestamo_key);
        	$explodePrestamoKey[2]++;
        	$key = array(
        		'prestamoKey' => $explodePrestamoKey[0].'-'.$explodePrestamoKey[1].'-'.$explodePrestamoKey[2]
        	);
        	
			return $key;
        }
	}

	private function fechaHasta($fechaDesde){
		$date = Carbon::parse($fechaDesde);//("Y-m-d");//
		$date->toDateTimeString();// Convertimos la fecha en un String
		$fechaHasta = '';
		$totalDias = 22;
		$dias = 1;
	   	for($i=1; $i < 31 ; $i++){//CONSIDERANDO EL TOTAL DE DIAS QUE PUEDE TENER COMO MÁXIMO UN MES
	   		
	   		$date = $date->addDay();
	   		if($date->isSunday()){
		   		continue;
		   	}else{
		   		$fechaHasta = $date; 	
	   		}			
		   	if($dias == $totalDias){
		   		break;
		   	}
		   	$dias++;
		   	
	   	}
	   	return $fechaHasta;
	}

}


 ?>