<!DOCTYPE>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Reporte de Venta</title>
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

    #cv,
    #cm {
        color: #0c0c0c;
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
        background: #b4a36b;
        text-align: center;
        border-bottom: 1px solid #f8f5f5;
    }

    #medicamento {
        width: 100%;
        border-collapse: collapse;
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

    .descripcion p {
        padding: 3px;
        width: 98%;
      text-align: left;
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
        <div class="cliente">
        <h4 style="text-align:center">REPORTE DE DETALLE DE VENTA REALIZADO</h4>

            @foreach ($venta as $v)
                <h4>CLIENTE</h4>
                <b>Nombre: </b><label>{{ $v->nombre }}</label><br>
                <b>Documento: </b><label>{{ $v->tipo_comprobante }} ----{{ $v->num_documento }}</label><br>
                <b>Dirección: </b><label>{{ $v->direccion }}</label><br>
                <b>Teléfono: </b><label>{{ $v->telefono }}</label><br>
                <b>Email: </b><label>{{ $v->email }}</label>
            @endforeach
        </div>
    </section>

    <section>
        <div>
            <table id="vendedor">
                <thead>
                    <tr id="cv">
                        <th>Comprobante de venta</th>
                        <th>Vendedor</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $v->tipo_comprobante }}--{{ $v->num_comprobante }}</td>
                        <td>{{ $v->usuario }}</td>
                        <td>{{ $v->fecha_salida }}</td>
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
                            <td>{{ $det->fecha_vencimiento }}</td>
                            <td>{{ $det->lote }}</td>
                            <td>{{ $det->precio * $det->cantidad }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @foreach ($venta as $v)
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="background-color: #bdb795">TOTAL</th>
                            <td style="background-color: #bdb795">$ {{ $v->total }}</td>
                        </tr>
                    @endforeach
                </tfoot>
            </table>
        </div>

        <div class="descripcion">
            <b>Se desarrollo en;</b>
            <p> {{ $v->descripcion }}</p>
        </div>
    </section>

    <footer>
        <h3>(FUNDEL)--REPORTE  DE VENTA {{ now() }}<h3>
        </h1>
    </footer>
</body>

</html>
