@extends('layouts.dashboard')
@section('title', 'Editar usuario')
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
                <h3 class="card-title">Editar datos del usuario</h3>
                <button type="submit" id="habilitar" class="btn btn-primary float-right">Habilitar</button>        
            </div>
              <!-- /.card-header -->
              <!-- form start -->
            <div class="card-body">
                <form role="form" action="{{route('user.update', $user->id)}}" method="POST">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control" value="{{$user->nombre}}" name="nombre" id="inputNombre" placeholder="Nombre de la empresa" required disabled>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" class="form-control" value="{{$user->email}}" name="email" id="inputEmail" placeholder="example@gmail.com" disabled>
                            </div>
                        </div>
							<div class="col-lg-2">
								<div class="form-group">
									<label for="nombre">Perfil o Role</label>
									<select name="role" id="selectRole" class="form-control" disabled>
                                    @role('SuperUser')
                                        @foreach($hasRoles as  $key => $role)
                                            @if($role->name == $roleName[0])
                                                <option value="{{$role->name}}" selected>{{$role->name}}</option>
                                                 @continue
                                            @endif
                                            <option value="{{$role->name}}">{{$role->name}} </option>
                                        @endforeach
									@endrole
									@role('Administrador')
                                        @foreach($hasRoles as  $key => $role)
                                            @if($role->name == 'SuperUser')
                                                @continue
                                            @else
                                                @if($role->name == $roleName[0])
                                                    <option value="{{$role->name}}" selected>{{$role->name}} </option>
                                                    @continue
                                                @endif    
                                            <option value="{{$role->name}}">{{$role->name}} </option>
                                            @endif
                                        @endforeach
									@endrole
									@role('Gerente')
										@foreach($hasRoles as  $key => $role)
                                            @if($role->name == 'SuperUser' || $role->name =='Administrador')
                                                @continue
                                            @else
                                                @if($role->name == $roleName[0])
                                                    <option value="{{$role->name}}" selected>{{$role->name}} </option>
                                                    @continue
                                                @endif
                                            <option value="{{$role->name}}">{{$role->name}} </option>
                                            @endif
                                        @endforeach
									@endrole
									</select>
								</div>  
                            </div>
                            <div class="col-lg-2">
								<div class="form-group">
									<label for="nombre">Contraseña actual</label>
									<input type="password" class="form-control" value="123456" name="passwordActual" id="inputPassword" required disabled>
								</div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="espacio">&nbsp</label>
                                    <button type="button" class="btn btn-secondary" id="btnchangepassword" data-toggle="modal" data-target="#changePasswordModal" data-whatever="@getbootstrap" disabled>Cambiar contraseña</button>
                                </div>
                            </div>                                                  
                    </div>
                <!-- /.card-body -->
                    <div class="card-footer" id="card-footer" style="display:none">
                        <button type="submit" class="btn btn-success float-right">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña de {{$user->nombre}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" action="{{route('changePassword', $user->id)}}" method="POST">
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
            //habilitar inputs
            $('#habilitar').click(function(e){
                e.preventDefault();
                var hblt = document.getElementById('habilitar'); 
                if(hblt.innerHTML == 'Habilitar'){
                    document.getElementById('inputNombre').disabled = false;
                    document.getElementById('inputEmail').disabled = false;
                    document.getElementById('selectRole').disabled = false;
                    document.getElementById('btnchangepassword').disabled = false;
                    document.getElementById('card-footer').style.display = 'block';
                    hblt.className = "btn btn-danger float-right";
                    hblt.innerHTML = 'Deshabilitar';
                }else{
                    document.getElementById('inputNombre').disabled = true;
                    document.getElementById('inputEmail').disabled = true;
                    document.getElementById('btnchangepassword').disabled = true;
                    document.getElementById('selectRole').disabled = true;
                    document.getElementById('card-footer').style.display = 'none';
                    hblt.className = "btn btn-primary float-right";
                    hblt.innerHTML = 'Habilitar';
                }    
            });
            //deshabilitar inputs
            $('#PasswordChange').click(function(e){
               
                document.getElementById('cardPasswordChange').style.display = 'block';
             }
            );
    });

</script>
@endsection