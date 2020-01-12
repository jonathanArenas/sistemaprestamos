@extends('layouts.dashboard')
@section('title', 'Crear permiso')
@section('content')
<div class="row">
	<div class="col-lg-12">
	@if(\Session::has('success'))
				<div class="alert alert-info">{{\Session::get('success')}} </div>
	@endif
	<br>
    <div class="panel panel-warning">
		<div class="panel-heading">
			<h3 class="panel-title">Alta de Cliente</h3>
		</div>
		<div class="panel-body">
			<br>
            {!! Form::open(['route'=> ['cliente.update', $cliente->id]] , ['method'=>'POST']) !!}
            {{method_field('PATCH')}}
            {{csrf_field()}}
				<div class="form-group col-lg-6">
						{!! Form::label('grupo','Grupo') !!}			
			   			<select name="grupo" class="form-control">
			   				<option value="{{$g->id}}" selected>{{$g->zona}} {{$g->seccion}} </option>
			   				@foreach($grupos as  $key => $grupo)
			   					@if($grupo->id == $g->id)
			   					 	@continue
			   					@endif
			   					<option value="{{$grupo->id}}">{{$grupo->zona}} {{$grupo->seccion}} </option>
			   				@endforeach
			   			</select>  
				
				</div>



				<div class="form-group col-lg-6">
						<label><spam style="color: red">*</spam> Nombre</label>
						<input type="text" value="{{$cliente->nombre}}"  onkeyup="this.value=Text(this.value)" name="nombre" class="form-control input" required>
				</div>
                <div class="form-group col-lg-6">
						<label><spam style="color: red">*</spam> Apellido paterno</label>
						<input type="text" value="{{$cliente->paterno}}"  onkeyup="this.value=Text(this.value)" name="paterno" class="form-control input" required>
				</div>
                <div class="form-group col-lg-6">
						<label><spam style="color: red">*</spam> Apellido materno</label>
						<input type="text" value="{{$cliente->materno}}"  onkeyup="this.value=Text(this.value)" name="materno" class="form-control input" required>
				</div>
                <div class="form-group col-lg-6">
						<label><spam style="color: red">*</spam> Dirección | Domicilio</label>
						<input type="text" value="{{$cliente->direccion}}"  onkeyup="this.value=Text(this.value)" name="direccion" class="form-control input" required> 
				</div>
                <div class="form-group col-lg-6">
						<label><spam style="color: red">*</spam>Teléfono Celular</label>
						<input type="tel"  value="{{$cliente->telefono}}" name="telefono" onkeypress="return Numbers(event);" minlength="10" maxlength="10" class="form-control input" required>
						 {!! $errors->first('telefono', '<spam class="help-block" style="color:red;">:message</spam>') !!}
				</div>
				<div class="form-group col-lg-6">
						{!! Form::label('estatus','Estatus') !!}
						<select name="estatus" class="form-control">
			   				@if($cliente->estatus == 'NUEVO' )
			   					<option select value="{{$cliente->estatus}}">{{$cliente->estatus}} </option>
			   					<option value="BAJA" >BAJA</option>
			   				@else
			   					<option select value="{{$cliente->estatus}}">{{$cliente->estatus}} </option>
			   					<option value="NUEVO" >NUEVO</option>
			   				@endif
			   			</select>				
				</div>
                <div class="form-group col-lg-6">
                	<label>Entregó documentación</label>
						<div class="custom-control custom-radio">
							@if($cliente->documento_I == 'SI')
								<input type="radio" class="custom-control-input" name="documento_I" checked value="SI">
								<label class="custom-control-label">SI</label>
							@else
								<input type="radio" class="custom-control-input" name="documento_I" value="SI">
								<label class="custom-control-label">SI</label>
							@endif
						</div>
						<div class="custom-control custom-radio">
							@if($cliente->documento_I == 'NO')
								<input type="radio" class="custom-control-input" name="documento_I" checked value="NO">
								<label class="custom-control-label">NO</label>

							@else
								<input type="radio" class="custom-control-input" name="documento_I" value="NO">
								<label class="custom-control-label">NO</label>
							@endif
							
						</div>			
						
					
				</div>
				<div class="form-group col-lg-12">
					<input type="submit" value="Editar Cliente" class="btn btn-warning">
				</div>			
			{!! Form::close() !!}
		</div>
            
    	</div>		
	</div>
</div>	
@endsection