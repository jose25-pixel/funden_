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
        .encabezado{
            padding: 3px 10px;
            border: rgb(23, 25, 26) 5px double;
            border-top-left-radius: 20px;
            border-bottom-right-radius: 20px;
            }

        .logo{
        width: 250px;
        }


        img {
        float: left;
        width: 250px;
        height: 140px;
        }
        .table {
            
            display:table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 9px;
            background-color: transparent;
            border-collapse: collapse;
            border: 1px solid #151616;

        }
        .tables {
            
            display:table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 9px;
            background-color: transparent;
            border-collapse: collapse;
        

        }

        .table-bordered {
            border: 1px solid #151616;
        }

        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
            background-color: #aea27d;
        }

        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }

        .table th,
        .table td {
            padding: 1px;
            vertical-align: top;
            border-top: 1px solid #121213;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #19191a;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #0a0a0a;
        }

        th,
        td {
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

        .izquierda {
            float: left;
        }

        .derecha {
            float: right;
        }

        
    </style>
</head>

<body>
    <section class="encabezado">
        <div class="logo">
            <img src="img/reporte.jpg" alt="">
        </div>
    
        <div class="texto">
            <h4>FUNDACIÓN DE DESARROLLLO LATINOÁMERICANO</h4>
            <i> Calle, al Mirador Pje.11 #122 Col.Escalón <br> 
                San Salvador, El Salvador </i> <br>
           <i>Telefono:(+503)734475859</i> <br>
            <i> Email:fundel123@gmail.com</i>
        </div>
      </section>
      <br>
   <section>
    
    <h3 style="text-align: center">CONTROL INTERNO SOBRE EL INVENTARIO DEL MEDICAMENTO KARDEX</h3>
    <div>
        @foreach ($articulos as $a)
        <table class="tables table-responsive table-borderless table-sm">
            <tr>
                <td scope="col"> <b >Nombre:</b><label>{{ $a->nombre }}</label></td>
                <td scope="col"><b >Presentación:</b><label for="">{{ $a->presentacion }}</label></td>
                <td ><b >Farmacéutica:</b><label for="">{{ $a->nombre_categoria }}</label></td>
            </tr>
            <tr>
                <td><b >Concentración:</b><label for="">{{ $a->concentracion }}{{ $a->nombre_gramaje}}</label></td>
                <td><b >Cantidad de items:</b><label for="">{{ $a->items}}</label></td>
                <td><b >Administración</b><label for="">{{ $a->administracion}}</label></td>
            </tr>
        </table>
        @endforeach
    </div>
</section>


    <br>
   
    <h4 style="text-align: center">REGISTROS DE ENTRADAS</h4>
    <section>
        <div>
            <table class="table table-responsive table-borderless table-sm">
                <thead>
                    <tr>
                        <th scope="col">F_Compras</th>
                        <th scope="col">Proveedor</th>
                        <th scope="col">Compb</th>
                        <th scope="col">Número</th>
                        <th scope="col">Lote</th>
                        <th scope="col">Vencimiento</th>
                        <th scope="col">Entradas</th>
                        <th scope="col">saldo</th>
                    </tr>
                </thead>
                <tbody>
  
                    @foreach ($detalle_ingresos as $ing)
                    <tr>
                        <td>{{ $ing->fecha_compra }}</td>
                        <td>{{ $ing->proveedor }}</td>
                        <td>{{ $ing->tipo_comprobante }}</td>
                        <td>{{ $ing->num_comprobante }}</td>
                        <td>{{ $ing->lote }}</td>
                        <td>{{ $ing->fecha_vencimiento }}</td>
                        <td>{{ $ing->cantidad . '/' . $ing->cantidad_blister }}</td>
                        <td>
                            {{ $ing->antiguo_tableta . '/' . $ing->antiguo_blister }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <h4 style="text-align: center">REGISTROS DE SALIDAS</h4>
    <section>
        <div>
            <table class="table table-responsive table-borderless table-sm">
                <thead>
                    <tr>
                        <th scope="col">Fe_Salidas</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Compb</th>
                        <th scope="col">Número</th>
                        <th scope="col">Lote</th>
                        <th scope="col">Vencimiento</th>
                        <th scope="col">Salida</th>
                        <th scope="col">saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalle_ventas as $sal)
                    <tr>
                        <td>{{ $sal->fecha_salida }}</td>
                        <td>{{ $sal->descripcion }}</td>
                        <td>{{ $sal->cliente }}</td>
                        <td>{{ $sal->tipo_comprobante }}</td>
                        <td>{{ $sal->num_comprobante }}</td>
                        <td>{{ $sal->lote }}</td>
                        <td>{{ $sal->fecha_vencimiento }}</td>
                    
                        <td>{{ $sal->cantidad . '/' . $sal->cantidad_blister }}</td>
                        <td>{{ $sal->antiguo_tableta . '/' . $sal->antiguo_blister }} </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </section>
    <br>
    <h4 style="text-align: center">SALDO ACTUAL DEL MEDICAMNETO</h4>
    <section>
        <div>
            <table class="table table-responsive table-borderless table-sm">
                <thead>
                    <tr>
                        <th scope="col">Cantidad de Tabletas</th>
                        <th scope="col">Cantidad de blister</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventarios as $in)
                    <tr style="text-align: center" >
                        <td>{{ $in->cantidad_tableta }}</td>
                        <td>{{ $in->cantidad_blister }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>