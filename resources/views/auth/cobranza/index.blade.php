@extends('layouts.dashboard')
@section('title', 'Cobranza')
@section('content')


<div class="row mb-2">
			<div class="col-lg-12">
				<a class="btn btn-secondary btn-sm float-right" href="{{route('invoices', $numCredito)}}"><i class="far fa-id-badge"></i> E. Cuenta</a>
			</div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card card-secondary">
            <div class="card-header">
                <div class="card-title">Cobranza</div>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <input type="text" name="table_search" class="form-control float-left" id="buscador" placeholder="Search">
                        <div class="input-group-append">
                            <span class="btn btn-default"><i class="fas fa-search"></i></span>
                        </div>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group row">
                            <label for="forDate" class="col-lg-2 col-sm-2 col-3 col-form-label">Fecha:</label>
                            <div class="col-lg-5 col-sm-6 col-9">
                                 <input type="date" class="form-control form-control-sm" id="forDate" value="{{date('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                            <b>ID prestamo: </b> {{$numCredito}} <br>
                            <b>Nombre cliente: </b> {{$cliente->offsetGet(0)->nombre}} {{$cliente->offsetGet(0)->paterno}} {{$cliente->offsetGet(0)->materno}} <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <p><strong>Pagos y recargos pendentes:</strong></p>
                        <div id="cargosRender">
                        
                        </div>
                    </div>
                </div>
                <div class="row bg-light mp-2">
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                        <label for="" class="col-form-label-sm">ACTIVAR</label>
                        <button type="button" class="btn btn-block btn-primary btn-sm" id="btnActivate">
                           <i class="far fa-check-square"></i>
                        </button>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <label for="" class="col-form-label-sm"># Pago</label>
                        <input type="text" class="form-control form-control-sm" id="num_pago" disabled>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <label for="" class="col-form-label-sm">Al capital</label>
                        <input type="text" class="form-control form-control-sm" id="al_capital" disabled>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <label for="" class="col-form-label-sm">Al interes</label>
                        <input type="text" class="form-control form-control-sm" id="al_interes" disabled>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <label for="" class="col-form-label-sm">Recargos</label>
                        <input type="text" class="form-control form-control-sm" id="recargos" disabled> 
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                        <label for="" class="col-form-label-sm">Total</label>
                        <input type="text" class="form-control form-control-sm" id="total" disabled> 
                    </div>
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                        <label for="baskett" class="col-form-label-sm">AÑADIR</label>
                        <button type="button" id="btnBasket" class="btn btn-block btn-success btn-sm" disabled>
                            <i class="fas fa-shopping-basket"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-9 table-responsive pt-0">
                        <table class="table table-sm table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Núm. Pago</th>
                                    <th>Al capital</th>
                                    <th>Al interes</th>
                                    <th>Importe</th>
                                    <th>Cargos</th>
                                    <th>Neto</th>
                                </tr>
                            </thead>
                            <tbody id="tableRenderCarrito">
                            </tbody>
                            <tfoot id="totalRenderCarrito">
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-3">
                    <table class="table text-center">
                        <tbody id="addInput">
                            <tr><td><button type="button" class="btn btn-block bg-secondary btn-app" id="btnCleanCarrito"><i class="fas fa-times" ></i>CANCELAR</button></td></tr>
                            <tr><td><button type="button" class="btn btn-block btn-app" id="exit" ><i class="fas fa-sign-out-alt"></i>SALIR</button></td></tr>
                            <tr><td><button type="button" class="btn btn-block bg-success btn-app" id="btnPagar" disabled><i class="fas fa-donate"></i>PAGAR</button></td></tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>   
</div>
<div class="modal fade" id="modalDeuda" tabindex="-1" role="dialog" aria-labelledby="modalDeudaDescription" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p>Tiene deuda vencida, por lo cual, se han generado cargos.</p>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalSavePayment" tabindex="-1" role="dialog" aria-labelledby="modalSavePaymentLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content" id="load">
      <div class="modal-header">
        <h6 class="modal-title text-center" id="modalSavePaymentLongTitle">Ingrese la cantidad recibida</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
            <div class="col-lg-12 col-sm-12 col-12">
                <input type="text" class="form-control form-control-sm" id="cash">
                <span id="errorCash"></span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary float-rigth" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnTerminar">Terminar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-success" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title text-center" id="modalTitle">Operación Éxitosa</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id= "content-success">
      </div>
    </div>
  </div>
</div>

