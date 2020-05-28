@extends('layouts.dashboard')
@section('title', 'Crear permiso')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Crear Rol</h3>
			</div>
			<div class="card-body">
				{!! Form::open(['route'=>'roles.store'], ['method'=>'POST']) !!}
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							{!! Form::label('name','Nombre') !!}	
							{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Nombre','required'])!!}
					
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							{!! Form::label('name','Descripción') !!}	
							{!! Form::text('descripcion', null, ['class'=>'form-control', 'placeholder'=>'role para ....','required'])!!}
					
						</div>
					</div>
					</div>
					
					<div class="card-footer">
						
							{!! Form::submit('Guardar', ['class' =>'btn btn-success float-right'])!!}
	
					</div>
							{!! Form::close() !!}
			</div>
		</div>
	</div>
 </div>

@endsection