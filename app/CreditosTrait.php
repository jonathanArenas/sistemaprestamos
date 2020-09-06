<?php 
namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\DesglosePagos;
use App\Cliente;
use App\Http\Requests\StoreCredito;
use Illuminate\Http\Request;

trait CreditosTrait{

	//función para mostrar un detalle de los pagos de los prestanos individuales
	public function desgloseIndividual(StoreCredito $request){
		if($request->ajax()){
			$data = $request->validated();			
			//se crea un objeto carbon de tipo fecha y si no hay fecha se crea de acuerdo a la de hoy
			$dateRequest =  Self::dateRequest($data['dateRequest']);
			$dateDevolution = Self::dateFinalDevolution($dateRequest, $data['devolucion'], $data['no_cobranza']);
			if($data['interesType'] == "SIMPLE"){	
				 return self::simple($data['capital'], $data['porcentaje'], $dateRequest,  $data['devolucion'], $data['no_cobranza']);
			}elseif($data['interesType'] == "COMPUESTO"){
				 return self::compuesto($data['capital'], $data['porcentaje'], $dateRequest,  $data['devolucion'], $data['no_cobranza']);
			}else{
				return "error al realiza las operaciones";
			}
		}   		
	}

	private function simple($capital, $porcentaje ,$dateRequest, $plazoDevolucion, $dia_no_cobranza){
		$vigente = (integer)$capital;
		$totalInteres = round(($capital*($porcentaje/100))*$plazoDevolucion['numberPlazo']);
		$totalPayForCredito = $capital + $totalInteres;
		$numberPayments = $plazoDevolucion['numberPlazo'];
		//pensado cuando el plazo de cobro es distinto al plazo de devolución, 2 meses, cobranza semanal, quicenal
		//$numberPayments = Self::getNumbersPayments($dateRequest, $dateDevolution, $plazoDevolucion['timePlazo']);
		$payment = $vigente/$numberPayments;
		$cuataForInteres = $totalInteres/$numberPayments;
		$totalToPayment = $payment + $cuataForInteres;
		$table = array();
		for ($i=1; $i <= $numberPayments ; $i++) { 
			$row = array ( 
					"date" => Self::addDateForPayment($dateRequest, $plazoDevolucion['timePlazo'], $dia_no_cobranza),
		   			"numberPago" => ($i<10 && $numberPayments <10) ?  '0'.$i.'/0'.$numberPayments : (($i<10 && $numberPayments>=10) ? '00'.$i.'/0'.$numberPayments : '0'.$i.'/0'.$numberPayments),
		   			"vigente" => number_format($vigente, 2, '.', ','),
		   			"alCapital" => number_format($payment, 2, '.', ','),
		   			"alInteres" => number_format($cuataForInteres, 2, '.', ','),
		   			"totalPagar" => $totalToPayment,
			);
			$table[] = $row;
			$vigente = ($vigente - $payment);
		}
		return array(
			'capital' => $capital, 
			'totalIntereses' => $totalInteres, 
			'totalPagar' => $totalPayForCredito, 
			'desglose' => $table,
		);
	}

	private function compuesto($capital, $porcentaje ,$dateRequest,  $plazoDevolucion, $dia_no_cobranza){
		$vigente = (integer) $capital;
		$numberPayments = $plazoDevolucion['numberPlazo'];
		$payment = $vigente/$numberPayments;
		$totalInteres = $numberPayments*($capital*($porcentaje/100) + $payment*($porcentaje/100))/2;
		$totalPayForCredito = $capital + $totalInteres;
		$table = array();
		for ($i=1; $i <= $numberPayments; $i++) { 
			$interesForCuentaVigente = $vigente*($porcentaje/100);
			$totalToPayment = ($payment + $interesForCuentaVigente);
			$row = array ( 
				   "date" => Self::addDateForPayment($dateRequest, $plazoDevolucion['timePlazo'], $dia_no_cobranza),
				   "numberPago" => '0'.$i.'/0'.$numberPayments,
				   "vigente" => number_format($vigente, 2, '.',','),
				   "alCapital" => number_format($payment, 2, '.', ','),
				   "alInteres" => number_format($interesForCuentaVigente, 2, '.', ','),
				   "totalPagar" => $totalToPayment,
			);
		$table[] = $row;
		$vigente = ($vigente - $payment);
		}
		return array(
			'capital' => $capital,
			'totalIntereses' => $totalInteres, 
			'totalPagar' => $totalPayForCredito, 
			'desglose' => $table,
		);
	}

