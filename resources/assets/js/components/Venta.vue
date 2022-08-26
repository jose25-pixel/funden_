<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Ventas
                    <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <!-- Listado-->
                <template v-if="listado == 1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="fecha_salida">fecha_venta</option>
                                        <option value="nombre">nombre_cliente</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarVenta(1, buscar, criterio)"
                                        class="form-control" placeholder="Texto a buscar" />
                                    <button type="submit" @click="listarVenta(1, buscar, criterio)"
                                        class="btn btn-cafe">
                                        <i class="fa fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Usuario</th>
                                        <th>Cliente</th>
                                        <th>Fecha salida</th>
                                        <th>Tipo_Comprobante</th>
                                        <th>Num_Comprobante</th>
                                        <th>Total</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="venta in arrayVenta" :key="venta.id">
                                        <td>
                                            <button type="button" @click="verVenta(venta.id)"
                                                class="btn btn-success btn-sm">
                                                <i class="icon-eye"></i>
                                            </button>
                                            &nbsp;

                                            <button type="button" @click="pdfVenta(venta.id)"
                                                class="btn btn-danger btn-sm">
                                                  <i class="fa fa-file-pdf-o"></i>
                                            </button>
                                            &nbsp;
                                        </td>
                                        <td v-text="venta.usuario"></td>
                                        <td v-text="venta.nombre"></td>
                                        <td v-text="venta.fecha_salida"></td>
                                        <td v-text="venta.tipo_comprobante"></td>
                                        <td v-text="venta.num_comprobante"></td>
                                        <td v-text="venta.total"></td>
                                        <td v-text="venta.descripcion"></td>
                                         <div v-if="venta.estado">
                      <span class="badge badge-success">Registrada</span>
                    </div>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--Paginacion-->
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="
                                        cambiarPagina(
                                            pagination.current_page - 1,
                                            buscar,
                                            criterio
                                        )
                                    ">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page"
                                    :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)"
                                        v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="
                                        cambiarPagina(
                                            pagination.current_page + 1,
                                            buscar,
                                            criterio
                                        )
                                    ">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </template>
                <!--Fin Listado-->
                <!-- Detalle-->
                <template v-else-if="listado == 0">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Cliente<spam style="color: red">(*Ingrese)</spam></label>
                                    <v-select @search="selectCliente" label="nombre" :options="arrayCliente"
                                        placeholder="Buscar Clientes.." @input="getDatosCliente">
                                    </v-select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo Comprobante<spam style="color: red">(*Seleccione)</spam></label>
                                    <select class="form-control" v-model="tipo_comprobante">
                                        <option value="0">Seleccione</option>
                                        <option value="Credíto Fiscal">Credito Fiscal</option>
                                        <option value="FACTURA">Factura</option>
                                        <option value="TICKET">Ticket</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Número Comprobante<spam style="color: red">(*Ingrese)</spam></label>
                                    <input type="text" class="form-control" v-model="num_comprobante"
                                        placeholder="000xx" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Fecha Salida<spam style="color: red">(*Ingrese)</spam></label>
                                <input type="date" class="form-control" v-model="fecha_salida"
                                    placeholder="2020-7-12" />
                            </div>

                            <div class="col-md-4">
                                <label for="">Descripción<spam style="color: red">(*Ingrese)</spam></label>
                                <textarea class="form-control" v-model="descripcion" placeholder="Descripción" name=""
                                    id="" cols="53" rows="3"></textarea>
                                <br />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div v-show="errorVenta" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjVenta" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Meidacamento
                                        <spam style="color: red" v-show="idinventario == 0">(*Seleccione)</spam>
                                    </label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="nombre"
                                            @keyup.enter="buscarArticulo()" placeholder="Ingrese Medicamento" />
                                        <button @click="abrirModal()" class="btn btn-primary">
                                            Seleccionar
                                        </button>
                                        <input type="text" class="form-control" readonly v-model="inventario" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Precio
                                        <spam style="color: red" v-show="precio == 0">(*)</spam>
                                    </label>
                                    <input type="number" value="0" step="any" class="form-control" v-model="precio" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cantidad_pastillas<spam style="color: red" v-show="cantidad == 0">(*)
                                        </spam>
                                    </label>
                                    <input type="number" value="0" class="form-control" v-model="cantidad" />
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>cantidad_blister
                                        <spam style="color: red" v-show="cantidad_blister == 0">(*)</spam>
                                    </label>
                                    <input type="number" value="0" class="form-control" v-model="cantidad_blister" />
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar">
                                        <i class="icon-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Medicamento</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Cantidad_blister</th>
                                            <th>Fecha_vencimiento</th>
                                            <th>Lote</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle, index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.articulo"></td>
                                            <td>
                                                <input type="number" v-model="detalle.precio" class="form-control" />
                                            </td>
                                            <td>
                                                <span style="color: red" v-show="detalle.cantidad > detalle.stock">
                                                    Stock:{{ detalle.stock }}
                                                </span>
                                                <input type="number" v-model="detalle.cantidad" class="form-control" />
                                            </td>
                                            <td>
                                                <span style="color: red"
                                                    v-show="detalle.cantidad_blister > detalle.stockk">Stock:{{
                                                            detalle.stockk
                                                    }}
                                                </span>
                                                <input type="number" v-model="detalle.cantidad_blister"
                                                    class="form-control" />
                                            </td>
                                            <td>
                                              
                                                <input type="date" v-model="detalle.fecha_vencimiento"
                                                    class="form-control" />
                                            </td>
                                            <td>
                                                <input type="number" v-model="detalle.lote" class="form-control" />
                                            </td>

                                            <td>
                                                ${{ detalle.precio * detalle.cantidad }}
                                            </td>
                                        </tr>
                                        <tr style="background-color: #d8e4e4">
                                            <td colspan="7" align="right">
                                                <strong>Total Neto:</strong>
                                            </td>
                                            <td>$ {{ (total = calcularTotal) }}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="7">No hay medicamento agregado</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-dark">
                                    Cerrar
                                </button>
                                <button type="button" class="btn cafe" @click="registrarVenta()">
                                    Registrar Venta
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Fin Detalle-->
                <!-- Ver el ingreso ya-->
                <template v-else-if="listado == 2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for=""> <b>Cliente</b> </label>
                                    <p v-text="cliente"></p>
                                </div>
                               </div>
                                <div class="col-md-4">
                                <label for=""><b>Usuario</b></label>
                                <p v-text="usuario"></p>
                            </div>
                            <div class="col-md-4">
                                <label for=""><b>Tipo_Comprobante</b></label>
                                <p v-text="tipo_comprobante"></p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Num_Comprobante</b></label>
                                    <p v-text="num_comprobante"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Medicamento</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Cantidad_blister</th>
                                            <th>Fecha_vencimiento</th>
                                            <th>Lote</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.articulo"></td>
                                            <td v-text="detalle.precio"></td>
                                            <td v-text="detalle.cantidad"></td>
                                            <td v-text="detalle.cantidad_blister"></td>
                                            <td v-text="detalle.fecha_vencimiento"></td>
                                            <td v-text="detalle.lote"></td>
                                            <td>
                                                {{ detalle.precio * detalle.cantidad }}
                                            </td>
                                        </tr>
                                        <tr style="background-color: #dfdf9c">
                                            <td colspan="6" align="right">
                                                <strong>Total Neto:</strong>
                                            </td>
                                            <td>$ {{ total }}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6">No hay Medicamento agregado</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Fin ver ingreso-->
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{ mostrar: modal }" role="dialog" aria-labelledby="myModalLabel"
            style="display: none" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioA">
                                        <option value="nombre">Nombre</option>
                                        <option value="concentracion">concentracion</option>
                                        <option value="presentacion">Presentación</option>
                                    </select>
                                    <input type="text" v-model="buscarA"
                                        @keyup.enter="listarArticuloinventario(buscarA, criterioA)" class="form-control"
                                        placeholder="Texto a buscar" />
                                    <button type="submit" class="btn btn-primary"
                                        @click="listarArticuloinventario(buscarA, criterioA)">
                                        <i class="fa fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-responsive table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Concentracion</th>

                                        <th>C.Farmaceutica</th>
                                        <th>Administracion</th>
                                        <th>Presentacion</th>
                                        <th>stock pastillas</th>
                                        <th>stock superior</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="inventario in arrayInventario" :key="inventario.idproducto">
                                        <td>
                                            <button type="button" @click="agregarDetalleModal(inventario)"
                                                class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                            </button>
                                        </td>
                                        <td v-text="inventario.nombre"></td>
                                        <td v-text="
                                            inventario.concentracion + inventario.nombre_gramaje
                                        "></td>
                                        <td v-text="inventario.nombre_categoria"></td>
                                        <td v-text="inventario.administracion"></td>
                                        <td v-text="inventario.presentacion"></td>
                                        <td v-text="inventario.cantidad_tableta"></td>
                                        <td v-text="inventario.cantidad_blister"></td>
                                        <td>
                                            <div v-if="inventario.condicion">
                                                <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-else>
                                                <span class="badge badge-danger">Inactivo</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cafe" @click="cerrarModal()">
                            Cerrar
                        </button>
                        <button type="button" v-if="tipoAccion == 1" class="btn btn-primary"
                            @click="registrarPersona()">
                            Guardar
                        </button>
                        <button type="button" v-if="tipoAccion == 2" class="btn btn-primary"
                            @click="actualizarPersona()">
                            Actualizar
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    </main>
</template>

