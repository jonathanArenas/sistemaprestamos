@extends('layouts.dashboard')
@section('title', 'Crear Usuario')

@section('content')
<div class="row">
	<div class="col-md-12">
	@if(\Session::has('success'))
				<div class="alert alert-success">{{\Session::get('success')}} </div>
	@endif
	<br>

		<div class="panel panel-primary">
			<div class="panel-heading">Crear Usuario</div>
			<div class="panel-body">
				{!! Form::open(['route'=>'user.store'], ['method'=>'POST']) !!}
				<div class="form-group col-lg-3">
						{!! Form::label('nombre','Nombre de Usuario') !!}
			    	 		
			   			{!! Form::text('nombre', null, ['class'=>'form-control input', 'placeholder'=>'Nombre','required'])!!}
				</div>
				<div class="form-group col-lg-4">
						{!! Form::label('email','Email') !!} 
						{!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>'','required']) !!}
				</div>
				
				<div class="form-group col-lg-3">
						{!! Form::label('contraseña','Contraseña') !!} 
						<input type="password" name="password" class="form-control input" required>
				</div>
				<div class="form-group col-lg-2">
						{!! Form::label('usuario','Asignar Rol al usuario') !!}			
			   			<select name="role" id="role" class="form-control">
			   				@foreach($hasRoles as  $key => $role)
			   					<option value="{{$role->name}}">{{$role->name}} </option>
			   				@endforeach
			   			</select>  
				
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