@extends('layouts.dashboard')
@section('title', 'Cobradores')
@section('content')
		<div class="row">
			<div class="col-lg-3 col-xs-3">
          <!-- small box -->
          			<a href="{{route('cobradores.create')}} " class="small-box-footer">
            		<div class="small-box bg-primary">
	            		<div class="inner">
	              			<h3>CREAR</h3>
	              			<p>COBRADOR</p>
	            		</div>
          			</div>
          			</a>
        	</div><!-- col -->
        	<div class="col-lg-3 col-xs-3">
          <!-- small box -->
          			<a href="./?view=products" class="small-box-footer">
	            		<div class="small-box bg-green">
		            		<div class="inner">
		              			<h3>BUSCAR</h3>
		              			<p>COBRADOR</p>
		            		</div>
	          			</div>
          			</a>
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
						cobradores
					</div>
					<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Id</th>
							<th scope="col">Nombre</th>
							<th scope="col">Paterno</th>
							<th scope="col">Materno</th>
						</tr>
					</thead>
					<tbody>
							@foreach($cobradores as $key => $cobrador)
							<tr>
								<td>{{ $cobrador->id}} </td>
								<td>{{ $cobrador->nombre}}</td>
								<td>{{ $cobrador->paterno}}</td>
								<td>{{ $cobrador->materno}}</td>
								<td> {!! Form::open(['route' => ['cobradores.edit', $cobrador->id] ,'name' => 'formedit' , 'method' => 'GET']) !!} <button type="submit" class="btn btn-warning">Editar</button>

								{!! Form::close() !!}</td>
								<td>
									{!! Form::open(['route' => ['cobradores.destroy', $cobrador->id] , 'id' => 'formdelete'.$cobrador->id])!!}
									{{method_field('DELETE')}}
									{{csrf_field()}}

								<a onClick="eliminar('{{$cobrador->id}}', '{{$cobrador->nombre}}');" class="btn btn-danger">Eliminar</a>{!! Form::close() !!}

								</td>
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