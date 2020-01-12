@extends('layouts.dashboard')
@section('title', 'Editar role')

@section('content')
<div class="row">
	<div class="col-lg-12">
	@if(\Session::has('success'))
				<div class="alert alert-success">{{\Session::get('success')}} </div>
	@endif
	<br>	
		<div class="panel panel-warning">
			<div class="panel-heading">Editar Rol #{{$role->name}} </div>
			<div class="panel-body">
				{!! Form::open(['route'=> ['roles.update', $role->id]] , ['method'=>'POST']) !!}
				{{method_field('PATCH')}}
				{{csrf_field()}}
				<div class="form-group col-lg-6">
						{!! Form::label('name','Nombre') !!}
			    	 		
			   			{!! Form::text('name', $role->name, ['class'=>'form-control', 'placeholder'=>'Nombre','required'])!!}
				</div>
				
				<div class="form-group col-lg-6">
						{!! Form::label('descripcion','Descripción') !!} 
						{!! Form::text('descripcion', $role->descripcion, ['class'=>'form-control', 'placeholder'=>'','required']) !!}
				</div>
					<div class="col-lg-12">
					<hr>
					<table class="table table-default">
						<thead>
							<tr>
							<th scope="col"></th>
							<th scope="col">Permiso</th>
							<th scope="col">Descripción</th>
							</tr>
						</thead>
						<tbody>			
								@for($i=0; $i< count($allPermisos);$i++)		
										
											<tr>
											<td><input type="checkbox"  name="permisos[]" value="{{$allPermisos[$i]->name}}" <?php in_array($allPermisos[$i]->name, $permisosCheck) ?  print "checked" :  "c"; ?>></td>
											<td>{{$allPermisos[$i]->name}}</td>
											<td>{{$allPermisos[$i]->descripcion}}</td>
											</tr>
										
							@endfor
						</tbody>
					</table>
				</div>
				<div class="form-group col-lg-2">
						<br>
						{!! Form::submit('Guardar cambios', ['class' =>'btn btn-warning'])!!}
				</div>
			{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>	

@stop