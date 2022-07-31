<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Venta</title>
    <style>
        body {
        font-family: Arial, sans-serif; 
        font-size: 14px;
        }
 
        #logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        border-radius: 150px;
        }
 
        #imagen{
        width: 100px;
        }
 
        #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        /*text-align: justify;*/
        }
 
        #encabezado{
        text-align: center;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 15px;
        }
 
        #fact{
        /*position: relative;*/
        float: right;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 20px;
        }
 
        section{
        clear: left;
        }
 
        #cliente{
        text-align: left;
        }
 
        #facliente{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }
 
        #fac, #fv, #fa{
        color: #FFFFFF;
        font-size: 15px;
        }
 
        #facliente thead{
        padding: 20px;
        background: #795300;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;  
        }
 
        #facvendedor{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        text-align: center;
        margin-bottom: 15px;
        }
 
        #facvendedor thead{
        padding: 20px;
        background: #795300;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }
 
        #facarticulo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }
 
       /*  Aqui te dejo la ruta */

        /* /inventario/pdf/{id} */

        #facarticulo thead{
        padding: 20px;
        background: #795300;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }
 
        #gracias{
        text-align: center; 
        }
    </style>
    <body>
        @foreach ($ingreso as $ing)
        <header>
            <div id="logo">
                <img src="img/fundel.png"  id="imagen">
            </div>
            <div id="datos">
                <p id="encabezado">
                    <b>Fundel</b><br>Karla fundel, Santa Tecla,El Salvador<br>Telefono:(+503)734475859<br>Email: fundel123@gmail.com
                </p>
            </div>
            <div id="fact">
                <p>{{$ing->tipo_comprobante}}<br>
                {{$ing->serie_comprobante}}-{{$ing->num_comprobante}}</p>
            </div>
        </header>
        <br>
        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Proveedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>
                            <p id="datosprovee">
                                <b>Sr(a).</b>  {{$ing->nombre}}<br>
                                <b>Tipo de documento:</b> {{$ing->tipo_documento}}<br>
                                <b>Número de documento:</b>  {{$ing->num_documento}}<br>
                                <b>Dirección:</b> {{$ing->direccion}}<br>
                                <b>Teléfono:</b> {{$ing->telefono}}<br>
                                <b>Email:</b> {{$ing->email}}
                        </p>
                        </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        @endforeach
        <br>
        <section>
            <div>
                <table id="facvendedor">
                    <thead>
                        <tr id="fv">
                            <th>VENDEDOR</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">{{$ing->usuario}}</td>
                            <td class="text-center">{{$ing->created_at}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <section>
            <div>
                <table id="facarticulo">
                    <thead>
                        <tr id="fa">
                            <th>CANTIDAD</th>
                            <th>DESCRIPCION</th>
                            <th>PRECIO UNITARIO</th>
                            <th>PRECIO TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $det)
                        <tr>
                            <td>{{$det->cantidad}}</td>
                            <td>{{$det->articulo}}</td>
                            <td>{{$det->precio}}</td>
                            <td>{{$det->precio*$det->cantidad}}</td>                            
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @foreach ($ingreso as $ing)
                        <tr>
                            <th></th>
                            <th></th>+
                            <th>TOTAL COMPRA</th>
                            <td>$ {{$ing->total}}</td>
                        </tr>
                        @endforeach
                    </tfoot>
                </table>
            </div>
        </section>
        <br>
        <br>
        <footer>
            <div id="gracias">
                <p><b>GRACIAS POR SU PREFERENCIA DE PARTE DE FUNDEL</b></p>
            </div>
        </footer>
    </body>
</html>