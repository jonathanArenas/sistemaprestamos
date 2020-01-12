@extends('layouts.app')


@section('content')
<div class="login-box">
      <div class="login-logo">
        <a href="./">SISTEMA<b>PRESTAMOS</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <form action="{{ route('login')}} " method="POST">
          {{ csrf_field() }}

          <div class="form-group has-feedback {{ $errors->has('nombre') ? 'has-error' : ''}}"  >
            <input type="text" name="nombre"  value="{{old('nombre')}}" class="form-control" placeholder="Usuario"/>
              {!! $errors->first('nombre', '<spam class="help-block">:message</spam>') !!}
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          
          <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : ''}}" >
            <input type="password" name="password"  class="form-control" placeholder="Password"/>
             {!! $errors->first('password', '<spam class="help-block">:message</spam>') !!}
             <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block btn-block">Acceder</button>
          </div><!-- /.col -->
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->  
@stop