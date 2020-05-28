@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
<div class="row">

	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">PRESTAMO GRUPAL</h3>
			</div>
			<div class="panel-body">
				<br>
				<div class="form-group col-lg-3">
						<label><spam style="color: red">*</spam>Grupo</label>			
			   			<select name="grupo" id="group" class="form-control">
			   			
			   			</select>  				
				</div>
				{!! Form::open(['route'=>['grupal.store'], 'id'=>'formCrear','method'=>'POST']) !!}
				<div class="form-group col-lg-2">
					<label><spam style="color: red">*</spam>Prestamista</label>
					<select name="prestamista" class="form-control">
						<option value="EMPRESA">EMPRESA</option>
						<option value="VICTOR">VICTOR</option>
						<option value="OMAR">OMAR</option>
						
					</select>
					
				</div>
				<div class="form-group col-lg-2">
					<label><spam style="color: red">*</spam>Cantidad Solicitada</label>
					<input type="text" name="desembolso" onkeypress="return Numbers(event);" class="form-control" maxlength="6" minlength="4" required> 
				</div>
				<div class="form-group col-lg-3">
					<label><spam style="color: red">*</spam>Fecha de solicitud</label>
					<input type="date" id="date" name="date" class="form-control" required> 
				</div>
				<div class="form-group col-lg-2">
					<label><span>&nbsp;</span></label>
					<a id="dispersar" class="btn btn-primary form-control" > Dispersar</a> 
				</div>
				 
				 			<div id="key" class="form-group col-lg-3"></div>
				 			<div id="error" class="col-lg-9"></div>
							<div id="table" class="table-responsive col-lg-12" ></div>
				 {!! Form::close()!!}

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
		$('#dispersar').click(function(e){
			e.preventDefault();
			$.ajaxSetup({
				headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
			});

			$.ajax({
				url : "{{route('clientesgrupos')}}",
				method : 'POST',
				data: {
					grupo : $('#group').val(),
				},beforeSend: function() {

    				
  				},
			}).done(function(msg){
				if(msg != null){
					console.log(msg['clientes']);
					console.log(msg['grupokey']);
					console.log(msg['keyIndividual']);
					var desembolso = document.getElementsByName("desembolso")[0].value;
					var dispersion  =  (desembolso / (msg['clientes'].length )).toFixed(2); //sacamos el la dispersión indivual
					dispersion = Math.round(dispersion); //se redondea el número de la dispersión individual
					var SumaDisperDesem = (dispersion * msg['clientes'].length);
					if(SumaDisperDesem > desembolso ){
						alert("La suma de los prestamos individuales revaza el total de la cantidad solicitada, corregir prestamos individuales manualmente, Total: " + SumaDisperDesem);// 
					}
					
					var idtable = document.getElementById("table");//optenemos el id de la tabla
					if (idtable.childNodes.length != 0) {
							idtable.removeChild(idtable.firstChild); //removemos todos los nodos de la tabla
					}
					var idKey = document.getElementById("key");

					if (idKey.childNodes.length != 0) {
							idKey.removeChild(idKey.firstChild) // no es lo correcto pero funciona 
							idKey.removeChild(idKey.firstChild);; //removemos todos los nodos de la tabla
					}
					const label = document.createElement("label");
					const inputKey = document.createElement("input");


					var textLabel = document.createTextNode("Clave del prestamo");
					label.appendChild(textLabel);
					inputKey.setAttribute("id", "inputKey");
					inputKey.setAttribute("name", "id");
					inputKey.value = msg['grupokey'];
					inputKey.style.color= 'green';
					inputKey.className += " form-control";
					inputKey.setAttribute("readonly", true);
					idKey.appendChild(label);
					idKey.appendChild(inputKey);
					
					const table = document.createElement("table");
					const tbody = document.createElement("tbody");
					
					//HEAD TABLE
					const thead = document.createElement("thead");
					const filaHead = document.createElement("tr");
					var datosHead = ["KEY INDIVIDUAL","NOMBRE","APELLIDO PATERNO","APELLIDO MATERNO","PRESTAMO INDIVIDUAL"];
					for (var i = 0; i < datosHead.length; i++) {
						var celdaHead = document.createElement("th");
						var textCeldaHead = document.createTextNode(datosHead[i]);
						celdaHead.appendChild(textCeldaHead);
						filaHead.appendChild(celdaHead);
					}
					//END HEAD TABLE

				
					for (var i = 0; i < msg['clientes'].length  ; i++) {
						var fila = document.createElement("tr"); //elemento para la fila
						//var divDesglose = document.createElement("div"); // elemento para el div de divDesglose

						var datosCliente = [ msg['keyIndividual'][i].prestamoKey, msg['clientes'][i].nombre, msg['clientes'][i].paterno, msg['clientes'][i].materno, 
						"4", "5"];
						for (var j = 0; j <datosCliente.length; j++) {
							var celda = document.createElement("td");
						    var textCelda = document.createTextNode(datosCliente[j]);
							if(j == datosCliente[4]){ // PARA PODER CREAR UN INPUT DONDE PUEDA MANIPULAR  LOS DATOS SIN ENVIARLO A UN TEXNODE
								var input = document.createElement("INPUT");
								
								input.setAttribute("type", "Number");
								input.setAttribute("id", "input" + msg['clientes'][i].id);
								input.setAttribute("name", msg['clientes'][i].id);
								
								input.setAttribute("onclick", "activeInput(event)");
								input.setAttribute("onBlur", "focusInput(event)");
								input.setAttribute("readonly", true);
								if(SumaDisperDesem > desembolso ){// texto en rojo por fuera de rango en dispersión individual 
				
									input.value = dispersion;
									input.style.color= 'red';
							 	}else{
							 		input.value = dispersion;
									input.style.color= 'green';
							 	}
							 	//a.setAttribute("href", "#");
							 	//a.appendChild(textA);
							 	
								input.className += " form-control sum";
								celda.appendChild(input);
							}else if(j == datosCliente[5]){
								var a = document.createElement("a");
								var textA = document.createTextNode("Detalle");
								a.appendChild(textA);
								a.setAttribute("onclick", "showDesgloseIndividual("+msg['clientes'][i].id+")");
							    a.className += "btn btn-warning";
							 	
								celda.appendChild(a);
								
							}else{
								textCelda.className += "form-control";
								celda.appendChild(textCelda);
							}
							//fila.setAttribute("onclick", "showHide("+msg['clientes'][i].id+")");
							//fila.style.cursor = 'pointer';
							fila.appendChild(celda);
							

						}

						    /*divDesglose.setAttribute("id", msg['clientes'][i].id+"D");
						    divDesglose.className += "container";
						    divDesglose.style.display = 'none';
						    //divDesglose.style.width = 'auto';*/
							
						tbody.appendChild(fila)
						//tbody.appendChild(divDesglose);
							

					}
					table.appendChild(filaHead);
					table.appendChild(tbody);
					idtable.appendChild(table);
					table.className += " table table-hover";
					var buttonCrearPrestamo = document.createElement("a");
					buttonCrearPrestamo.setAttribute("id", "crear");
					buttonCrearPrestamo.appendChild(document.createTextNode("Crear prestamo"));
					buttonCrearPrestamo.setAttribute("onclick", "execute()");
					buttonCrearPrestamo.className += "btn btn-success btn-block float-right";
					table.appendChild(buttonCrearPrestamo);

				}else{
					console.log('error');
				}
			});
		});
	});

