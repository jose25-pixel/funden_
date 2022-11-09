<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card ">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Ventas
                   
                </div>
                <!-- Listado-->
                <template v-if="listado == 1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="tipo_comprobante">Tipo_Comprobante</option>
                                        <option value="num_comprobante">Número_Comprobante</option>
                                        <option value="fecha_salida">Fecha_venta</option>
                                        <option value="descripcion">Descripción</option>
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
                                        <th>Nombre_de_Cliente</th>
                                        <th>Fecha_de_salida</th>
                                        <th>Tipo_Comprobante</th>
                                        <th>Número_Comprobante</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="venta in arrayVenta" :key="venta.id"> 
                                        <td>
                                            <button type="button" @click="pdfVenta(venta.id)"
                                                class="btn btn-danger btn-sm">
                                                  <i class="fa fa-file-pdf-o"></i>
                                            </button>
                                            &nbsp;
                                            <button type="button" @click="verVenta(venta.id)"
                                            class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                        </button>
                                        &nbsp;
                                        </td>
                                        <td v-text="venta.usuario"></td>
                                        <td v-text="venta.nombre"></td>
                                        <td v-text="venta.fecha_salida"></td>
                                        <td v-text="venta.tipo_comprobante"></td>
                                        <td v-text="venta.num_comprobante"></td>
                                        <td v-text="venta.total"></td>
                                        <td v-text="venta.estado"></td>
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
                                <label for=""><b>Tipo_Comprobante</b></label>
                                <p v-text="tipo_comprobante"></p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Número de Comprobante</b></label>
                                    <p v-text="num_comprobante"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Fecha  de venta</b></label>
                                    <p v-text="fecha_salida"></p>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="form-group">
                                    <label><b>Descripción</b></label>
                                    <p v-text="descripcion"></p>
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
               
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
       
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
            criterio: "tipo_comprobante",
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
            presentacionv:"",
            itemsv:""
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
                    me.descripcion = arrayVentaT[0]["descripcion"];
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
      
    },
    mounted() {
        this.listarVenta(1, this.buscar, this.criterio);
    },
};
</script>
