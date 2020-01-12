@extends('layouts.dashboard')
@section('title', 'Clientes')
@section('content')
		<div class="row">
			<div class="col-lg-3 col-xs-12">
          <!-- small box -->
          			<a href="{{route('cliente.create')}} " class="small-box-footer">
            		<div class="small-box bg-primary">
            		<div class="inner">
              			<h3>CREAR</h3>
              			<p>CLIENTE</p>
            		</div>
          			</div></a>
        	</div><!-- col -->
        	<div class="col-lg-9 col-xs-12">
          <!-- small box -->
        		<div class="small-box">
        		<div class="inner">
            	<div class="input-group">
	          		<input type="text" name="buscador" id="buscador" class="form-control" placeholder="Search...">
	          		<span class="input-group-btn"><button  id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
	              	</span>
	        	</div>
	        	</div>
	        	</div>
        	</div><!-- col -->
		</div>
    
		<div class="row">
			<div class="col-lg-12">
				@if(\Session::has('success'))
				<div class="alert alert-success">{{\Session::get('success')}} </div>
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Clientes</div>
					<div class="panel-body">
					<div id="t" class="table-responsive">
						<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Nombre</th>
							<th scope="col">Apellido paterno</th>
							<th scope="col">Apellido materno</th>
							
						</tr>
					</thead>
					<tbody>
							@foreach($clientes as $key => $cliente)
							<tr>
								<td>{{ $cliente->id}} </td>
								<td>{{ $cliente->nombre}}</td>
								<td>{{ $cliente->paterno}}</td>
								<td>{{ $cliente->materno}}</td>
								<td> {!! Form::open(['route' => ['cliente.edit', $cliente->id] ,'name' => 'formedit', 'id' => 'formedit', 'method' => 'GET']) !!} <button type="submit" class="btn btn-warning">Editar</button>

								{!! Form::close() !!}</td>
								<td>
									{!! Form::open(['route' => ['cliente.destroy', $cliente->id] , 'id' => 'formdelete'.$cliente->id])!!}
									{{method_field('DELETE')}}
									{{csrf_field()}}

								<a onClick="eliminar('{{$cliente->id}}', '{{$cliente->nombre}}');" class="btn btn-danger">Eliminar</a>
							{!! Form::close() !!}</td>
							</tr>
								
							@endforeach
					</tbody>
				</table>
						
					</div>
					
						
					</div>
					
				</div>
				
			</div>
		</div>
		<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
<script>
	$(document).ready(function(){
		var timer;

		$('#buscador').keyup(function(e){
			e.preventDefault();
			var valor = $(this).val();
			
			
			
			clearTimeout(timer);
			timer = setTimeout(function() {
        	$.ajaxSetup({
				headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
			});

			$.ajax({
				url : "{{route('clienteShow')}}",
				method : 'POST',
				data: {
				query: valor,
				},beforeSend: function() {

    				
  				},
			}).done(function(msg){
				if(msg != null){
					
					console.log(msg['data']);
					var idtable = document.getElementById("t");//optenemos el id de la tabla
					/*if (idtable.childNodes.length != 0) {
							idtable.removeChild(idtable.firstChild); //removemos todos los nodos de la tabla
					}*/
					if ( idtable.hasChildNodes() ){
						while ( idtable.childNodes.length >= 1 ){
							idtable.removeChild(idtable.firstChild );
						}
					}
					
					const table = document.createElement("table");
					const tbody = document.createElement("tbody");
					
					//HEAD TABLE
					const thead = document.createElement("thead");
					const filaHead = document.createElement("tr");
					var datosHead = ["#","Nombre","Apellido paterno","Apellido materno", "",""];
					for (var i = 0; i < datosHead.length; i++) {
						var celdaHead = document.createElement("th");
						var textCeldaHead = document.createTextNode(datosHead[i]);
						celdaHead.appendChild(textCeldaHead);
						filaHead.appendChild(celdaHead);
					}
					//END HEAD TABLE

				
					for (var i = 0; i < msg['data'].length  ; i++) {
						var fila = document.createElement("tr"); //elemento para la fila
						//var divDesglose = document.createElement("div"); // elemento para el div de divDesglose

						var datosCliente = [msg['data'][i].id, msg['data'][i].nombre, msg['data'][i].paterno, msg['data'][i].materno, 
						"4", "5"];
						for (var j = 0; j <datosCliente.length; j++) {
							var celda = document.createElement("td");
						    var textCelda = document.createTextNode(datosCliente[j]);
							if (j == datosCliente[4]) {
								var a = document.createElement("a");
								var textA = document.createTextNode("Editar");
								a.appendChild(textA);
								a.setAttribute("onclick", "showDesgloseIndividual("+msg['data'][i].id+")");
							    a.className += "btn btn-warning";
							 	
								celda.appendChild(a);
							}else if(j == datosCliente[5]){
								var a = document.createElement("a");
								var textA = document.createTextNode("Detalle");
								a.appendChild(textA);
								a.setAttribute("onclick", "showDesgloseIndividual("+msg['data'][i].id+")");
							    a.className += "btn btn-danger";
							 	
								celda.appendChild(a);
							}else{
								textCelda.className += "form-control";
								celda.appendChild(textCelda);
							}
							
						
							//fila.setAttribute("onclick", "showHide("+msg['clientes'][i].id+")");
							//fila.style.cursor = 'pointer';
							fila.appendChild(celda);		

						}

						
						tbody.appendChild(fila)
					
							

					}
					table.appendChild(filaHead);
					table.appendChild(tbody);
					idtable.appendChild(table);
					table.className += " table table-hover";
				
							

				}else{
					console.log('error');
				}
			});
			}, 150);
		});
	});

</script>
@endsection