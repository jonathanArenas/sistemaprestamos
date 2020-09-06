<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            table.blueTable {
            border: 1px solid #1C6EA4;
            background-color: #FFFFFF;
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            }
            table.blueTable td, table.blueTable th {
            border: 1px solid #AAAAAA;
            padding: 3px 2px;
            }
            table.blueTable tbody td {
            font-size: 13px;
            }
            table.blueTable tr:nth-child(even) {
            background: #F5F2A0;
            }
            table.blueTable thead {
            background: #1C6EA4;
            background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
            background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
            background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
            }
            table.blueTable thead th {
            font-size: 15px;
            font-weight: bold;
            color: #FFFFFF;
            border-left: 2px solid #D0E4F5;
            }
            table.blueTable thead th:first-child {
            border-left: none;
            }   
        </style>
    </head>
    <body>
    <b>FECHA SOLICITUD: </b>{{$credito->fecha_desde->format('d/m/Y')}} <br><br>
        <table>
            <tbody>
                <tr>
                    <td>
                            <b>ID CRÉDITO: </b>#{{$credito->num}}<br>
                            <b>NOMBRE CLIENTE: </b>{{$credito->Cliente}}<br>
                            <b>NÚM. CRÉDITO CLIENTE: </b>{{$credito->num_credito_cliente}}<br>
                            <b>CAPITAL SOLICITADO: </b>{{$credito->capital_solicitado}}   
                    </td>
                    <td>
                            <b>OTORGA: </b>{{$credito->otorga}}<br>
                            <b>ZONA: </b>{{$zona->nombre}}<br>
                            <b>SECCIÓN: </b>{{$zona->seccion}}<br><br>
                    </td>
                </tr>
            </tbody>
        </table>
            
        <br>
        <table class="blueTable">>
            <thead>
                <tr>
                    <th>FECHA</th>
                    <th>NÚM. PAGO</th>
                    <th>VIGENTE</th>
                    <th>AL CAPITAL</th>
                    <th>AL INTERES</th>
                    <th>TOTAL PAGO</th>
                    <th>FIRMA</th>
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
                    <td></td>
                </tr> 
                @endforeach
            </tbody>
        </table>
    </body>
</html>