<script>
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

export default {
    data() {
        return {
            venta_id: 0,
            idcliente: 0,
            cliente: "",
            tipo_comprobante: "",
            num_comprobante: "",
            fecha_salida: "",
            usuario: "",
            total: 0.0,
            descripcion: "",
            totalImpuesto: 0.0,
            totalParcial: 0.0,
            arrayVenta: [],
            arrayCliente: [],
            arrayDetalle: [],
            listado: 1,
            modal: 0,
            tituloModal: "",
            tipoAccion: 0,
            errorVenta: 0,
            errorMostrarMsjVenta: [],
            pagination: {
                total: 0,
                current_page: 0,
                per_page: 0,
                last_page: 0,
                from: 0,
                to: 0,
            },
            offset: 3,
            criterio: "fecha_salida",
            buscar: "",
            criterioA: "nombre",
            buscarA: "",
            arrayArticulo: [],
            arrayInventario: [],
            idinventario: 0,
            nombre: "",
            articulo: "",
            inventario: "",
            precio: 0,
            cantidad: 0,
            cantidad_blister: 0,
            stock: 0,
            stockk: 0,
            fecha_vencimiento: "",
            lote: 0,
        };
    },
    components: {
        vSelect,
    },
    computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        //Calcula los elementos de la paginación
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }

            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }

            var to = from + this.offset * 2;
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }

            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
        calcularTotal: function () {
            var resultado = 0.0;
            for (var i = 0; i < this.arrayDetalle.length; i++) {
                resultado =
                    resultado +
                    this.arrayDetalle[i].precio * this.arrayDetalle[i].cantidad;
            }
            return resultado;
        },
    },
    methods: {
        listarVenta(page, buscar, criterio) {
            let me = this;
            var url =
                "/venta?page=" + page + "&buscar=" + buscar + "&criterio=" + criterio;
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayVenta = respuesta.ventas.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectCliente(search, loading) {
            let me = this;
            loading(true);

            var url = "/cliente/selectCliente?filtro=" + search;
            axios
                .get(url)
                .then(function (response) {
                    let respuesta = response.data;
                    q: search;
                    me.arrayCliente = respuesta.clientes;
                    loading(false);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getDatosCliente(val1) {
            let me = this;
            me.loading = true;
            me.idcliente = val1.id;
        },
        buscarArticulo() {
            let me = this;
            var url = "/inventario/buscarArticuloInventariov?filtro=" + me.nombre;

            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayInventario = respuesta.inventarios;

                    if (me.arrayInventario.length > 0) {
                        me.inventario = me.arrayInventario[0]["nombre"];
                        me.idinventario = me.arrayInventario[0]["precio"];
                        me.idinventario = me.arrayInventario[0]["id"];
                        me.stock = me.arrayInventario[0]["cantidad_tableta"];
                        me.stockk = me.arrayInventario[0]["cantidad_blister"];
                    } else {
                        me.inventario = "No existen Medicamentos";
                        me.idinventario = 0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        pdfVenta(id) {
            window.open("/venta/pdf/" + id + "," + "_blank");
        },

        cambiarPagina(page, buscar, criterio) {
            let me = this;
            //Actualiza la página actual
            me.pagination.current_page = page;
            //Envia la petición para visualizar la data de esa página
            me.listarVenta(page, buscar, criterio);
        },
        encuentra(id) {
            var sw = 0;

            for (var i = 0; i < this.arrayDetalle.length; i++) {
                if (this.arrayDetalle[i].idinventario == id) {
                    sw = true;
                }
            }
            return sw;
        },
        eliminarDetalle(index) {
            let me = this;
            me.arrayDetalle.splice(index, 1);
        },

        agregarDetalle() {
            let me = this;

            if (
                me.idinventario == 0 ||
                me.cantidad == 0 ||
                me.cantidad_blister == 0 ||
                me.precio == 0 ||
                me.fecha_vencimiento == 0 ||
                me.lote == 0
            ) {
            } else {
                if (me.encuentra(me.idinventario)) {
                    swal({
                        type: "error",
                        title: "Error....",
                        text: "Ese Medicamento ya se encuentra agregado!",
                    });
                } else {
                    if (me.cantidad > me.stock) {
                        swal({
                            type: "error",
                            title: "Error....",
                            text: "No hay stock disponible !",
                        });
                    } else {
                        me.arrayDetalle.push({
                            idinventario: me.idinventario,
                            articulo: me.nombre, //para mostrar el noombre del articulo en busqueda por nombre

                            cantidad: me.cantidad,
                            cantidad_blister: me.cantidad_blister,
                            precio: me.precio,
                            cantidad_tableta: me.stock,
                            cantidad_blister: me.stockk,
                            fecha_vencimiento: me.fecha_vencimiento,
                            lote: me.lote,
                        });

                        me.nombre = "";
                        me.idinventario = 0;
                        me.inventario = "";
                        me.cantidad = 0;
                        me.cantidad_blister = 0;
                        me.precio = 0;
                        me.fecha_vencimiento = "";
                        me.lote = 0;
                        me.stock = 0;
                        me.stockk = 0;
                    }
                }
            }
        },
        agregarDetalleModal(data = []) {
            let me = this;

            if (me.encuentra(data["id"])) {
                swal({
                    type: "error",
                    title: "Error....",
                    text: "Ese Medicamento ya se encuentra agregado!",
                });
            } else {
                me.arrayDetalle.push({
                    idinventario: data["id"],
                    articulo: data["nombre"],
                    cantidad: 1,
                    cantidad_blister: 1,
                    stock: data["cantidad_tableta"],
                    stockk: data["cantidad_blister"],
                    precio: 0,
                    fecha_vencimiento: "",
                    lote: 0,
                });
            }
        },

        //listar articulo
        listarArticuloinventario(buscar, criterio) {
            let me = this;
            var url =
                "/inventario/buscarArticuloInventarioventa?buscar=" +
                buscar +
                "&criterio=" +
                criterio;
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    //handle sucess
                    me.arrayInventario = respuesta.inventarios.data;
                })
                .catch(function (error) {
                    //handle error
                    console.log(error);
                });
        },
        registrarVenta() {
            if (this.validarVenta()) {
                return;
            }

            let me = this;

            axios
                .post("/venta/registrar", {
                    idcliente: this.idcliente,
                    tipo_comprobante: this.tipo_comprobante,
                    num_comprobante: this.num_comprobante,
                    fecha_salida: this.fecha_salida,
                    total: this.total,
                    descripcion: this.descripcion,
                    data: this.arrayDetalle,
                })
                .then(function (response) {
                    me.listado = 1;
                    me.listarVenta(1, "", "num_comprobante");
                    me.idcliente = 0;
                    me.tipo_comprobante = "BOLETA";
                    me.num_comprobante = "";
                    me.total = 0.0;
                    (me.descripcion = ""), (me.idinvetario = 0);
                    me.inventario = "";
                    me.articulo = "";
                    me.fecha_salida = "";
                    me.cantidad = 0;
                    me.precio = 0;
                    me.stock = 0;
                    me.stockk = 0;
                    me.cantidad_blister = 0;
                    me.fecha_vencimiento = "";
                    me.lote = "";
                    me.arrayDetalle = [];
                    //window.open('/venta/pdf/'+ response.data.id + ',' + '_blank');
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        validarVenta() {
            let me = this;
            me.errorVenta = 0;
            me.errorMostrarMsjVenta = [];
            var art;

            me.arrayDetalle.map(function (x) {
                if (x.cantidad > x.stock) {
                    art = x.articulo + x.stock + "Con stock insuficiente";
                    me.errorMostrarMsjVenta.push(art);
                }
            });

            if (this.idcliente == 0)
                this.errorMostrarMsjVenta.push("Seleccione un Cliente .");
            if (this.tipo_comprobante == 0)
                this.errorMostrarMsjVenta.push("Seleccione el comprobante.");
            if (!this.num_comprobante)
                this.errorMostrarMsjVenta.push("Ingrese el número de comprobante.");
            if (this.fecha_salida == 0)
                this.errorMostrarMsjVenta.push("Seleccione el fecha.");
            if (this.descripcion == 0)
                this.errorMostrarMsjVenta.push("Ingrese descripción.");
            if (this.arrayDetalle.length <= 0)
                this.errorMostrarMsjVenta.push("Ingrese detalles.");

            if (this.errorMostrarMsjVenta.length) this.errorVenta = 1;

            return this.errorVenta;
        },
        mostrarDetalle() {
            let me = this;
            this.listado = 0;
            me.idproveedor = 0;
            me.tipo_comprobante = 0, 
            me.num_comprobante = "";
            me.fecha_salida = "";
            me.total = 0.0;
            me.descripcion = "";
            me.idarticulo = 0;
            me.cantidad = 0;
            me.precio = 0;
            me.fecha_vencimiento = "";
            me.lote = "";
            me.arrayDetalle = [];
        },
        verVenta(id) {
            let me = this;
            this.listado = 2;

            //Obtener los datos del ingreso++++
            var arrayVentaT = [];

            var url = "/venta/obtenerCabecera?id=" + id;

            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    arrayVentaT = respuesta.venta;
                    me.cliente = arrayVentaT[0]["nombre"];
                    me.tipo_comprobante = arrayVentaT[0]["tipo_comprobante"];
                    me.num_comprobante = arrayVentaT[0]["num_comprobante"];
                    me.fecha_salida = arrayVentaT[0]["fecha_salida"];
                    me.total = arrayVentaT[0]["total"];
                })
                .catch(function (error) {
                    console.log(error);
                });
            //Obtener los datos del detalle++++

            var url = "/venta/obtenerDetalles?id=" + id;

            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        ocultarDetalle() {
            this.listado = 1;
        },
        cerrarModal() {
            this.modal = 0;
            this.tituloModal = "";
        },
        abrirModal() {
            this.arrayInventario = [];
            this.modal = 1;
            this.tituloModal = "Seleccione uno o varios Medicamentos";
        },
        desactivarVenta(id) {
            swal({
                title: "Esta seguro de anular esta Venta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar!",
                cancelButtonText: "Cancelar",
                confirmButtonClass: "btn btn-success",
                cancelButtonClass: "btn btn-danger",
                buttonsStyling: false,
                reverseButtons: true,
            }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios
                        .put("/venta/desactivar", {
                            id: id,
                        })
                        .then(function (response) {
                            me.listarVenta(1, "", "num_comprobante");
                            swal(
                                "Anulado!",
                                "La Venta ha sido anulada con éxito.",
                                "success"
                            );
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                }
            });
        },
    },
    mounted() {
        this.listarVenta(1, this.buscar, this.criterio);
    },
};
</script>
<style>
.modal-content {
    width: 100% !important;
    position: absolute !important;
}

.mostrar {
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
}

.div-error {
    display: flex;
    justify-content: center;
}

.text-error {
    color: red !important;
    font-weight: bold;
}

@media (min-width: 600px) {
    .btnagregar {
        margin-top: 2rem;
    }
}
</style>
