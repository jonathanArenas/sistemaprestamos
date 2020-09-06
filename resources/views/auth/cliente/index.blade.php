@extends('layouts.dashboard')
@section('title', 'Clientes')
@section('content')
		<div class="row mb-2">
			<div class="col-lg-12">
				<a class="btn btn-primary float-right" href="{{route('cliente.create')}}">Agregar</a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">Clientes</h3>
						<div class="card-tools">
							<div class="input-group input-group-sm" style="width: 250px;">
								<input type="text" name="table_search" class="form-control float-left" id="buscador" placeholder="Search">
								<div class="input-group-append">
								<span class="btn btn-default"><i class="fas fa-search"></i></span>
								</div>
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
								<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
								<i class="fas fa-times"></i></button>
							</div>
						</div>
					</div>
					<div  class="card-body table-responsive p-0">
						<table class="table table-sm table-hover text-nowrap" id="t">
									<thead>
										<tr>
											<th>#</th>
											<th>Nombre</th>
											<th>Apellido paterno</th>
											<th>Apellido materno</th>
											<th>Acción</th>										
										</tr>
									</thead>
									<tbody>
											@foreach($clientes as $key => $cliente)
											<tr>
												<td>{{ $cliente->id}} </td>
												<td>{{ $cliente->nombre}}</td>
												<td>{{ $cliente->paterno}}</td>
												<td>{{ $cliente->materno}}</td>
												<td class="py-0 align-middle">
													<div class="btn-group btn-group-sm">
														<a class="btn btn-warning btn-sm" href="{{route('cliente.edit', $cliente->id)}}"><i class="far fa-edit"></i></a>
														@hasrole('SuperUser|Prestamista')
														{!! Form::open(['route' => ['cliente.destroy', $cliente->id] , 'id' => 'formdelete'.$cliente->id])!!}
														{{method_field('DELETE')}}
														{{csrf_field()}}
														<a class="btn btn-danger btn-sm" onClick="eliminar('{{$cliente->id}}', '{{$cliente->nombre}}');" ><i class="far fa-trash-alt"></i></a>
														{!! Form::close() !!}
														@endhasrole
													</div>
												</td>	
											</tr>			
											@endforeach
									</tbody>
						</table>	
					</div>
				</div>		
			</div>					
		</div>
		<div id="modal-destroy">
		</div>
@endsection
@section('extras')
<script>

	function addBottonEdit(id){
		let btnEdit= document.createElement("a");
		let iEdit = document.createElement("i");
		let	url = "{{route('cliente.edit', 'id')}}"
		url = url.replace('id', id);

		btnEdit.setAttribute("href", url);
		btnEdit.className = "btn btn-warning";;
		iEdit.className = "far fa-edit";
		btnEdit.appendChild(iEdit);
		return btnEdit; 
	}

	function addButtonDelete(id, name){
		let btnDelete = document.createElement("a");
		let iDelete = document.createElement("i");
		let formDelete = document.createElement("form");
		let inputHidden = document.createElement("input");
		let inputToken = document.createElement("input");

		let url = "{{route('cliente.destroy', 'id')}}"
		url = url.replace('id', id); 
		formDelete.setAttribute("action", url);
		formDelete.setAttribute("method", "POST");
		formDelete.setAttribute("id", "formdelete"+id);
		inputHidden.setAttribute("type" , "hidden");
		inputHidden.setAttribute("name" , "_method");
		inputHidden.setAttribute("value" , "DELETE");
		inputToken.setAttribute("type" , "hidden");
		inputToken.setAttribute("name" , "_token");
		inputToken.setAttribute("value" , "{{ csrf_token()}}");

		btnDelete.setAttribute("onclick", "eliminar('"+id+"', '"+name+"')");
		btnDelete.className = "btn btn-danger";
		iDelete.className = "far fa-trash-alt";
		btnDelete.appendChild(iDelete);
		formDelete.appendChild(inputHidden);
		formDelete.appendChild(inputToken);
		formDelete.appendChild(btnDelete);
		return formDelete;
	}

	$(document).ready(function(){
		var timer; 
		$('#buscador').keyup(function(e){
			e.preventDefault();
			let valor = $(this).val();
			let id = $(this).attr('id');
			$.ajax({
				headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  },
				url : "{{route('clienteShow')}}",
				method : 'POST',
				data: {
				query: valor,
				type: id,
				},
			}).done(function(msg){
				if(msg != null){
					console.log(msg['data']);
					var idtable = document.getElementById("t");//optenemos el id de la tabla
					
					if ( idtable.hasChildNodes() ){//removemos los nodos de la tabla
						while ( idtable.childNodes.length >= 1 ){
							idtable.removeChild(idtable.firstChild );
						}
					}
					
					const tbody = document.createElement("tbody");
					
					//HEAD TABLE
					const thead = document.createElement("thead");
					const filaHead = document.createElement("tr");
					let datosHead = ["#","Nombre cliente","Apellido paterno","Apellido materno", "acción"];
					for (let i = 0; i < datosHead.length; i++) {
						let celdaHead = document.createElement("th");
						let textCeldaHead = document.createTextNode(datosHead[i]);
						celdaHead.appendChild(textCeldaHead);
						filaHead.appendChild(celdaHead);
					}
					//END HEAD TABLE
					for (let i = 0; i < msg['data'].length  ; i++) {
						let fila = document.createElement("tr"); //elemento para la fila
						let datosCliente = [msg['data'][i].id, msg['data'][i].nombre, msg['data'][i].paterno, msg['data'][i].materno,  
						"4"];
						for (let j = 0; j <datosCliente.length; j++) {
							let celda = document.createElement("td");
							if (j == datosCliente[4]) {
								let div = document.createElement("div");
									div.className += "btn-group btn-group-sm";
									div.appendChild(addBottonEdit(msg['data'][i].id));
									let role = "{{Auth()->user()->getRoleNames()}}"
									if(!role.includes("Administrador")){
										div.appendChild(addButtonDelete(msg['data'][i].id, msg['data'][i].nombre));
									}
									celda.appendChild(div);
									celda.className += "py-0 align-middle";
							}else{
								var textCelda = document.createTextNode(datosCliente[j]);
								celda.appendChild(textCelda);
							}
							fila.appendChild(celda);		
						}
						tbody.appendChild(fila)
					}
					idtable.appendChild(filaHead);
					idtable.appendChild(tbody);
				}else{
					console.log('error');
				}
			}).fail(function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR.responseText);
            });
        	
		});
	});
</script>
@endsection