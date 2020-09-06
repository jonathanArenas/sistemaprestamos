@extends('layouts.dashboard')
@section('title', 'Prestamos')
@section('content')

<div class="row mb-2">
	<div class="col-lg-12">
		<button class="btn btn-primary float-right" id="prestamos">Nuevo</button>
	</div>
</div>
<div class="col-lg-12">
        <div class="card card-info">
            <div class="card-header">              
                <div class="row">
                        <div class="col-lg-2 col-md-2 col-4">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="nombre" value="nombre" onclick="getRadio(this);" name="r1" checked>
                                <label for="nombre">
                                Nombre Cliente
                                </label>
                            </div>
                        </div>
						<div class="col-lg-2 col-md-2 col-4">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="num" value="num" onclick="getRadio(this);" name="r1">
                                <label for="num">
                                Núm. Crédito
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 offset-lg-5 offset-md-5">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control input" id="inputBuscador" placeholder="BUSCAR">
                                <div class="input-group-append">
                                    <span class="btn btn-default"><i class="fas fa-search"></i></span>
                                    </div>
                            </div>
                        </div>
                </div>         
            </div>
            <div class="card-body table-responsive p-0" style="height: 380px; " >
					<table class="table table-sm table-head-fixed table-hover text-nowrap" id="t">
						<thead>
							<tr>
								<th>#</th>
								<th>Fecha de solicitud</th>
								<th>Nombre Cliente</th>
								<th>Capital solicitado</th>
								<th>Tipo de credito</th>
								<th>Estatus</th>
								<th>Express</th>
								<th>Vinculado</th>
								<th>Acción</th>										
							</tr>
						</thead>
						<tbody>
							@foreach($creditos as $key => $credito)
							<tr>
							<td>{{ $credito->num}} </td>
							<td>{{ $credito->fecha_desde->format('d/m/Y')}}</td>
							<td>{{ $credito->nombre}} {{$credito->paterno}} {{$credito->materno}}</td>
							<td>{{$credito->capital_solicitado}}</td>
							<td>{{$credito->interes_type}} </td>
							<td>
							@if($credito->estatus == "OTORGADO")
								<span class="badge bg-primary btn-block">{{$credito->estatus}}</span>
							@elseif($credito->estatus == "CANCELADO")
								<span class="badge bg-danger btn-block">{{$credito->estatus}}</span>
							@elseif($credito->estatus == "PAGADO")
								<span class="badge  bg-success btn-block">{{$credito->estatus}}</span>
							@elseif($credito->estatus == "POR CONCLUIR")
								<span class="badge  bg-warning btn-block">{{$credito->estatus}}</span>
							@endif
			
							</td>
							<td>
							@if($credito->express == 1)
								<span class="text-primary">SÍ</span>
							@else
								<span class="text-muted">NO</i></span>
							@endif
							</td>
							<td>
							@if($credito->vinculado == "NO")
								<span class="text-muted">NO</i></span>
							@else
								<a href="{{route('credito.show', $credito->vinculado)}}" target="_blank">{{ $credito->vinculado}}</a>
							@endif
							</td>
							<td class="py-0 align-middle">
								<div class="btn-group btn-group-sm">
									<a class="btn btn-info" href="{{route('credito.show', $credito->num)}}"><i class="fas fa-eye"></i></a>						
									<a class="btn btn-secondary" href="{{route('getCobranza', $credito->num)}}"><i class="fas fa-cash-register"></i></a>
								</div>
							</td>	
							</tr>			
							@endforeach
						</tbody>
					</table>            
            </div>
        </div>              
    </div>

	<div class="modal fade" id="catalogoPrestamos" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Puedes basarte al catalogo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="row">
   
            @foreach($catalogos as $key => $catalogo)
            <div class="col-lg-6">
              <a href="{{route('generar', $catalogo->id)}}" class="btn btn-block btn-outline-success btn-lg mb-2">{{$catalogo->nombre}}</a>
            </div>
            @endforeach
			@if((($catalogo->count())%2) == 0 )
            <div class="col-lg-12">
              <a href="{{route('generar')}}" class="btn btn-block btn-outline-success btn-lg mb-2">PERSONALIZADO</a>
            </div>
			@else
			<div class="col-lg-6">
              <a href="{{route('generar')}}" class="btn btn-block btn-outline-success btn-lg mb-2">PERSONALIZADO</a>
            </div>
			@endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>		
@endsection 
@section('extras')
<script>
let  input = document.getElementById('inputBuscador');
input.addEventListener("keyup", function(e){
	e.preventDefault();
	let inputRadio = document.getElementsByName("r1");
	let buscar;
	for(let i=0; i<inputRadio.length; i++){
		if(inputRadio[i].checked){
			buscar = inputRadio[i].value;
		}
	}

	console.log(input.value +" "+ buscar);

	$.ajax({
		headers:{
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
		url: "{{route('shearCredito')}}" ,
		method: 'POST',
		data:{
			buscar: buscar,
			query: input.value,
		}
	}).done(function(response){
		console.log(response['data']);
		let table = document.getElementById("t");
		clearTable(table);
		const dataHead = ["#","Fecha de solicitud", "Nombre cliente", "Capital solicitado", "Tipo de crédito", "Estatus", "Express", "Vinculado", "Acción"] 
		crearTable(dataHead, response['data'], table);

	}).fail(function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR.responseText);
	});
	
});

