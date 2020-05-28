@extends('layouts.dashboard')
@section('title', 'Editar role')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card card-warning">
			<div class="card-header">
				<h3 class="card-title">Editar Rol #{{$role->name}}</h3>
			</div>
			<div class="card-body">
					{!! Form::open(['route'=> ['roles.update', $role->id]] , ['method'=>'POST']) !!}
					<div class="row">
						{{method_field('PATCH')}}
						{{csrf_field()}}
						<div class="col-lg-6">
							<div class="form-group">
								{!! Form::label('name','Nombre') !!}			    	 		
								{!! Form::text('name', $role->name, ['class'=>'form-control', 'placeholder'=>'Nombre','required'])!!}
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								{!! Form::label('descripcion','Descripción') !!} 
								{!! Form::text('descripcion', $role->descripcion, ['class'=>'form-control', 'placeholder'=>'','required']) !!}
							</div>
						</div>
					</div>
					<div class="card-footer">
					
							{!! Form::submit('Guardar cambios', ['class' =>'btn btn-success float-right'])!!}
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>	

@stop