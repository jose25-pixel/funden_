<!DOCTYPE>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Reporte de Compra</title>
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

    .titulo {
        margin: 14px 1 0px 5px;
    }

    section {
        clear: unset;
        margin-top: 20px;
        margin-bottom: 30px;
    }

    #cc,
    #cm {
        color: #121212;
        font-size: 15px;
    }


    #vendedor {
        width: 100%;
        border: 1px solid #a2a7a7;
        border-spacing: 0;
        text-align: center;
    }



    #vendedor thead {
        padding: 20px;
        background-color: #b4a36b;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;
    }

    #medicamento {
        width: 100%;

        border: 1px solid #a2a7a7;
        border-spacing: 0;
        margin-bottom: 15px;
        text-align: center;
    }


    #medicamento thead {
        padding: 20px;
        background: #b4a36b;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;
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
    <div class="container">
        <div class="contenedor1">
            <img src="img/reporte.jpg" alt="">
        </div>

        <div class="contenedor2">
            <h3 class="titulo">FUNDACIÓN DE DESARROLLO LATINOAMERICANO</h3>
            <b>(FUNDEL)</b>
        </div>
    </div>
    <section class="contenido">
        <div class="proveedor">
            <h4 style="text-align:center">REPORTE DE DETALLE DE COMPRA</h4>
            @foreach ($ingreso as $ing)
            <H4>PROVEEDOR</H4>
            <b>Proveedor:</b><label>{{ $ing->nombre }} </label><br>
            <b>Tipo de documento:</b> <label>{{ $ing->tipo_documento }}</label><br>
            <b>Número de documento:</b> <label>{{ $ing->num_documento }}</label><br>
            <b>Dirección:</b><label> {{ $ing->direccion }}<label><br>
                    <b>Teléfono:</b><label> {{ $ing->telefono }}<label><br>
                            <b>Email:</b><label> {{ $ing->email }}<label>
                                    @endforeach
        </div>
    </section>


    <section>
        <div>
            <table id="vendedor">
                <thead>
                    <tr id="cv">
                        <th>Comprobante</th>
                        <th>Serie y Número</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $ing->tipo_comprobante }}</td>
                        <td>{{ $ing->serie_comprobante }} núm.{{ $ing->num_comprobante }}</td>
                        <td>{{ $ing->usuario }}</td>
                        <td>{{ \Carbon\Carbon::parse($ing->fecha_compra)->formatLocalized("%d/%B/%Y")}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section>
        <div>
            <table id="medicamento">
                <thead>
                    <tr id="cm">
                        <th>Medicamento</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Blister</th>
                        <th>Vencimiento</th>
                        <th>Lote</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalles as $det)
                    <tr>
                        <td>{{ $det->articulo }}</td>
                        <td>{{ $det->precio }}</td>
                        <td>{{ $det->cantidad }}</td>
                        <td>{{ $det->cantidad_blister }}</td>
                        <td>{{  \Carbon\Carbon::parse($det->fecha_vencimiento)->formatLocalized("%d  %B %Y") }}</td>
                        <td>{{ $det->lote }}</td>
                        <td>{{ $det->precio * $det->cantidad }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @foreach ($ingreso as $ing)
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="background-color: #bdb795">TOTAL DE LA</th>
                        <th style="background-color: #bdb795"> COMPRA</th>
                        <td style="background-color: #bdb795">$ {{ $ing->total }}</td>
                    </tr>
                    @endforeach
                </tfoot>
            </table>
        </div>
    </section>

    <footer>
        <p class="pag">REPORTE DE DETALLE DE COMPRA
            <?php echo date("d-m-Y"  );?>
            Pagína
        </p>
    </footer>

</body>

</html>