<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de kardex</title>
    <style>

header 
    { position: fixed;
        left: 0px;
         top: 0px;
          
        }   

        body {
        font-family: 'Courier New', Courier, monospace;
        font-size: 15px;
    }

    .container {
        width: 98%;
        height: 68px;
        border-bottom: rgb(95, 94, 94) 4px double;
    }

    .contenedor1 {
        width: 30%;
        float: left;
    }

    img {
        width: 70%;
        height: 65px;
        margin-left: 80px;
    }

    .contenedor2 {
        width: 65%;
        height: 150px;
        text-align: center;
        margin: 0px 0px 0px 4px;
        float: right;
    }

        .titulo{
        margin: 4px  0px 5px;
        }
     section {
        clear: unset;
        
    }
        
        .table {
            display:table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 9px;
            background-color: transparent;
            border-collapse: collapse;
            border: 1px solid #a2a7a7;
        }
        .tables {
            
            display:table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 9px;
            background-color: transparent;
            border-collapse: collapse;
        }

        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
            background-color: #b4a36b;
            border: 1px solid #a2a7a7;
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
            border-top: 1px solid #a1a5a7;
        }

        .table thead th {
            vertical-align: bottom;
            border-top: 1px solid #bec6c9;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #c2cfd6;
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
        .tabla1 {
            margin-top: 200px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 25px;
            color: BLACK;
            text-align: center;
            clear:unset;
        }
        .pag:after { 
            content: counter(page, upper-roman);
         }

        
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="contenedor1">
                <img src="img/reporte.jpg" alt="">
            </div>
    
            <div class="contenedor2">
                <h3 class="titulo">FUNDACIÓN DE DESARROLLO LATINOAMERICANO</h3>
                <b>(FUNDEL)</b>
            </div>
        </div>
        
        <section class="medicamento">
            <div>

                @foreach ($articulos as $a)
        <h4 style="text-align: center">CONTROL INTERNO SOBRE EL INVENTARIO DEL MEDICAMENTO KARDEX </h4>

                <table class="tables table-responsive table-borderless table-sm">
                    <tr>
                        <td scope="col"> <b >Medicamento: </b><label>{{ $a->nombre }}</label></td>
                        <td scope="col"><b >Presentación: </b><label for="">{{ $a->presentacion }}</label></td>
                        <td ><b >Casa Farmacéutica: </b><label for="">{{ $a->nombre_categoria }}</label></td>
                    </tr>
                    <tr>
                        <td><b >Concentración: </b><label for="">{{ $a->concentracion }}{{ $a->nombre_gramaje}}</label></td>
                        <td><b >Cantidad de ítems: </b><label for="">{{ $a->items}}</label></td>
                        <td><b >Administración: </b><label for="">{{ $a->administracion}}</label></td>
                    </tr>
                </table>
                @endforeach
            </div>
        </section>
    </header>
 
  
 
    <section >
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
                        <th scope="col">Estado</th>
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
                        <td>{{ $ing->estado }}</td>
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

    
    <section>
        <h4 style="text-align: center">Registros de Salidas</h4>
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
 
    <section>
    <h4 style="text-align: center">Saldo Actual del Medicamento</h4>
        <div>
            <table class="table table-responsive table-borderless table-sm">
                <thead >
                    <tr>
                        <th scope="col" style="text-align: center" >Cantidad de Tabletas</th>
                        <th scope="col" style="text-align: center" >Cantidad de blister</th>

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


    <footer>
        <P class="pag">INVENTARIO DEL MEDICAMENTO KARDEX      Pagina</P>
        <b>{{ now() }}</b>
      
    </footer>
</body>

</html>
