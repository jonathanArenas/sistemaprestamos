@extends('layouts.dashboard')
@section('title', 'Empresa')
@section('content')
<div class="row">
  
<div class="col-lg-12 col-md-12 col-xs-12">
            @if(isset($empresa))
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                  <i class="fas fa-info-circle"></i>
                    Detalles de la compañia.
                </h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link bg-warning" href="{{route('empresa.edit', $empresa->id)}}">Editar datos</a></li>
                </ul>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl>
                  <dt>Nombre</dt>
                  <dd>{{$empresa->nombre}}</dd>
                  <dt>Email</dt>
                  <dd>{{$empresa->email}}</dd>
                  <dt>Teléfono</dt>
                  <dd>{{$empresa->telefono}}</dd>
                  <dt>Código Postal</dt>
                  <dd>{{$empresa->cp}}</dd>
                  <dt>Estado</dt>
                  <dd>{{$empresa->estado}}</dd>
                  <dt>Municipio</dt>
                  <dd>{{$empresa->municipio}}</dd>
                  <dt>Colonia</dt>
                  <dd>{{$empresa->colonia}}</dd>
                  <dt>Direccion</dt>
                  <dd>{{$empresa->direccion}}</dd>
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            @else
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                  <i class="fas fa-info-circle"></i>
                    Detalles de la compañia.
                </h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link bg-primary" href="{{route('empresa.create')}}"">Agregar datos</a></li>
                </ul>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl>
                  <dt>Nombre</dt>
                  <dd>Sin datos</dd>
                  <dt>Dirección</dt>
                  <dd>Sin datos</dd>
                  <dt>Código postal</dt>
                  <dd>Sin datos</dd>
                  <dt>Colonia</dt>
                  <dd>Sin datos</dd>
                  <dt>Email</dt>
                  <dd>Sin datos</dd>
                  <dt>Teléfono</dt>
                  <dd>Sin datos</dd>
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            @endif
</div>

</div>
@endsection