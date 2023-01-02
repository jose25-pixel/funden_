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
                    <i class="fa fa-align-justify"></i> Ingresos
                    <button type="button" @click="mostrarDetalle()" class="btn btn-cafe">
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
                                        <option value="tipo_comprobante">Tipo Comprobante</option>
                                        <option value="num_comprobante">Número Comprobante</option>
                                        <option value="fecha_compra">Fecha-Compra</option>
                                    </select>
                                    <input type="text" v-model="buscar"
                                        @keyup.enter="listarIngreso(1, buscar, criterio)" class="form-control"
                                        placeholder="Texto a buscar" />
                                    <button type="submit" @click="listarIngreso(1, buscar, criterio)"
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
                                        <th>Proveedor</th>
                                        <th>Tipo Comprobante</th>
                                        <th>Serie Comprobante</th>
                                        <th>Número Comprobante</th>
                                        <th>Fecha Compra</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ingreso in arrayIngreso" :key="ingreso.id">
                                        <td>

                                            <button type="button" @click="pdfIngreso(ingreso.id)"
                                                class="btn btn-danger btn-sm">
                                                <i class="fa fa-file-pdf-o"></i>
                                            </button>
                                            <button type="button" @click="verIngreso(ingreso.id)"
                                                class="btn btn-success btn-sm">
                                                <i class="icon-eye"></i>
                                            </button>

                                        </td>
                                        <td v-text="ingreso.usuario"></td>
                                        <td v-text="ingreso.nombre"></td>
                                        <td v-text="ingreso.tipo_comprobante"></td>
                                        <td v-text="ingreso.serie_comprobante"></td>
                                        <td v-text="ingreso.num_comprobante"></td>
                                        <td v-text="ingreso.fecha_compra"></td>
                                        <td v-text="ingreso.total"></td>
                                        <td v-text="ingreso.estado">

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
                                    <label for="">Proveedor</label>
                                    <span style="color: red" v-show="arrayProveedor == 0">(*Ingrese)
                                    </span>
                                    <v-select @search="selectProveedor" label="nombre" :options="arrayProveedor"
                                        placeholder="Buscar Proveedores..." @input="getDatosProveedor">
                                    </v-select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo Comprobante</label>
                                    <span style="color: red" v-show="tipo_comprobante == 0">(*Ingrese)
                                    </span>
                                    <select class="form-control" v-model="tipo_comprobante">
                                        <option value="0">Seleccione</option>
                                        <option value="CCF">Credito Fiscal</option>
                                        <option value="FACTURA">Factura</option>
                                        <option value="TICKET">Ticket</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Serie Comprobante</label>
                                    <span style="color: red" v-show="serie_comprobante == 0">(*Ingrese)
                                    </span>
                                    <input type="text" class="form-control" v-model="serie_comprobante"
                                        placeholder="000x" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Número Comprobante</label>
                                    <span style="color: red" v-show="num_comprobante == 0">(*Ingrese)
                                    </span>
                                    <input type="text" class="form-control" v-model="num_comprobante"
                                        placeholder="000xx" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha_Compra</label>
                                    <span style="color: red" v-show="fecha_compra == 0">(*Seleccione)
                                    </span>
                                    <input type="date" class="form-control" v-model="fecha_compra"
                                        placeholder="Seleccione la fecha" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div v-show="errorIngreso" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjIngreso" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Medicamento </label>
                                    <span style="color: red" v-show="arrayInventario == 0">(*Seleccione)
                                    </span>

                                    <div class="form-inline">
                                        <!--   <input type="text" class="form-control" v-model="nombre"
                                              @keyup.enter="buscarArticulo()"
                                              placeholder="Visualizar medicamentos."
                                          />-->
                                        <button @click="abrirModal()" class="btn btn-primary">
                                            Seleccionar.
                                        </button>
                                        <input type="text" class="form-control" readonly v-model="inventario" />
                                    </div>
                                </div>
                            </div>

                            <!--Para mostrar el boton verde de agregar el produto
                              <div class="col-md-2">
                                  <div class="form-group">
                                      <button
                                          @click="agregarDetalle()"
                                          class="btn btn-success form-control btnagregar"
                                      >
                                          <i class="icon-plus"></i>
                                      </button>
                                  </div>
                              </div>-->
                        </div>
                        <!--para mostrar el detalle de la compra en el ojo-->
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Medicamento</th>
                                            <th>Precio</th>
                                            <th>Tratamientos</th> <!-- Blister-->
                                            <th>Ítems X Tratamiento <label> </label></th> <!-- Pastillas-->
                                            <th>Fecha Vencimiento</th>
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
                                            <td v-text="detalle.nombre"></td>
                                            <td>
                                                <span style="color: red" v-show="detalle.precio == 0">(*Ingrese)
                                                </span>
                                                <input type="number" v-model="detalle.precio" class="form-control"
                                                    placeholder="Precio Unidad" />
                                            </td>
                                            <td>
                                                <span style="color: blue" v-text="detalle.items"></span><span
                                                    style="color: red"
                                                    v-show="detalle.cantidad_blister == ''">(*Ingrese)
                                                </span>
                                                <input type="number" v-model="detalle.cantidad_blister"
                                                    class="form-control" placeholder="Ingrese " />
                                            </td>
                                            <td>
                                                <span style="color: red" v-show="detalle.cantidad == 0">(*Ingrese)
                                                </span>
                                                <input type="number" v-model="detalle.cantidad" class="form-control"
                                                    placeholder="Ingrese" />
                                            </td>

                                            <td>
                                                <span style="color: red"
                                                    v-show="detalle.fecha_vencimiento == 0">(*Ingrese)
                                                </span>
                                                <input type="date" v-model="detalle.fecha_vencimiento"
                                                    class="form-control" />
                                            </td>
                                            <td>
                                                <span style="color: red" v-show="detalle.lote == 0">(*Ingrese)
                                                </span>
                                                <input type="text" v-model="detalle.lote" class="form-control"
                                                    placeholder="xx0000" />
                                            </td>

                                            <td>${{ detalle.precio * detalle.cantidad }}</td>
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
                                            <td colspan="7">No hay medicina agregada</td>
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
                                <button type="button" class="btn cafe" @click="registrarIngreso()">
                                    Registrar Compra
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Fin Detalle-->
                <!-- Visualización de la compra y del detalle de compra-->
                <template v-else-if="listado == 2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for=""> <b>Proveedor</b> </label>
                                    <p v-text="proveedor"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Tipo Comprobante</b></label>
                                    <p v-text="tipo_comprobante"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Serie Comprobante</b></label>
                                    <p v-text="serie_comprobante"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Número Comprobante</b></label>
                                    <p v-text="num_comprobante"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Fecha Compra</b></label>
                                    <p v-text="fecha_compra"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Total</b></label>
                                    <p v-text="total"></p>
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
                                            <th>Tratamientos</th><!-- Blister-->
                                            <th>Ítems X Tratamientos</th><!-- Pastillas-->
                                            <th>Fecha vencimiento</th>
                                            <th>Lote</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.articulo"></td>
                                            <td v-text="detalle.precio"></td>
                                            <td v-text="detalle.cantidad_blister"></td>
                                            <td v-text="detalle.cantidad"></td>
                                            <td v-text="detalle.fecha_vencimiento"></td>
                                            <td v-text="detalle.lote"></td>
                                            <td>${{ detalle.precio * detalle.cantidad }}</td>
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
                                            <td colspan="6">No hay medicamento agregado</td>
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
                <!-- Editar de la compra y del detalle de compra------en desarrollo  -->

                <!-- Fin editar ingreso-->
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar ingreso-->
        <div class="modal fade" tabindex="-1" :class="{ mostrar: modal }" role="dialog" aria-labelledby="myModalLabel"
            style="display: none" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header cafe col-md-12">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <!-- MODAL PARA MOSTRAR LOS PRODUCTOS AL LA HORA DE RELIZAR LA COMPRA -->

                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioA">
                                        <option value="nombre">Nombre</option>
                                        <option value="concentracion">Concentración</option>
                                        <option value="presentacion">Presentación</option>
                                        <option value="items">Items</option>
                                    </select>
                                    <input type="text" v-model="buscarA"
                                        @keyup.enter="listarArticuloinventario(buscarA, criterioA)" class="form-control"
                                        placeholder="Texto a buscar" />
                                    <button type="submit" class="btn btn-cafe"
                                        @click="listarArticuloinventario(buscarA, criterioA)">
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
                                        <th>Medicament.</th>
                                        <th>Concentración</th>
                                        <th>C.Farmacéutica</th>
                                        <th>Administraci.</th>
                                        <th>Presentación</th>
                                        <th>Items</th>
                                        <th>Tratamient.</th><!-- Blister-->
                                        <th>Ítems X Tratamient.</th><!-- Pastillas-->
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
                                        <td v-text="inventario.items"></td>
                                        <td v-text="inventario.cantidad_blister"></td>
                                        <td v-text="inventario.cantidad_tableta"></td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" @click="cerrarModal()">
                            Cerrar </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal agregar/actualizar-->
    </main>
