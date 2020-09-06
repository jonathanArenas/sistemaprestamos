@extends('layouts.dashboard')
@section('title', 'Información del credito')
@section('content')
@hasrole('SuperUser|Prestamista')
  @if($credito->estatus != "CANCELADO")
  <div class="row mb-2">
    <div class="col-lg-12 col-12">
      <button type="button" class="btn btn-default btn-sm float-right" onclick="printme()"><i class="fas fa-print"></i> Imprimir</button>
      <a href="{{route('fichaPdfPagos', $credito->num)}}" target="_blank" class="btn btn-primary btn-sm  float-right" style="margin-right: 5px;"><i class="fas fa-download"></i> Generate Ficha Pagos</a>
      {!! Form::open(['route' => ['credito.destroy', $credito->num] , 'id' => 'formdelete'.$credito->num])!!}
      {{method_field('DELETE')}}
      {{csrf_field()}}
      <a href="#" class="btn btn-danger btn-sm float float-right" style="margin-right: 5px;" onClick="eliminar('{{$credito->num}}', '{{$credito->num}}');" ><i class="far fa-trash-alt"></i> Cancelar Crédito</a>
      {!! Form::close() !!}
    </div>
  </div>
@endif
@endhasrole
<div class="row">
    <div class="col-12">
        <div class="invoice p-3 mb-3" >
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                  <i class="fas fa-building"></i> {{$empresa->nombre}}.
                    <small class="float-right"><b>Fecha solicitud: </b>{{$credito->fecha_desde->format('d/m/Y')}}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  De
                  <address>
                    <strong>{{ucwords(strtolower($credito->otorga))}} </strong><br>
                    {{ucwords(strtolower($empresa->direccion))}}<br>
                    Colonia {{ucfirst(strtolower($empresa->colonia))}}, {{$empresa->cp}} <br>
                    Tel: {{$empresa->telefono}} <br>
                    Email: {{$empresa->email}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  A
                  <address>
                    <strong>{{ucwords(strtolower($credito->Cliente))}} </strong><br>
                    {{ucwords(strtolower($credito->direccion))}} #{{$credito->num_ext}}<br>
                    Colonia {{ucfirst(strtolower($credito->colonia))}}, {{$credito->cod_postal}}<br>
                    {{ucfirst(strtolower($credito->municipio))}}, {{ucfirst(strtolower($credito->estado))}}<br>
                    Tel: {{$credito->telefono}}<br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  @if($credito->estatus != "CANCELADO")
                    <b>ID Credito: </b>#{{$credito->num}}<br>
                    <br>
                    <b>ID Cliente: </b>{{$credito->id_cliente}}<br>
                    <b>Pagar al: </b>{{$credito->fecha_hasta->format('d/m/Y')}}<br>
                    <b>Num credito cliente: </b>{{$credito->num_credito_cliente}}<br>
                    <b>Capital solicitado: </b>{{$credito->capital_solicitado}}
                  @else
                    <b>ID Credito: </b>#{{$credito->num}}<br>
                    <br>
                    <b>ID Cliente: </b>{{$credito->id_cliente}}<br>
                    <b>Num credito cliente: </b>{{$credito->num_credito_cliente}}<br>
                    <h1 class="text-danger">CANCELADO</h1>
                  @endif
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Núm. Pago</th>
                      <th>Vigente</th>
                      <th>al Capital</th>
                      <th>al Interes</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($desglose as $key => $pago)
                            <tr>
                            <td>{{$pago->fecha->format('d/m/Y')}}</td>
                            <td>{{$pago->num_pago_credito}}</td>
                            <td>{{$pago->vigente}}</td>
                            <td>{{$pago->al_capital}}</td>
                            <td>{{$pago->al_interes}}</td>
                            <td>{{$pago->total_pago}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Métodos de pagos:</p>
                  <img src="{{asset('img/pay-efectivo.png')}}" alt="Efectivo">

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    En caso de retardo se cobraran $50 por día de retrazo para cada pago.
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Pagar al {{$credito->fecha_hasta->format('d/m/Y')}}</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tbody><tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>{{$credito->total_pagar}}</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>{{$credito->total_pagar}}</td>
                      </tr>
                    </tbody></table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">    
                </div>
              </div>
        </div>
    </div>
</div>
<div id="modal-destroy">
</div>
@endsection
@section('extras')
<script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script src="{{asset('js/jspdf.min.js')}}"></script>
@endsection