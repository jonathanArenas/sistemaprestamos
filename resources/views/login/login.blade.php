@extends('layouts.app')


@section('content')
  <div class="login-box">
        <div class="login-logo">
          <a href="./">Tu<b>CRÉDITO</b></a>
        </div><!-- /.login-logo -->
        <div class="card">
        <div class="card-body login-card-body">
          <form action="{{ route('login')}} " method="POST">
            {{ csrf_field() }}

            <div class="input-group mb-3 has-feedback {{ $errors->has('email') ? 'has-error' : ''}}"  >
              <input type="text" name="email"  value="{{old('email')}}" class="form-control" placeholder="Email"/>
               
                <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                </div>
                {!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
            </div>
            
            <div class="input-group mb-3 has-feedback {{ $errors->has('password') ? 'has-error' : ''}}" >
              <input type="password" name="password"  class="form-control" placeholder="Password"/>
              
              <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
              </div>
              {!! $errors->first('password', '<spam class="help-block">:message</spam>') !!}            
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block btn-block">Acceder</button>
            </div><!-- /.col -->
          </form>
        </div><!-- /.login-box-body -->
        </div>
        
  </div><!-- /.login-box -->  
@stop