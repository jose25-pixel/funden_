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
            margin-top: 130px;

        }

        @page {
            margin: 0.5cm;

        }


        .header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 4.6cm;
        }

        .container {
            width: 100%;
            height: 62px;
            border-bottom: rgb(144, 140, 140) 0.2cm double;
        }

        .contenedor1 {
            width: 30%;
            float: left;
        }

        img {
            width: 70%;
            height: 57px;
            margin-top: 3px;
            margin-left: 80px;
        }

        .contenedor2 {
            width: 65%;
            height: 58px;
            text-align: center;
            float: right;
        }

        .titulo {
            margin: 10px;
        }

        .nombre {
            margin: 5px 10px 3px 2px;
        }

        .contenido {
            padding-right: 40px;
            margin: 5px 10px 0px 0px;
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
            height: 1cm;
            color: black;

            text-align: center;
            line-height: 0.5cm;
        }

        .pag:after {
            content: counter(page, disc);
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="container">
            <div class="contenedor1">
                <img src="img/reporte.jpg" alt="">
            </div>

            <div class="contenedor2">
                <h3 class="titulo">FUNDACIÓN DE DESARROLLO LATINOAMÉRICANO</h3>
                <h3 class="nombre">(FUNDEL)</h3>
            </div>
        </div>
        <br>
        <h3 style="text-align: center">Lista de Medicamentos</h3>
    </div>


    <section class="contenido">
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

    </section>

    <div class="izquierda">
        <p><strong>Total de registros: </strong>{{ $cont }}</p>
    </div>

    <footer>
        <p class="pag">REPORTE DE MEDICAMENTOS
            <?php echo date("d-m-Y");?>
            Pagína
        </p>
    </footer>

</body>

</html>