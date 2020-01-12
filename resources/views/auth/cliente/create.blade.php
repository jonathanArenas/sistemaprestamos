@extends('layouts.dashboard')
@section('title', 'Crear permiso')
@section('content')
<div class="row">
	<div class="col-lg-12">
	@if(\Session::has('success'))
				<div class="alert alert-info">{{\Session::get('success')}} </div>
	@endif
	<br>
    <div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Alta de Cliente</h3>
		</div>
		<div class="panel-body">
			<br>
            {!! Form::open(['route'=>'cliente.store'], ['method'=>'POST']) !!}
				<div class="form-group col-lg-6">
						{!! Form::label('grupo','Grupo') !!}			
			   			<select name="grupo" class="form-control">
			   				@foreach($grupos as  $key => $grupo)
			   					<option value="{{$grupo->id}}">{{$grupo->zona}} {{$grupo->seccion}} </option>
			   				@endforeach
			   			</select>  
				
				</div>



				<div class="form-group col-lg-6">
						<label><spam style="color: red">*</spam> Nombre</label>
						<input type="text"  onkeyup="this.value=Text(this.value)" name="nombre" class="form-control input" required>
				</div>
                <div class="form-group col-lg-6">
						<label><spam style="color: red">*</spam> Apellido Paterno</label>
						<input type="text"  onkeyup="this.value=Text(this.value)" name="paterno" class="form-control input" required>
				</div>
                <div class="form-group col-lg-6">
						<label><spam style="color: red">*</spam> Apellido Materno</label>
						<input type="text"  onkeyup="this.value=Text(this.value)" name="materno" class="form-control input" required>
				</div>
                <div class="form-group col-lg-12">
						<label><spam style="color: red">*</spam> Dirección | Domicilio</label>
						<input type="text" name="direccion" class="form-control input" required>
				</div>
                <div class="form-group col-lg-6">
						<label><spam style="color: red">*</spam>Teléfono Celular</label>
						<input type="tel" name="telefono" onkeypress="return Numbers(event);" minlength="10" maxlength="10" class="form-control input" required>
						 {!! $errors->first('telefono', '<spam class="help-block" style="color:red;">:message</spam>') !!}
						 
				</div>
                <div class="form-group col-lg-6">
                	<label>Entregó documentación</label>
						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" name="documento_I" value="SI">
							<label class="custom-control-label">SI</label>
							
						</div>
						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" name="documento_I" value="NO">
							<label class="custom-control-label">NO</label>
							
						</div>			
						
					
				</div>
				<div class="form-group col-lg-12">
					<input type="submit" value="Crear Cliente" class="btn btn-primary ">
				</div>			
			{!! Form::close() !!}
		</div>
            
    	</div>		
	</div>
</div>
@endsection