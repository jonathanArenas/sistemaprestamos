<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\savePaymentRequest;
use App\DesglosePagos;
use App\Credito;
use App\Cargos;
use App\Recibo;
use App\PagosReciboCuenta;
use Carbon\Carbon;


class CobranzaController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'role:SuperUser|Prestamista|Administrador|Cobrador']);
    }
    
    public function getStockCredito($id){
        $cliente = Credito::select('clientes.nombre','clientes.paterno', 'clientes.materno', 'credito.tarifa_cargos', 'credito.estatus')
        ->join('clientes','clientes.id', '=', 'credito.id_cliente')
        ->where('credito.num',$id)->get();
        $allDeudas = Self::allDeudas($id);
    
       // $deudas = DB::select('call deudas(?,?)', array($id, $today));
        if(count($allDeudas) > 0){
            foreach ($allDeudas as $key => $deuda) {
                $CheckLastCargos = Cargos::where('id_pago', $deuda->id)->get();
               // return $CheckLastCargos;
                if(count($CheckLastCargos) == 0){
                    $cargo = new Cargos;
                    $cargo->id_pago = $deuda->id;
                    $cargo->dias_atrasados = $deuda->total_atrasos;
                    $cargo->monto_cargo = $cliente[0]->tarifa_cargos;
                    $cargo->save();
                }else{
                    if($CheckLastCargos[0]->dias_atrasados < $deuda->total_atrasos){
                        $cargo = Cargos::find($CheckLastCargos[0]->id);
                        $cargo->dias_atrasados = $deuda->total_atrasos;
                        $cargo->monto_cargo = $cliente[0]->tarifa_cargos;
                        $cargo->save();
                    }        
                }
            }
        }

       
      $PagosStock = Self::allPagosStock($id);
        //$pagos = DB::select('call desglose_pagos_stock(?)', array($id));
       $numCredito = $id;
        return view('auth.cobranza.index', compact('cliente','PagosStock', 'numCredito'));
    }

    public function save(savePaymentRequest $request){
        if($request->ajax()){
            $data = $request->validated();
            if($data['total'] == Self::total($data['payments'])){
                $residuo = $data['total'] - $data['efectivo'];
                $recibo = new Recibo;
                $recibo->fecha = Carbon::parse($data['date']);
                $recibo->total = $data['total'];
                $recibo->efectivo = $data['efectivo'];
                $recibo->residuo = $residuo;
                $recibo->estatus = "PAGADO";
                $recibo->cajero = Auth()->user()->id;
                $recibo->save();
                Self::saveDetallePagosCuenta($data['payments'], $recibo->id);
                $newPagosStock = Self::allPagosStock($data['num']);
                if(count($newPagosStock) == 0){
                    $credito = Credito::findOrFail($data['num']);
                    $credito->estatus = "PAGADO";
                    $credito->save();
                }
                if(count($newPagosStock) == 1){
                    $credito = Credito::findOrFail($data['num']);
                    $credito->estatus = "POR CONCLUIR";
                    $credito->save();
                }
                return response()->json(['estatus' => true, 
                'data' => [
                    'credito' => $data['num'],
                    'recibo' => $recibo->id,
                    'total'  => $data['total'],
                    'stock' => $newPagosStock, // return status credito
                ]]);
            }
                return response()->json(['estatus' => false, 'data' => 'bad']);
        }
       
    }

    private function total($pagos){
        $total = 0;
        foreach ($pagos as $key => $pago) {
            $number = str_replace(",", "", $pago['total_pagar']);
            $number = substr($number ,1);
            $total += $number;
        }
        return $total;
    }

    private function saveDetallePagosCuenta($pagos, $idRecibo){
        foreach($pagos as $key => $pago){
            $DetallePagosCuenta = new PagosReciboCuenta;
            $DetallePagosCuenta->id_pago = $pago["id"];
            $DetallePagosCuenta->id_recibo = $idRecibo;
            $DetallePagosCuenta->save();
        }
    }

    private function pagosStockWithCancelacion(){

    }

    private function allPagosStock($id){
        $pagosStockWithCancelacion =  Credito::select(
            'pagos_desglose.id as id', 
            'pagos_desglose.num_pago_credito as num_pago_credito', 
            'pagos_desglose.fecha as fecha', 
            'pagos_desglose.al_capital as al_capital', 
            'pagos_desglose.al_interes as al_interes', 
            'pagos_desglose.total_pago as total_pago',
            DB::raw('IF((cargos.dias_atrasados*cargos.monto_cargo) IS NULL, 0, (cargos.dias_atrasados*cargos.monto_cargo) ) as recargos'),
            DB::raw('IF((cargos.dias_atrasados*cargos.monto_cargo+pagos_desglose.total_pago) IS NULL, pagos_desglose.total_pago, (cargos.dias_atrasados*cargos.monto_cargo+pagos_desglose.total_pago)) as total_pagar'))
        ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
        ->join('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
        ->join('recibo','recibo.id','=','pagos_recibo_cuenta.id_recibo')
        ->leftJoin('cargos', 'cargos.id_pago', '=', 'pagos_desglose.id')
        ->where('credito.num', $id)
        ->where('recibo.estatus', 'CANCELADO');

        $allPagosStock = Credito::select(
            'pagos_desglose.id as id', 
            'pagos_desglose.num_pago_credito as num_pago_credito', 
            'pagos_desglose.fecha as fecha', 
            'pagos_desglose.al_capital as al_capital', 
            'pagos_desglose.al_interes as al_interes', 
            'pagos_desglose.total_pago as total_pago',
            DB::raw('IF((cargos.dias_atrasados*cargos.monto_cargo) IS NULL, 0, (cargos.dias_atrasados*cargos.monto_cargo) ) as recargos'),
            DB::raw('IF((cargos.dias_atrasados*cargos.monto_cargo+pagos_desglose.total_pago) IS NULL, pagos_desglose.total_pago, (cargos.dias_atrasados*cargos.monto_cargo+pagos_desglose.total_pago)) as total_pagar'))
        ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
        ->leftJoin('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
        ->leftJoin('cargos', 'cargos.id_pago', '=','pagos_desglose.id')
        ->where('credito.num', $id)->whereNull('pagos_recibo_cuenta.id_pago')
        ->unionAll($pagosStockWithCancelacion)->orderBy('id', 'ASC')->get();
        return $allPagosStock;
    }

    private function allDeudas($id){
        $today = Carbon::today()->format('Y-m-d');
        $deudasWithCancelacion = Credito::select(
            'pagos_desglose.id as id', 
            'pagos_desglose.num_pago_credito as num_pago_credito', 
            'pagos_desglose.fecha as fecha', 
            DB::raw("DATEDIFF('". $today. "', pagos_desglose.fecha) as total_atrasos"))
        ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
        ->join('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
        ->join('recibo','recibo.id','=','pagos_recibo_cuenta.id_recibo')
        ->where('credito.num', $id)
        ->where('recibo.estatus', 'CANCELADO')
        ->where('pagos_desglose.fecha', '<', $today);
        $allDeudas = Credito::select(
            'pagos_desglose.id as id', 
            'pagos_desglose.num_pago_credito as num_pago_credito', 
            'pagos_desglose.fecha as fecha', 
            DB::raw("DATEDIFF('". $today. "', pagos_desglose.fecha) as total_atrasos"))
        ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
        ->leftJoin('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
        ->where('credito.num', $id)
        ->whereNull('pagos_recibo_cuenta.id_pago')
        ->where('pagos_desglose.fecha', '<', $today)
        ->unionAll($deudasWithCancelacion)->get();
        return $allDeudas;
    } 

}
