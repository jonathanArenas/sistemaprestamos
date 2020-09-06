@extends('layouts.dashboard')
@section('title', 'catalogo prestamos')
@section('content')

<div class="row mb-2">
	<div class="col-lg-12">
		  <a class="btn btn-primary float-right" href="{{route('catalogo.create')}}">Agregar</a>
	</div>
</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-info">
				<div class="card-header">
                <h3 class="card-title">Catálogo</h3>
                <div class="card-tools">
                 

            		<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              		<i class="fas fa-minus"></i></button>
            		<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              		<i class="fas fa-times"></i></button>
                 
                </div>
              </div>
					<div class="card-body table-responsive p-0">
						<table class="table table-sm table-hover text-nowrap" id="t">
							<thead>
								<tr>
									<th>#</th>
									<th>Concepto</th>
									<th>Interes</th>
                                    <th>Porcentaje</th>
									<th>Plazo de devolución</th>
                                    <th>Acción</th>
								</tr>
							</thead>
							<tbody>
							@foreach($catalogos as $key => $catalogo)
							<tr>
									<td>{{ $catalogo->id}} </td>
									<td>{{ $catalogo->nombre}}</td>
                                    <td>{{ $catalogo->interes}}</td>
                                    <td>{{ $catalogo->porcentaje}} %</td>
									<td>{{ $catalogo->num_plazodevolucion }} @if($catalogo->time_plazodevolucion == "ANIO") AÑO @elseif($catalogo->time_plazodevolucion == "ANIOS") AÑOS  @else {{$catalogo->time_plazodevolucion}} @endif </td>
									<td class="py-0 align-middle"">
											<div class="btn-group btn-group-sm">
												<a class="btn btn-warning btn-sm" href="{{route('catalogo.edit', $catalogo->id)}}"><i class="far fa-edit"></i></a>
												{!! Form::open(['route' => ['catalogo.destroy', $catalogo->id] , 'id' => 'formdelete'.$catalogo->id])!!}
												{{method_field('DELETE')}}
												{{csrf_field()}}
												<a onClick="eliminar('{{$catalogo->id}}', '{{$catalogo->concepto}}');" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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