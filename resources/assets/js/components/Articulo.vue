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
                    <i class="fa fa-align-justify"></i> Artículos
                    <button type="button" @click="abrirModal('articulo', 'registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                    <button type="button" @click="cargarPdf()" class="btn btn-info">
                        <i class="icon-doc"></i>&nbsp;Reporte
                    </button>
                </div>
                <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                   <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="concentracion">Concentraciónn</option>
                                      <option value="presentacion">Presentación</option>
                                   
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarArticulo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" class="btn btn-primary" @click="listarArticulo(1,buscar,criterio)"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Medicamento</th>
                                <th>Casa_Farmaceutica</th>
                                <th>Concentración</th> 
                                <th>Presentación</th>
                                <th>Administración</th>
                                <th>Items</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                <td>
                                    <button type="button" @click="abrirModal('articulo', 'actualizar', articulo)"
                                        class="btn btn-warning btn-sm">
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <template v-if="articulo.condicion">
                                        <button type="button" class="btn btn-danger btn-sm"
                                            @click="desactivarArticulo(articulo.id)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-info btn-sm"
                                            @click="activarArticulo(articulo.id)">
                                            <i class="icon-check"></i>
                                        </button>
                                    </template>
                                </td>
                                <td v-text="articulo.nombre"></td>
                                <td v-text="articulo.nombre_categoria"></td>
                                <td v-text="articulo.concentracion+articulo.nombre_gramaje"></td>
                               
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
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#"
                                    @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page"
                                :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)"
                                    v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#"
                                    @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{ 'mostrar': modal }" role="dialog" aria-labelledby="myModalLabel"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                               
                                <div class="col-md-9">
                                    <select class="form-control" v-model="idcategoria">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="categoria in arrayCategoria" :key="categoria.id"
                                            :value="categoria.id" v-text="categoria.nombre"></option>
                                    </select>
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control"
                                        placeholder="Nombre de artículo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">concentracion</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="concentracion" class="form-control"
                                        placeholder="ingresa la concentracion">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Gramaje</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="idgramaje">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="gramaje in arraygramaje" :key="gramaje.id" :value="gramaje.id"
                                            v-text="gramaje.gramaje"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Tipo Administración</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="administracion">
                                        <option value="0" disabled>Seleccione</option>
                                        <option  value="Vía oral">Oral</option>
                                        <option  value="Vía Inyectables">Inyectables</option>
                                        <option  value="Vía Ocular">Ocular</option>
                                        <option  value="Vía Ótica">Ótica</option>
                                        <option  value="Vía Nasal">Nasal</option>
                                        <option  value="Vía Inhalatoria">Inhalatoria</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Presentacion</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="presentacion" class="form-control"
                                        placeholder="ingresa la presentacion">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">C.Items</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="items" class="form-control"
                                        placeholder="Ingrese la cantidad de items">
                                </div>
                            </div>
                            <div v-show="errorArticulo" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion == 1" class="btn btn-primary"
                            @click="registrarArticulo()">Guardar</button>
                        <button type="button" v-if="tipoAccion == 2" class="btn btn-primary"
                            @click="actualizarArticulo()">Actualizar</button>
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
import VueBarcode from 'vue-barcode';
export default {
    data() {
        return {
            articulo_id: 0,
            idcategoria: 0,
            idgramaje: 0,
            nombre_categoria: '',
            nombre: '',
            concentracion: '',
            administracion : 0,
            presentacion: '',
            items: '',
            arrayArticulo: [],
            modal: 0,
            tituloModal: '',
            tipoAccion: 0,
            errorArticulo: 0,
            errorMostrarMsjArticulo: [],
            pagination: {
                'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0,
            },
            offset: 3,
            criterio: 'nombre',
            buscar: '',
            arrayCategoria: [],
            arraygramaje: []
        }
    },
    components: {
        'barcode': VueBarcode
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

            var to = from + (this.offset * 2);
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
        listarArticulo(page, buscar, criterio) {
            let me = this;
            var url = '/articulo?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayArticulo = respuesta.articulos.data;
                me.pagination = respuesta.pagination;
            })
                .catch(function (error) {
                    console.log(error);
                });
        },
        cargarPdf() {
            window.open('articulo/listarPdf', '_blank');
        },
        selectCategoria() {
            let me = this;
            var url = '/categoria/selectCategoria';
            axios.get(url).then(function (response) {
                //console.log(response);
                var respuesta = response.data;
                me.arrayCategoria = respuesta.categorias;
            })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectGramaje() {
            let me = this;
            var url = '/gramaje/selectGramaje';
            axios.get(url).then(function (response) {
                //console.log(response);
                var respuesta = response.data;
                me.arraygramaje = respuesta.gramajes;
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
            me.listarArticulo(page, buscar, criterio);
        },
        registrarArticulo() {
            if (this.validarArticulo()) {
                return;
            }

            let me = this;

            axios.post('/articulo/registrar', {
                'idcategoria': this.idcategoria,
                'idgramaje': this.idgramaje,
                'nombre': this.nombre,
                'presentacion': this.presentacion,
                'administracion': this.administracion,
                'concentracion': this.concentracion,
                'items': this.items
            }).then(function (response) {
                me.cerrarModal();
                me.listarArticulo(1, '', 'nombre');
            }).catch(function (error) {
                console.log(error);
            });
        },
        actualizarArticulo() {
            if (this.validarArticulo()) {
                return;
            }

            let me = this;

            axios.put('/articulo/actualizar', {
                'idcategoria': this.idcategoria,
                'idgramaje': this.idgramaje,
                'nombre': this.nombre,
                'presentacion': this.presentacion,
                'administracion': this.administracion,
                'concentracion': this.concentracion,
                'items': this.items,
                'id': this.articulo_id
            }).then(function (response) {
                me.cerrarModal();
                me.listarArticulo(1, '', 'nombre');
            }).catch(function (error) {
                console.log(error);
            });
        },
        desactivarArticulo(id) {
            swal({
                title: 'Esta seguro de desactivar este artículo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/articulo/desactivar', {
                        'id': id
                    }).then(function (response) {
                        me.listarArticulo(1, '', 'nombre');
                        swal(
                            'Desactivado!',
                            'El registro ha sido desactivado con éxito.',
                            'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });


                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {

                }
            })
        },
        activarArticulo(id) {
            swal({
                title: 'Esta seguro de activar este artículo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/articulo/activar', {
                        'id': id
                    }).then(function (response) {
                        me.listarArticulo(1, '', 'nombre');
                        swal(
                            'Activado!',
                            'El registro ha sido activado con éxito.',
                            'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });


                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {

                }
            })
        },
        validarArticulo() {
            this.errorArticulo = 0;
            this.errorMostrarMsjArticulo = [];

            if (this.idcategoria == 0) this.errorMostrarMsjArticulo.push("Seleccione una categoría.");
            if (this.idgramaje == 0) this.errorMostrarMsjArticulo.push("Seleccione un gramaje.");
            if (!this.nombre) this.errorMostrarMsjArticulo.push("El nombre del artículo no puede estar vacío.");
            if (!this.presentacion) this.errorMostrarMsjArticulo.push("El campo presentacion no puede quedar vacio.");
            if (!this.administracion) this.errorMostrarMsjArticulo.push("El campo de via de administracion no puede quedar vacio.");
            if (!this.concentracion) this.errorMostrarMsjArticulo.push("El campo concentracion no puede quedar vacio");

            if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;

            return this.errorArticulo;
        },
        cerrarModal() {
            this.modal = 0;
            this.tituloModal = '';
            this.idcategoria = 0;
            this.idgramaje = 0;
            this.nombre_categoria = '';
            this.nombre = '';
            this.concentracion = '';
            this.administracion = 0;
            this.presentacion = '';
            this.items = '';
            this.errorArticulo = 0;
        },
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "articulo":
                    {
                        switch (accion) {
                            case 'registrar':
                                {
                                    this.modal = 1;
                                    this.tituloModal = 'Registrar Artículo';
                                    this.idcategoria = 0;
                                    this.idgramaje = 0;
                                    this.nombre_categoria = '';
                                    this.nombre = '';
                                    this.concentracion = '';
                                    this.administracion = 0;
                                    this.presentacion = '';
                                    this.items = '';
                                    this.tipoAccion = 1;
                                    break;
                                }
                            case 'actualizar':
                                {
                                    //console.log(data);
                                    this.modal = 1;
                                    this.tituloModal = 'Actualizar Artículo';
                                    this.tipoAccion = 2;
                                    this.articulo_id = data['id'];
                                    this.idcategoria = data['idcategoria'];
                                    this.idgramaje = data['idgramaje'];
                                    this.nombre = data['nombre'];
                                    this.concentracion = data['concentracion'];
                                    this.administracion = data['administracion'];
                                    this.presentacion = data['presentacion'];
                                    this.items = data['items'];
                                    break;
                                }
                        }
                    }
            }
            this.selectCategoria();
            this.selectGramaje();
        }
    },
    mounted() {
        this.listarArticulo(1, this.buscar, this.criterio);
    }
}
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