	public function storeDesglose($idPrestamo, $dataDesglose){
		try {
			foreach ($dataDesglose as $key => $item) {
				$Payment = new DesglosePagos;
				$Payment->num_credito = $idPrestamo;
				$Payment->fecha = new Carbon($item['date']);
				$Payment->num_pago_credito = $item['numberPago'];
				$Payment->vigente = str_replace(",", "", $item['vigente']);
				$Payment->al_capital = str_replace(",", "", $item['alCapital']);
				$Payment->al_interes = str_replace(",", "", $item['alInteres']);
				$Payment->total_pago = str_replace(",", "", $item['totalPagar']);
				$Payment->save(); 		   
			}
			return true;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
		
	}

	/*public function getLatestKeyForPrestamoGrupal($idGrupo = null){
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
	}*/


	/*
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
	}*/

	private function addDateForPayment($dateForPayment, $cobro, $dia_no_cobranza){
		if($cobro == "DIAS"){
			$dateForPayment->addDay();
			if($dia_no_cobranza != "NINGUNO"){
				if($dateForPayment->isDayOfWeek(Self::translateDayOfWeek($dia_no_cobranza)))
				$dateForPayment->addDay();

			}
		$dateForPayment = $dateForPayment->format('d-m-Y');
		return $dateForPayment;			
		}elseif($cobro == "MES" || $cobro == "MESES"){
			$dateForPayment->addMonth();
			$copyDateForPayment = $dateForPayment->copy();
			if($dia_no_cobranza != "NINGUNO"){
				if($copyDateForPayment->isDayOfWeek(Self::translateDayOfWeek($dia_no_cobranza)))
				$copyDateForPayment->addDay();
			}
		$copyDateForPayment = $copyDateForPayment->format('d-m-Y');
		return $copyDateForPayment;	
		}elseif($cobro == "ANIO" || $cobro == "ANIOS"){
			$dateForPayment->addYear();
			$copyDateForPayment = $dateForPayment->copy();
			if($dia_no_cobranza != "NINGUNO"){
				if($copyDateForPayment->isDayOfWeek(Self::translateDayOfWeek($dia_no_cobranza)))
				$copyDateForPayment->addDay();
			}
		$copyDateForPayment = $copyDateForPayment->format('d-m-Y');
		return $copyDateForPayment;		
		}
	}

	private function getNumbersPayments($dateRequest, $dateDevolution, $cobro){
		$numberPayments = 0;
		if($cobro == "DIAS"){
			$numberPayments = $dateRequest->diffInDays($dateDevolution);
		}elseif($cobro == "MES" || $cobro == "MESES"){
			$numberPayments = $dateRequest->diffInMonths($dateDevolution);
		}elseif($cobro == "ANIO" || $cobro == "ANIOS"){
			$numberPayments = $dateRequest->diffInYears($dateDevolution);
		}
		return $numberPayments;
	}

	private function dateFinalDevolution($dateRequest, $devolution, $dia_no_cobranza){
		$dateDevolution= $dateRequest->copy();
		$dateDevolution->toDateTimeString();
		//$dateRequest->toDateTimeString();// Convertimos la fecha en un String
		//$dateDevolution = ''; //inicializamos la fecha de devolución
		$numberPlazo = $devolution['numberPlazo'];
		$timePlazo = $devolution['timePlazo'];
		for ($i=0; $i < $numberPlazo ; $i++) { 
			if($timePlazo == "DIAS"){
				$dateDevolution->addDay();
				if($dia_no_cobranza != "NINGUNO"){
					if($dateDevolution->isDayOfWeek(Self::translateDayOfWeek($dia_no_cobranza)))
					$dateDevolution->addDay();
				}
			}elseif($timePlazo == "MES"){
				$dateDevolution->addDay();
				if($dia_no_cobranza != "NINGUNO"){
					if($dateDevolution->isDayOfWeek(Self::translateDayOfWeek($dia_no_cobranza)))
					$dateDevolution->addDay();
				}
			}elseif($timePlazo == "MESES"){
				$dateDevolution->addMonth();
				if($dia_no_cobranza != "NINGUNO"){
					if($dateDevolution->isDayOfWeek(Self::translateDayOfWeek($dia_no_cobranza)))
					$dateDevolution->addDay();
				}
			}elseif($timePlazo == "ANIO"){
				$dateDevolution->addYear();
				if($dia_no_cobranza != "NINGUNO"){
					if($dateDevolution->isDayOfWeek(Self::translateDayOfWeek($dia_no_cobranza)))
					$dateDevolution->addDay();
				} 
			}elseif($timePlazo == "ANIOS"){
				$dateDevolution->addYear();
				if($dia_no_cobranza != "NINGUNO"){
					if($dateDevolution->isDayOfWeek(Self::translateDayOfWeek($dia_no_cobranza)))
					$dateDevolution->addDay();
				}
			}else{
				$dateDevolution = "no se realizo el calculo";
			}
		}
			   		
	   	return $dateDevolution;
	}

	private function dateRequest($date){
		return ($date == null) ? Carbon::today() : Carbon::parse($date) ;
	}

	private function translateDayOfWeek($dia_no_cobranza){
		switch ($dia_no_cobranza) {
			case 'LUNES':
				return Carbon::MONDAY;
				break;
			case 'MARTES':
				return Carbon::TUESDAY;
				break;
			case 'MIERCOLES':
				return Carbon::WEDNESDAY;
				break;
			case 'JUEVES':
				return Carbon::THURSDAY;
				break;
			case 'VIERNES':
				return Carbon::FRIDAY;
				break;
			case 'SABADO':
				return Carbon::SATURDAY;
				break;
			case 'DOMINGO':
				return Carbon::SUNDAY;
				break;
		}
	}
}


 ?>