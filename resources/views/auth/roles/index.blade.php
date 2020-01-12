@extends('layouts.dashboard')
@section('title', 'Permisos')
@section('content')
		<div class="row">
			<div class="col-lg-3 col-xs-3">
          <!-- small box -->
          			<a href="{{route('roles.create')}} " class="small-box-footer">
            		<div class="small-box bg-primary">
            		<div class="inner">
              			<h3>CREAR</h3>
              			<p>ROLE</p>
            		</div>
          			</div>
          			</a>
        	</div><!-- col -->
        	<div class="col-lg-3 col-xs-3">
          <!-- small box -->
                    <a href="./?view=products" class="small-box-footer">
            		<div class="small-box bg-green">
            		<div class="inner">
              			<h3>BUSCAR</h3>
              			<p>ROLE</p>
            		</div>
          			</div>
          			</a>
        	</div><!-- col -->
        
		</div>
		<div class="row">
			<div class="col-lg-12">
				@if(\Session::has('success'))
				<div class="alert alert-success">{{\Session::get('success')}} </div>
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Permisos
					</div>
					<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Nombre del Role </th>
							<th scope="col">Tipo</th>
							<th scope="col">Descripción</th>
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
								<td> {!! Form::open(['route' => ['roles.edit', $rol->id] , 'method' => 'GET']) !!} <button type="submit" class="btn btn-warning">Editar</button>

								{!! Form::close() !!}</td>
								<td>
									{!! Form::open(['route' => ['roles.destroy', $rol->id] , 'id' => 'formdelete'.$rol->id])!!}
									{{method_field('DELETE')}}
									{{csrf_field()}}

								<a onClick="eliminar('{{$rol->id}}', '{{$rol->name}}');" class="btn btn-danger">Eliminar</a>
								{!! Form::close() !!}</td>
							</tr>
								
							@endforeach
						</tr>
					</tbody>
				</table>
						
					</div>
					
						
					</div>
					
				</div>
				
			</div>
		</div>
@endsection