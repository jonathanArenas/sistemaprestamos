@extends('layouts.dashboard')
@section('title','Generar Prestamo')
@section('content')
<div class="row" id="alert">
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">DATOS</h3>
                        <div class="card-tools">    
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">Fecha Solicitud</label>
                                <input id="dateRequest" class="form-control form-control-sm" type="date">
                            </div>
                            <div class="col-lg-6">
                                <label for="">Prestamista</label>
                                <select id="prestamista" class="form-control form-control-sm">
                                    @foreach($prestamistas as $key => $prestamista)
                                        <option value="{{$prestamista->id}}">{{$prestamista->username}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Capital</label>
                                <input type="text" id="capitalRequest" maxlength="6" class="form-control form-control-sm"  onkeypress="return Numbers(event);">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">TIPO DE PRESTAMO | @if(isset($catalogo)){{$catalogo->nombre}}@else PERSONALIZADO @endif</h3>
                    <div class="card-tools">    
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-6">
                            <label for="interesType">Interes</label>
                            @if(isset($catalogo))
                                <input id="interesType"  value="{{$catalogo->interes}}" type="text" class="form-control form-control-sm" disabled>
                            @else
                                <select id="interesType" class="form-control form-control-sm">
                                @foreach($intereses as $key => $interes)
                                    <option value="{{$interes}}">{{$interes}}</option>
                                @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="col-lg-4 col-6">
                            <label for="porcentaje">Porcentaje</label>
                            @if(isset($catalogo))
                                <input id="porcentaje" type="text"  value="{{$catalogo->porcentaje}}" class="form-control form-control-sm" disabled>
                            
                            @else
                                <input id="porcentaje"  type="text" onkeypress=" return Numbers(event);"  class="form-control form-control-sm">
                            @endif
                        </div>
                        <div class="col-lg-4 col-6">
                                <label for="plazo">Plazo de </label>
                                @if(isset($catalogo))
                                    <input id="numberPlazo" value="{{$catalogo->num_plazodevolucion}}" type="text" class="form-control form-control-sm" disabled>
                                @else
                                    <input id="numberPlazo" type="text" maxlength="2" onkeypress=" return Numbers(event);" class="form-control form-control-sm">
                                @endif
                        </div>
                        <div class="col-lg-4 col-6">
                                <label for="timePlazo">devolución</label>
                                @if(isset($catalogo))
                                <select  id="timePlazo" class="form-control form-control-sm" disabled>
                                    <option value="{{$catalogo->time_plazodevolucion}}" selected>{{$catalogo->time_plazodevolucion}}</option>
                                </select>
                                @else
                                <select  id="timePlazo" class="form-control form-control-sm">
                                    @foreach($defineTiempo as $key => $tiempo)
                                        @if($tiempo == "AÑOS")
                                            <option value="ANIOS">AÑOS</option>
                                            @continue
                                        @endif
                                        <option value="{{$tiempo}}">{{$tiempo}}</option>
                                    @endforeach
                                </select>
                                @endif                                
                        </div>
                        <div class="col-lg-4 col-6">
                            <label for="">D. Cobranza</label>
                            @if(isset($catalogo))
                                <input type="text" class="form-control form-control-sm" value="{{$catalogo->no_cobranza}}" name="no_cobranza" id="no_cobranza" disabled>
                            @else
                            <select name="no_cobranza" id="no_cobranza" class="form-control form-control-sm">
                                @foreach($no_cobranza as $key => $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                        <div class="col-lg-4 col-6">
                            <label for="tarifa_cargos">T. cargos</label>
                            @if(isset($catalogo))
                                <input type="text" class="form-control form-control-sm" name="tarifa_cargos" id="tarifa_cargos" value="{{$catalogo->tarifa_cargos}}" disabled>
                            @else
                            <input type="text" class="form-control form-control-sm" name="tarifa_cargos" id="tarifa_cargos">
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card card-olive">
            <div class="card-header">              
                <div class="row">
                        <div class="col-lg-2 col-md-2 col-4">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="showZona" onclick="getRadio(this);" name="r1">
                                <label for="showZona">
                                Por zona y sección
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-4">
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="showName" onclick="getRadio(this); "name="r1">
                                <label for="showName">
                                Por nombre
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 offset-lg-4 offset-md-4" id="zona" style="display:none">
                            <div class="form-group input-group-sm">
                                <select class="form-control" name="zona" id="selectZona">
                                <option disabled selected>ZONA</option>
                                @foreach($zonas as $key => $zona)
                                <option value="{{$zona->nombre}}">{{$zona->nombre}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div  class="col-lg-2 col-md-2" id="seccion" style="display:none">
                            <div class="form-group input-group-sm">
                                <select class="form-control" name="seccion" id="selectSeccion">
                                    <option disabled selected>SECCIÓN</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 offset-lg-5 offset-md-5" id="name" style="display:none">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control input" id="inputName" placeholder="NOMBRE">
                                <div class="input-group-append">
                                    <span class="btn btn-default"><i class="fas fa-search"></i></span>
                                    </div>
                            </div>
                        </div>
                </div>         
            </div>
            <div class="card-body table-responsive pt-0" style="height: 320px;" >
                    <table class="table table-sm table-head-fixed text-nowrap" id="t">
                        
                    </table>
            </div>
            <div class="card-footer">
                <input id="dispersar" type="button" value="DISPERSAR" class="btn btn-info float-right" style="display:none">
            </div>
        </div>              
    </div>
    <div class="modal fade" id="modal-pagos" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Calculo de pagos a realizar</h4>
    
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
              <div class="col-12">
                <button type="button" class="btn btn-primary btn-sm float-right" id="pdf">PDF</button>
              </div>
                <div class="col-lg-12 table-responsive pt-0" id="table-pagos">

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-gray float-right" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>  
</div>

 <!-- Modal for select cobrador and save prestamo-->
    <div class="modal fade" id="modal-save" tabindex="-1" role="dialog" aria-labelledby="modalLabelSave" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="load">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelSave">Selecciona un cobrador para este prestamo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <select class="form-control" name="cobrador" id="cobrador">
                        @foreach($cobradores as $key => $cobrador)
                        <option value="{{$cobrador->id}}">{{$cobrador->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="save" class="btn btn-success">Guardar</button>
            </div>
            </div>
        </div>
    </div>
@endsection
@section('extras')
<script>
    var datos;
    function getRadio(e){
        
        let zona = document.getElementById('zona');
        let seccion = document.getElementById('seccion');
        let name = document.getElementById('name');
        let btnDispersar = document.getElementById('dispersar');
        if(e.id == 'showZona'){
            clearTable();
            name.style = 'display:none';
            zona.style = 'display:block';
            seccion.style = 'display:block';
            btnDispersar.style = 'display:none';
        }if(e.id == 'showName') {
            clearTable();
            name.style = 'display:block';
            zona.style = 'display:none';
            seccion.style = 'display:none';
            btnDispersar.style = 'display:none';
            $('#inputName').keyup(function(a){
                a.preventDefault();
                var keyShear = $(this).val();
                tableAjax(keyShear, e.id);
            });
        } 
    }

    let inputCapitalRequest = document.getElementById('capitalRequest');
    let inputTarifa = document.getElementById('tarifa_cargos');

    inputCapitalRequest.addEventListener('keyup', function(e){
        formatCurrency(inputCapitalRequest);
    });

    inputCapitalRequest.addEventListener('blur', function(e){
        formatCurrency(inputCapitalRequest, "blur")
    });

    inputTarifa.addEventListener('keyup', function(e){
        formatCurrency(inputTarifa);
    });

    inputTarifa.addEventListener('blur', function(e){
        formatCurrency(inputTarifa, "blur")
    });


    function nativeTable(idTable, dataHead, dataBody){
        if ( idTable.hasChildNodes()){//removemos los nodos de la tabla
            while ( idTable.childNodes.length >= 1 ){
            idTable.removeChild(idTable.firstChild );
            }
        }
        const table = document.createElement("table");
		const tBody = document.createElement("tbody");					
		//HEAD TABLE
		const tHead = document.createElement("thead");
		const rowHead = document.createElement("tr");
        let sizeDataHead = dataHead.length;
        let sizeDataBody = dataBody.length;
        for (let i = 0; i < sizeDataHead; i++) {
            let cellHead = document.createElement("th"); 
            let textCellHead = document.createTextNode(dataHead[i]);
            cellHead.appendChild(textCellHead);
            rowHead.appendChild(cellHead);   
        }
        tHead.appendChild(rowHead);
        tHead.className = "thead-light";
        for (let i = 0; i < sizeDataBody; i++) {
            let row = document.createElement("tr");
            let dataRow = dataBody[i];
            let sizeDataRow = dataRow.length;
            if(Array.isArray(dataRow)){
                for (let index = 0; index < sizeDataRow; index++) {
                    let cell = document.createElement("td");
                    let textCellBody = document.createTextNode(dataRow[index]);
                    cell.appendChild(textCellBody);
                    row.appendChild(cell);
                } 
            }else{
                for( index in dataRow){
                    let cell = document.createElement("td");
                    let textCellBody = document.createTextNode(dataRow[index]);
                    cell.appendChild(textCellBody);
                    row.appendChild(cell);
                }
            }
            tBody.appendChild(row);  
        }
        table.appendChild(tHead);
        table.appendChild(tBody);
        table.id = "table-pdf";
        table.className = "table table-sm table-hover  text-nowrap";
        idTable.appendChild(table);
    }


    function createTable(args, dispersar = false){
                    console.log(args);
				        if( args['data'] != false){
                        const table = document.getElementById("t");//optenemos el id de la tabla
                        if ( table.hasChildNodes() ){//removemos los nodos de la tabla
                            while ( table.childNodes.length >= 1 ){
                                table.removeChild(table.firstChild );
                            }
                        }

					    const tBody = document.createElement("tbody");
					
					//HEAD TABLE
					    const tHead = document.createElement("thead");
					    const filaHead = document.createElement("tr");
                        if(dispersar){
                            let datosHead = ["#", "NOMBRE", "APELLIDO PATERNO", "APELLIDO MATERNO", "$ CREDITO", "ACCIÓN"];
                            let sizeHead = datosHead.length;
                            for (let i = 0; i < sizeHead; i++) {
                                let celdaHead = document.createElement("th"); 
                                    let textCeldaHead = document.createTextNode(datosHead[i]);
                                    celdaHead.appendChild(textCeldaHead);
                                
                                filaHead.appendChild(celdaHead);
                            }
                            tHead.appendChild(filaHead);
                            tHead.className = "thead-light";   
                            //START BODY TABLE ROWS
                            for (let i = 0; i < args['data'].length  ; i++) {
                                let fila = document.createElement("tr"); //elemento para la fila
                                let datosCliente = [args['data'][i].id, args['data'][i].nombre, args['data'][i].paterno, args['data'][i].materno, args['data'][i].capital, args['data'][i].express, "accion"];
                                let sizeDatosClientes = datosCliente.length;
                                for (let j = 0; j < sizeDatosClientes; j++) {
                                    let celda = document.createElement("td");
                                    if(j == 4){
                                        let inputCredito = document.createElement("input");                    
                                        inputCredito.setAttribute("id", datosCliente[0]);
                                        inputCredito.setAttribute("express", datosCliente[5])
                                        inputCredito.setAttribute("ondblclick", "activeInput(event)");
                                        inputCredito.setAttribute("onBlur", "focusInput(event)");
                                        inputCredito.setAttribute("onkeypress", "return Numbers(event)");
                                        inputCredito.value = datosCliente[4];
                                        inputCredito.size = 10;
                                        inputCredito.setAttribute("readonly", true);
                                        inputCredito.className = "form-control form-control-sm";
                                        celda.appendChild(inputCredito);
                                    }else if(j == 5){
                                        continue;
                                    }else if(datosCliente[j] == "accion"){
                                        let buttonDesglose = document.createElement("button");
                                        let iButtonDesglose = document.createElement("i");
                                        let buttonCrear = document.createElement("button");
                                        let iButtonCrear = document.createElement("i");
                                        let div = document.createElement("div");
                                        buttonDesglose.className = "btn btn-info";
                                        buttonDesglose.id = "desglose"+datosCliente[0];
                                        iButtonDesglose.className = "fas fa-eye";
                                        iButtonDesglose.innerHTML = " Calcular pagos";
                                        buttonDesglose.setAttribute("onclick", "desglosePagos("+datosCliente[0]+", event)");
                                        buttonDesglose.appendChild(iButtonDesglose);
                                        div.appendChild(buttonDesglose);  
                                        
                                        buttonCrear.className = "btn btn-success";
                                        buttonCrear.id = "crear"+datosCliente[0];
                                        iButtonCrear.className = "fas fa-save";
                                        iButtonCrear.innerHTML = " Crear prestamo";
                                        buttonCrear.setAttribute("onclick", "generar("+datosCliente[0]+", event)");
                                        buttonCrear.appendChild(iButtonCrear);
                                        div.appendChild(buttonCrear);
                                        div.className = "btn-group btn-group-sm";
                                        celda.appendChild(div);
                                        celda.align = "center";
                                        
                                    }else{
                                        let textCelda = document.createTextNode(datosCliente[j]);
                                        celda.appendChild(textCelda);
                                    }                                
                                    fila.appendChild(celda);		
                                }
                                tBody.appendChild(fila)
                            }
                        }else{
                            //TABLE FOR SELECT CLIENTS
                            let datosHead = ["ALL","#","NOMBRE","APELLIDO PATERNO","APELLIDO MATERNO", "ACRÉDITA"];
                            let sizeHead = datosHead.length;
                             //START HEAD TABLE
                            for (let i = 0; i < sizeHead; i++) {
                                let celdaHead = document.createElement("th");
                                if(datosHead[i] == "ALL"){
                                    let link = document.createElement("a");
                                    link.href = "#t";
                                    link.setAttribute("onclick", "selectAll(this)");
                                    //link.setAttribute("onclick","allSelection()");
                                    link.innerHTML = "✓";
                                    celdaHead.appendChild(link);
                                    filaHead.appendChild(celdaHead);
                                }else{
                                    let textCeldaHead = document.createTextNode(datosHead[i]);
                                    celdaHead.appendChild(textCeldaHead);
                                    filaHead.appendChild(celdaHead);
                                }   
                            }
                            tHead.appendChild(filaHead);
                            tHead.className = "thead-light";
                            //END HEAD TABLE
                            //START BODY TABLE ROWS
                            for (let i = 0; i < args['data'].length  ; i++) {
                                let fila = document.createElement("tr"); //elemento para la fila
                                let datosCliente = ["0", args['data'][i].id, args['data'][i].nombre, args['data'][i].paterno, args['data'][i].materno, args['data'][i].estatus];
                                for (let j = 0; j <datosCliente.length; j++) {
                                    let celda = document.createElement("td");
                                    if(datosCliente[j]== "0"){
                                        let divCheck = document.createElement("div");
                                        let checkbox = document.createElement("input");
                                        let label = document.createElement("label");

                                        checkbox.type = "checkbox";
                                        checkbox.className ="form-check-input";
                                        checkbox.name = "cliente_id";
                                        checkbox.value = datosCliente[1];
                                        checkbox.id = "check" + datosCliente[1];
                                        label.setAttribute("for", "check" + datosCliente[1]);
                                        label.className = "form-check-label";
                                        divCheck.appendChild(checkbox);
                                        divCheck.appendChild(label);
                                        divCheck.className = "form-check";
                                        celda.appendChild(divCheck);
                                    }else if(datosCliente[j] == "TRUE"){
                                        let text = document.createTextNode("SI");
                                        celda.appendChild(text);
                                        celda.className = "bg-olive text-center";
                                    }else if(datosCliente[j] == "FALSE"){
                                        let text = document.createTextNode("NO");
                                        celda.appendChild(text);
                                        celda.className = "bg-orange text-center";
                                    }else if(datosCliente[j] == "EXPRESS"){
                                        let text = document.createTextNode("EXPRESS");
                                        celda.appendChild(text);
                                        celda.className = "bg-primary text-center";
                                    }else{
                                        let textCelda = document.createTextNode(datosCliente[j]);
                                        celda.appendChild(textCelda);
                                    }
                                    fila.appendChild(celda);		
                                }
                                tBody.appendChild(fila)
                            }
                        }
                        table.appendChild(tHead);
                        table.appendChild(tBody);
				}else{
                    clearTable();
				}
    }
    
    let tableAjax = function(shear, type = null){   
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                url: "{{route('clienteShow')}}",
                method: "POST",
                data:{
                    query: shear,
                    type: type,
                },
            }).done(function(msg){
                datos = msg;
                createTable(msg);
                let btnDispersar = document.getElementById("dispersar");
                btnDispersar.style = "display:block";    
			});
    }; 
    
    let clearTable = function(){
        let idtable = document.getElementById("t");//optenemos el id de la tabla
			if ( idtable.hasChildNodes() ){//removemos los nodos de la tabla
				while ( idtable.childNodes.length >= 1 ){
					idtable.removeChild(idtable.firstChild );
				}
            }
    };

    let secciones = function(zona){
        $.ajax({
        headers: {
           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        url:"{{route('showSecciones')}}",
        method: "POST",
        data:{
            query: zona,
        }
        }).done(function(response){
            if (response != null) {
                console.log(response);
                $('#selectSeccion').empty();
                $('#selectSeccion').append($('<option>',{
                    text: 'SECCIÓN',
                    selected: 'selected',
                }));
				for( var i = 0; i < response['data'].length ; i++){
					$('#selectSeccion').append($('<option>',{
						value: response['data'][i]['id'],
						text: response['data'][i]['seccion'],                    
					}));
				}
    		}
        }).fail(function(jqXHR, textStatus, errorThrown){
                if(jqXHR.status == 419){
                    window.location.replace("{{route('dashboard')}}");
                }
        });
    };

    $('#selectZona').change(function(){
        $("#selectZona option:selected").each(function(){
        var	query = $(this).text();
            secciones(query);
        }); 
    });

    $('#selectSeccion').change(function(){
                $("#selectSeccion option:selected").each(function(){
                 var	query = $(this).val();
                 tableAjax(query, 'showZona');
                });
    });
    
    function selectAll(e){
        let innerH = e.innerHTML;
        
        let checkboxs = document.getElementsByName('cliente_id');
        if(innerH == "✓"){
            for (let index = 0; index < checkboxs.length; index++) {
                const element = checkboxs[index];
                 element.checked = true;
            }
            e.innerHTML = 'X';
        }else{
            for (let index = 0; index < checkboxs.length; index++) {
                const element = checkboxs[index];
                 element.checked = false;
            }
            e.innerHTML = '✓';
        }
    }
    function activeInput(e){
		$id = e.target.id;
		$element = document.getElementById($id);
		$element.removeAttribute("readonly");

	}
	function focusInput(e){
		$id = e.target.id;
		$element = document.getElementById($id);
		$element.setAttribute("readonly", true);
	}

    $('#dispersar').click(function(){
        let valor = document.getElementById("capitalRequest").value;
        let capital = parseInt(eraseNumber(valor));
        //alert(cantidad);
        let checkBoxChecked = new Array();
        if(!isNaN(capital) ){
            let checkboxs = document.getElementsByName('cliente_id');
            let key = 0;
            for(let index = 0; index< checkboxs.length; index++){
                const element = checkboxs[index];
                if(element.checked == true){
                    checkBoxChecked[key]= element.value;
                    key++;
                }else{
                    continue;
                }
            }
            
            if(checkBoxChecked != null && capital != null){
                for (let index = 0; index < datos['data'].length;index++) {
                    if(inArray(datos['data'][index].id, checkBoxChecked) && datos['data'][index].estatus == "TRUE"){
                        datos['data'][index].capital = valor;
                        datos['data'][index].express = 0;
                        continue;
                    }else if(inArray(datos['data'][index].id, checkBoxChecked) && datos['data'][index].estatus == "EXPRESS"){
                        datos['data'][index].capital = valor;
                        datos['data'][index].express = 1;
                        continue;
                    }else{
                        datos['data'].splice(index, 1);
                        --index;
                    }
                }
            }

        createTable(datos, true);
        let btnDispersar = document.getElementById('dispersar');
        btnDispersar.style = 'display:none';
        }else{
            alert("El campo esta vacio");
        }

    });

    function desglosePagos(id){
     
        let dateRequest = document.getElementById('dateRequest').value;
        let capital = eraseNumber(document.getElementById(id).value);
        let interesType = document.getElementById('interesType').value;
        let porcentaje = document.getElementById('porcentaje').value;
        let numberPlazo = document.getElementById('numberPlazo').value;
        let timePlazo = document.getElementById('timePlazo').value;
        let no_cobranza = document.getElementById('no_cobranza').value;
        let tarifa_cargos = eraseNumber(document.getElementById('tarifa_cargos').value);
        let cobrador = document.getElementById('cobrador').value; 
        let prestamista = document.getElementById('prestamista').value;
        let tablePagos = document.getElementById('table-pagos');      
        $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                url: "{{route('desglose')}}",
                method: "POST",
                data:{
                    id: id,
                    dateRequest: dateRequest,
                    capital: capital,
                    interesType: interesType,
                    porcentaje: porcentaje,
                    devolucion: { numberPlazo: numberPlazo, timePlazo:timePlazo},
                    no_cobranza: no_cobranza,
                    tarifa_cargos: tarifa_cargos,
                    cobrador: cobrador,
                    prestamista: prestamista,
                },
            }).done(function(msg){
                console.log(msg);
                let head = ['Fecha', 'Núm. Pago', 'Vigente', 'al Capital', 'al Interes', 'Total del Pago'];
                nativeTable(tablePagos, head,msg['desglose']);
                $('#modal-pagos').modal();
                
			}).fail(function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR.responseText);
                if(jqXHR.status == 422){
                    let alert = document.getElementById("alert");
                    if(alert.hasChildNodes()){
                        while ( alert.childNodes.length >= 1 ){
                                alert.removeChild(alert.firstChild );
                            }
                    }    
                    let divCol = document.createElement("div");
                    let divClass = document.createElement("div");
                    let button = document.createElement("button");
                    let h5 = document.createElement("h5");
                    let i = document.createElement("i");
                    let ul = document.createElement("ul");
                        divCol.className = "col-lg-6";
                        divClass.className = "alert alert-danger alert-dismissible";
                        button.type = "button";
                        button.className = "close";
                        button.setAttribute("data-dismiss", "alert");
                        button.setAttribute("aria-hidden", "true");
                        button.innerHTML = "x";
                        i.className = "icon fas fa-ban";
                        h5.appendChild(i);
                        h5.innerHTML = "Alerta";
                   
                    for (const key in jqXHR.responseJSON['errors']) {
                        if (jqXHR.responseJSON['errors'].hasOwnProperty(key)) {
                            let li = document.createElement("li");
                            li.innerHTML = jqXHR.responseJSON['errors'][key];
                            ul.appendChild(li);
                        }
                    }  
                    divClass.appendChild(h5);
                    divClass.appendChild(button);
                    divClass.appendChild(ul);
                    divCol.appendChild(divClass);
                    alert.appendChild(divCol);
                }else if(jqXHR.status == 419){
                    window.location.replace("{{route('dashboard')}}");
                }
                
            }); 
    }

    function generar(id, e){
        e.preventDefault();
        let idSave = document.getElementById('save');
        idSave.setAttribute('onclick', 'save('+id+')');
        $('#modal-save').modal();    
    }
    


    function rediretCredito(id,num){
        let btnCredito = document.getElementById("crear"+id);
        let btnDesglose = document.getElementById("desglose"+id);
        btnCredito.removeChild(btnCredito.firstChild);
        btnCredito.innerHTML = "Ver Credito";
        console.log(typeof num);
        num = num.replace(/0/g,"");
        console.log(num);
        btnCredito.setAttribute("onclick", `show(${num})`);
        btnDesglose.disabled = true;
    }

    function save(id){
            let cobrador = document.getElementById('cobrador').value;
            let prestamista = document.getElementById('prestamista').value;
            let dateRequest = document.getElementById('dateRequest').value;
            let capital = eraseNumber(document.getElementById(id).value);
            let interesType = document.getElementById('interesType').value;
            let porcentaje = document.getElementById('porcentaje').value;
            let numberPlazo = document.getElementById('numberPlazo').value;
            let timePlazo = document.getElementById('timePlazo').value;
            let no_cobranza = document.getElementById('no_cobranza').value;
            let tarifa_cargos = eraseNumber(document.getElementById('tarifa_cargos').value);
            console.log(capital);
            console.log(cobrador);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                url:"{{route('credito.store')}}",
                method: "POST",
                data:{
                    id: id,
                    dateRequest: dateRequest,
                    capital: capital,
                    interesType: interesType,
                    porcentaje: porcentaje,
                    devolucion: { numberPlazo: numberPlazo, timePlazo:timePlazo},
                    no_cobranza: no_cobranza,
                    tarifa_cargos: tarifa_cargos,
                    cobrador: cobrador,
                    prestamista: prestamista,
                },beforeSend: function() {
                        load();
  				},
            }).done(function(msg){
                console.log(msg);
                if(msg['data'][0]){ 
                    toastr.success('Se ha realizado un nuevo prestamo con núm: ' +msg['data'][1]);
                    rediretCredito(id, msg['data'][1]);
                }else{
                    hideLoad();
                }
            }).always(function(event, request, settings){
                hideLoad();
    		}).fail(function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR.responseText);
                if(jqXHR.status == 422){
                    let alert = document.getElementById("alert");
                    if(alert.hasChildNodes()){
                        while ( alert.childNodes.length >= 1 ){
                                alert.removeChild(alert.firstChild );
                            }
                    }    
                    let divCol = document.createElement("div");
                    let divClass = document.createElement("div");
                    let button = document.createElement("button");
                    let h5 = document.createElement("h5");
                    let i = document.createElement("i");
                    let ul = document.createElement("ul");
                        divCol.className = "col-lg-6";
                        divClass.className = "alert alert-danger alert-dismissible";
                        button.type = "button";
                        button.className = "close";
                        button.setAttribute("data-dismiss", "alert");
                        button.setAttribute("aria-hidden", "true");
                        button.innerHTML = "x";
                        i.className = "icon fas fa-ban";
                        h5.appendChild(i);
                        h5.innerHTML = "Alerta";
                   
                    for (const key in jqXHR.responseJSON['errors']) {
                        if (jqXHR.responseJSON['errors'].hasOwnProperty(key)) {
                            let li = document.createElement("li");
                            li.innerHTML = jqXHR.responseJSON['errors'][key];
                            ul.appendChild(li);
                        }
                    }  
                    divClass.appendChild(h5);
                    divClass.appendChild(button);
                    divClass.appendChild(ul);
                    divCol.appendChild(divClass);
                    alert.appendChild(divCol);
                }else if(jqXHR.status == 419){
                    window.location.replace("{{route('dashboard')}}");
                }
            });
    }

    function inArray(needle, hayStack){
        let sizeArray = hayStack.length;
        for(let index = 0; index < sizeArray; index++ ){
          if(needle == hayStack[index]){
              return true;
          }else{
              continue;
          }
        }
        return false;
    }

    function show(credito){
        console.log(credito);
        let url = "{{route('credito.show','id')}}"
        url = url.replace('id', credito);
        window.open(url);
    }

</script>
<script src="{{asset('js/jspdf.min.js')}}"></script>
<script src="{{asset('js/jspdf.plugin.autotable.min.js')}}"></script>
<script src="{{asset('js/toastr.min.js')}}"></script>
<script>
    $("#pdf").click(function(){
        let doc = new jsPDF();
        doc.autoTable({html: '#table-pdf'});
        doc.save('table.pdf');  
    })
    
</script>
@endsection