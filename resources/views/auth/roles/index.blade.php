@extends('layouts.dashboard')
@section('title', 'Permisos')
@section('content')
<div class="row mb-2">
	<div class="col-lg-12">
		<div class="margin float-right">
			<div class="btn-group">
				<a class="btn btn-primary" href="{{route('roles.create')}}">Agregar</a>
			</div>
		</div>
	</div>
</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-secondary">
					<div class="card-header">
						<h3 class="card-title">Roles</h3>
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
					<table class="table table-hover text-nowrap" id="t">
						<thead>
							<tr>
								<th>#</th>
								<th>Nombre del Role </th>
								<th>Tipo</th>
								<th>Descripción</th>
								@role('SuperUser')
								<th>Acción</th>
								@endrole
							</tr>
						</thead>
						<tbody>
							<tr>
								@foreach($roles as $key => $rol)
								<tr>
									<td>{{ $rol->id}} </td>
									<td>{{ $rol->name}}</td>
									<td>{{ $rol->guard_name}}</td>
									<td>{{ $rol->descripcion}} </td>
									@role('SuperUser')
									<td class="py-0 align-middle"">
											<div class="btn-group btn-group-sm">
												<a class="btn btn-warning" href="{{route('roles.edit', $rol->id)}}"><i class="fas fa-eye"></i></a>
												{!! Form::open(['route' => ['roles.destroy', $rol->id] , 'id' => 'formdelete'.$rol->id])!!}
												{{method_field('DELETE')}}
												{{csrf_field()}}
												<a onClick="eliminar('{{$rol->id}}', '{{$rol->name}}');" class="btn btn-danger"><i class="fas fa-trash"></i></a>
												{!! Form::close() !!}
												</div>
									</td>
									@endrole
								</tr>
								@endforeach
							</tr>
						</tbody>
					</table>		
				</div>
			</div>	
		</div>
@endsection