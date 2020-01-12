@extends('layouts.dashboard')
@section('title', 'Editar permido')

@section('content')
<div class="row">
	<div class="col-lg-12">
	@if(\Session::has('success'))
				<div class="alert alert-success">{{\Session::get('success')}} </div>
	@endif
	<br>	
		<div class="panel panel-warning">
			<div class="panel-heading">Editar Permiso #{{$permiso->id}} </div>
			<div class="panel-body">
				{!! Form::open(['route'=> ['permiso.update', $permiso->id]] , ['method'=>'POST']) !!}
				{{method_field('PATCH')}}
				{{csrf_field()}}
				<div class="form-group col-lg-4">
						{!! Form::label('name','Vista') !!}
			    	 		
			   			{!! Form::text('name', $permiso->name, ['class'=>'form-control', 'placeholder'=>'Nombre','required'])!!}
				</div>
				
				<div class="form-group col-lg-6">
						{!! Form::label('description','Descripción') !!} 
						{!! Form::text('descripcion', $permiso->descripcion, ['class'=>'form-control', 'placeholder'=>'','required']) !!}
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
@endsection