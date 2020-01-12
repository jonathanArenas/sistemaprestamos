@extends('layouts.dashboard')
@section('title', 'Crear cobrador')
@section('content')
<div class="row">
	<div class="col-lg-12">
	@if(\Session::has('success'))
				<div class="alert alert-info">{{\Session::get('success')}} </div>
	@endif
	<br>
    <div class="panel panel-warning">
		<div class="panel-heading">
			<h3 class="panel-title">Edición del Cobrador</h3>
		</div>
		<div class="panel-body">
			<br>
            {!! Form::open(['route'=> ['cobradores.update', $cobrador->id ]], ['method'=>'POST']) !!}
				{{method_field('PATCH')}}
				{{csrf_field()}}
				<div class="form-group col-lg-4">
						{!! Form::label('nombre','Nombre') !!}	
						{!! Form::text('nombre', $cobrador->nombre, ['class'=>'form-control', 'placeholder'=>'Ejemplo: Juan','required']) !!} 
				</div>
                <div class="form-group col-lg-4">
						{!! Form::label('paterno','Apellido Parterno') !!}				
						{!! Form::text('paterno', $cobrador->paterno, ['class'=>'form-control', 'placeholder'=>'','required']) !!} 
				</div>
                <div class="form-group col-lg-4">
						{!! Form::label('materno','Apellido Materno') !!}				
						{!! Form::text('materno', $cobrador->materno, ['class'=>'form-control', 'placeholder'=>'','required']) !!} 
				</div>
                <div class="form-group col-lg-8">
						{!! Form::label('direccion','Dirección') !!}				
						{!! Form::text('direccion', $cobrador->direccion, ['class'=>'form-control', 'placeholder'=>'','required']) !!} 
				</div>
                <div class="form-group col-lg-4">
						{!! Form::label('telefono','Teléfono') !!}				
						{!! Form::text('telefono', $cobrador->telefono, ['class'=>'form-control', 'placeholder'=>'','required']) !!} 
				</div>
				<div class="form-group col-lg-12">
					<input type="submit" value="Editar registro" class="btn btn-warning">
				</div>			
			{!! Form::close() !!}
		</div>
            
    	</div>		
	</div>
</div>	
@endsection