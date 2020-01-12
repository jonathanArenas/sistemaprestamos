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

		<div class="panel panel-primary">
			<div class="panel-heading">Crear Grupo</div>
			<div class="panel-body">
				<div class="row">
						<div class="col-lg-12">
							<button id="plus" class="btn btn-primary pull-right">+ SECCIONES</button>
						</div>
				</div>

				<div class="row">
						{!! Form::open(['route'=>'grupo.store'], ['method'=>'POST']) !!}
				<div class="form-group col-lg-4">
						{!! Form::label('zona','Zona') !!}
			    	 		
			   			{!! Form::text('zona', null, ['class'=>'form-control', 'placeholder'=>'Nombre','required'])!!}
				</div>
				
				<div class="form-group col-lg-6">
						{!! Form::label('seccion','Sección') !!} 
						<select name="seccion" id="secciones" class="form-control">
							@foreach($secciones as $key => $seccion)
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

<script>
	$(document).ready(function(){
		$('#plus').click(function(e){
			e.preventDefault();
			$.ajaxSetup({
				headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
			});

			$.ajax({
				url : "{{route('seccion')}}",
				method : 'POST',
				data: {
					id : 1,
				},beforeSend: function() {

    				
  				},
			}).done(function(msg){
				if(msg != null){
					console.log(msg);
					$('#secciones').empty();
						for( var  i= 0; i < msg['secciones'].length; i++){
							$('#secciones').append($('<option>',{
								value: msg['secciones'][i]['id'] ,
								text: msg['secciones'][i]['id'] ,
							}));
						}
				}else{
					console.log('error');
				}
			});
		});
	});

</script>
@endsection
