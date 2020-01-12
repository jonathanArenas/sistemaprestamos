@extends('layouts.dashboard')
@section('title', 'Crear cobrador')
@section('content')
<div class="row">
	<div class="col-lg-12">
	@if(\Session::has('success'))
				<div class="alert alert-info">{{\Session::get('success')}} </div>
	@endif
	<br>
    <div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Alta del Cobrador</h3>
		</div>
		<div class="panel-body">
			<br>
            {!! Form::open(['route'=>'cobradores.store'], ['method'=>'POST']) !!}
				
				<div class="form-group col-lg-4">
						<label><spam style="color: red">*</spam> Nombre</label>
						<input type="text"  onkeyup="this.value=Text(this.value)" name="nombre" class="form-control input" required>
				</div>
                <div class="form-group col-lg-4">
						<label><spam style="color: red">*</spam> Apellido Paterno</label>
						<input type="text"  onkeyup="this.value=Text(this.value)" name="paterno" class="form-control input" required>
				</div>
                <div class="form-group col-lg-4">
						<label><spam style="color: red">*</spam> Apellido Materno</label>
						<input type="text"  onkeyup="this.value=Text(this.value)" name="materno" class="form-control input" required> 
				</div>
                <div class="form-group col-lg-8">
						<label><spam style="color: red">*</spam> Dirección | Domicilio</label>
						<input type="text" name="direccion" class="form-control input" required>
				</div>
                <div class="form-group col-lg-4">
						<label><spam style="color: red">*</spam>Teléfono Celular</label>
						<input type="tel" name="telefono" onkeypress="return Numbers(event);" minlength="10" maxlength="10" class="form-control input" required>
						 {!! $errors->first('telefono', '<spam class="help-block" style="color:red;">:message</spam>') !!}
				</div>
				<div class="form-group col-lg-12">
					<input type="submit" value="Crear" class="btn btn-primary ">
				</div>			
			{!! Form::close() !!}
		</div>
            
    	</div>		
	</div>
</div>	
@endsection