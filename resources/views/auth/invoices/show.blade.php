@extends('layouts.dashboard')
@section('title', 'Estado de Cuenta')
@section('content')
<div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header">              
            <h3 class="card-title">
                ESTADO DE CUENTA
            </h3>
            </div>
            <div class="card-body table-responsive p-0">
					<table class="table table-sm table-head-fixed table-hover text-nowrap" id="t">
						<thead>
							<tr>
								<th>Folio recibo</th>
								<th>Fecha</th>
								<th>Total</th>
                                <th>Cajero</th>	
								<th>Estatus</th>
								<th>Cancelar</th>							
							</tr>
						</thead>
						<tbody>
							@foreach($receipts as $key => $receipt)
							<tr>
							<td><a href="{{route('pdfInvoice', [$num, $receipt->id])}}" target="_blank">{{ $receipt->id}}</a></td>
							<td>{{ $receipt->created_at}}</td>
							<td>{{ $receipt->total}}</td>
                            <td>{{$receipt->nombre}}</td>
							<td>
							@if($receipt->estatus == "CANCELADO")
								<span class="badge bg-danger">{{$receipt->estatus}}</span>
                            @else
                                <span class="badge bg-success">PAGADO</span>
							@endif
							</td>
                            
                            <td><a href="{{route('cancelacion',$receipt->id)}}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a></td>
							</tr>			
							@endforeach
							
						</tbody>
					</table>            
            </div>
        </div>              
    </div>
@endsection