@extends('layouts.dashboard')
@section('title', 'Cancelar Recibo')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-disabled">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-3 col-12">
                           
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <input type="radio" name="id" id="General" onclick="getRadio(this);" checked>
                                        <label for="General">En general</label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">    
                                        <input type="radio" name="id" id="Nombre" onclick="getRadio(this);">
                                        <label for="Nombre">Nombre C.</label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <input type="radio" name="id" id="Folio" onclick="getRadio(this);">
                                        <label for="Fólio">Fólio recibo</label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <input type="radio" name="id" id="Crédito" onclick="getRadio(this);">
                                        <label for="Crédito">Núm. Crédito</label>
                                    </div>
                                    <!--<div class="col-lg-6 col-md-6 col-6">
                                        <input type="radio" name="id" id="Zona y Sección" onclick="getRadio(this);">
                                        <label for="Zona y Sección">Zona y Sección</label>
                                    </div>-->
                                </div>
						
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="desde">Desde</label>
                                <input type="date" id="desde" name="desde" class="form-control form-control-sm">
                                </div>
                        
                            <div class="col-lg-6">
                                <label for="hasta">Hasta</label>
                                <input type="date" id="hasta" name="hasta" class="form-control form-control-sm">                           
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3" id="addCol">
                    <label for="Shearch">General</label>
                    <input type="text" class="form-control form-control-sm" id="Search" flat="General" disabled>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <button type="button" id="btnSearch" class="btn btn-outline-info btn-block btn-xs">CONSULTAR</button>
                            <button type="button" id="btnCancelar" class="btn btn-outline-danger btn-block btn-xs" disabled>CANCELAR</button>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="card-body table-responsive p-0"">
                <table class="table table-sm table-head-fixed table-hover text-nowrap" id="t">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Num</th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Pago</th>
                            <th>Total</th>
                            <th>Estatus</th>
                            <th>Cajero</th>
                        </tr>
                    </thead>
                
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('extras')
<script src="{{asset('js/jquery.dataTables.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.js')}}"></script>

<script>
var zonas = @json($zonas);
console.log(zonas);
let btnSearch = document.getElementById('btnSearch');
let btnCancelar = document.getElementById('btnCancelar');

btnSearch.addEventListener('click', function(){
        let search = document.getElementById('Search');
        let flat = search.getAttribute("flat");
       
        if(flat == "Nombre" || flat == "General"){
            let start = document.getElementById('desde');
            let end = document.getElementById('hasta');
            invoicesByNombreOrGeneral(flat, start.value, end.value, search.value);
        }
        if(flat == "Folio" || flat == "Crédito"){
            invoicesByFolioOrCredito(flat, search.value);
        }
});

btnCancelar.addEventListener('click', function(){

});