</script>

<script type="text/javascript">
	
	function activeInput(e){
		$id = e.target.id;
		$element = document.getElementById($id);
		$element.removeAttribute("readonly");

	}
	function focusInput(e){
		$id = e.target.id;
		$element = document.getElementById($id);
		$element.setAttribute("readonly", true);
		if (EqualsSum()) {
			DeleteErrorSum();
		}
	}

	function showDesgloseIndividual(e){
		
		var monto = $('#input'+e).val();
		var date = $('#date').val();
		//alert("enviar siguientes datos; " + "monto: " + monto + ", id" + e);
		//var uri = location.host+"/show/desglose/individual/"+e+"/"+monto+"";
		window.open("/show/desglose/individual/"+e+"/"+monto+"/"+date+"");
	}

	function execute(){	
				
		var inputKey = $('#inputKey').val();
		if(EqualsSum()){			
			var response = window.confirm("ESTAS SEGURO(A) DE CREAR EL SIGUIENTE PRESTAMO: " +inputKey);
			console.log(response);
		
			if (response) {
				document.getElementById("formCrear").submit();
			}
		}else{
			
			const textError = document.createTextNode("LA SUMA NO ES IGUAL A LA CANTIDAD SOLICITADA, VERIFIQUE LOS PRESTAMOS");
			const h6 = document.createElement("h6");
			h6.style.color = 'red'; 
			h6.appendChild(textError);
			error.appendChild(h6);
		}	
	}

	function EqualsSum(){//suma de los prestamos individuales
		var desembolso = document.getElementsByName("desembolso")[0].value;
		// Selecciona todos los elementos cuyo nombre de clase sea "sum"
		var inputs = document.getElementsByClassName("sum")
		var suma = 0;
		for (var i = 0; i < inputs.length; i++) {
	    	suma += Number(inputs[i].value);
		}

		if(suma == desembolso){
			return true;
		}else{
			return false;
		}
	}

	function DeleteErrorSum(){
		const error = document.getElementById("error");
			if (error.childNodes.length != 0) {
				error.removeChild(error.firstChild);
		}
	}
	
			
		
</script>

@endsection