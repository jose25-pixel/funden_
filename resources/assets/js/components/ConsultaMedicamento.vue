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
                    <i class="fa fa-medkit" aria-hidden="true"></i> Medicamentos
                </div>
                <div class="card-header">
                    <button type="button" @click="articulosTodos()" class="btn btn-secondary">
                        <i class="icon-doc"></i>&nbsp;Reporte Medicamentos
                    </button>
                </div>
                <template v-if="listado == 1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="nombre">Nombre</option>
                                        <option value="concentracion">Concentración</option>
                                        <option value="presentacion">Presentación</option>
                                        <option value="items">Items</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarArticulo(1, buscar, criterio)" class="form-control"
                                        placeholder="Texto a buscar"/>
                                    <button type="submit" class="btn btn-cafe" @click=" listarArticulo(1, buscar, criterio) ">
                                        <i class="fa fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-responsive table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Medicamento</th>
                                    <th>Casa_Farmacéutica</th>
                                    <th>Concentración</th>
                                    <th>Presentación</th>
                                    <th>Administración</th>
                                    <th>Items</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="articulo in arrayArticulo" :key="articulo.id" >
                                    <td>
                                        <button type="button" @click="pdfArticulo(articulo.id)" class="btn btn-outline-danger btn-sm">
                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        </button>
                                        &nbsp;
                                         <button type="button" @click="abrirModalfecha('articulo','fecha',articulo)" class="btn btn-outline-dark btn-sm">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </button>
                                        &nbsp;
                                    </td>
                                    <td v-text="articulo.nombre"></td>
                                    <td v-text="articulo.nombre_categoria"></td>
                                    <td v-text="articulo.concentracion + articulo.nombre_gramaje"> </td>
                                    <td v-text="articulo.presentacion"></td>
                                    <td v-text="articulo.administracion"></td>
                                    <td v-text="articulo.items"></td>
                                    <td>
                                        <div v-if="articulo.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item " v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent=" cambiarPagina(pagination.current_page - 1,
                                                buscar, criterio) ">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="  cambiarPagina(page,buscar, criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if=" pagination.current_page <pagination.last_page ">
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
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>

     

     

        <!--modal de rago de  fechas-->
         <div
            class="modal fade"
            tabindex="-1"
            :class="{ mostrar: modal1 }"
            role="dialog"
            aria-labelledby="myModalLabel"
            style="display: none"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header cafe">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button
                            type="button"
                            class="close"
                            @click="cerrarModalfecha()"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body ">
                        <form
                            action=""
                            method="post"
                            enctype="multipart/form-data"
                            class="form-horizontal"
                        >
                        <div class="form-group row">
                            <div class="col-md-9">
                                <input
                                    type="hidden"
                                    v-model="articulo_id"
                                    class="form-control"
                                    placeholder="Ingrese presentación del medicamento"
                                />
                            </div>
                        </div>
                           
                           
                            <div class="form-group row">
                                <label
                                    class="col-md-3 form-control-label"
                                    for="text-input"
                                    >Desde
                                </label>
                                <div class="col-md-9">
                                    <input
                                        type="date"
                                        v-model="desde"
                                        class="form-control"
                                    
                                    />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    class="col-md-3 form-control-label"
                                    for="email-input"
                                >
                                    <spam style="color: black">Hasta</spam>
                                </label>
                                <div class="col-md-9">
                                    <input
                                        type="date"
                                        v-model="hasta"
                                        class="form-control"
                                      
                                    />
                                </div>
                            </div>

                            <div
                                v-show="errorArticulo"
                                class="form-group row div-error"
                            >
                                <div class="text-center text-error">
                                    <div
                                        v-for="error in errorMostrarMsjArticulo"
                                        :key="error"
                                        v-text="error"
                                    ></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-dark"
                            @click="cerrarModalfecha()"
                        >
                            Cerrar
                        </button>
                        <button
                            type="button"
                            v-if="tipoAccion1 == 1"
                            class="btn btn-cafe"
                            @click="listarArticulofeha(articulo_id,desde,hasta)"
                        >
                            ver fecha
                        </button>
                    
                    </div>
                </div>

                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

     
    </main>
</template>

<script>
import VueBarcode from "vue-barcode";
export default {
    data() {
        return {
            articulo_id: 0,
            idcategoria: 0,
            idgramaje: 0,
            nombre_categoria: "",
            nombre: "",
            concentracion: "",
            administracion: 0,
            presentacion: "",
            items: "",
            arrayArticulo: [],
            arrayIngresoT: [],
            arrayArticuloT: [],
            arrayDetalle: [],
            listado: 1,
            modal: 0,
            modal1:0,
            imagen:'',
            imagenminiatura:'',
            tituloModal: "",
            tipoAccion: 0,
             tipoAccion1: 0,
            errorArticulo: 0,
            errorMostrarMsjArticulo: [],
            pagination: {
                total: 0,
                current_page: 0,
                per_page: 0,
                last_page: 0,
                from: 0,
                to: 0
            },
            offset: 3,
            criterio: "nombre",
            desde: "",
            hasta: "",
            buscar: "",
            arrayCategoria: [],
            arraygramaje: [],
            arrayArticulofecha:[]
        };
    },
    components: {
        barcode: VueBarcode
    },
    computed: {
        isActived: function() {
            return this.pagination.current_page;
        },
        //Calcula los elementos de la paginación
        pagesNumber: function() {
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
        }
    },
    methods: {


    
        pdfArticulo(id) {
            window.open("/articulo/pdf/" + id + "," + "_blank");
        },
    
listarArticulofeha(id, desde, hasta) {
window.open("/articulo/reporte_resultados/" + id + "/" + desde + "/" + hasta+"," + "__blank");
//console.log(desde + hasta);
//me.listarArticulo(1, "", "nombre");
},

        listarArticulo(page, buscar, criterio) {
            let me = this;
            var url ="/articulo?page=" +page + "&buscar=" +buscar +"&criterio=" +criterio;
            axios
                .get(url)
                .then(function(response) {
                    var respuesta = response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },


        articulosTodos() {
            window.open("articulo/articulosTodos", "_blank");
        },
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            //Actualiza la página actual
            me.pagination.current_page = page;
            //Envia la petición para visualizar la data de esa página
            me.listarArticulo(page, buscar, criterio);
        },
       
       
            cerrarModalfecha() {
            this.modal1 = 0;
            this.tituloModal1 = "";
             this.articulo_id ="";
                            this.desde = "";
                            this.hasta = "";
        },
       
         //funcion en prueva
        abrirModalfecha(modelo1, accion1, data = []) {
            switch (modelo1) {
                case "articulo": {
                    switch (accion1) {
                        case "fecha": {
                              console.log(data);
                            this.modal1 = 1;
                            this.tituloModal = "Rango por fechas de entradas y salidas";
                            this.articulo_id = data["id"];
                            this.desde = "";
                            this.hasta = "";
                            this.tipoAccion1 = 1;
                            break;
                        }
                    }
                }
            }
        },
      
       
    },
    mounted() {
        this.listarArticulo(1, this.buscar, this.criterio);
        //this.listarArticulofeha(articulo, this.desde, this.hasta);
    }
};
</script>
