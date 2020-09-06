@extends('layouts.dashboard')
@section('title', 'Crear cobrador')
@section('content')
@if ($errors->any())
    <div class="col-lg-4">
        <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
<div class="row">
		<div class="col-lg-12">
			<div class="card card-warning">
				<div class="card-header">
					<h3 class="card-title">Datos | Cobrador</h3>
					<button type="submit" id="habilitar" class="btn btn-primary float-right">Habilitar</button>
					<button type="button" class="btn btn-secondary float-right" id="btnChangePassword"  data-toggle="modal" data-target="#changePasswordModal" data-whatever="@getbootstrap" disabled>Cambiar contraseña</button>
				</div>
				<div class="card-body">
					<form role="form" action="{{route('cobradores.update', $cobrador->id)}}" method="POST">
					{{method_field('PATCH')}}
                	{{csrf_field()}}
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label for="nombre">Nombre de usuario</label>
									<input type="text" class="form-control input" name="username" id="inputUserName" value="{{$cobrador->username}}" onkeyup="this.value=Text(this.value)" placeholder="Nombre de usuario" required disabled>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" class="form-control" name="email" id="inputEmail" value="{{$cobrador->email}}" placeholder="example@gmail.com" required disabled>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label for="name_cobrador">Nombre Cobrador</label>
									<input type="text" class="form-control input" name="nombre" id="inputNameCobrador"  value="{{$cobrador->nombre}}" onkeyup="this.value=Text(this.value)" placeholder="Nombre" required disabled>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label for="paterno">Apellido Paterno</label>
									<input type="text" class="form-control input" name="paterno" id="inputPaterno" value="{{$cobrador->paterno}}" onkeyup="this.value=Text(this.value)" placeholder="Paterno" required disabled>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label for="materno">Apellido Materno</label>
									<input type="text" class="form-control input" name="materno" id="inputMaterno"  value="{{$cobrador->materno}}" onkeyup="this.value=Text(this.value)" placeholder="Materno" required disabled>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label for="date">Fecha Nacimiento</label>
									<input type="date" class="form-control" name="nacimiento" value="{{$cobrador->fecha_na}}" required disabled>
								</div>
							</div>
						</div>
						<!-- /.card-body -->
						<div class="card-footer" id="card-footer" style="display:none">
                        	<button type="submit" class="btn btn-primary float-right">Guardar</button>
                    	</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña de {{$cobrador->nombre}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" action="{{route('changePasswordCobrador', $cobrador->id)}}" method="POST">
        {{method_field('PATCH')}}
        {{csrf_field()}}
          <div class="form-group">
            <label for="old-password" class="col-form-label">Contraseña actual</label>
            <input type="password" class="form-control" name="current_password" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="password" class="col-form-label">Nueva contraseña</label>
            <input type="password" class="form-control" name="password" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="confirm-password" class="col-form-label">Confirmar contraseña</label>
            <input type="password" class="form-control" name="confirm_password" id="recipient-name">
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Actualizar dato</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('extras')
	<script>
		$(document).ready(function(){
		$('#habilitar').click(function(e){
		e.preventDefault();
		let hblt = document.getElementById('habilitar');
		let cardFooter = document.getElementById('card-footer');
		let btnChangePassword = document.getElementById('btnChangePassword')
		let elements = document.getElementsByClassName('form-control');
		if(hblt.innerHTML == 'Habilitar'){
			for (let index = 0; index < elements.length; index++) {
				const element = elements[index];
				element.disabled = false;
			}
			hblt.innerHTML = 'Deshabilitar';
			hblt.className = "btn btn-danger float-right";
			btnChangePassword.disabled = false;
            cardFooter.style.display = 'block';
		}else{
			for (let index = 0; index < elements.length; index++) {
				const element = elements[index];
				element.disabled = true;
			}
			hblt.innerHTML = 'Habilitar';
			hblt.className = "btn btn-primary float-right";
			btnChangePassword.disabled = true;
			cardFooter.style.display = 'none';
		}	
	});
});

$('#PasswordChange').click(function(e){
               
			   document.getElementById('cardPasswordChange').style.display = 'block';
			}
		   );
	</script>
@endsection