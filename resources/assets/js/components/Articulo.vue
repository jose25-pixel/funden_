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
                    <button type="button" @click="abrirModal('articulo', 'registrar')" class="btn btn-cafe">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
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
                                         <button type="button" @click="abrirModalfecha('articulo','fecha',articulo)" class="btn btn-success btn-sm">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </button>

                                        <button type="button" @click="abrirModal('articulo','actualizar', articulo)"
                                            class="btn btn-warning btn-sm"><i class="icon-pencil"></i>
                                        </button>
                                        &nbsp;

                                        <template v-if="articulo.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click=" desactivarArticulo(articulo.id)">
                                             <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click=" activarArticulo(articulo.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
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

     

        <!--Inicio del modal agregar/actualizar-->
        <div
            class="modal fade"
            tabindex="-1"
            :class="{ 'mostrar': modal }"
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
                            @click="cerrarModal()"
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
                                <label class="col-md-3 form-control-label" for="text-input" >Casa Farmacéutica
                                    <span style="color:red"  v-show="idcategoria==0" >(*Seleccione) </span>
                                </label>

                                <div class="col-md-9">
                                    <select class="form-control"
                                        v-model="idcategoria"
                                    >
                                        <option value="0" disabled>
                                            Seleccione una casa farmacéutica
                                        </option>
                                        <option
                                            v-for="categoria in arrayCategoria"
                                            :key="categoria.id"
                                            :value="categoria.id"
                                            v-text="categoria.nombre"
                                        ></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre
                                    <span style="color:red"  v-show="nombre==0" >(*Ingrese) </span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del medicamento"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Concentración
                                    <span style="color:red"  v-show="concentracion==0" >(*Ingrese) </span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" v-model="concentracion" class="form-control" placeholder="Ingrese concentración del medicamento"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input" >Gramaje
                                    <span style="color:red"  v-show="idgramaje==0" >(*Selecione) </span>
                                </label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="idgramaje">
                                        <option value="0" disabled>Seleccione un Gramaje</option>
                                        <option
                                            v-for="gramaje in arraygramaje"
                                            :key="gramaje.id"
                                            :value="gramaje.id"
                                            v-text="gramaje.gramaje"
                                        ></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Tipo Administración
                                    <span style="color:red"  v-show="administracion==0" >(*Seleccione) </span>
                                </label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="administracion" >
                                        <option value="0" disabled>Seleccione</option>
                                        <option value="Vía Oral">Oral</option>
                                        <option value="Vía Inyectables" >Inyectables</option >
                                        <option value="Vía Ocular">Ocular</option>
                                        <option value="Vía Ótica">Ótica</option>
                                        <option value="Vía Tópica">Tópica</option>
                                        <option value="Vía Nasal">Nasal</option>
                                        <option value="Vía Inhalatoria">Inhalatoria</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Presentación
                                    <span style="color:red"  v-show="presentacion==0" >(*Ingrese) </span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" v-model="presentacion" class="form-control" placeholder="Ingrese presentación del medicamento" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Items
                                <span style="color:black"  v-show="items==0" >(*Cantidad) </span>
                                </label>
                                <div class="col-md-9">
                                    <input type="email" v-model="items" class="form-control" placeholder="Ingrese la cantidad de items"/>
                                </div>
                            </div>
                            <div v-show="errorArticulo" class="form-group row div-error">
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
                            @click="cerrarModal()"
                        >
                            Cerrar
                        </button>
                        <button
                            type="button"
                            v-if="tipoAccion == 1"
                            class="btn btn-cafe"
                            @click="registrarArticulo()"
                        >
                            Guardar
                        </button>
                        <button
                            type="button"
                            v-if="tipoAccion == 2"
                            class="btn btn-cafe"
                            @click="actualizarArticulo()"
                        >
                            Actualizar
                        </button>
                    </div>
                </div>

                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
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
                            <label
                                class="col-md-3 form-control-label"
                                for="text-input"
                                >id
                            </label>
                            <div class="col-md-9">
                                <input
                                    type="text"
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
      /*  listarArticulofehas(id,desde, hasta) {
            //let me = this;
            //var url =
             window.open("/articulo/pdf/"+id+"/"+ desde + "/" +hasta); 
            // window.open("/articulo/pdf/" + response.data.id + ','+ "_blank" );
        },
Fecha(id) {

window.open("/articulo/reporte_resultados/" + id + "," + "__blank");

},*/

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
        selectCategoria() {
            let me = this;
            var url = "/categoria/selectCategoria";
            axios
                .get(url)
                .then(function(response) {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayCategoria = respuesta.categorias;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        selectGramaje() {
            let me = this;
            var url = "/gramaje/selectGramaje";
            axios
                .get(url)
                .then(function(response) {
                    //console.log(response);
                    var respuesta = response.data;
                    me.arraygramaje = respuesta.gramajes;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            //Actualiza la página actual
            me.pagination.current_page = page;
            //Envia la petición para visualizar la data de esa página
            me.listarArticulo(page, buscar, criterio);
        },
        registrarArticulo() {
            if (this.validarArticulo()) {
                return;
            }
            let me = this;

            axios
                .post("/articulo/registrar", {
                    idcategoria: this.idcategoria,
                    idgramaje: this.idgramaje,
                    nombre: this.nombre,
                    presentacion: this.presentacion,
                    administracion: this.administracion,
                    concentracion: this.concentracion,
                    items: this.items
                })
                .then(function(response) {
                    me.cerrarModal();
                    me.listarArticulo(1, "", "nombre");
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        actualizarArticulo() {
            if (this.validarArticulo()) {
                return;
            }
            let me = this;
            axios
                .put("/articulo/actualizar", {
                    idcategoria: this.idcategoria,
                    idgramaje: this.idgramaje,
                    nombre: this.nombre,
                    presentacion: this.presentacion,
                    administracion: this.administracion,
                    concentracion: this.concentracion,
                    items: this.items,
                    id: this.articulo_id
                })
                .then(function(response) {
                    me.cerrarModal();
                    me.listarArticulo(1, "", "nombre");
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        desactivarArticulo(id) {
            swal({
                title: "Esta seguro de desactivar este artículo?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar!",
                cancelButtonText: "Cancelar",
                confirmButtonClass: "btn btn-success",
                cancelButtonClass: "btn btn-danger",
                buttonsStyling: false,
                reverseButtons: true
            }).then(result => {
                if (result.value) {
                    let me = this;

                    axios
                        .put("/articulo/desactivar", {
                            id: id
                        })
                        .then(function(response) {
                            me.listarArticulo(1, "", "nombre");
                            swal(
                                "Desactivado!",
                                "El registro ha sido desactivado con éxito.",
                                "success"
                            );
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                }
            });
        },
        activarArticulo(id) {
            swal({
                title: "Esta seguro de activar este artículo?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar!",
                cancelButtonText: "Cancelar",
                confirmButtonClass: "btn btn-success",
                cancelButtonClass: "btn btn-danger",
                buttonsStyling: false,
                reverseButtons: true
            }).then(result => {
                if (result.value) {
                    let me = this;

                    axios
                        .put("/articulo/activar", {
                            id: id
                        })
                        .then(function(response) {
                            me.listarArticulo(1, "", "nombre");
                            swal(
                                "Activado!",
                                "El registro ha sido activado con éxito.",
                                "success"
                            );
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                }
            });
        },
        validarArticulo() {
            this.errorArticulo = 0;
            this.errorMostrarMsjArticulo = [];

            if (this.idcategoria == 0)
                this.errorMostrarMsjArticulo.push(
                    "Seleccione una casa farmacéutica."
                );

            if (this.nombre == "" || this.nombre == null) {
                this.errorMostrarMsjArticulo.push(
                    "El nombre del medicamento no puede quedar vacio."
                );
                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;
            } else if (
                !/^[a-zA-ZÀ-ÿ\u00f1\u00d1 ]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/.test(
                    this.nombre
                )
            ) {
                this.errorMostrarMsjArticulo.push(
                    "El nombre del medicamento no debe contener números"
                );
                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;
            } else if (!/^[A-Z]/.test(this.nombre)) {
                this.errorMostrarMsjArticulo.push(
                    "El nombre del medicamento debe iniciar con una letra mayúscula"
                );
                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;
            } else if (this.concentracion == "" || this.concentracion == null) {
                this.errorMostrarMsjArticulo.push(
                    "El campo de concentración no puede estar vacio."
                );
                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;
            } else if (!/^[0-9]/.test(this.concentracion)) {
                this.errorMostrarMsjArticulo.push(
                    "La concentración debe ser en números."
                );
                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;
            } else if (this.idgramaje == 0) {
                this.errorMostrarMsjArticulo.push("Seleccione un gramaje.");
                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;
            } else if (
                this.administracion == "" ||
                this.administracion == null
            ) {
                this.errorMostrarMsjArticulo.push(
                    "La administración del medicamento no puede quedar vacio"
                );
                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;
            } else if (this.presentacion == "" || this.presentacion == null) {
                this.errorMostrarMsjArticulo.push(
                    "La presentación del medicamento no puede quedar vacia"
                );
                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;
            } else if (
                !/^[a-zA-ZÀ-ÿ\u00f1\u00d1 ]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/.test(
                    this.presentacion
                )
            ) {
                this.errorMostrarMsjArticulo.push(
                    "El presentación  no debe contener números"
                );
                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;
            } else if (!/^[A-Z]/.test(this.presentacion)) {
                this.errorMostrarMsjArticulo.push(
                    "La presentación del medicamento  debe iniciar con una letra mayúscula"
                );
                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;
            }
            return this.errorArticulo;
        },
        cerrarModal() {
            this.modal = 0;
            this.tituloModal = "";
            this.idcategoria = 0;
            this.idgramaje = 0;
            this.nombre_categoria = "";
            this.nombre = "";
            this.concentracion = "";
            this.administracion = 0;
            this.presentacion = "";
            this.items = "";
            this.errorArticulo = 0;
        },
            cerrarModalfecha() {
            this.modal1 = 0;
            this.tituloModal1 = "";
             this.articulo_id ="";
                            this.desde = "";
                            this.hasta = "";
        },
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "articulo": {
                    switch (accion) {
                        case "registrar": {
                            this.modal = 1;
                            this.tituloModal = "Registrar un Medicamento";
                            this.idcategoria = 0;
                            this.idgramaje = 0;
                            this.nombre_categoria = "";
                            this.nombre = "";
                            this.concentracion = "";
                            this.administracion = 0;
                            this.presentacion = "";
                            this.items = "";
                            this.tipoAccion = 1;
                            break;
                        }
                        case "actualizar": {
                            //console.log(data);
                            this.modal = 1;
                            this.tituloModal = "Actualizar Medicamento";
                            this.tipoAccion = 2;
                            this.articulo_id = data["id"];
                            this.idcategoria = data["idcategoria"];
                            this.idgramaje = data["idgramaje"];
                            this.nombre = data["nombre"];
                            this.concentracion = data["concentracion"];
                            this.administracion = data["administracion"];
                            this.presentacion = data["presentacion"];
                            this.items = data["items"];
                            break;
                        }
            
                    }
                }
            }
            this.selectCategoria();
            this.selectGramaje();
        },
         //funcion en prueva
        abrirModalfecha(modelo1, accion1, data = []) {
            switch (modelo1) {
                case "articulo": {
                    switch (accion1) {
                        case "fecha": {
                              console.log(data);
                            this.modal1 = 1;
                            this.tituloModal = "Rango de fecha";
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
      
        ocultarDetalle() {
            this.listado = 1;
        },
        cerrarModal() {
            this.modal = 0;
            this.tituloModal = "";
        }
    },
    mounted() {
        this.listarArticulo(1, this.buscar, this.criterio);
        //this.listarArticulofeha(articulo, this.desde, this.hasta);
    }
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
</style>
