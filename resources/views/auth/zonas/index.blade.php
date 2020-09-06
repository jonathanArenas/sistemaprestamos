@extends('layouts.dashboard')
@section('title','zonas')
@section('content')
@if ($errors->any())
    <div class="col-lg-6">
        <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
@hasrole('SuperUser|Prestamista')
<div class="row mb-2">
  <div class="col-lg-12">
  <button class="btn btn-primary float-right" data-toggle="modal" data-target="#registerZonaModal" data-whatever="@getbootstrap">Agregar zona</button>
  </div>
</div>
@endhasrole
@if($zonasOrd)
  <div class="row mb-1">
  @foreach($zonasOrd as $key => $zonas)
			<div class="col-lg-6">
				<div class="card card-info">
				<div class="card-header">
                	<h3 class="card-title">SECCIONES DE LA ZONA <strong>{{$zonas[0]['nombre']}}</strong></h3>
					<div class="card-tools">
					
              @hasrole('SuperUser|Prestamista')<button type="button" class="btn btn-tool" onclick="addSeccion('{{$zonas[0]['nombre']}}')"><i class="fas fa-plus-circle"></i></button>@endhasrole
							<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
							<i class="fas fa-minus"></i></button>
							<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
							<i class="fas fa-times"></i></button>
						
					</div>
              	</div>
				<div class="card-body table-responsive p-0">
						<table class="table table-hover text-nowrap" id="t">
							<thead>
								<tr>
									<th>#</th>
									<th>Nombre zona</th>
									<th>seccion</th>
								</tr>
							</thead>
							<tbody>
							@foreach($zonas as $key => $zona)
							<tr>
									<td>{{ $zona->id}} </td>
									<td>{{ $zona->nombre}}</td>
									<td>{{ $zona->seccion}}</td>	
								</tr>
								@endforeach
							</tbody>
						</table>			
					</div>
				</div>	
			</div>   
  @endforeach
  </div>
@endif

<div class="modal fade" id="registerZonaModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos | Nueva zona</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" action="{{route('zonas.store')}}" method="POST">
        {{csrf_field()}}
          <div class="form-group">
            <label class="col-form-label">Nombre</label>
            <input type="text" class="form-control input" name="nombre" id="nombre">
          </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="updateZonaModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  id="form" role="form" method="POST">
        {{method_field('PATCH')}}
        {{csrf_field()}}
          <div class="form-group">
            <p id="text"></p>
          </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
        <button type="submit" class="btn btn-success">SI</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('extras')
<script>
  function addSeccion(zona){
  $('#ModalLabel').empty();
  $('#text').empty();
  $('#ModalLabel').append(zona);
  $('#text').append("¿Está seguro de añadir una nueva sección a la zona "+zona+"?");
  $('#form').removeAttr("action");
  $('#form').attr("action", "http://127.0.0.1:8000/dashboard/zonas/"+zona);
  $('#updateZonaModal').modal();
}
</script>
@endsection