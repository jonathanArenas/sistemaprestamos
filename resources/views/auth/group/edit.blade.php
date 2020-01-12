@extends('layouts.dashboard')
@section('title', 'Crear permiso')

@section('content')
<div class="row">
	<div class="col-md-12">
	@if(\Session::has('success'))
				<div class="alert alert-success">{{\Session::get('success')}} </div>
	@endif
	@if(\Session::has('error'))
				<div class="alert alert-danger">{{\Session::get('error')}} </div>
	@endif
	<br>

		<div class="panel panel-warning">
			<div class="panel-heading">Editar Grupo {{$grupo->id}} </div>
			<div class="panel-body">
			
				<div class="row">
						{!! Form::open(['route'=>['grupo.update', $grupo->id ]], ['method'=>'POST']) !!}
						{{method_field('PATCH')}}
						{{csrf_field()}}
				<div class="form-group col-lg-4">
						{!! Form::label('zona','Zona')!!}
			   			{!! Form::text('zona', $grupo->zona, ['class'=>'form-control', 'placeholder'=>'Nombre','required'])!!}
				</div>
				<div class="form-group col-lg-6">
						{!! Form::label('seccion','Sección') !!} 
						<select name="seccion" id="secciones" class="form-control">
							<option value="{{$grupo->seccion}}" selected>{{$grupo->seccion}}</option>
							@foreach($secciones as $key => $seccion)
									@if($seccion->id == $grupo->seccion)
									@continue
									@endif
									<option value="{{$seccion->id}}">{{$seccion->id}}</option>
							@endforeach
						</select>
				</div>
				<div class="form-group col-lg-2">
						<br>
						{!! Form::submit('Crear', ['class' =>'btn btn-primary'])!!}
				</div>
			{!! Form::close() !!}
					
				</div>
				
				
			</div>
		</div>
	</div>
</div>
@endsection