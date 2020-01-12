@extends('layouts.dashboard')
@section('title', 'Crear permiso')

@section('content')
<div class="row">
	<div class="col-md-12">
	@if(\Session::has('success'))
				<div class="alert alert-success">{{\Session::get('success')}} </div>
	@endif
	<br>

		<div class="panel panel-primary">
			<div class="panel-heading">Crear Permiso</div>
			<div class="panel-body">
				{!! Form::open(['route'=>'permiso.store'], ['method'=>'POST']) !!}
				<div class="form-group col-lg-4">
						{!! Form::label('name','Vista') !!}
			    	 		
			   			{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Nombre','required'])!!}
				</div>
				
				<div class="form-group col-lg-6">
						{!! Form::label('description','Descripción') !!} 
						{!! Form::text('descripcion', null, ['class'=>'form-control', 'placeholder'=>'','required']) !!}
				</div>
				<div class="form-group col-lg-2">
						<br>
						{!! Form::submit('Crear', ['class' =>'btn btn-primary'])!!}
				</div>
			{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>	
@endsection