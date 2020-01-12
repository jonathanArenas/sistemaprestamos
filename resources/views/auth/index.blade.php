@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')

{{--inicia Rectangulos--}}
  <br>
 
<div class="row">
    <div class="col-lg-4 col-xs-12">
      <a href="{{route('diario.index')}} " class="small-box-footer">
      <div class="small-box bg-orange">
            <div class="inner"><h3>PRESTAMO</h3> <p>EXPRESS</p></div>
		     
       </div>
        </a>
    </div>
        <!-- ./col -->
    <div class="col-lg-4 col-xs-12">
        <!-- small box -->
      <a href="{{route('grupal.index')}} " class="small-box-footer">
      <div class="small-box bg-blue">
            <div class="inner"><h3>PRESTAMO</h3><p>GRUPAL</p></div>    
      </div>
      </a>
    </div>
        <!-- ./col -->
    <div class="col-lg-4 col-xs-12">
          <!-- small box -->
      <a href="{{route('mensual.index')}} " class="small-box-footer">
        <div class="small-box bg-green">
            <div class="inner"><h3>PRESTAMO</h3><p>MENSUAL</p></div>
            
        </div>
      </a>
    </div>
</div>
{{--Fin Rectangulos--}}
@endsection