</template>
  
<script>
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";


export default {
    data() {
        return {
            ingreso_id: 0,
            idproveedor: 0,
            proveedor: "",
            nombre: "",
            tipo_comprobante: "",
            serie_comprobante: "",
            num_comprobante: "",
            fecha_compra: "",
            total: 0.0,
            totalImpuesto: 0.0,
            totalParcial: 0.0,
            arrayIngreso: [],
            arrayProveedor: [],
            arrayDetalle: [],
            listado: 1,
            modal: 0,
            tituloModal: "",
            tipoAccion: 0,
            errorIngreso: 0,
            errorMostrarMsjIngreso: [],
            pagination: {
                total: 0,
                current_page: 0,
                per_page: 0,
                last_page: 0,
                from: 0,
                to: 0,
            },
            offset: 3,
        /**/ criterio: "num_comprobante",
        /**/ buscar: "",
            criterioA: "nombre",
            buscarA: "",
        //arrayArticulo: [],
        /**/ arrayInventario: [],
        /**/ idinventario: 0,
        /**/ nombre: "",
            items: "",
            presentacion: "",
        //articulo: "",
        /**/ inventario: "",
        /**/ precio: 0,
        /**/ cantidad: 0,
        /**/ cantidad_blister: 0,
        /**/ fecha_vencimiento: "",
        /**/ lote: "",
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
        listarIngreso(page, buscar, criterio) {
            let me = this;
            var url =
                "/ingreso?page=" + page + "&buscar=" + buscar + "&criterio=" + criterio;
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayIngreso = respuesta.ingresos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectProveedor(search, loading) {
            let me = this;
            loading(true);

            var url = "/proveedor/selectProveedor?filtro=" + search;
            axios
                .get(url)
                .then(function (response) {
                    let respuesta = response.data;
                    q: search;
                    me.arrayProveedor = respuesta.proveedores;
                    loading(false);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getDatosProveedor(val1) {
            let me = this;
            me.loading = true;
            me.idproveedor = val1.id;
        },
        buscarArticulo() {
            let me = this;
            var url = "/inventario/buscarArticuloInventario?filtro=" + me.nombre;

            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayInventario = respuesta.inventarios;

                    if (me.arrayInventario.length > 0) {
                        me.inventario = me.arrayInventario[0]["nombre"];
                        me.items = me.arrayInventario[0]["items"];
                        me.presentacion = me.arrayInventario[0]["presentacion"];
                        me.idinventario = me.arrayInventario[0]["id"];
                    } else {
                        me.inventario = "No existen articulos";
                        me.idinventario = 0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        },

        cambiarPagina(page, buscar, criterio) {
            let me = this;
            //Actualiza la página actual
            me.pagination.current_page = page;
            //Envia la petición para visualizar la data de esa página
            me.listarIngreso(page, buscar, criterio);
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
                    me.arrayDetalle.push({
                        idinventario: me.idinventario,
                        nombre: me.nombre,
                        items: me.items,
                        cantidad: me.cantidad,
                        cantidad_blister: me.cantidad_blister,
                        precio: me.precio,
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
                    nombre: data["nombre"],
                    items: data["items"],
                    presentacion: data["presentacion"],
                    cantidad: "",
                    cantidad_blister: "",
                    precio: "",
                    fecha_vencimiento: "",
                    lote: "",
                });
            }
        },

        //listar articulo para selecionar al ingreso
        listarArticuloinventario(buscar, criterio) {
            let me = this;
            var url =
                "/inventario/buscarArticuloin?buscar=" +
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
        registrarIngreso() {
            if (this.validarIngreso()) {
                return;
            }
            swal({
                title:
                    "Esta seguro de registrar el medicamento?  Verifique los datos ingresados!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "green",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar!",
                cancelButtonText: "Cancelar!",
                confirmButtonClass: "btn btn-success",
                cancelButtonClass: "btn btn-danger",
                buttonsStyling: false,
                reverseButtons: true,
            }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios
                        .post("/ingreso/registrar", {
                            idproveedor: this.idproveedor,
                            tipo_comprobante: this.tipo_comprobante,
                            serie_comprobante: this.serie_comprobante,
                            num_comprobante: this.num_comprobante,
                            fecha_compra: this.fecha_compra,
                            total: this.total,
                            data: this.arrayDetalle,
                        })
                        .then(function (response) {
                            me.listado = 1;
                            me.listarIngreso(1, "", "fecha_compra");
                            me.idproveedor = 0;
                            me.tipo_comprobante = "CCF";
                            me.serie_comprobante = "";
                            me.num_comprobante = "";
                            me.fecha_compra = "";
                            me.total = 0.0;
                            me.idinventario = 0;
                            me.inventario = "";
                            me.cantidad = 0;
                            me.cantidad_blister = 0;
                            me.precio = 0;
                            me.fecha_vencimiento = "";
                            me.lote = "";
                            me.arrayDetalle = [];
                            swal(
                                "Medicamentos Ingresados!",
                                "El ingreso se realizo con éxito.",
                                "success"
                            );
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
        },
        //en desarrollo
        UpdateIngreso() {
            if (this.validarIngreso()) {
                return;
            }
            swal({
                title:
                    "Esta seguro de actualizar los datos?  Verifique los datos ingresados!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "green",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar!",
                cancelButtonText: "Cancelar!",
                confirmButtonClass: "btn btn-success",
                cancelButtonClass: "btn btn-danger",
                buttonsStyling: false,
                reverseButtons: true,
            }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios
                        .post("/ingreso/update", {
                            idproveedor: this.idproveedor,
                            tipo_comprobante: this.tipo_comprobante,
                            serie_comprobante: this.serie_comprobante,
                            num_comprobante: this.num_comprobante,
                            fecha_compra: this.fecha_compra,
                            total: this.total,

                        })
                        .then(function (response) {
                            me.listado = 1;
                            me.listarIngreso(1, "", "fecha_compra");

                            swal(
                                "Medicamentos Ingresados!",
                                "El ingreso se realizo con éxito.",
                                "success"
                            );
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
        },
        //fin de prueba de desarrolllo
        validarIngreso() {
            this.errorIngreso = 0;
            this.errorMostrarMsjIngreso = [];

            if (this.idproveedor == 0)
                this.errorMostrarMsjIngreso.push("Seleccione un Proveedor.");
            if (this.tipo_comprobante == 0)
                this.errorMostrarMsjIngreso.push("Seleccione el  tipo comprobante.");
            if (!this.num_comprobante)
                this.errorMostrarMsjIngreso.push("Ingrese el número de comprobante.");
            if (!this.fecha_compra)
                this.errorMostrarMsjIngreso.push("Seleccione la fecha de compra.");
            if (this.arrayDetalle.length <= 0)
                this.errorMostrarMsjIngreso.push("Ingrese detalles.");
            if (this.errorMostrarMsjIngreso.length) this.errorIngreso = 1;

            return this.errorIngreso;
        },
        mostrarDetalle() {
            let me = this;
            this.listado = 0;
            /*dejara las variables vacias cuando el usuario ingres una compra pero no la registra se actualiza*/
            me.idproveedor = 0;
            me.tipo_comprobante = "";
            me.serie_comprobante = "";
            me.num_comprobante = "";
            me.fecha_compra = "";
            me.total = 0.0;
            me.idinventario = 0;
            me.inventario = "";
            me.cantidad = 0;
            me.cantidad_blister = 0;
            me.precio = 0;
            me.fecha_vencimiento = "";
            me.lote = "";
            me.arrayDetalle = [];
        },
        verIngreso(id) {
            let me = this;
            this.listado = 2;
            //Obtener los datos del ingreso++++
            var arrayIngresoT = [];
            var url = "/ingreso/obtenerCabecera?id=" + id;
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    arrayIngresoT = respuesta.ingreso;
                    me.proveedor = arrayIngresoT[0]["nombre"];
                    me.tipo_comprobante = arrayIngresoT[0]["tipo_comprobante"];
                    me.serie_comprobante = arrayIngresoT[0]["serie_comprobante"];
                    me.num_comprobante = arrayIngresoT[0]["num_comprobante"];
                    me.fecha_compra = arrayIngresoT[0]["fecha_compra"];
                    me.total = arrayIngresoT[0]["total"];
                })
                .catch(function (error) {
                    console.log(error);
                });
            //Obtener los datos del detalle++++
            var url = "/ingreso/obtenerDetalles?id=" + id;
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
        AnularIngreso(id) {
            swal({
                title: "Esta seguro de anular este ingreso?",
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
                        .delete("eliminar/ingreso/anular?id=" + id, {

                        })
                        .then(function (response) {
                            me.listarIngreso(1, "", "num_comprobante");
                            swal(
                                "Anulado!",
                                "El ingreso ha sido anulado con éxito.",
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


        /*funcion para editar los ingresos en desarrollo*/
        EditarIngreso(id) {
            let me = this;
            this.listado = 3;
            //Obtener los datos del ingreso++++
            var arrayIngresoE = [];
            var url = "/ingreso/obtenerEditar?id=" + id;
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    arrayIngresoE = respuesta.ingreso;
                    me.proveedor = arrayIngresoE[0]["nombre"];
                    me.tipo_comprobante = arrayIngresoE[0]["tipo_comprobante"];
                    me.serie_comprobante = arrayIngresoE[0]["serie_comprobante"];
                    me.num_comprobante = arrayIngresoE[0]["num_comprobante"];
                    me.fecha_compra = arrayIngresoE[0]["fecha_compra"];
                    me.total = arrayIngresoE[0]["total"];
                })
                .catch(function (error) {
                    console.log(error);
                });
            //Obtener los datos del detalle++++
            var url = "/ingreso/editarDetalles?id=" + id;
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
        pdfIngreso(id) {
            window.open("/ingreso/pdf/" + id + "," + "_blank");
        },
        ocultarDetalle() {
            this.listado = 1;
        },
        cerrarModal() {
            this.modal = 0;
            this.tituloModal = "";
            this.buscar = "";
        },
        abrirModal() {
            this.arrayInventario = [];
            this.modal = 1;
            this.tituloModal = "Seleccione uno o varios medicamentos";
        },
        desactivarIngreso(id) {
            swal({
                title: "Esta seguro de anular este ingreso?",
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
                        .put("/ingreso/desactivar", {
                            id: id,
                        })
                        .then(function (response) {
                            me.listarIngreso(1, "", "num_comprobante");
                            swal(
                                "Anulado!",
                                "El ingreso ha sido anulado con éxito.",
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
        this.listarIngreso(1, this.buscar, this.criterio);
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
  