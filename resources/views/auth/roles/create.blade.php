@extends('layouts.dashboard')
@section('title', 'Crear permiso')

@section('content')
<div class="row">
	<div class="col-lg-12">
	@if(\Session::has('success'))
				<div class="alert alert-success">{{\Session::get('success')}} </div>
	@endif
	<br>

		<div class="panel panel-primary">
			<div class="panel-heading">Crear Rol</div>
			<div class="panel-body">
				{!! Form::open(['route'=>'roles.store'], ['method'=>'POST']) !!}
				<div class="form-group col-lg-6">
						{!! Form::label('name','Nombre') !!}	
			   			{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Nombre','required'])!!}
				</div>
				<div class="form-group col-lg-6">
						{!! Form::label('name','Descripción') !!}	
			   			{!! Form::text('descripcion', null, ['class'=>'form-control', 'placeholder'=>'muestra la vista de -------','required'])!!}
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
							@foreach($haspermiso as $key => $permiso)
							<tr>
								<td><input type="checkbox" name="permisos[] " value="{{$permiso->name}} "></td>
								<td>{{$permiso->name}} </td>
								<td>{{$permiso->descripcion}} </td>
							</tr>
							@endforeach
						</tbody>
						
					</table>
				</div>

				<div class="form-group col-lg-2">
						{!! Form::submit('Crear', ['class' =>'btn btn-primary'])!!}
				</div>

			{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>	
@endsection