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
                    <i class="fa fa-align-justify"></i> Inventario Actual
                <!--      <button type="button" @click="abrirModal('inventarios', 'registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>-->
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
                                    <option value="cantidad_blister">Cantidad</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarInventario(1, buscar, criterio)"
                                    class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarInventario(1, buscar, criterio)"
                                    class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm table-responsive">
                        <thead>
                            <tr>
                               
                                <th>Opciones</th>
                                <th>Id</th>
                                <th>Producto</th>
                                <th>Stock Tableta</th>
                                <th>Stock Blister</th>
                                <th>condicion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="inventarios in arrayInventario" :key="inventarios.id">
                              <td>
                              <!--  <template v-if="inventarios.condicion">
                                        <button type="button" class="btn btn-danger btn-sm"
                                            @click="desactivarInventario(inventarios.id)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-info btn-sm"
                                            @click="activarInventario(inventarios.id)">
                                            <i class="icon-check"></i>
                                        </button>
                                    </template> -->
                                   
                                </td>
                                <td v-text="inventarios.id"></td>
                                <td v-text="inventarios.nombre_articulo"></td>
                                <td v-text="inventarios.cantidad_tableta"></td>
                                <td v-text="inventarios.cantidad_blister"></td>
                                 <td>
                                    <div v-if="inventarios.condicion">
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
        <!--
      
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
                                <label class="col-md-3 form-control-label" for="text-input">Producto</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="idproducto">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="articulos in arrayArticulos" :key="articulos.id"
                                            :value="articulos.id" v-text="articulos.nombre"></option>
                                    </select>
                                </div>
                            </div>
                         
                          
                            <div v-show="errorInventario" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjInventario" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion == 1" class="btn btn-primary"
                            @click="registrarInventario()">Guardar</button>
                        <button type="button" v-if="tipoAccion == 2" class="btn btn-primary"
                            @click="actualizarInventario()">Actualizar</button>
                    </div>
                </div>
            
            </div>
          
        </div> Final-->
        <!--Fin del modal-->
    </main>
</template>
  
<script>
import VueBarcode from 'vue-barcode';
export default {
    data() {
        return {
            articulo_id: 0,
            idproducto: 0,
            cantidad_blister: 0,
            cantidad_tableta: 0,
            modal: 0,
            tituloModal: '',
            tipoAccion: 0,
            errorInventario: 0,
            errorMostrarMsjInventario: [],
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
            arrayInventario: [],
            arrayArticulos: []
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
        listarInventario(page, buscar, criterio) {
            let me = this;
            var url = '/inventario?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayInventario = respuesta.inventarios.data;
                me.pagination = respuesta.pagination;
            })
                .catch(function (error) {
                    console.log(error);
                });
        },
        cargarPdf() {
            window.open('/articulo/listarPdf', '_blank');
        },
        selectArticulo() {
            let me = this;
            var url = '/articulo/selectArticulo';
            axios.get(url).then(function (response) {
                //console.log(response);
                var respuesta = response.data;
                me.arrayArticulos = respuesta.articulos;
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
            me.listarInventario(page, buscar, criterio);
        },
        registrarInventario() {
            if (this.validarInventario()) {
                return;
            }

            let me = this;

            axios.post('/inventario/registrar', {
                'idproducto': this.idproducto,
                'cantidad_tableta': this.cantidad_tableta,
                'cantidad_blister': this.cantidad_blister,
            }).then(function (response) {
                me.cerrarModal();
                me.listarInventario(1, '', 'nombre');
            }).catch(function (error) {
                console.log(error);
            });
        },
 
        desactivarInventario(id) {
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

                    axios.put('/inventario/desactivar', {
                        'id': id
                    }).then(function (response) {
                        me.listarInventario(1, '', 'nombre');
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
        activarInventario(id) {
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

                    axios.put('/inventario/activar', {
                        'id': id
                    }).then(function (response) {
                        me.listarInventario(1, '', 'nombre');
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
        validarInventario() {
            this.errorInventario = 0;
            this.errorMostrarMsjInventario = [];
            if (this.idproducto== 0) this.errorMostrarMsjInventario.push("Seleccione un producto de lo contraio no se puede seguir con el procedimiento.");
           // if (!this.cantidad_blister) this.errorMostrarMsjInventario.push("El stock de Blister debe ser un número y no puede estar vacío.");
            //if (!this.cantidad_tableta) this.errorMostrarMsjInventario.push("El stock de Tableta debe ser un número y no puede estar vacío.");

            if (this.errorMostrarMsjInventario.length) this.errorInventario = 1;

            return this.errorInventario;
        },
        cerrarModal() {
            this.modal = 0;
            this.tituloModal = '';
            this.idcategoria = 0;
            this.nombre_categoria = '';
            this.codigo = '';
            this.nombre = '';
            this.precio_venta = 0;
            this.stock = 0;
            this.descripcion = '';
            this.errorArticulo = 0;
        },
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "inventarios":
                    {
                        switch (accion) {
                            case 'registrar':
                                {
                                    this.modal = 1;
                                    this.tituloModal = 'Registrar Nuevo Inventario en Stock';
                                    this.idproducto = 0;
                                    this.cantidad_blister = 0;
                                    this.cantidad_tableta = 0;
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
                                    this.idproducto= data['idproducto'];
                                    this.cantidad_blister = data['cantidad_blister'];
                                    this.cantidad_tableta = data['cantidad_tableta'];
                                    break;
                                }
                        }
                    }
            }
            this.selectArticulo();
        }
    },
    mounted() {
        this.listarInventario(1, this.buscar, this.criterio);
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
