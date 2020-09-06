<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use Barryvdh\DomPDF\Facade as PDF;
class PdfController extends Controller
{
    public function generar(){
        $clientes = Cliente::all();
        
        $pdf = PDF::loadHTML('<h1>Hola Putitos</h1>');
        return $pdf->stream();
    }
}
