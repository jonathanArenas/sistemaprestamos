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
		<div class="card card-primary">
			<div class="card-header">
					<h3 class="card-title">Datos | Nuevo cliente</h3>
			</div>
			<div class="card-body">
				<form role="form" action="{{route('cliente.store')}}" method="POST">
                {{csrf_field()}}
					<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
										<label><spam style="color: red">*</spam> Nombre</label>
										<input type="text"  onkeyup="this.value=Text(this.value)" name="nombre" class="form-control input" placeholder="JOHN" required>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
										<label><spam style="color: red">*</spam> Apellido Paterno</label>
										<input type="text"  onkeyup="this.value=Text(this.value)" name="paterno" class="form-control input" placeholder="PRIMER APELLIDO" required>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
										<label><spam style="color: red">*</spam> Apellido Materno</label>
										<input type="text"  onkeyup="this.value=Text(this.value)" name="materno" class="form-control input" placeholder="SEGUNDO APELLIDO" required>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="telefono">Teléfono</label>
									<input type="text"  class="form-control" maxlength="13" name="telefono" placeholder="7671024556" onkeypress="return Numbers(event);">
								</div>
							</div>
					</div>
					<hr color="#007bff" size=2> 
					<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<label for="postal">Código Postal</label>
									<input type="text" class="form-control" name="postal" id="inputPostal" maxlength="5" placeholder="44055" onkeypress="return Numbers(event);" required>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="estado">Estado</label>
									<input type="text"  class="form-control input" name="estado" id="inputEstado" placeholder="GUERRERO" required>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="municipio">Municipio</label>
									<input type="text" class="form-control input" name="municipio" id="inputMunicipio" placeholder="CHILPANCINGO" required>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="Colonia">Colonia</label>
									<select class="form-control" name="colonia" id="inputColonia">
									</select>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
										<label><spam style="color: red">*</spam> Dirección | Calle, Av..</label>
										<input type="text"  class="form-control input" name="direccion" placeholder="AV. INDEPENDENCIA"  required>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<label for="num_int">Número Interion</label>
									<input type="text" class="form-control input" name="num_int">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<label for="num_int">Número Exterior</label>
									<input type="text" class="form-control" name="num_ext" onkeypress="return Numbers(event);">
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-goup">
									<label for="zona">Zona</label>
									<select name="zona" class="form-control" id="selectZona">
									@foreach($zonas as $key => $zona)
										<option value="{{$zona->nombre}}">{{$zona->nombre}}</option>
									@endforeach
									</select>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label for="seccion">Seccion</label>
									<select name="seccion" class="form-control" id="selectSeccion">
									</select>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<label>Documentos</label>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" name="documento_I" id="radio1" value="SI">
											<label for="radio1" class="custom-control-label">SI</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" name="documento_I" id="radio2" value="NO">
											<label for="radio2" class="custom-control-label">NO</label>
										</div>			
								</div>	
							</div>
					</div>              
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
<script>
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
                        console.log(response);
    					$('#selectSeccion').empty();
    					for( var i = 0; i < response['data'].length ; i++){
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
</script>
@endsection