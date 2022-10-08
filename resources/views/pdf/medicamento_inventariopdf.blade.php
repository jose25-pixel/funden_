<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventario</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;
        }
        .container{
            padding: 3px 9px;
            width: 98%;
            height: 138px;
            border: black 4px double;
            border-top-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .contenedor1{
        width: 40%;
        margin: 4px;
        float: left;
        }

        img{
        width: 98%;
        height: 130px;
        }

        .contenedor2{
        width: 55%;
        height: 150px;
        text-align: left;
        margin: 4px 0px 0px 15px;
        float: right;
        }

        .titulo{
        margin: 4px  0px 5px;
        }

        .contenido{
            clear:both;
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

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        footer {
            position: absolute;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 25px;
            color: rgb(8, 8, 8);
            text-align: center;
         
        }
    </style>
</head>

<body>
    <div class="container">
       
        <div class="contenedor1">
            <img src="img/reporte.jpg" alt="">
        </div>

        <div class="contenedor2">
            <h4   class="titulo" >FUNDACIÓN DE DESARROLLO LATINOAMERICANO</h4>
            <i> Calle al Mirador Pje.11 #122 Col.Escalón  San Salvador, <br> 
               El Salvador. </i> <br>
             <i>Telefono:(+503)734475859</i> <br>
            <i> Email:fundel123@gmail.com</i>
        </div>
    </div>

  <section class="contenido">
        <h3 style="text-align: center">Inventario</h3>
    <div>
        <table class="table table-responsive table-borderless table-sm">
            <thead>
                <tr>
                    <th scope="col">Medicamento</th>
                    <th scope="col">Casa_Farmacéutica</th>
                    <th scope="col">Concentración</th>
                    <th scope="col">Presentación </th>
                    <th scope="col">Administración</th>
                    <th scope="col">Items</th>
                    <th scope="col"> Stock Tableta</th>
                    <th scope="col">Stock Blister</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventarios as $inv)
                <tr>
                    
                    <td>{{ $inv->medicamento }}</td>
                    <td>{{ $inv->casa_farmaceutica }}</td>
                    <td>{{ $inv->concentracion }}{{ $inv->gramaje }}</td>
                    <td>{{ $inv->presentacion }}</td>
                    <td>{{ $inv->administracion}}</td>
                    <td>{{ $inv->items }}</td>
                    <td>{{ $inv->cantidad_tableta }}</td>
                    <td>{{ $inv->cantidad_blister }}</td>
                </tr>
                @endforeach

            </tbody>

        </table>
    </div>
    
</section>

<footer>
    <p> {{ now() }}</p>
    </div>
</footer>


    <span class="derecha"></span>
</body>

</html>