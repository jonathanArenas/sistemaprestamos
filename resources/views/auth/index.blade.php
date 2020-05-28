@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')

{{--inicia Rectangulos--}}
<div class="row">
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <a href="#">
        <div class="small-box bg-olive">
            <div class="inner">
              <h3>150</h3>
              <p>Prestamos Realizados</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
        </div>
      </a>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <a href="#">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>$ 0.00</h3>
              <p>Ingresos de hoy</p>
          </div>
          <div class="icon">
              <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </a>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <a href="{{route('user.index')}}">
        <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$user}}</h3>
              <p>Usuarios registrados</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
        </div>
       </a>   
    </div>
    <!-- -/col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <a href="#" id="prestamos">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>Generar</h3>
            <p>Prestamo</p>
          </div>
          <div class="icon">
            <i class="fas fa-money-check-alt"></i>
        </div>
        </div>
      </a>
    </div>
</div>
<div class="modal fade" id="catalogoPrestamos" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Puedes basarte al catalogo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="row">
        <div class="col-lg-12">
            @foreach($catalogos as $key => $catalogo)
            <a href="{{route('generar', $catalogo->id)}}" class="btn btn-block btn-outline-success btn-lg">{{$catalogo->nombre}}</a>
            @endforeach
            <a href="{{route('generar')}}" class="btn btn-block btn-outline-success btn-lg">PERSONALIZADO</a>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

{{--Fin Rectangulos--}}
@endsection
@section('extras')
<script>
  $(document).ready(function(){
    $('#prestamos').click(function(e){
    $('#catalogoPrestamos').modal();   
    });
  });
</script>
@endsection