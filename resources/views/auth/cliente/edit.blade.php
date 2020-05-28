@extends('layouts.dashboard')
@section('title', 'Crear cliente')
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
		<div class="card card-warning">
			<div class="card-header">
					<h3 class="card-title">Datos | Editar cliente</h3>
					<button type="submit" id="habilitar" class="btn btn-primary float-right">Habilitar</button>
			</div>
			<div class="card-body">
				<form role="form" action="{{route('cliente.update', $cliente->id)}}" method="POST">
                {{method_field('PATCH')}}
                {{csrf_field()}}
					<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
										<label><spam style="color: red">*</spam> Nombre</label>
										<input type="text"  onkeyup="this.value=Text(this.value)" value="{{$cliente->nombre}}" name="nombre" class="form-control input" placeholder="JOHN" required disabled>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
										<label><spam style="color: red">*</spam> Apellido Paterno</label>
										<input type="text"  onkeyup="this.value=Text(this.value)" value="{{$cliente->paterno}}" name="paterno" class="form-control input" placeholder="PRIMER APELLIDO" required disabled>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
										<label><spam style="color: red">*</spam> Apellido Materno</label>
										<input type="text"  onkeyup="this.value=Text(this.value)" value="{{$cliente->materno}}" name="materno" class="form-control input" placeholder="SEGUNDO APELLIDO" required disabled>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="telefono">Teléfono</label>
									<input type="text"  class="form-control" maxlength="13" value="{{$cliente->telefono}}" name="telefono" placeholder="7671024556" onkeypress="return Numbers(event);" disabled>
								</div>
							</div>
					</div>
					<hr color="#007bff" size=2> 
					<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<label for="postal">Código Postal</label>
									<input type="text" class="form-control" name="postal" value="{{$ubicacion[0]->cod_postal}}" id="inputPostal" maxlength="5" placeholder="44055" onkeypress="return Numbers(event);" required disabled>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="estado">Estado</label>
									<input type="text"  class="form-control input" value="{{$ubicacion[0]->estado}}" name="estado" id="inputEstado" placeholder="GUERRERO" required disabled>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="municipio">Municipio</label>
									<input type="text" class="form-control input" value="{{$ubicacion[0]->estado}}"  name="municipio" id="inputMunicipio" placeholder="CHILPANCINGO" required disabled>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="Colonia">Colonia</label>
									<select class="form-control" name="colonia" id="inputColonia" disabled>
									</select>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
										<label><spam style="color: red">*</spam> Dirección | Calle, Av..</label>
										<input type="text"  class="form-control input" value="{{$ubicacion[0]->direccion}}" name="direccion" placeholder="AV. INDEPENDENCIA"  required disabled>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<label for="num_int">Número Interion</label>
									<input type="text" class="form-control input" value="{{$ubicacion[0]->num_int}}" name="num_int" disabled>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<label for="num_ext">Número Exterior</label>
									<input type="text" class="form-control" value="{{$ubicacion[0]->num_ext}}" name="num_ext" onkeypress="return Numbers(event);" disabled>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-goup">
									<label for="zona">Zona</label>
									<select name="zona" class="form-control" id="selectZona" disabled>
									@foreach($zonas as $key => $itemZona)
										@if($itemZona->nombre == $zona->nombre)´
											<option value="{{$itemZona->nombre}}" selected="selected">{{$itemZona->nombre}}</option>
											@continue
										@else
											<option value="{{$itemZona->nombre}}">{{$itemZona->nombre}}</option>
										@endif
									@endforeach
									</select>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="seccion">Seccion</label>
									<select name="seccion" class="form-control" id="selectSeccion" disabled>
									</select>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<label>Documentos</label>
									@if($cliente->documento_I == 'SI')
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" name="documento_I" id="radio1" value="SI" checked>
											<label for="radio1" class="custom-control-label">SI</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" name="documento_I" id="radio2" value="NO">
											<label for="radio2" class="custom-control-label">NO</label>
										</div>
									@else
									<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" name="documento_I" id="radio1" value="SI">
											<label for="radio1" class="custom-control-label">SI</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" name="documento_I" id="radio2" value="NO" checked>
											<label for="radio2" class="custom-control-label">NO</label>
										</div>

									@endif

								</div>	
							</div>
					</div>              
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
		var postal = $('#inputPostal').val();
		if(postal.length ==5){
			postals(postal, "{{$ubicacion[0]->colonia}}");
		}
				$('#inputPostal').on("keyup",function(){
				postal = $('#inputPostal').val();
				if(postal.length == 5){
					postals(postal);
				}else{
    			$('#inputEstado').val("");
    			$('#inputMunicipio').val("");
    			$('#inputColonia').empty();
    			}
			});
		function postals(postal, colonia=null){
			var cod = postal;
			var uri = "https://api-sepomex.hckdrk.mx/query/info_cp/";
    			uri = uri + cod + "?type=simplified";
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
							if(colonia !=null && colonia == response['response']['asentamiento'][i].toUpperCase()){
								$('#inputColonia').append($('<option>',{
    							value: response['response']['asentamiento'][i].toUpperCase(),
								text: response['response']['asentamiento'][i].toUpperCase(),
								selected: "selected",
								}));
								continue;
							}
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
		}
    });
</script>
<script>

	var seccion = "{{$zona->seccion}}"
	$('#selectZona').change(function(){
				var query ="";
				$("#selectZona option:selected").each(function(){
					query = $(this).text();
				});				
    			$.ajax({
					headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  },
    				 url: "{{route('showSecciones')}}",
					   method: 'POST',
					   data:{
						   query: query,
					   },
    			}).done(function(response){
    				if (response != null) {
                        //console.log(response);
    					$('#selectSeccion').empty();
    					for( var i = 0; i < response['data'].length ; i++){
							if(seccion == response['data'][i]['seccion']){
								$('#selectSeccion').append($('<option>',{
    							value: response['data'][i]['seccion'],
								text: response['data'][i]['seccion'],
								selected: "selected",
								}));
								seccion = null;
								continue;
							}
    						$('#selectSeccion').append($('<option>',{
    							value: response['data'][i]['seccion'],
    							text: response['data'][i]['seccion'], 
    						}));
    					}
    				}else{
    					console.log('error');
    				}
    			});
}).change();

$(document).ready(function(){
	$('#habilitar').click(function(e){
		e.preventDefault();
		var hblt = document.getElementById('habilitar');
		var elements = document.getElementsByClassName('form-control');
		if(hblt.innerHTML == 'Habilitar'){
			for (let index = 0; index < elements.length; index++) {
				const element = elements[index];
				element.disabled = false;
			}
			hblt.innerHTML = 'Deshabilitar';
			hblt.className = "btn btn-danger float-right";
		}else{
			for (let index = 0; index < elements.length; index++) {
				const element = elements[index];
				element.disabled = true;
			}
			hblt.innerHTML = 'Habilitar';
			hblt.className = "btn btn-primary float-right";
		}	
	});
});
</script>
@endsection