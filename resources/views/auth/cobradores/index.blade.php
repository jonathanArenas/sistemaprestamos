@extends('layouts.dashboard')
@section('title', 'Cobradores')
@section('content')
		<div class="row mb-2">
			<div class="col-lg-12">
				<a class="btn btn-primary float-right" href="{{route('cobradores.create')}}">Agregar</a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">Cobradoes</h3>
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
											<th>Nombre de usuario</th>
											<th>Email</th>
											<th>Acción</th>									
										</tr>
									</thead>
									<tbody>
											@foreach($cobradores as $key => $cobrador)
											<tr>
												<td>{{ $cobrador->id}} </td>
												<td>{{ $cobrador->nombre}}</td>
												<td>{{ $cobrador->email}}</td>
												<td class="py-0 align-middle">
													<div class="btn-group btn-group-sm">
														<a class="btn btn-warning btn-sm" href="{{route('cobradores.edit', $cobrador->id)}}"><i class="far fa-edit"></i></a>
														{!! Form::open(['route' => ['cobradores.destroy', $cobrador->id] , 'id' => 'formdelete'.$cobrador->id])!!}
														{{method_field('DELETE')}}
														{{csrf_field()}}
														<a onClick="eliminar('{{$cobrador->id}}', '{{$cobrador->nombre}}');" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
														{!! Form::close() !!}
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
@endsection
@section('extras')
<script>
function addBottonEdit(id){
		let btnEdit= document.createElement("a");
		let iEdit = document.createElement("i");
		let	url = "{{route('cobradores.edit', 'id')}}"
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

		let url = "{{route('cobradores.destroy', 'id')}}"
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
			$.ajaxSetup({
				headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
			});
			$.ajax({
				url : "{{route('cobradorShow')}}",
				method : 'POST',
				data: {
				query: valor,
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
					var datosHead = ["#","Nombre de usuario", "Email", "acción"];
					for (var i = 0; i < datosHead.length; i++) {
						var celdaHead = document.createElement("th");
						var textCeldaHead = document.createTextNode(datosHead[i]);
						celdaHead.appendChild(textCeldaHead);
						filaHead.appendChild(celdaHead);
					}
					//END HEAD TABLE
					for (var i = 0; i < msg['data'].length  ; i++) {
						var fila = document.createElement("tr"); //elemento para la fila
						var datosCliente = [msg['data'][i].id, msg['data'][i].username, msg['data'][i].email,  
						"3"];
						for (var j = 0; j <datosCliente.length; j++) {
							var celda = document.createElement("td");
							if (j == datosCliente[3]) {
								let div = document.createElement("div");
								div.className += "btn-group btn-group-sm";
								div.appendChild(addBottonEdit(msg['data'][i].id));
								div.appendChild(addButtonDelete(msg['data'][i].id, msg['data'][i].nombre));
								celda.appendChild(div);
								celda.className += "py-0 align-middle";
							}else{
								var textCelda = document.createTextNode(datosCliente[j]);
								celda.appendChild(textCelda);
							}
							//fila.setAttribute("onclick", "showHide("+msg['clientes'][i].id+")");
							//fila.style.cursor = 'pointer';
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