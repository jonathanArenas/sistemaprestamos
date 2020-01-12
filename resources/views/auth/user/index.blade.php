@extends('layouts.dashboard')
@section('title', 'Clientes')
@section('content')
		<div class="row">
			<div class="col-lg-3 col-xs-12">
          <!-- small box -->
          			<a href="{{route('user.create')}} " class="small-box-footer">
            		<div class="small-box bg-primary">
            		<div class="inner">
              			<h3>CREAR</h3>
              			<p>USUARIO</p>
            		</div>
          			</div></a>
        	</div><!-- col -->
        	<div class="col-lg-3 col-xs-12">
          <!-- small box -->
          			<a href="./?view=products" class="small-box-footer">
            		<div class="small-box bg-green">
            		<div class="inner">
              			<h3>BUSCAR</h3>
              			<p>USUARIO</p>
            		</div>
          			</div></a>
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
						clientes
					</div>
					<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Nombre de usuario</th>
							<th scope="col">Email</th>
							<th scope="col">Acción</th>
						</tr>
					</thead>
					<tbody>
							@foreach($users as $key => $user)
							<tr>
								<td>{{ $user->id}} </td>
								<td>{{ $user->nombre}}</td>
								<td>{{ $user->email}}</td>
							
								<td> {!! Form::open(['route' => ['user.edit', $user->id] ,'name' => 'formedit', 'id' => 'formedit', 'method' => 'GET']) !!} <button type="submit" class="btn btn-warning">Editar</button>

								{!! Form::close() !!}</td>
								<td>
									{!! Form::open(['route' => ['user.destroy', $user->id] , 'id' => 'formdelete'.$user->id])!!}
									{{method_field('DELETE')}}
									{{csrf_field()}}

								<a onClick="eliminar('{{$user->id}}', '{{$user->nombre}}');" class="btn btn-danger">Eliminar</a>
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