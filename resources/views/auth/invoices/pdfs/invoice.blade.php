<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            
            .h{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 27px;
                word-spacing: 2px;
                color: #000000;
                font-weight: 400;
                text-decoration: none;
                font-style: normal;
                font-variant: normal;
                text-transform: none;
            }
            table{
                width: 100%;
            
            }
            .right{
                text-align:right;
             
            }
            .left{
                text-align:left;
            }
            .center{
                text-align:center;
            }
            b.title{
                font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
                font-size: 17px;
                letter-spacing: 0px;
                word-spacing: 0px;
                color: #333333;
                font-weight: normal;
                text-decoration: none;
                font-style: normal;
                font-variant: normal;
                text-transform: none;
            }
            b.strong{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 10px;
                letter-spacing: 0.2px;
                word-spacing: 0.6px;
                color: #333333;
                font-weight: 700;
                text-decoration: none;
                font-style: normal;
                font-variant: normal;
                text-transform: none;
            }
            b.subtitle{
                font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
                font-size: 13px;
                font-weight: bold;
                color: #303030;
            }
            b{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 10px;
                letter-spacing: 0.2px;
                word-spacing: 0.6px;
                color: #333333;
                font-weight: normal;
                text-decoration: none;
                font-style: normal;
                font-variant: normal;
                text-transform: none;
            }
            hr{
                border-top: 0.2px solid gray;
            }
            p{
                font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
                font-size: 13px;
                letter-spacing: -0.6px;
                word-spacing: 0.8px;
                color: #000000;
                font-weight: normal;
                text-decoration: none;
                font-style: normal;
                font-variant: normal;
                text-transform: none;
            }

            table.blueTable {
                font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
                font-size: 17px;
                letter-spacing: 0px;
                word-spacing: 0px;
                color: #333333;
                font-weight: normal;
                width: 100%;
                text-align: center;
                border-collapse: collapse;
            }
            table.blueTable td, table.blueTable th {
            padding: 4px 0px;
            }
            table.blueTable tbody td {
            font-size: 13px;
            }
            table.blueTable tr:nth-child(even) {
            background: #F2F2F2;
            }
            table.blueTable thead {
                background: #EDEDED;
                border-bottom: 0px solid #444444;
            }
            table.blueTable thead th {
                font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
            font-size: 13px;
            font-weight: bold;
            color: #303030;
            text-align: center;
            border-left: 0px solid #D0E4F5;
            }
            table.blueTable thead th:first-child {
            border-left: none;
            }

            table.totales{
                width: auto;
                margin-right: 0px;
                margin-left: auto;
            }
         
        </style>
    </head>
    <body>
    <header>
        <table>
            <tbody>
            <tr>
                <td>
                <b class="title">Recibo de Jonathan Arenas Andrés</b> <br>
                <b>Identificador del recibo: {{$recibo["id"]}}</b>
                </td>
                <td clss="right">
                    <?php
                        $path = public_path('/img/signo_pesos.jpg');
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    ?>
                    <img src="{{$base64}}" alt=""><span>TuCrédito</span>
                </td>
            </tr>
            </tbody>
        </table>
        
        <hr>
    </header>
    <br>
        <table>
            <tbody>
                <tr>
                    <td>
                        <table>
                            <tbody >
                                <tr>
                                    <td>
                                        <b>Fecha de recibo/pago</b><br>
                                        <b class="strong">{{$recibo["fecha"]->format('d/m/Y')}}</b>
                                    </td>
                                </tr>
                                <tr>
                                     <td>
                                        <b>Id crédito</b><br>
                                        <b class="strong">{{$credito["num"]}}</b>
                                    </td>
                                </tr>
                                <tr>
                                     <td>
                                        <b>Núm. Crédito Cliente</b><br>
                                        <b class="strong">{{$credito["num_credito_cliente"]}}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table> 
                    </td>
                    <td class="right">
                        <b class="title">Pagado</b><br>
                        <b class="h">{{$recibo["total"]}} MXN</b> 
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <hr>
        <b class="title">Desglose</b>
        <br>
        <hr>
        <table class="blueTable">
            <thead>
                <tr>
                    <th>Pago correspondiente</th>
                    <th>Pagar el</th>
                    <th>Vigente</th>
                    <th>Al capital</th>
                    <th>Al interes</th>
                    <th>Total pago</th>
                    <th>Recargos</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pagos as $key => $pago)
                <tr>
                    <td>{{$pago["num_pago_credito"]}}</td>
                    <td>{{$pago["fecha"]->format('d/m/Y')}}</td>
                    <td>{{$pago["vigente"]}}</td>
                     <td>{{$pago["al_capital"]}}</td>
                    <td>{{$pago["al_interes"]}}</td>
                    <td>{{$pago["total_pago"]}}</td>
                    <td>{{$pago["recargos"]}}</td>
                    <td>{{$pago["total_pagar"]}}</td>
                </tr> 
                @endforeach
            </tbody>
        </table>
        <hr>
 
        <table class="totales">
            <tbody>
                <tr> 
                
                    <td class="left"><b class="subtitle">Total:</b></td>
                    <td class="right">{{$recibo["total"]}}</td>
                </tr>
                <tr>
              
                    <td class="left"><b class="subtitle">Importe:</b></td>
                    <td class="right">{{$recibo["efectivo"]}}</td>
                </tr>
                <tr>
                        
                    <td class="left"><b class="subtitle">Residuo:</b></td>
                    <td class="right">{{$recibo["residuo"]}}</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>