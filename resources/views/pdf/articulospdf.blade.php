<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de articulos</title>
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
        width: 300px;
        }


        img {
        float: left;
        width: 300px;
        height: 140px;
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
            border: 1px solid #151616;
        }

        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
            background-color: #b6a25f;
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
            border-top: 1px solid #c2cfd6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
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

  <section>
        <h4>Lista de Medicamentos</h4>
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
    <span class="derecha">{{ now() }}</span>
</body>

</html>