function clearTable(id){
	let idTable = id;
	if ( idTable.hasChildNodes() ){//removemos los nodos de la tabla
		while ( idTable.childNodes.length >= 1 ){
			idTable.removeChild(idTable.firstChild );
		}
	}
}

function crearTable(dataHead, data, table){
	//HEAD TABLE
	const thead = document.createElement("thead");
	const filaHead = document.createElement("tr");
	//BODY TABLE
	const tBody = document.createElement("tbody");

	//DATOS HEAD
	let sizeDataHead = dataHead.length;
	for (let i = 0; i < sizeDataHead; i++) {
		let celdaHead = document.createElement("th");
		let textCeldaHead = document.createTextNode(dataHead[i]);
		celdaHead.appendChild(textCeldaHead);
		filaHead.appendChild(celdaHead);
	}
	let sizeRowData = data.length;
	console.log(sizeRowData);
	for (let index = 0; index < sizeRowData; index++) {
		let row = document.createElement("tr");
		let dataRow = [data[index].num, data[index].fecha_desde, data[index].Cliente, data[index].interes_type, data[index].capital_solicitado, data[index].estatus, data[index].express, data[index].vinculado, "accion"];
		console.log(dataRow);
		let sizeDataRow = dataRow.length;
		for (let key = 0; key < sizeDataRow; key++) {
			let cell = document.createElement("td");
			if(key == 5){
				let span = document.createElement("span");
				if(dataRow[key] == "OTORGADO" ){
					span.innerHTML = "OTORGADO";
					span.className = "badge bg-primary btn-block";
				}else if(dataRow[key] ==  "CANCELADO"){
					span.innerHTML = "CANCELADO";
					span.className =  "badge bg-danger btn-block";
				}else if(dataRow[key] == "PAGADO"){
					span.innerHTML = "PAGADO";
					span.className = "badge  bg-success btn-block";
				}else if(dataRow[key] == "POR CONCLUIR"){
					span.innerHTML = "POR CONCLUIR";
					span.className = "badge  bg-warning btn-block";
				}
				cell.appendChild(span);
			}else if(key == 6){ 
				let span = document.createElement("span");
			   	if(dataRow[key] == 1){
					span.innerHTML = "SÍ";
					span.className = "text-center text-primary";
				}
				if(dataRow[key] == 0){
					span.innerHTML = "NO";
					span.className = "text-center text-muted";
				}
				cell.appendChild(span);
			}else if(key == 7){ 
			   	if(dataRow[key] == "NO"){
					let span = document.createElement("span");
					span.innerHTML = dataRow[key];
					span.className = "text-muted";
					cell.appendChild(span);
				}else{
					let a = document.createElement("a");
					let urlVinculado = "{{route('credito.show', 'id')}}"
					urlVinculado = urlVinculado.replace('id', dataRow[key]);
					a.setAttribute("href", urlVinculado);
					a.innerHTML = dataRow[key];
					cell.appendChild(a);	
				}
			}else if(dataRow[key] == "accion"){
				let div = document.createElement("div");
				let show = document.createElement("a");
				let charge = document.createElement("a");
				let iShow = document.createElement("i");
				let iCharge = document.createElement("i");

				let urlShow = "{{route('credito.show','id')}}";
				urlShow = urlShow.replace('id', dataRow[0]);
				   
				show.setAttribute("href", urlShow);
				show.className = "btn btn-info";
				iShow.className = "fas fa-eye";

				let urlCharge = "{{route('credito.show','id')}}";
				urlCharge = urlCharge.replace('id', dataRow[0]);

				charge.setAttribute("href", urlCharge);
				charge.className = "btn btn-secondary";
				iCharge.className = "fas fa-cash-register";

				show.appendChild(iShow);
				charge.appendChild(iCharge);
				div.appendChild(show);
				div.appendChild(charge);
				div.className = "btn-group btn-group-sm";
				cell.appendChild(div);
				cell.className = "py-0 align-middle";
			}else{
				let textCellBody = document.createTextNode(dataRow[key]);
           		cell.appendChild(textCellBody);
            	
			}
			row.appendChild(cell);
		}

		tBody.appendChild(row);  
	} 
	thead.appendChild(filaHead);
	table.appendChild(thead);
	table.appendChild(tBody);
}

function getRadio(e){
	let buscador = document.getElementById('inputBuscador');
	if(e.id == 'num'){
		buscador.setAttribute("onkeypress", "return Numbers(event);");
	}
	if(e.id == "nombre"){
		buscador.removeAttribute("onkeypress");
	}
}

$(document).ready(function(){
    $('#prestamos').click(function(e){
    $('#catalogoPrestamos').modal();   
    });
  });
</script>
@endsection