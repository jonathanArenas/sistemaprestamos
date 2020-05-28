<?php 
namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\DesglosePagoDiarios;
use App\Cliente;
use Illuminate\Http\Request;

trait CreditosTrait{

	//función para mostrar un detalle de los pagos de los prestanos individuales
	public function desgloseIndividual(Request $request){
		if($request->ajax()){
			$data = $this->validate(Request(),[
				'id' => 'required|integer',
				'dateRequest' => 'nullable|date',
				'capital' => 'required|integer|max:999999',
				'interesType' => ['required', Rule::in(['SIMPLE', 'COMPUESTO', 'MIXTO'])],
				'porcentaje' => 'required|integer|max:99',
				'devolucion' => 'required',
				'devolucion.numberPlazo' => 'required|integer',
				'devolucion.timePlazo' => ['required', Rule::in(['DIAS', 'MESES', 'ANIOS'])],
				'cobro' => ['required', Rule::in(['DIARIO', 'SEMANAL', 'QUINCENAL', 'MENSUAL', 'ANUAL'])],
			]);
			
			$dateRequest = ($data['dateRequest'] == null) ? Carbon::today() : Carbon::parse($data['dateRequest']) ;
			//$dateRequest->tz = 'America/Mexico_City';
			$dateDevolution = Self::dateFinalDevolution($dateRequest, $data['devolucion']);
			//$numeros = Self::getNumbersPayments($dateRequest, $dateDevolution, $data['cobro']);
			//return array($numeros, $dateRequest, $dateDevolution);
			if($data['interesType'] == "SIMPLE"){
				
				 return self::simple($data['capital'], $data['porcentaje'], $dateRequest, $dateDevolution, $data['cobro']);
			}elseif($data['interesType'] == "COMPUESTO"){
				 return self::compuesto($data['capital'], $data['porcentaje'], $dateRequest, $dateDevolution, $data['cobro']);
			}elseif($data['interesType'] == "MIXTO"){

			}else{
				return "error al realiza las operaciones";
			}
			/*
			if(var_dump($dateRequest->notEqualTo($dateDevolution))){
				return response()->json(['data' => true]);
			}*/
			//return response()->json(['data' => [$dateRequest, $dateDevolution]]);
		}
		/*
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
					"fecha" => $dia,
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
	   	return view('auth.prestamo.desgloseIndividual', compact('desglose'));*/
	}

	private function simple($capital, $porcentaje ,$dateRequest, $dateDevolution, $cobro){
		$vigente = (integer) $capital;
		$totalInteres = $capital*($porcentaje/100);
		//$totalPayForCredito = $capital + $totalInteres; utilizar despues si es necesario
		$numberPayments = Self::getNumbersPayments($dateRequest, $dateDevolution, $cobro);
		$payment = $vigente/$numberPayments;
		$cuataForInteres = $totalInteres/$numberPayments;
		$totalToPayment = $payment + $cuataForInteres;
		$table = array();
		for ($i=1; $i <= $numberPayments ; $i++) { 
			
			$row = array ( 
					"date" => Self::addDateForPayment($dateRequest, $cobro),
		   			"numberPago" => '0'.$i.'/0'.$numberPayments,
		   			"vigente" => number_format($vigente, 2, '.', ','),
		   			"al capital" => number_format($payment, 2, '.', ','),
		   			"al interes" => number_format($cuataForInteres, 2, '.', ','),
		   			"Total a pagar" => $totalToPayment,
			);
			$table[] = $row;
			$vigente = ($vigente - $payment);
		}
		return $table;
	}

	private function compuesto($capital, $porcentaje ,$dateRequest, $dateDevolution, $cobro){
		$vigente = (integer) $capital;
		$numberPayments = Self::getNumbersPayments($dateRequest, $dateDevolution, $cobro);
		$payment = $vigente/$numberPayments;
		$table = array();
		for ($i=1; $i <= $numberPayments; $i++) { 
			$interesForCuentaVigente = $vigente*($porcentaje/100);
			$totalToPayment = ($payment + $interesForCuentaVigente);
			$row = array ( 
				   "date" => Self::addDateForPayment($dateRequest, $cobro),
				   "numberPago" => '0'.$i.'/0'.$numberPayments,
				   "vigente" => number_format($vigente, 2, '.',','),
				   "al capital" => number_format($payment, 2, '.', ','),
				   "al interes" => number_format($interesForCuentaVigente, 2, '.', ','),
				   "Total a pagar" => $totalToPayment,
			);
		$table[] = $row;
		$vigente = ($vigente - $payment);
		}
		return $table;
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

	private function addDateForPayment($dateForPayment, $cobro){
		if($cobro == "DIARIO"){
			$dateForPayment->addDay();
		}elseif($cobro == "SEMANAL"){
			$dateForPayment->addWeek();
		}elseif($cobro == "QUINCENAL"){
			$dateForPayment->addDays(15);
		}elseif($cobro == "MENSUAL"){
			$dateForPayment->addMonth();
		}elseif($cobro == "ANUAL"){
			$dateForPayment->addYear();
		}
		$dateForPayment = $dateForPayment->format('d-m-Y');
		
		return $dateForPayment;
	}

	private function getNumbersPayments($dateRequest, $dateDevolution, $cobro){
		$numberPayments = 0;
		if($cobro == "DIARIO"){
			$numberPayments = $dateRequest->diffInDays($dateDevolution);
		}elseif($cobro == "SEMANAL"){
			$numberPayments = $dateRequest->diffInDays($dateDevolution);
			$numberPayments = intDiv($numberPayments,7);
		}elseif($cobro == "QUINCENAL"){
			$numberPayments = $dateRequest->diffInDays($dateDevolution);
			$numberPayments = intDiv($numberPayments,15);
		}elseif($cobro == "MENSUAL"){
			$numberPayments = $dateRequest->diffInMonths($dateDevolution);
		}elseif($cobro == "ANUAL"){
			$unumberCobros = $dateRequest->diffInYears($dateDevolution);
		}
		return $numberPayments;
	}

	private function dateFinalDevolution($dateRequest, $devolution){
		$dateDevolution= $dateRequest->copy();
		$dateDevolution->toDateTimeString();
		//$dateRequest->toDateTimeString();// Convertimos la fecha en un String
		//$dateDevolution = ''; //inicializamos la fecha de devolución
		$numberPlazo = $devolution['numberPlazo'];
		$timePlazo = $devolution['timePlazo'];
			if($timePlazo == "DIAS"){
				$dateDevolution->addDays($numberPlazo);
			}elseif($timePlazo == "MESES"){
				$dateDevolution->addMonths($numberPlazo);
			}elseif($timePlazo == "ANIOS"){
				$dateDevolution->addYear($numberPlazo);
			}else{
				$dateDevolution = "no se realizo el calculo";
			}
	   		
	   	return $dateDevolution;
	}

	

}


 ?>