@endsection
@section('extras')
<script>
    var datos = @json($PagosStock);
    console.log(datos);
    var carrito = [];
    var activado = [];
    var total;
    var estatus = "{{$cliente[0]->estatus}}"
    const btnActivate = document.getElementById('btnActivate');
    const btnBasket = document.getElementById('btnBasket');
    const btnExit = document.getElementById('exit');
    const btnPagar = document.getElementById('btnPagar');
    const btnTerminar = document.getElementById('btnTerminar');
    const inputNumPago = document.getElementById('num_pago');
    const inputAlCapital = document.getElementById('al_capital');
    const inputAlInteres = document.getElementById('al_interes');
    const inputRecargos = document.getElementById('recargos');
    const inputTotal = document.getElementById('total');
    const btnCleanCarrito = document.getElementById('btnCleanCarrito');
    const tableRenderCarrito = document.getElementById('tableRenderCarrito');
    const totalRenderCarrito = document.getElementById('totalRenderCarrito');
    const date = document.getElementById('forDate');
    const inputCash = document.getElementById('cash');

    renderDeudas(datos);
    btnActivate.addEventListener('click', function(){
        if(datos.length){
            activado[0] = datos.shift();
            loadDrawPay(activado);
            disabledBtnBasket(false);
            disabledBtnActivate(true);
        }else{
            alert("No hay pagos pendientes para añadir");
        }
    });
    btnBasket.addEventListener('click', function(){
        disabledBtnActivate(false);
        cleanDrawPay();
        addCarrito();
        console.log(carrito);
        disabledBtnBasket(true);
        btnPagar.disabled = false;
    });
    btnCleanCarrito.addEventListener('click', function(){
        cleanCarrito();
        btnPagar.disabled = true;
    });

    btnPagar.addEventListener('click', function(){
        $('#modalSavePayment').modal();
        inputCash.value = formatNumberWithDecimals(total);
        cleanMessageImporte();
    });

    btnExit.addEventListener('click', function(){
        window.location.href = "{{url('/')}}" ;
    });
    btnTerminar.addEventListener('click', function(){
        let cash = inputCash.value;
        cash = eraseNumber(cash);
        cleanMessageImporte();
        if(parseFloat(cash) < parseFloat(total)){
            let errorCash = document.getElementById('errorCash');
            errorCash.innerHTML = 'Por el momento solo admitimos pagos completos. Ingrese una cantidad igual o mayor al total';
            errorCash.className = "help-block text-justify";
        }else{
            save(cash);
        }  
    });

    inputCash.addEventListener('keyup', function(e){
        formatCurrency(inputCash);
    });

    inputCash.addEventListener('blur', function(e){
        formatCurrency(inputCash, "blur")
    });

    function loadDrawPay(pay){
        inputNumPago.value = pay[0].num_pago_credito;
        inputAlCapital.value = pay[0].al_capital;
        inputAlInteres.value = pay[0].al_interes;
        inputRecargos.value = pay[0].recargos;
        inputTotal.value = pay[0].total_pagar;
    }

    function cleanDrawPay(){
        inputNumPago.value = "";
        inputAlCapital.value = "";
        inputAlInteres.value = "";
        inputRecargos.value = "";
        inputTotal.value = "";
    }

    function addCarrito(){
        carrito.push(activado[0]);
        renderCarrito();
        calcularTotal()
        renderTotal();
    }

    function renderCarrito(){
        cleanRenderCarrito();
        let sizeCarrito = carrito.length;
        for (let i = 0; i < sizeCarrito; i++) {
            let row = document.createElement("tr");
            let numRow = i + 1;
            let dataRow = [numRow, carrito[i].num_pago_credito, carrito[i].al_capital, carrito[i].al_interes, carrito[i].total_pago, carrito[i].recargos, carrito[i].total_pagar];
            let sizeDatarow = carrito[i].length;
            dataRow.forEach(element => {
                let cell = document.createElement("td");
                let textCelda = document.createTextNode(element);
                cell.appendChild(textCelda);
                row.appendChild(cell);
            });
            tableRenderCarrito.appendChild(row);
        }
    }


    function cleanCarrito(){
        if(carrito.length){
            Array.prototype.push.apply(carrito,datos);
            datos = [];
            datos = carrito;
            carrito = [];
            activado = [];
            cleanRenderCarrito();
            cleanRenderTotal();
            disabledBtnActivate(false);
            disabledBtnBasket(true);
            cleanDrawPay();
        }else{
            
            Array.prototype.push.apply(activado, datos);
            datos = [];
            datos = activado;
            activado = [];
            console.log(datos);
            disabledBtnActivate(false);
            disabledBtnBasket(true);
            cleanDrawPay();
        }
    }

    function cleanRenderCarrito(){
        if ( tableRenderCarrito.hasChildNodes()){//removemos los nodos de la tabla
            while ( tableRenderCarrito.childNodes.length >= 1 ){
                tableRenderCarrito.removeChild(tableRenderCarrito.firstChild );
            }
        }
    }

    function calcularTotal(){
        total = 0;
        for (const item in carrito) {
            let number = carrito[item]['total_pagar'].replace(/,+/,'');
            let total_for_item = parseFloat(number.substr(1));
            total += total_for_item;
        }
        total = total.toFixed(2);
    }

    function renderTotal(){
        cleanRenderTotal();
        let row = document.createElement('tr');
        let cellLabelTotal = document.createElement('th');
        let cellTotal = document.createElement('th');
        cellLabelTotal.setAttribute("colspan","6")
        cellLabelTotal.appendChild(document.createTextNode("Total:"));
        cellTotal.appendChild(document.createTextNode(formatNumberWithDecimals(total)));
        row.appendChild(cellLabelTotal);
        row.appendChild(cellTotal);
        totalRenderCarrito.appendChild(row);
    }

 

    function cleanRenderTotal(){
        if ( totalRenderCarrito.hasChildNodes()){//removemos los nodos de la tabla
            while ( totalRenderCarrito.childNodes.length >= 1 ){
                totalRenderCarrito.removeChild(totalRenderCarrito.firstChild );
            }
        }
    }

    function disabledBtnActivate(estatus){
        if(estatus){
            btnActivate.className = 'btn btn-block btn-danger btn-sm';
            btnActivate.disabled = true;
        }else{
            btnActivate.className = 'btn btn-block btn-primary btn-sm';
            btnActivate.disabled = false;
        }
    }
    function disabledBtnBasket(estatus){
        if(estatus){
            btnBasket.disabled = true;
        }else{
            btnBasket.disabled = false;
        }
    }

    function cleanMessageImporte(){
        let errorCash = document.getElementById('errorCash');
        errorCash.innerHTML="";
    }

    
    function renderDeudas(){
        let renderDeudas = document.getElementById('cargosRender');
        let h1 = document.createElement("h1");
        let p = document.createElement("p");
        
        cleanAllNodosById(renderDeudas);
        if(estatus == "PAGADO"){
            h1.innerHTML  = "PAGADO";
            h1.className = "text-success";
            renderDeudas.appendChild(h1);
        }else if(estatus == "CANCELADO"){
            datos = [];
            console.log(datos);
            h1.innerHTML = "CANCELADO";
            h1.className = "text-danger";
            renderDeudas.appendChild(h1);
        }else{
            let deudasFilter  = datos.filter(thereDeudas);
            if(deudasFilter.length){
                $('#modalDeuda').modal();
                deudasFilter.forEach(element => {
                    p.innerHTML += element.num_pago_credito + ' [' + element.recargos + '], ';
                });
                p.className = "text-danger";
                renderDeudas.appendChild(p);
            }else{
                p.innerHTML = "Ninguna";
                renderDeudas.appendChild(p);
            }
        }    
    }

    function thereDeudas(pago){
        return pago.recargos !== "$0.00";
    }

    
    function save(efectivo){
        $.ajax({
				headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  },
				url : "{{route('savePayment')}}",
				method : 'POST',
				data: {
                num: "{{$numCredito}}",
                date: date.value,
				payments: carrito,
				total: total,
                efectivo: efectivo,
				},beforeSend: function(){
                    load();
                }
	}).done(function(response){ 
        console.log(response);
        actionAfterSavePayment(response);
    }).always(function(event, request, setting){
        hideLoad();
    }).fail(function(jqXHR, textStatus, errorThrown){
        console.log(jqXHR.responseText);
        if(jqXHR.status == 419){
            window.location.replace("{{route('dashboard')}}");
        }
    });
    }
    
    function actionAfterSavePayment(response){
        if(response['estatus']){
            datos = response['data']['stock'];
            carrito = [];
            cleanRenderCarrito();
            cleanRenderTotal();
            modalSuccessRecibo(response['data']['credito'], response['data']['recibo'], response['data']['total']);
            renderDeudas(datos);
        }else{
            modalErrorSavePayment();
        }
    }

    function modalSuccessRecibo(num, recibo, total){
        console.log(num);
        console.log(recibo);
      
        let content = document.getElementById('content-success');
        cleanAllNodosById(content);
        $('#modalSavePayment').modal('hide');
        let divRow = document.createElement("div");//row
        let divCol1 = document.createElement("div");//col
        let divCol2 = document.createElement("div")
        let divCol3 = document.createElement("div");
        let p = document.createElement("p");
        let btnPrint = document.createElement("a");
        let btnClose = document.createElement("button");
        divRow.className = "row";
        divCol1.className = "col-lg-12";
        divCol2.className = "col-lg-6 col-md-6 col-sm-6 text-center";
        divCol3.className = "col-lg-6 col-md-6 col-sm-6 text-center";
        
        p.innerHTML = `Se ha generado el recibo núm.  ${recibo}, por el total de $ ${total}` ;
        p.className = "text-justify";
        let url = "{{route('pdfInvoice', ['num', 'recibo'])}}"
        url = url.replace('num', num);
        url = url.replace('recibo', recibo);
        btnPrint.setAttribute("href", url);
        btnPrint.setAttribute("target", "_blank")
        btnPrint.className = "btn btn-primary btn-sm mb-2";
        btnPrint.innerHTML = "Imprimir";
        btnClose.type = "button";
        btnClose.className = "btn btn-secondary btn-sm mb-2";
        btnClose.setAttribute("data-dismiss","modal");
        btnClose.innerHTML = "Cerrar";
        divCol1.appendChild(p);
        divCol2.appendChild(btnPrint);
        divCol3.appendChild(btnClose);
        divRow.appendChild(divCol1);
        divRow.appendChild(divCol2);
        divRow.appendChild(divCol3);
        content.appendChild(divRow);

        $('#modal-success').modal('show');
    }

    function modalErrorSavePayment(){
        console.log('error');
    }

    
</script>


@endsection