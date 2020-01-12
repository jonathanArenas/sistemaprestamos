@extends('layouts.dashboard')
@section('title', 'Grupos')
@section('content')
		<div class="row">
			<div class="col-lg-3 col-xs-12">
          <!-- small box -->
          			<a href="{{route('grupo.create')}} " class="small-box-footer">
            		<div class="small-box bg-primary">
            		<div class="inner">
              			<h3>CREAR</h3>
              			<p>GRUPO</p>
            		</div>
          			</div></a>
        	</div><!-- col -->
        	<div class="col-lg-3 col-xs-12">
          <!-- small box -->
          			<a href="./?view=products" class="small-box-footer">
            		<div class="small-box bg-green">
            		<div class="inner">
              			<h3>BUSCAR</h3>
              			<p>GRUPO</p>
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
						grupos
					</div>
					<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Clave</th>
							<th scope="col">Zona</th>
							<th scope="col">Sección</th>
						</tr>
					</thead>
					<tbody>
							@foreach($grupos as $key => $grupo)
							<tr>
								<td>{{ $grupo->id}} </td>
								<td>{{ $grupo->zona}}</td>
								<td>{{ $grupo->seccion}}</td>
								<td> {!! Form::open(['route' => ['grupo.edit', $grupo->id] ,'id' => 'formedit' , 'method' => 'GET']) !!} <button type="submit" class="btn btn-warning">Editar</button>

								{!! Form::close() !!}</td>
								<td>
									{!! Form::open(['route' => ['grupo.destroy', $grupo->id] , 'id' => 'formdelete'.$grupo->id])!!}
									{{method_field('DELETE')}}
									{{csrf_field()}}

								<button onClick="del('{{$grupo->id}}', '{{$grupo->name}}');" class="btn btn-danger">Eliminar</button>
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