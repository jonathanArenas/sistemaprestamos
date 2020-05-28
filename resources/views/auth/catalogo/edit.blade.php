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
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Nuevo concepto de prestamo al catalogo</h3>
                <button type="button" class="btn btn-primary float-right" id="Habilitar">Habilitar</button>
            </div>
              <!-- /.card-header -->
              <!-- form start -->
            <div class="card-body">
                <form role="form" action="{{route('catalogo.update', $catalogo->id)}}" method="POST">
                {{method_field('PATCH')}}
                {{csrf_field()}}
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control input" value="{{$catalogo->nombre}}" name="nombre"  id="inputNombre" placeholder="2 MESES AL 5%" required disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Interes</label>
                                <select class="form-control" name="interes" disabled>
                                @foreach($intereses as $key => $interes)
                                    @if($catalogo->interes == $interes)
                                        <option value="{{$catalogo->interes}}" selected="seleted">{{$catalogo->interes}}</option>
                                        @continue
                                    @endif
                                        <option value="{{$interes}}">{{$interes}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Porcentaje</label>
                                <input type="number" class="form-control" value="{{$catalogo->porcentaje}}" name="porcentaje" maxlength="2" onkeypress="return Numbers(event);" required disabled>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="plazo">Plazo</label>
                                <input type="text" class="form-control" value="{{$catalogo->plazo}}" name="plazo" onkeypress="return Numbers(event);" placeholder="3" required disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tiempo">de Tiempo</label>
                                <select class="form-control" name="define_tiempo" disabled> 
                                @foreach($defineTiempo as $key => $tiempo)
                                    @if($catalogo->define_timempo == $tiempo)
                                        <option value="{{$catalogo->define_tiempo}}" selected="selected">{{$catalogo->define_tiempo}}</option>
                                        @continue
                                    @endif
                                        <option value="{{$tiempo}}">{{$tiempo}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>                                                     
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="periodicidad">Periodicidad a cobrar</label>
                                <select class="form-control" name="periodicidad_cobro" disabled>
                                @foreach($periodicidad as $key => $periodo)
                                        @if($catalogo->periodicidad_cobro == $periodo)
                                            <option value="{{$catalogo->periodicidad_cobro}}" selected="selected">{{$catalogo->periodicidad_cobro}}</option>
                                            @continue
                                        @endif
                                            <option value="{{$periodo}}">{{$periodo}}</option>
                                @endforeach
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
@section('extras')
<script>
    $(document).ready(function(){
        $('#Habilitar').click(function(e){
            e.preventDefault();
            var hblt = this.innerHTML;
            var elements = document.getElementsByClassName('form-control');

            if(hblt == 'Habilitar'){
                for (let index = 0; index < elements.length; index++) {
                    const element = elements[index];
                    element.disabled = false;
                }
                this.innerHTML = 'Deshabilitar'
                this.className = "btn btn-danger float-right";
            }else{
                for (let index = 0; index < elements.length; index++) {
                    const element = elements[index];
                    element.disabled = true;
                }
                this.innerHTML = 'Habilitar'
                this.className = "btn btn-primary float-right";
            }
        });
    });
</script>
@endsection