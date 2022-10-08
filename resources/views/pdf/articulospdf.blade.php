<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Medicamentos</title>
    <style>
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
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
            border: 1px solid #a2a7a7;
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
            padding: 0.75rem;
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

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        line-height: 1px;
        color: rgb(17, 16, 16);
        text-align: center;
        font-size: 10px;
    }
    </style>
</head>

<body>
    <div class="container">
       
        <div class="contenedor1">
            <img src="img/reporte.jpg" alt="">
        </div>

        <div class="contenedor2">
            <h3 class="titulo">FUNDACIÓN DE DESARROLLO LATINOAMERICANO</h3>
            <b>(FUNDEL)</b>
        </div>
    </div>
    </div>

  <section class="contenido">
        <h3 style="text-align: center">Lista de Medicamentos</h3>
    <div>
        <table class="table table-responsive table-borderless table-sm">
            <thead>
                <tr>
                    <th scope="col">Medicamento</th>
                    <th scope="col">Farmacéutica</th>
                    <th scope="col">Concentración</th>
                    <th scope="col">Presentación </th>
                    <th scope="col">Administración</th>
                    <th scope="col">Items</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articulos as $a)
                <tr>
                    
                    <td>{{ $a->nombre }}</td>
                    <td>{{ $a->nombre_categoria }}</td>
                    <td>{{ $a->concentracion }}{{ $a->gramaje }}</td>
                    <td>{{ $a->presentacion }}</td>
                    <td>{{ $a->administracion }}</td>
                    <td>{{ $a->items }}</td>
                </tr>
                @endforeach

            </tbody>

        </table>
    </div>
    <div class="izquierda">
        <p><strong>Total de registros: </strong>{{ $cont }}</p>
    </div>
</section>

<footer>
    <h3>(FUNDEL)--REPORTE  DE MEDICAMENTOS {{ now() }}<h3>
    </h1>
</footer>

</body>

</html>