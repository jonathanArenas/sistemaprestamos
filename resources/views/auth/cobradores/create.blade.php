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
			<div class="card card-olive">
				<div class="card-header">
					<h3 class="card-title">Datos | Nuevo Cobrador</h3>
				</div>
				<div class="card-body">
					<form role="form" action="{{route('cobradores.store')}}" method="POST">
					{{csrf_field()}}
						<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<label for="nombre">Nombre de usuario</label>
									<input type="text" class="form-control input" name="username" id="inputUserName" onkeyup="this.value=Text(this.value)" placeholder="Nombre de usuario" required>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" class="form-control" name="email" id="inputEmail" placeholder="example@gmail.com" required>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="password">Contraseña</label>
									<input type="password" class="form-control" name="password" id="inputPassword" placeholder="**********" required>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="password_confirm">Nuevamente</label>
									<input type="password" class="form-control" name="password_confirm" id="inputPasswordConfirm" placeholder="**********" required>
								</div>
							</div>
							</div>
							<hr color="#3d9970" size=2> 
							<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<label for="name_cobrador">Nombre Cobrador</label>
									<input type="text" class="form-control input" name="nombre" id="inputNameCobrador" onkeyup="this.value=Text(this.value)" placeholder="Nombre" required>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="paterno">Apellido Paterno</label>
									<input type="text" class="form-control input" name="paterno" id="inputPaterno" onkeyup="this.value=Text(this.value)" placeholder="Paterno" required>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="materno">Apellido Materno</label>
									<input type="text" class="form-control input" name="materno" id="inputMaterno" onkeyup="this.value=Text(this.value)" placeholder="Materno" required>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="date">Fecha Nacimiento</label>
									<input type="date" class="form-control" name="nacimiento" required>
								</div>
							</div>
						</div>
						<!-- /.card-body -->
						<div class="card-footer">
                        	<button type="submit" class="btn bg-olive float-right">Registrar</button>
                    	</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection