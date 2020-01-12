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
              			<p>PRESTAMO GRUPAL</p>
            		</div>
          			</div></a>
        	</div><!-- col -->
        	<div class="col-lg-3 col-xs-12">
          <!-- small box -->
          			<a href="./?view=products" class="small-box-footer">
            		<div class="small-box bg-green">
            		<div class="inner">
              			<h3>BUSCAR</h3>
              			<p>PRESTAMO</p>
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
						Prestamos grupales
					</div>
					<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Prestamo Key</th>
							<th scope="col">Grupo</th>
							<th scope="col">Fecha del prestamo</th>
							<th scope="col">Monto</th>
							<th scope="col">Prestamista</th>

							
						</tr>
					</thead>
					<tbody>
							@foreach($prestamosGrupales as $key => $prestamoGrupal)
							<tr>
								<td>{{ $prestamoGrupal->id}} </td>
								<td>{{ $prestamoGrupal->prestamo_key}}</td>
								<td>{{ $prestamoGrupal->zona . ' '.  $prestamoGrupal->seccion }}</td>
								<td>{{$prestamoGrupal->fecha}} </td>
								<td>{{$prestamoGrupal->monto}} </td>
								<td>{{$prestamoGrupal->prestamista}} </td>
								<td> {!! Form::open(['route' => ['diario.show', $prestamoGrupal->id], 'name' => 'formedit', 'id' => 'formedit', 'method' => 'GET']) !!} <button type="submit" class="btn btn-warning">Mostrar Individuales</button>

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