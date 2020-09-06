<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Credito;
use App\PagosReciboCuenta;
use App\DesglosePagos;
use App\Recibo;
use Carbon\Carbon;
use App\Http\Requests\InvoicesAjaxRequest;
use App\Http\Requests\InvoiceAjaxRequest;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class InvoicesController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function invoices($num){//Search receipts credit

        $receipts = Credito::select('recibo.id', 'recibo.created_at', 'recibo.total', 'recibo.estatus', 'usuarios.nombre')
        ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
        ->join('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
        ->join('recibo','recibo.id','=','pagos_recibo_cuenta.id_recibo')
        ->join('usuarios', 'usuarios.id', '=', 'recibo.cajero')->where('credito.num', $num)->groupBy('recibo.id')->get();
        return view('auth.invoices.show', compact('receipts', 'num'));
    }

    public function pdfInvoices($num){

    }


    public function invoice($num, $id){
        $pagosRecibosCuenta = DesglosePagos::select('id', 'fecha', 'num_pago_credito', 'vigente', 'al_capital', 'al_interes', 'total_pago')->join();
    }

    public function pdfInvoice($num, $id){  
        $recibo = Recibo::findOrFail($id);
        $credito = Credito::findOrFail($num);
        $pagos = Credito::select('pagos_desglose.fecha', 'pagos_desglose.num_pago_credito', 'pagos_desglose.vigente', 
        'pagos_desglose.al_capital', 'pagos_desglose.al_interes', 'pagos_desglose.total_pago',
        DB::raw('IF((cargos.dias_atrasados*cargos.monto_cargo) IS NULL, 0, (cargos.dias_atrasados*cargos.monto_cargo) ) as recargos'),
        DB::raw('IF((cargos.dias_atrasados*cargos.monto_cargo+pagos_desglose.total_pago) IS NULL, pagos_desglose.total_pago, (cargos.dias_atrasados*cargos.monto_cargo+pagos_desglose.total_pago)) as total_pagar'))
        ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
        ->join('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
        ->join('recibo', 'recibo.id', '=' , 'pagos_recibo_cuenta.id_recibo')
        ->leftJoin('cargos', 'cargos.id_pago', '=', 'pagos_desglose.id')
        ->where('credito.num', $num)
        ->where('recibo.id', $id)->get();
        
        $PDF = PDF::setOptions([
            'images' => true
        ])->loadView('auth.invoices.pdfs.invoice',compact('pagos', 'recibo', 'credito'));
        return $PDF->stream('prueba.pdf');
    }

    
    public function invoicesAjax(InvoicesAjaxRequest $request){
        if($request->ajax()){
            $data = $request->validated();
            if($data['flat'] == "General"){
                    $result = Self::getInvoicesGeneral($data['dateStart'], $data['dateEnd']);
            }else if($data['flat'] == "Nombre"){
                if($data['keyText'] != ""){
                    $result = Self::getInvoicesByName($data['keyText'], $data['dateStart'], $data['dateEnd']);
                }else{
                    $result = false;
                } 
            }else{
                $result = false;
            }
            return response()->json(['data' => $result ]);
        }
    }

    public function invoiceAjax(InvoiceAjaxRequest $request){
        if($request->ajax()){
            $data = $request->validated();
            if($data['flat'] == "Folio"){
                    $result = Self::getInvoiceByFolio($data['key']);
            }else if($data['flat'] == "Crédito"){
                if($data['key'] != ""){
                    $result = Self::getInvoicesByNumCredito($data['key']);
                }else{
                    $result = false;
                } 
            }else{
                $result = false;
            }
            return response()->json(['data' => $result ]);
        }
    }


    private function getInvoicesGeneral($dateStart, $dateEnd){
        if($dateStart == null && $dateEnd == null ){
            $invoices = Credito::select('recibo.id', 'credito.num', 'clientes.nombre', 'recibo.created_at', DB::raw("GROUP_CONCAT(pagos_desglose.num_pago_credito SEPARATOR ' | ') as Pagos"),'recibo.total', 'recibo.estatus', 'usuarios.nombre as Cajero')
            ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')
            ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
            ->join('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
            ->join('recibo','recibo.id','=','pagos_recibo_cuenta.id_recibo')
            ->join('usuarios', 'usuarios.id', '=', 'recibo.cajero')->groupBy('recibo.id')->groupBy('credito.num')->groupBy('clientes.nombre')->get();
        }else if($dateStart != null && $dateEnd == null){
            $start = Self::dateRequest($dateStart);
            $invoices = Credito::select('recibo.id','credito.num', 'clientes.nombre', 'recibo.created_at', DB::raw("GROUP_CONCAT(pagos_desglose.num_pago_credito SEPARATOR ' | ') as Pagos"), 'recibo.total', 'recibo.estatus', 'usuarios.nombre as Cajero')
            ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')
            ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
            ->join('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
            ->join('recibo','recibo.id','=','pagos_recibo_cuenta.id_recibo')
            ->join('usuarios', 'usuarios.id', '=', 'recibo.cajero')->where('recibo.fecha', '>=', $start)->groupBy('recibo.id')->groupBy('credito.num')->groupBy('clientes.nombre')->get();
        }else if($dateStart == null && $dateEnd != null){
            $end = Self::dateRequest($dateEnd);
            $invoices = Credito::select('recibo.id','credito.num', 'clientes.nombre', 'recibo.created_at', DB::raw("GROUP_CONCAT(pagos_desglose.num_pago_credito SEPARATOR ' | ') as Pagos"), 'recibo.total', 'recibo.estatus', 'usuarios.nombre as Cajero')  
            ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')           
            ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
            ->join('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
            ->join('recibo','recibo.id','=','pagos_recibo_cuenta.id_recibo')
            ->join('usuarios', 'usuarios.id', '=', 'recibo.cajero')->where('recibo.fecha', '=', $end)->groupBy('recibo.id')->groupBy('credito.num')->groupBy('clientes.nombre')->get();
        }else{
            $start = Self::dateRequest($dateStart);
            $end = Self::dateRequest($dateEnd);
            $invoices = Credito::select('recibo.id','credito.num', 'clientes.nombre', 'recibo.created_at', DB::raw("GROUP_CONCAT(pagos_desglose.num_pago_credito SEPARATOR ' | ') as Pagos"), 'recibo.total', 'recibo.estatus', 'usuarios.nombre as Cajero')  
            ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')           
            ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
            ->join('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
            ->join('recibo','recibo.id','=','pagos_recibo_cuenta.id_recibo')
            ->join('usuarios', 'usuarios.id', '=', 'recibo.cajero')->where('recibo.fecha', '>=', $start)->where('recibo.fecha', '<=', $end)->groupBy('recibo.id')->groupBy('credito.num')->groupBy('clientes.nombre')->get();
        }
        return $invoices;
    }

    private function getInvoicesByName($key, $dateStart, $dateEnd){
        if($dateStart == null && $dateEnd == null ){
            $invoices = Credito::select('recibo.id', 'credito.num', 'clientes.nombre', 'recibo.created_at', DB::raw("GROUP_CONCAT(pagos_desglose.num_pago_credito SEPARATOR ' | ') as Pagos"),'recibo.total', 'recibo.estatus', 'usuarios.nombre as Cajero')
            ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')
            ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
            ->join('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
            ->join('recibo','recibo.id','=','pagos_recibo_cuenta.id_recibo')
            ->join('usuarios', 'usuarios.id', '=', 'recibo.cajero')
            ->Where(DB::raw('CONCAT_WS(clientes.nombre, clientes.paterno, clientes.materno)'), 'like', '%'.$key.'%')
            ->groupBy('recibo.id')->groupBy('credito.num')->groupBy('clientes.nombre')->get();
        }else if($dateStart != null && $dateEnd == null){
            $start = Self::dateRequest($dateStart);
            $invoices = Credito::select('recibo.id','credito.num', 'clientes.nombre', 'recibo.created_at', DB::raw("GROUP_CONCAT(pagos_desglose.num_pago_credito SEPARATOR ' | ') as Pagos"), 'recibo.total', 'recibo.estatus', 'usuarios.nombre as Cajero')
            ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')
            ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
            ->join('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
            ->join('recibo','recibo.id','=','pagos_recibo_cuenta.id_recibo')
            ->join('usuarios', 'usuarios.id', '=', 'recibo.cajero')
            ->Where(DB::raw('CONCAT_WS(clientes.nombre, clientes.paterno, clientes.materno)'), 'like', '%'.$key.'%')
            ->where('recibo.fecha', '>=', $start)->groupBy('recibo.id')->groupBy('credito.num')->groupBy('clientes.nombre')->get();
        }else if($dateStart == null && $dateEnd != null){
            $end = Self::dateRequest($dateEnd);
            $invoices = Credito::select('recibo.id','credito.num', 'clientes.nombre', 'recibo.created_at', DB::raw("GROUP_CONCAT(pagos_desglose.num_pago_credito SEPARATOR ' | ') as Pagos"), 'recibo.total', 'recibo.estatus', 'usuarios.nombre as Cajero')  
            ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')           
            ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
            ->join('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
            ->join('recibo','recibo.id','=','pagos_recibo_cuenta.id_recibo')
            ->join('usuarios', 'usuarios.id', '=', 'recibo.cajero')
            ->Where(DB::raw('CONCAT_WS(clientes.nombre, clientes.paterno, clientes.materno)'), 'like', '%'.$key.'%')
            ->where('recibo.fecha', '=', $end)->groupBy('recibo.id')->groupBy('credito.num')->groupBy('clientes.nombre')->get();
        }else{
            $start = Self::dateRequest($dateStart);
            $end = Self::dateRequest($dateEnd);
            $invoices = Credito::select('recibo.id','credito.num', 'clientes.nombre', 'recibo.created_at', DB::raw("GROUP_CONCAT(pagos_desglose.num_pago_credito SEPARATOR ' | ') as Pagos"), 'recibo.total', 'recibo.estatus', 'usuarios.nombre as Cajero')  
            ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')           
            ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
            ->join('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
            ->join('recibo','recibo.id','=','pagos_recibo_cuenta.id_recibo')
            ->join('usuarios', 'usuarios.id', '=', 'recibo.cajero')
            ->Where(DB::raw('CONCAT_WS(clientes.nombre, clientes.paterno, clientes.materno)'), 'like', '%'.$key.'%')
            ->where('recibo.fecha', '>=', $start)->where('recibo.fecha', '<=', $end)->groupBy('recibo.id')->groupBy('credito.num')->groupBy('clientes.nombre')->get();
        }
        return $invoices;
    }

    private function getInvoiceByFolio($id){
        $invoices = Credito::select('recibo.id', 'credito.num', 'clientes.nombre', 'recibo.created_at', DB::raw("GROUP_CONCAT(pagos_desglose.num_pago_credito SEPARATOR ' | ') as Pagos"),'recibo.total', 'recibo.estatus', 'usuarios.nombre as Cajero')
            ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')
            ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
            ->join('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
            ->join('recibo','recibo.id','=','pagos_recibo_cuenta.id_recibo')
            ->join('usuarios', 'usuarios.id', '=', 'recibo.cajero')->where('recibo.id',$id)->groupBy('recibo.id')->groupBy('credito.num')->groupBy('clientes.nombre')->get();
            return $invoices;
    }

    private function getInvoicesByNumCredito($num){
        $invoices = Credito::select('recibo.id', 'credito.num', 'clientes.nombre', 'recibo.created_at', DB::raw("GROUP_CONCAT(pagos_desglose.num_pago_credito SEPARATOR ' | ') as Pagos"),'recibo.total', 'recibo.estatus', 'usuarios.nombre as Cajero')
            ->join('clientes', 'clientes.id', '=', 'credito.id_cliente')
            ->join('pagos_desglose', 'pagos_desglose.num_credito', '=', 'credito.num')
            ->join('pagos_recibo_cuenta', 'pagos_recibo_cuenta.id_pago', '=', 'pagos_desglose.id')
            ->join('recibo','recibo.id','=','pagos_recibo_cuenta.id_recibo')
            ->join('usuarios', 'usuarios.id', '=', 'recibo.cajero')->where('credito.num',$num)->groupBy('recibo.id')->groupBy('credito.num')->groupBy('clientes.nombre')->get();
        return $invoices;
    }

    private function dateRequest($date){
		return ($date == null) ? Carbon::today() : Carbon::parse($date) ;
	}


   
    
}
