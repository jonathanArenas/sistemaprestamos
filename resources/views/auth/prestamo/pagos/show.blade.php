@extends('layouts.dashboard')
@section('title', 'Clientes')
@section('content')
		<div class="row">
		</div>
    
		<div class="row">
			<div class="col-lg-12">
				@if(\Session::has('success'))
				<div class="alert alert-success">{{\Session::get('success')}} </div>
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Pagos del prestamo
					</div>
					<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover">
					<thead>
						<tr>
							
							<th scope="col">Num. Pago</th>
							<th scope="col">Fecha</th>
							<th scope="col">Balance</th>
							<th scope="col">Cuata</th>
							<th scope="col">Demora</th>
							<th scope="col">Total</th>
							<th scope="col">Monto</th>

							
						</tr>
					</thead>
					<tbody>
							@foreach($pagos as $key => $pago)
							<tr>
								<td>{{ $pago->num_pago}} </td>
								<td>{{ $pago->fecha}}</td>
								<td>{{ $pago->balance}} </td>
							    <td>{{ $pago->cuata}} </td>
								<td>{{ $pago->demora}} </td>
								<td>{{ $pago->total}} </td>
								<td><input class="form-control" type="text" name="monto" value="{{ $pago->monto}}"></td>
							</tr>
								
							@endforeach
						</tr>
					</tbody>
				</table>
						
					</div>
					
						
					</div>
					
				</div>
				
			</div>
		</div>
@endsection