function getRadio(event){
    let addCol = document.getElementById('addCol');
    let inputDesde = document.getElementById('desde');
    let inputHasta = document.getElementById('hasta');
    cleanAllNodosById(addCol);
   
        inputDesde.disabled = true;
        inputHasta.disabled = true;
        console.log(event.id);
        let label = document.createElement("label");
        let input = document.createElement("input");

        label.innerHTML = event.id;
        input.className = "form-control form-control-sm";
        input.id = "Search";
        input.name = "Search";
        input.setAttribute("flat", event.id);
        addCol.appendChild(label);
        addCol.appendChild(input);
        if(event.id == "Nombre" || event.id == "General"){
            inputDesde.disabled = false;
            inputHasta.disabled = false;
            inputDesde.value = "";
            inputHasta.value = "";
        }
        if(event.id == "General"){
            input.disabled = true;
        }
        
    
    /*if(event.id == "Zona y Sección"){
        inputDesde.disabled = false;
        inputHasta.disabled = false;
        let divRow = document.createElement('div');
        let divColZonas = document.createElement('div');
        let divColSecciones = document.createElement('div');
        let labelZonas = document.createElement('label')
        let selectZonas = document.createElement('select');
        let labelSecciones = document.createElement('label')
        let selectSecciones= document.createElement('select');

        divRow.className = "row";
        divColZonas.className = "col-lg-6 col-6"
        divColSecciones.className = "col-lg-6 col-6"

        labelZonas.innerHTML = "Zonas";
        labelSecciones.innerHTML = "Secciones";
       
        selectZonas.className = "form-control form-control-sm";
        selectZonas.id = "selectZona";
        selectSecciones.className = "form-control form-control-sm";
        selectSecciones.id = "selectSeccion";
        let option = document.createElement("option");
        option.innerHTML = "ZONA";
        option.disabled = true;
        option.selected = true;
        selectZonas.appendChild(option);

        for(let value of zonas){
            let options = document.createElement("option");
            options.value = value.nombre;
            options.innerHTML = value.nombre;
            selectZonas.appendChild(options);
        }
        divColZonas.appendChild(labelZonas);
        divColZonas.appendChild(selectZonas);
    
        divColSecciones.appendChild(labelSecciones);
        divColSecciones.appendChild(selectSecciones);

        divRow.appendChild(divColZonas);
        divRow.appendChild(divColSecciones);

        addCol.appendChild(divRow);
        
            $('#selectZona').change(function(){
            $("#selectZona option:selected").each(function(){
                var	query = $(this).text();
                secciones(query);
                }); 
            });
    }*/
}

let invoicesByNombreOrGeneral = function(flat, start, end, key){
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        url: "{{route('invoicesAjax')}}",
        method: "POST",
        data:{
            flat: flat,
            dateStart: start, 
            dateEnd: end,
            keyText: key,
        }
    }).done(function(response){
        console.log(response);

                jQuery('#t').dataTable().fnDestroy();
                table = $('#t').DataTable({
                data: response['data'],
                language: {
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ningún dato disponible en esta tabla",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":    "",
                        "sSearch":         "Buscar:",
                        "sUrl":            "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        },
                        "buttons": {
                            "copy": "Copiar",
                            "colvis": "Visibilidad"
                        }
                    },
                columns: [
                    { "data": "id" },
                    { "data": "num" },
                    { "data": "nombre" },
                    { "data": "created_at" },
                    { "data": "Pagos" },
                    { "data": "total" },
                    {"data": "estatus"},
                    {"data": "Cajero"},
                ], 
                searching: true,
                paging:true,
                responsive: true,

            });
         
            //cleanAllNodosById(document.getElementById('t'));
    }).fail(function(jqXHR, textStatus, errorThrown){
        console.log(jqXHR.responseText);
        if(jqXHR.status == 419){
            window.location.replace("{{route('dashboard')}}");
        }
    });
}

/*
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
            console.log(response);
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

}
*/

let invoicesByFolioOrCredito = function(flat, key){
    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        url: "{{route('invoiceAjax')}}",
        method: "POST",
        data:{
            flat: flat,
            key: key,
        }
    }).done(function(response){
        jQuery('#t').dataTable().fnDestroy();
                table = $('#t').DataTable({
                data: response['data'],
                language: {
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ningún dato disponible en esta tabla",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":    "",
                        "sSearch":         "Buscar:",
                        "sUrl":            "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        },
                        "buttons": {
                            "copy": "Copiar",
                            "colvis": "Visibilidad"
                        }
                    },
                columns: [
                    { "data": "id" },
                    { "data": "num" },
                    { "data": "nombre" },
                    { "data": "created_at" },
                    { "data": "Pagos" },
                    { "data": "total" },
                    {"data": "estatus"},
                    {"data": "Cajero"},
                ], 
                searching: true,
                paging:true,
                responsive: true

            });
    }).fail(function(jqXHR, textStatus, errorThrown){
        console.log(jqXHR.responseText);
                if(jqXHR.status == 419){
                    window.location.replace("{{route('dashboard')}}");
                }
    });
}
let folio = "{{$folio}}";
console.log(folio);

</script>
@endsection