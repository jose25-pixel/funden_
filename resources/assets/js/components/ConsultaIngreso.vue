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
                    <input
                      type="text"
                      v-model="buscar"
                      @keyup.enter="listarIngreso(1, buscar, criterio)"
                      class="form-control"
                      placeholder="Texto a buscar"
                    />
                    <button
                      type="submit"
                      @click="listarIngreso(1, buscar, criterio)"
                      class="btn btn-cafe"
                    >
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
                       
                        <button
                        type="button"
                        @click="pdfIngreso(ingreso.id)"
                        class="btn btn-danger btn-sm"
                      >
                        <i class="fa fa-file-pdf-o"></i>
                      </button>
                      <button
                      type="button"
                      @click="verIngreso(ingreso.id)"
                      class="btn btn-success btn-sm"
                    >
                      <i class="icon-eye"></i>
                    </button>
                    &nbsp;
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
                    <a
                      class="page-link"
                      href="#"
                      @click.prevent="
                        cambiarPagina(
                          pagination.current_page - 1,
                          buscar,
                          criterio
                        )
                      "
                      >Ant</a
                    >
                  </li>
                  <li
                    class="page-item"
                    v-for="page in pagesNumber"
                    :key="page"
                    :class="[page == isActived ? 'active' : '']"
                  >
                    <a
                      class="page-link"
                      href="#"
                      @click.prevent="cambiarPagina(page, buscar, criterio)"
                      v-text="page"
                    ></a>
                  </li>
                  <li
                    class="page-item"
                    v-if="pagination.current_page < pagination.last_page"
                  >
                    <a
                      class="page-link"
                      href="#"
                      @click.prevent="
                        cambiarPagina(
                          pagination.current_page + 1,
                          buscar,
                          criterio
                        )
                      "
                      >Sig</a
                    >
                  </li>
                </ul>
              </nav>
            </div>
          </template>
          <!--Fin Listado-->
         
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
                        <th>Cantidad</th>
                        <th>Blister</th>
                        <th>Fecha vencimiento</th>
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
                  <button
                    type="button"
                    @click="ocultarDetalle()"
                    class="btn btn-secondary"
                  >
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
      <div
        class="modal fade"
        tabindex="-1"
        :class="{ mostrar: modal }"
        role="dialog"
        aria-labelledby="myModalLabel"
        style="display: none"
        aria-hidden="true"
      >
        
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
        /**/ criterio: "tipo_comprobante",
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
    
      cambiarPagina(page, buscar, criterio) {
        let me = this;
        //Actualiza la página actual
        me.pagination.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.listarIngreso(page, buscar, criterio);
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
   
      pdfIngreso(id) {
        window.open("/ingreso/pdf/" + id + "," + "_blank");
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
  