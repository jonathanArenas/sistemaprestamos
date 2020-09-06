@extends('layouts.dashboard')
@section('title', 'Cancelar Recibo')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-disabled">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-5 col-12">
                           
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label for="General">Zonas</label>
                                        <select name="zona" id="zonas" class="form-control form-control-sm">
                                        <option disabled selected>ZONA</option>
                                        @foreach($zonas as $key => $zona)
                                        <option value="{{$zona->nombre}}">{{$zona->nombre}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">    
                                        <label for="Nombre">Sección</label>
                                        <select name="seccion" id="secciones" class="form-control form-control-sm">
                                        </select>
                                    </div>
                                </div>
						
                    </div>
                    
                    <div class="col-lg-5 col-12">
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
                    <div class="col-lg-2">
                        <div class="form-group">
                            <button type="button" id="btnSearch" class="btn btn-outline-info btn-block btn-xs">BUSCAR</button>
                            <button type="button" id="btnCancelar" class="btn btn-outline-danger btn-block btn-xs" disabled>CANCELAR</button>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="card-body table-responsive p-0"">
                <table class="table table-sm table-head-fixed table-hover text-nowrap" id="t">
                
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('extras')
<script>

let btnSearch = document.getElementById('btnSearch');
let btnCancelar = document.getElementById('btnCancelar');

btnSearch.addEventListener('click', function(){
        let desde = document.getElementById('desde').value;
        let hasta = document.getElementById('hasta').value; 
        let seccion = document.getElementById('secciones').value;

        console.log(desde+" "+hasta+" "+zona+" "+seccion);
  
});

$('#zonas').change(function(){
    $("#zonas option:selected").each(function(){
        var	query = $(this).text();
        secciones(query);
    }); 
});


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
                $('#secciones').empty();
                $('#secciones').append($('<option>',{
                    text: 'SECCIÓN',
                    selected: 'selected',
                }));
				for( var i = 0; i < response['data'].length ; i++){
					$('#secciones').append($('<option>',{
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

</script>
@endsection