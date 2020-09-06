@extends('layouts.dashboard')
@section('title', 'Agregar datos')
@section('content')
<div id="carga">
				<img src="{{asset('img/infinito.gif')}}" id="loading-indicator" />
</div>

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
                <h3 class="card-title">Agregar datos de la compañia</h3>
            </div>
              <!-- /.card-header -->
              <!-- form start -->
            <div class="card-body">
                <form role="form" action="{{route('empresa.store')}}" method="POST">
                {{csrf_field()}}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control input" name="nombre" id="inputNombre" placeholder="Nombre de la empresa" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" class="form-control" name="email" id="inputEmail" placeholder="example@gmail.com">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Teléfono</label>
                                <input type="text" class="form-control" name="telefono" id="inputTelefono" maxlength="10" onkeypress="return Numbers(event);" placeholder="(000)-100-10-10">
                            </div>
                        </div>                                                      
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Código Postal</label>
                                    <input type="text" class="form-control" name="postal" id="inputPostal" maxlength="5" onkeypress="return Numbers(event);" placeholder="000000" required>
                                </div> 
                        </div> 
                        <div class="col-lg-3">    
                            <div class="form-group">
                                <label for="">Estado</label>
                                <input type="text" class="form-control" name="estado" id="inputEstado" placeholder="Estado" required>
                            </div>
                        </div>
                        <div class="col-lg-3">    
                            <div class="form-group">
                                <label for="">Municipio</label>
                                <input type="text" class="form-control" name="municipio" id="inputMunicipio" placeholder="Municipio" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label for="colonia">Colonia</label>
                            <select id="inputColonia" name="colonia" class="form-control" required>
							
						    </select>
                        </div>
                    </div>
                    <div class="row">   
                        <div class="col-lg-12">    
                            <div class="form-group">
                                <label for="">Dirección</label>
                                <input type="text" class="form-control input" name="direccion" id="idDireccion" placeholder="Dirección #Número" required>
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
    }); 
</script>
@endsection