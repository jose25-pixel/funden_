<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte medicamento por fecha.</title>
</head>
<style>
    body {
        font-family: 'Courier New', Courier, monospace;
        font-size: 15px;
        margin-top: 182px;
        margin-bottom: 43px;
        padding: 5px;
        padding-bottom: 2px;
        padding-top: 3px;

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



    .table {
        display: table;
        width: 100%;
        max-width: 100%;
        margin-bottom: 9px;
        background-color: transparent;
        border-collapse: collapse;
        border: 1px solid #a2a7a7;
    }

    .tables {

        display: table;
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
        <main>

            <div class="salida">
                <h4 style="text-align: center">Registros de Salidas</h4>
                <table class="table table-responsive table-borderless table-sm">
                    <thead>

                        <tr>
                            <th scope="col">Cliente</th>
                            <th scope="col">Medicamento</th>
                            <th scope="col">Fe.Salidas</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Compb</th>
                            <th scope="col">Número</th>
                            <th scope="col">Lote</th>
                            <th scope="col">Vencimiento</th>
                            <th scope="col">Cantidad</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalle_clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->cliente }}</td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->fecha_salida }}</td>
                            <td>{{ $cliente->descripcion }}</td>
                            <td>{{ $cliente->tipo_comprobante }}</td>
                            <td>{{ $cliente->num_comprobante }}</td>
                            <td>{{ $cliente->lote }}</td>
                            <td>{{ $cliente->fecha_vencimiento }}</td>
                            <td>{{ $cliente->cantidad . '/' . $cliente->cantidad_blister }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>

        <footer>
            <p class="pag">CONTROL INTERNO VENTAS POR CLIENTE
                <?php echo date("d-m-Y");?>
                Pagína
            </p>
        </footer>
</body>

</html>