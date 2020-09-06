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
                                <input type="text" class="form-control" value="{{$catalogo->porcentaje}}" name="porcentaje"  onkeypress="return Numbers(event);" required disabled>
                            </div>
                        </div> 
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="plazo">Plazo</label>
                                <input type="text" class="form-control" value="{{$catalogo->num_plazodevolucion}}" id="num_plazoDevolucion" name="num_plazoDevolucion" onkeypress="return Numbers(event);" placeholder="3" required disabled>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="tiempo">de devolucion</label>
                                <select class="form-control" name="time_plazoDevolucion" id="time_plazoDevolucion" disabled> 
                                @foreach($timeDevolucion as $key => $tiempo)
                                    @if($catalogo->time_plazodevolucion == "MES" && $catalogo->num_plazodevolucion == "1" && $tiempo == "MESES")
                                        <option value="{{$catalogo->time_plazodevolucion}}" selected="selected">{{$catalogo->time_plazodevolucion}}</option>
                                        @continue
                                    @endif
                                    @if($catalogo->time_plazodevolucion == "ANIO" && $catalogo->num_plazodevolucion == "1" && $tiempo == "AÑOS")
                                        <option value="{{$catalogo->time_plazodevolucion}}" selected="selected">AÑO</option>
                                        @continue
                                    @endif
                                    @if($catalogo->time_plazodevolucion == $tiempo)
                                            <option value="{{$catalogo->time_plazodevolucion}}" selected="selected">{{$catalogo->time_plazodevolucion}}</option>
                                        @continue
                                    @endif
                                    <option value="{{$tiempo}}">{{$tiempo}}</option>         
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="no_cobranza">Descanso cobranza</label>
                                    <select class="form-control" name="no_cobranza" disabled>
                                        @foreach($array_no_cobranza as $key => $item_no_cobranza)
                                            @if($catalogo->no_cobranza == $item_no_cobranza)
                                            <option value="{{$catalogo->no_cobranza}}" selected="selected" >{{$catalogo->no_cobranza}}</option>
                                                @continue
                                            @endif
                                            <option value="{{$item_no_cobranza}}">{{$item_no_cobranza}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="tarifa_cargos">Tarífa cargos</label>
                                    <input type="text" name="tarifa_cargos" id="tarifa_cargos" value="{{$catalogo->tarifa_cargos}}" maxlength="5" minlength="1" class="form-control" onkeypress="return Numbers(event);" disabled>
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

    let numPlazo = document.getElementById('num_plazoDevolucion');
    let inputTarifa = document.getElementById('tarifa_cargos');

    numPlazo.addEventListener('keyup', function(e){
        let timePlazo =  document.getElementById('time_plazoDevolucion');
        if(numPlazo.value == 1){   
            console.log('yes');       
            timePlazo.childNodes[3].value = "MES";
            timePlazo.childNodes[3].innerHTML = "MES";
            timePlazo.childNodes[5].value = "ANIO";
            timePlazo.childNodes[5].innerHTML = "AÑO";
        }else{
            console.log('no');
            timePlazo.childNodes[3].value = "MESES";
            timePlazo.childNodes[3].innerHTML = "MESES";
            timePlazo.childNodes[5].value = "ANIOS";
            timePlazo.childNodes[5].innerHTML = "AÑOS";
        }
    });

    inputTarifa.addEventListener('keyup', function(e){
        formatCurrency(inputTarifa);
    });

    inputTarifa.addEventListener('blur', function(e){
        formatCurrency(inputTarifa, "blur");
    });
    
</script>
@endsection