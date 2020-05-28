@extends('layouts.dashboard')
@section('title', 'crear concepto prestamo')
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
                <h3 class="card-title">Nuevo concepto de prestamo al catalogo</h3>
            </div>
              <!-- /.card-header -->
              <!-- form start -->
            <div class="card-body">
                <form role="form" action="{{route('catalogo.store')}}" method="POST">
                {{csrf_field()}}
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control input" name="nombre" id="inputNombre" placeholder="2 MESES AL 5%" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Interes</label>
                                <select class="form-control" name="interes" id="interes">
                                    <option value="SIMPLE">SIMPLE</option>
                                    <option value="COMPUESTO">COMPUESTO</option>
                                    <option value="MIXTO">MIXTO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Porcentaje</label>
                                <input type="number" class="form-control" name="porcentaje" maxlength="2" onkeypress="return Numbers(event);" required>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="plazo">Plazo</label>
                                <input type="text" class="form-control" name="plazo" onkeypress="return Numbers(event);" placeholder="3" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tiempo">de Tiempo</label>
                                <select class="form-control" name="define_tiempo" id="define_tiempo">
                                    <option value="DIAS">DIAS</option>
                                    <option value="MESES">MESES</option>
                                    <option value="ANIOS">AÑO</option>
                                </select>
                            </div>
                        </div>                                                     
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="periodicidad">Periodicidad a cobrar</label>
                                <select class="form-control" name="periodicidad_cobro" id="periodicidad">
                                    <option value="DIARIO">DIARIO</option>
                                    <option value="SEMANAL">SEMANAL</option>
                                    <option value="QUINCENAL">QUINCENAL</option>
                                    <option value="MENSUAL">MESUAL</option>
                                    <option value="ANUAL">ANUAL</option>
                                </select>
                            </div> 
                        </div> 
                    </div>
                <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success float-right">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection