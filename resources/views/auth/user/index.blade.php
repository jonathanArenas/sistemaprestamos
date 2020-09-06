@extends('layouts.dashboard')
@section('title', 'Clientes')
@section('content')

<div class="row mb-2">
	<div class="col-lg-12">
		<div class="margin float-right">
			<div class="btn-group">
				@role('SuperUser')<a class="btn btn-default"  href="{{route('roles.index')}}">Roles</a>@endrole	
			</div>
			<div class="btn-group">
				<a class="btn btn-primary" href="{{route('user.create')}}">Agregar</a>
			</div>
		</div>
	</div>
</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">Usuarios</h3>
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
					<div class="card-body table-responsive p-0">
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
								@foreach($users as $key => $user)
								<tr>
										<td>{{ $user->id}} </td>
										<td>{{ $user->username}}</td>
										<td>{{ $user->email}}</td>
										<td class="py-0 align-middle"">
												<div class="btn-group btn-group-sm">
													<a class="btn btn-warning btn-sm " href="{{route('user.edit', $user->id)}}"><i class="far fa-edit"></i></a>
													{!! Form::open(['route' => ['user.destroy', $user->id] , 'id' => 'formdelete'.$user->id])!!}
													{{method_field('DELETE')}}
													{{csrf_field()}}
													<a class="btn btn-danger btn-sm" onClick="eliminar('{{$user->id}}', '{{$user->nombre}}');" ><i class="far fa-trash-alt"></i></a>
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
		</div>


@endsection
@section('extras')
<script>
	$(document).ready(function(){
		var timer;

		$('#buscador').keyup(function(e){
			e.preventDefault();
			var valor = $(this).val();
        	$.ajaxSetup({
				headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
			});
			$.ajax({
				url : "{{route('userShow')}}",
				method : 'POST',
				data:{
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
					var datosHead = ["#","Nombre de usuario","Email","Accion"];
					for (var i = 0; i < datosHead.length; i++) {
						var celdaHead = document.createElement("th");
						var textCeldaHead = document.createTextNode(datosHead[i]);
						celdaHead.appendChild(textCeldaHead);
						filaHead.appendChild(celdaHead);
					}
					//END HEAD TABLE
					for (var i = 0; i < msg['data'].length  ; i++) {
						var fila = document.createElement("tr"); //elemento para la fila
						var datosCliente = [msg['data'][i].id, msg['data'][i].nombre, msg['data'][i].email,  
						"3"];
						for (var j = 0; j <datosCliente.length; j++) {
							var celda = document.createElement("td");
							if (j == datosCliente[3]) {
								var div = document.createElement("div");
								var view = document.createElement("a");
								var delte = document.createElement("a");
								var iview = document.createElement("i");
								var idelte = document.createElement("i");
								var form = document.createElement("form");
								var hiddenDelite = document.createElement("input");
								var hiddenToken = document.createElement("input");

									view.setAttribute("href", "http://127.0.0.1:8000/dashboard/user/"+msg['data'][i].id+"/edit");
									view.className += "btn btn-warning";
									iview.className += "fas fa-eye";
									form.setAttribute("action", "http://127.0.0.1:8000/dashboard/user/"+msg['data'][i].id);
									form.setAttribute("method", "POST");
									form.setAttribute("id", "formdelete"+msg['data'][i].id);
									delte.setAttribute("onclick", "eliminar('"+msg['data'][i].id+"', '"+msg['data'][i].nombre+"')");
									delte.className += "btn btn-danger";
									idelte.className += "fas fa-trash";
									hiddenDelite.setAttribute("type" , "hidden");
									hiddenDelite.setAttribute("name" , "_method");
									hiddenDelite.setAttribute("value" , "DELETE");
									hiddenToken.setAttribute("type" , "hidden");
									hiddenToken.setAttribute("name" , "_token");
									hiddenToken.setAttribute("value" , "{{ csrf_token()}}");
									view.appendChild(iview);
									delte.appendChild(idelte);
									form.appendChild(hiddenDelite);
									form.appendChild(hiddenToken);
									form.appendChild(delte);
									div.className += "btn-group btn-group-sm";
									div.appendChild(view);
									div.appendChild(form);
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