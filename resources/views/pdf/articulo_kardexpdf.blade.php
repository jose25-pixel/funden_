<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de productos</title>
    <style>

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
        }
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }

    </style>
</head>
<body>
    <div>
        <h3>Lista de los  productos <span class="derecha">{{now()}}</span></h3>
    </div>
    <div>
        
        <table class="table table-responsive table-borderless table-sm">
            <thead>
                <tr>
                   
                    <th scope="col">Nombre</th>
                    <th scope="col">Concentracion</th>
                    <th scope="col">Casa Farmaceutica</th>
                    <th scope="col">Pret.</th>
                    <th scope="col">Admi.</th>
                    <th scope="col">Items</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articulos as $a)
                    <tr>
                        <td>{{$a->nombre}}</td>
                        <td>{{$a->concentracion.$a->nombre_gramaje}}</td>
                        <td>{{$a->nombre_categoria}}</td>
                        <td>{{$a->presentacion}}</td>
                        <td>{{$a->administracion}}</td>
                        <td>{{$a->items}}</td>
                        <td>{{$a->cantidad_tableta}}</td>
                        <td>{{$a->cantidad_blister}}</td>
                        <td>{{$a->antiguo_tableta}}</td>
                        <td>{{$a->antiguo_blister}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
    <section>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Cantidad de Tabletas</th>
                        <th>Cantidad de blister</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventarios as $in)
                    <tr>
                        <td>{{$in->cantidad_tableta}}</td>
                        <td>{{$in->cantidad_blister}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <br>
    <section>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Antiguo Tabletas</th>
                        <th>Antiguo Blister</th>
                        <th>Proveedor</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalles as $det)
                    <tr>
                        <td>{{$det->antiguo_tableta}}</td>
                        <td>{{$det->antiguo_blister}}</td>
                        <td>{{$det->proveedor}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <section>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Fecha_Compra</th>
                        <th>Proveedor</th>
                        <th>Lote</th>
                        <th>Comprob</th>
                        <th>S_Comprob</th>
                        <th>N_Comprob</th>
                        <th>Fecha_Venci</th>
                        <th>Entradas</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalle_ingresos as $ing)
                    <tr>
                        <td>{{$ing->fecha_compra}}</td>
                        <td>{{$ing->proveedor}}</td>   
                        <td>{{$ing->lote}}</td> 
                        <td>{{$ing->tipo_comprobante}}</td>
                        <td>{{$ing->serie_comprobante}}</td>
                        <td>{{$ing->num_comprobante}}</td>
                        <td>{{$ing->fecha_vencimiento}}</td>
                        <td>{{$ing->cantidad.'/'.$ing->cantidad_blister}}</td>
                        <td>{{$ing->antiguo_tableta}}</td>
                       
                        <td>{{$ing->pastillas}}</td>
                       
                                       
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>