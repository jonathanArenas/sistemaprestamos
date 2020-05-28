@extends('layouts.dashboard')
@section('title','Generar Prestamo')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-secondary">
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
                                <input id="dateRequest" class="form-control" type="date">
                            </div>
                            <div class="col-lg-6">
                                <label for="">Prestamista</label>
                                <select name="" id="prestamista" class="form-control">
                                    <option value="JUAN">JUAN</option>
                                    <option value="OMAR">OMAR</option>
                                    <option value="EMPRESA">EMPRESA</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Capital solicitado</label>
                                <input type="text" id="capitalRequest" maxlength="6" class="form-control"  onkeypress="return Numbers(event);">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
            <div class="card card-info">
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
                        <div class="col-lg-6 col-6">
                            <label for="interesType">Interes</label>
                            @if(isset($catalogo))
                                <input id="interesType"  value="{{$catalogo->interes}}" type="text" class="form-control" disabled>
                            @else
                                <select id="interesType" class="form-control">
                                @foreach($intereses as $key => $interes)
                                    <option value="{{$interes}}">{{$interes}}</option>
                                @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="col-lg-3 col-6">
                            <label for="porcentaje">Porcentaje</label>
                            @if(isset($catalogo))
                                <input id="porcentaje" value="{{$catalogo->porcentaje}}" type="text" class="form-control" disabled>
                            @else
                                <input id="porcentaje" maxlength="2" onkeypress=" return Numbers(event);" type="text" class="form-control">
                            @endif
                        </div>
                        <div class="col-lg-3 col-6">
                                <label for="plazo">Plazo</label>
                                @if(isset($catalogo))
                                    <input id="numberPlazo" value="{{$catalogo->plazo}}" type="text" class="form-control" disabled>
                                @else
                                    <input id="numberPlazo" type="text" maxlength="2" onkeypress=" return Numbers(event);" class="form-control">
                                @endif
                        </div>
                        <div class="col-lg-6 col-6">
                                <label for="timePlazo">de devolución</label>
                                @if(isset($catalogo))
                                <select  id="timePlazo" class="form-control" disabled>
                                    <option value="{{$catalogo->define_tiempo}}" selected>{{$catalogo->define_tiempo}}</option>
                                </select>
                                @else
                                <select  id="timePlazo" class="form-control">
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
                        <div class="col-lg-6">
                            <label for="periodicidad">Cobrar</label>
                            @if(isset($catalogo))
                                <select id="cobro" class="form-control" disabled> 
                                    <option value="{{$catalogo->periodicidad_cobro}}">{{$catalogo->periodicidad_cobro}}</option>
                                </select>
                            @else
                                <select id="cobro" class="form-control"> 
                                    @foreach($periodicidad as $key => $periodo)
                                        <option value="{{$periodo}}">{{$periodo}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
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
            <div class="card-body" >
               
                <div class="row">
                    <div class="col-lg-12 table-responsive pt-0" id="t">
                        
                    </div>
                </div>
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

    function nativeTable(idTable, dataHead, dataBody){
        console.log(dataBody);
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
                        const idtable = document.getElementById("t");//optenemos el id de la tabla
                        if ( idtable.hasChildNodes() ){//removemos los nodos de la tabla
                            while ( idtable.childNodes.length >= 1 ){
                                idtable.removeChild(idtable.firstChild );
                            }
                        }

                        const table = document.createElement("table");
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
                                let datosCliente = [args['data'][i].id, args['data'][i].nombre, args['data'][i].paterno, args['data'][i].materno, args['data'][i].capital, "accion"];
                                let sizeDatosClientes = datosCliente.length;
                                for (let j = 0; j < sizeDatosClientes; j++) {
                                    let celda = document.createElement("td");
                                    if(j ==4 ){
                                        let inputCredito = document.createElement("input");                    
                                        inputCredito.setAttribute("id", datosCliente[0]);
                                        inputCredito.setAttribute("ondblclick", "activeInput(event)");
								        inputCredito.setAttribute("onBlur", "focusInput(event)");
                                        inputCredito.value = datosCliente[4];
                                        inputCredito.size = 10;
                                        inputCredito.setAttribute("readonly", true);
                                        inputCredito.className = "form-control form-control-sm";
                                        celda.appendChild(inputCredito);
                                    }else if(datosCliente[j] == "accion"){
                                        let buttonDesglose = document.createElement("button");
                                        let iButtonDesglose = document.createElement("i");
                                        let buttonCrear = document.createElement("button");
                                        let iButtonCrear = document.createElement("i");
                                        let div = document.createElement("div");
                                        buttonDesglose.className = "btn btn-info";
                                        iButtonDesglose.className = "fas fa-eye";
                                        iButtonDesglose.innerHTML = " Calcular pagos";
                                        buttonDesglose.setAttribute("onclick", "desglosePagos("+datosCliente[0]+")");
                                        buttonDesglose.appendChild(iButtonDesglose);
                                        div.appendChild(buttonDesglose);  
                                        
                                        buttonCrear.className = "btn btn-success";
                                        iButtonCrear.className = "fas fa-save";
                                        iButtonCrear.innerHTML = " Crear prestamo";
                                        buttonCrear.appendChild(iButtonCrear);
                                        div.appendChild(buttonCrear);
                                        div.className = "btn-group btn-group-sm";
                                        celda.appendChild(div);
                                        celda.className = "py-0 align-middle"  
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
                                if(datosHead[i] == "All"){
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
                                        checkbox.name = "cliente_id";
                                        checkbox.value = datosCliente[1];
                                        checkbox.id = "check" + datosCliente[1];
                                        label.setAttribute("for", "check" + datosCliente[1]);
                                        divCheck.appendChild(checkbox);
                                        divCheck.appendChild(label);
                                        divCheck.className = "icheck-primary";
                                        celda.appendChild(divCheck);
                                    }else if(datosCliente[j] == "TRUE"){
                                        let text = document.createTextNode("SI");
                                        celda.appendChild(text);
                                        celda.className = "bg-olive text-center";
                                    }else if(datosCliente[j] == "FALSE"){
                                        let text = document.createTextNode("NO");
                                        celda.appendChild(text);
                                        celda.className = "bg-orange text-center";
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
                        table.className = "table table-sm table-hover text-nowrap"; 
                        idtable.appendChild(table);
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
    		}else{
    			console.log('error');
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
        let capital = parseInt(valor);
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
                        datos['data'][index].capital = capital;
                        continue;
                    }else{
                        datos['data'].splice(index, 1);
                        --index;
                    }
                }
            }
        createTable(datos, true);
        }else{
            alert("El campo esta vacio");
        }

    });

    function desglosePagos(id){
        let dateRequest = document.getElementById('dateRequest').value;
        let capital = document.getElementById(id).value;
        let interesType = document.getElementById('interesType').value;
        let porcentaje = document.getElementById('porcentaje').value;
        let numberPlazo = document.getElementById('numberPlazo').value;
        let timePlazo = document.getElementById('timePlazo').value;
        let cobro = document.getElementById('cobro').value;
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
                    cobro: cobro,
                },
            }).done(function(msg){
                let head = ['Fecha', 'Núm. Pago', 'Vigente', 'al Capital', 'al Interes', 'Total del Pago'];
                nativeTable(tablePagos, head,msg);
                //console.log(msg);
                $('#modal-pagos').modal();     
			}).fail(function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR.responseText);
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

    function calcular(id){
        let date = document.getElementById('date').value;
        let monto = document.getElementById(id).value;
        let typeInteres = document.getElementById('interes');
        let porcertaje = document.getElementById('porcentaje');
        if(date == ''){
            date = new Date();
            date = date.toLocaleDateString();
        }
        alert(date);
        
    }

</script>
<script src="{{asset('js/jspdf.min.js')}}"></script>
<script src="{{asset('js/jspdf.plugin.autotable.min.js')}}"></script>
<script>
    $("#pdf").click(function(){
        let doc = new jsPDF();
        doc.autoTable({html: '#table-pdf'});
        doc.save('table.pdf');  
    })
    
</script>
@endsection