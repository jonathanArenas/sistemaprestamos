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
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Porcentaje %</label>
                                <input type="text" class="form-control" name="porcentaje" onkeypress="return Numbers(event);" required>
                            </div>
                        </div> 
                    
                        <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="plazo">Plazo</label>
                                    <input type="text" class="form-control" id="num_plazoDevolucion" name="num_plazoDevolucion"  maxlength="2" onkeypress="return Numbers(event);" placeholder="3" required>
                                </div>
                        </div>
                        <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="tiempo">de devolución</label>
                                    <select class="form-control" name="time_plazoDevolucion" id="time_plazoDevolucion">
                                        <option value="DIAS">DIAS</option>
                                        <option value="MESES">MESES</option>
                                        <option value="ANIOS">AÑOS</option>
                                    </select>
                                </div>
                        </div>
                        <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="no_cobranza">Descanso cobranza</label>
                                    <select class="form-control" name="no_cobranza">
                                        <option value="NINGUNO">NINGUNO</option>
                                        <option value="LUNES">LUNES</option>
                                        <option value="MARTES">MARTES</option>
                                        <option value="MIERCOLES">MIERCOLES</option>
                                        <option value="JUEVES">JUEVES</option>
                                        <option value="VIERNES">VIERNES</option>
                                        <option value="SABADO">SÁBADO</option>
                                        <option value="DOMINGO">DOMINGO</option>
                                    </select>
                                </div>
                        </div>
                        <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="tarifa_cargos">Tarífa cargos</label>
                                    <input type="text" name="tarifa_cargos" id="tarifa_cargos" maxlength="5" minlength="1" class="form-control" onkeypress="return Numbers(event);">
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
    let numPlazo = document.getElementById('num_plazoDevolucion');
    let inputTarifa = document.getElementById('tarifa_cargos');

    numPlazo.addEventListener('keyup', function(e){
        e.preventDefault();
        console.log(numPlazo.value);
        let timePlazo =  document.getElementById('time_plazoDevolucion');
        if(numPlazo.value == 1){          
            timePlazo.childNodes[3].value = "MES";
            timePlazo.childNodes[3].innerHTML = "MES";
            timePlazo.childNodes[5].value = "ANIO";
            timePlazo.childNodes[5].innerHTML = "AÑO";
        }else{
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