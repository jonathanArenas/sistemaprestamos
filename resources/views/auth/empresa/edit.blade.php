@extends('layouts.dashboard')
@section('title', 'Agregar datos')
@section('content')
<div id="carga">
				<img src="{{asset('img/infinito.gif')}}" id="loading-indicator" />
</div>
<div class="row">

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
    <div class="col-lg-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Editar datos de la compañia</h3>
                <button type="submit" id="habilitar" class="btn btn-primary float-right">Habilitar</button>
                
            </div>
              <!-- /.card-header -->
              <!-- form start -->
            <div class="card-body">
                <form role="form" action="{{route('empresa.update', $empresa->id)}}" method="POST">
                {{method_field('PATCH')}}
				{{csrf_field()}}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control input" value="{{$empresa->nombre}}" name="nombre" id="inputNombre" placeholder="Nombre de la empresa" required disabled>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" class="form-control" value="{{$empresa->email}}"name="email" id="inputEmail" placeholder="example@gmail.com" disabled>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Teléfono</label>
                                <input type="text" class="form-control" value="{{$empresa->telefono}}"name="telefono" id="inputTelefono" maxlength="10" onkeypress="return Numbers(event);" placeholder="(000)-100-10-10" disabled>
                            </div>
                        </div>                                                      
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Código Postal</label>
                                    <input type="text" class="form-control" value="{{$empresa->cp}}" name="postal" id="inputPostal" maxlength="5" onkeypress="return Numbers(event);" placeholder="000000" required disabled>
                                </div> 
                        </div> 
                        <div class="col-lg-3">    
                            <div class="form-group">
                                <label for="">Estado</label>
                                <input type="text" class="form-control" value="{{$empresa->estado}}"name="estado" id="inputEstado" placeholder="Estado" required disabled>
                            </div>
                        </div>
                        <div class="col-lg-3">    
                            <div class="form-group">
                                <label for="">Municipio</label>
                                <input type="text" class="form-control" value="{{$empresa->municipio}}"name="municipio" id="inputMunicipio" placeholder="Municipio" required disabled>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label for="colonia">Colonia</label>
                            <select id="inputColonia" name="colonia" class="form-control" required disabled>
							    <option value="{{$empresa->colonia}}">{{$empresa->colonia}}</option>
						    </select>
                        </div>
                    </div>
                    <div class="row">   
                        <div class="col-lg-12">    
                            <div class="form-group">
                                <label for="">Dirección</label>
                                <input type="text" class="form-control input" value="{{$empresa->direccion}}" name="direccion" id="inputDireccion" placeholder="Dirección #Número" required disabled>
                            </div>
                        </div>
                    </div>
                    
                <!-- /.card-body -->
                    <div class="card-footer" id="card-footer" style="display:none">
                        <button type="submit" class="btn btn-warning float-right">ACTUALIZAR</button>
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
    	    $('#inputPostal').on("keyup",function(){
    	    	$postal = $('#inputPostal').val();
    			var uri = "https://api-sepomex.hckdrk.mx/query/info_cp/";
                if($postal.length == 5){
                    uri = uri + $postal + "?type=simplified";
                    $.ajax({
                        url: uri,
                        method: 'GET',
                        beforeSend: function() {
                            $('#carga').show();
                            $('#loading-indicator').show();
                        },
                    }).done(function(response){
                        if (response != null) {
                            console.log(response);
                            $('#inputEstado').val(response['response']['estado'].toUpperCase());
                            $('#inputMunicipio').val(response['response']['municipio'].toUpperCase());
                            $('#inputColonia').empty();
                            for( var i = 0; i < response['response']['asentamiento'].length ; i++){
                                $('#inputColonia').append($('<option>',{
                                    value: response['response']['asentamiento'][i].toUpperCase(),
                                    text: response['response']['asentamiento'][i].toUpperCase(),
                                }));
                            }
                        }else{
                            console.log('error');
                        }
                    }).always(function(event, request, settings){
                            $('#carga').hide();
                            $('#loading-indicator').hide();
                    });	
                }else{
                    $('#inputEstado').val("");
                    $('#inputMunicipio').val("");
                    $('#inputColonia').empty();
                }
    		
    		
            });
            //habilitar inputs
            $('#habilitar').click(function(e){
                e.preventDefault();
                var hblt = document.getElementById('habilitar'); 
                if(hblt.innerHTML == 'Habilitar'){
                    document.getElementById('inputNombre').disabled = false;
                    document.getElementById('inputEmail').disabled = false;
                    document.getElementById('inputTelefono').disabled = false;
                    document.getElementById('inputPostal').disabled = false;
                    document.getElementById('inputEstado').disabled = false;
                    document.getElementById('inputMunicipio').disabled = false;
                    document.getElementById('inputColonia').disabled = false;
                    document.getElementById('inputDireccion').disabled = false;
                    document.getElementById('card-footer').style.display = 'block';
                    hblt.className = "btn btn-danger float-right";
                    hblt.innerHTML = 'Deshabilitar';
                }else{
                    
                    document.getElementById('inputNombre').disabled = true;
                    document.getElementById('inputEmail').disabled = true;
                    document.getElementById('inputTelefono').disabled = true;
                    document.getElementById('inputPostal').disabled = true;
                    document.getElementById('inputEstado').disabled = true;
                    document.getElementById('inputMunicipio').disabled = true;
                    document.getElementById('inputColonia').disabled = true;
                    document.getElementById('inputDireccion').disabled = true;
                    document.getElementById('card-footer').style.display = 'none';
                    hblt.className = "btn btn-primary float-right";
                    hblt.innerHTML = 'Habilitar';
                }
               
            });
            //deshabilitar inputs
    });

</script>
@endsection