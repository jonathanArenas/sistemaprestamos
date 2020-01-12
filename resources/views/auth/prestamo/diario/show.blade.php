@extends('layouts.dashboard')
@section('title', 'Clientes')
@section('content')
		<div class="row">
			<div class="col-lg-3 col-xs-12">
          <!-- small box -->
          			<a href="{{route('grupal.create')}} " class="small-box-footer">
            		<div class="small-box bg-primary">
            		<div class="inner">
              			<h3>CREAR</h3>
              			<p>PRESTAMO INDIVIDUAL EXPRESS</p>
            		</div>
          			</div></a>
        	</div><!-- col -->

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
						Prestamos individuales del prestamo grupal
					</div>
					<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Prestamo Key</th>
							<th scope="col">Monto Individual</th>
							<th scope="col">Interes al</th>
							<th scope="col">Total a pagar</th>
							<th scope="col">Fecha desde</th>
							<th scope="col">Fecha hasta</th>
							<th scope="col">Estatus</th>

							
						</tr>
					</thead>
					<tbody>
							@foreach($prestamosDiariosGrupo as $key => $prestamoIndividual)
							<tr>
								<td>{{ $prestamoIndividual->num}} </td>
								<td>{{ $prestamoIndividual->prestamo_key}}</td>
								<td>{{ $prestamoIndividual->monto}} </td>
							    <td>{{ $prestamoIndividual->interes}} % </td>
								<td>{{ $prestamoIndividual->total_pagar}} </td>
								<td>{{ $prestamoIndividual->fecha_desde}} </td>
								<td>{{ $prestamoIndividual->fecha_hasta}} </td>
								<td>{{ $prestamoIndividual->estatus}}</td>
								<td> {!! Form::open(['route' => ['dia.show', $prestamoIndividual->num], 'name' => 'formedit', 'id' => 'formedit', 'method' => 'GET']) !!} <button type="submit" class="btn btn-warning">Mostrar Pagos</button>

								{!! Form::close() !!}</td>
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