<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            hr {
                color: red;
            }
            h5{
                font-family: Georgia, serif;
                font-size: 20px;
                letter-spacing: 2px;
                word-spacing: 2px;
                color: #000000;
                font-weight: 700;
                text-decoration: none;
                font-style: normal;
                font-variant: small-caps;
                text-transform: uppercase;
                text-align:center;
            }
        </style>
    </head>
    <body>
        <header>
                <h5>INFORMACIÓN DEL CLIENTE</h5>
        </header>
        <hr>
        <p style="text-align: right">Fecha: {{date('d-m-Y')}}</p>
        <div>
            <p><strong>NOMBRE: </strong>{{$cliente->nombre}} {{$cliente->paterno}} {{$cliente->materno}} </p>
            <p><strong>TELÉFONO: </strong> {{$cliente->telefono}}</p>
            <P><strong>DIRECCIÓN: </strong>{{$ubicacion[0]->direccion}}, NÚM. EXT {{$ubicacion[0]->num_ext}},
            @if(empty($ubicacion[0]->num_int)) @else NÚM.INT {{$ubicacion[0]->num_int}} @endif
            COL. {{$ubicacion[0]->colonia}}, MUNICIPIO {{$ubicacion[0]->municipio}}
        </P>
        </div>
    </body>
</html>