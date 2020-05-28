@extends('layouts.dashboard')
@section('title', 'Crear Usuario')

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
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Datos | Nuevo usuario</h3>
				</div>
				<div class="card-body">
					<form role="form" action="{{route('user.store')}}" method="POST">
					{{csrf_field()}}
						<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<label for="nombre">Nombre</label>
									<input type="text" class="form-control input" name="nombre" id="inputNombre" placeholder="Nombre del usuario" required>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" class="form-control" name="email" id="inputEmail" placeholder="example@gmail.com" required>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<label for="nombre">Contraseña</label>
									<input type="password" class="form-control" name="password" id="inputPassword" required>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<label for="nombre">Confirmar contraseña</label>
									<input type="password" class="form-control" name="password_confirm" id="inputPasswordConfirm" required>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<label for="nombre">Perfil o Role</label>
									<select name="role" id="role" class="form-control">
									@role('SuperUser')
                                        @foreach($hasRoles as  $key => $role)
                                            <option value="{{$role->name}}">{{$role->name}} </option>
                                        @endforeach
									@endrole
									@role('Administrador')
                                        @foreach($hasRoles as  $key => $role)
                                            @if($role->name == 'SuperUser')
                                                @continue
                                            @else
                                            <option value="{{$role->name}}">{{$role->name}} </option>
                                            @endif
                                        @endforeach
									@endrole
									@role('Gerente')
										@foreach($hasRoles as  $key => $role)
                                            @if($role->name == 'SuperUser' || $role->name =='Administrador')
                                                @continue
                                            @else
                                            <option value="{{$role->name}}">{{$role->name}} </option>
                                            @endif
                                        @endforeach
									@endrole
									</select>
								</div>  
							</div>
						</div>
						<!-- /.card-body -->
						<div class="card-footer">
                        	<button type="submit" class="btn btn-primary float-right">Registrar</button>
                    	</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>	
@endsection