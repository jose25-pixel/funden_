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
                </div>
                <div class="card-header">
                    <button type="button" @click="inventarioPdf()" class="btn btn-secondary">
                        <i class="icon-doc"></i>&nbsp;Reporte de Inventario
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="cantidad_tableta">Cantidad_tableta</option>
                                    <option value="cantidad_blister">Cantidad_blister</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarInventario(1, buscar, criterio)"
                                    class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarInventario(1, buscar, criterio)"
                                    class="btn btn-cafe"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm table-responsive">
                        <thead style="background-color:">
                            <tr>
                                <th>Id</th>
                                <th>Medicamento</th>
                                <th>Farmacéutica</th>
                                <th>Concentración</th>
                                <th>Presentación</th>
                                <th>Administración</th>
                                <th>Items</th>
                                <th>Tratamiento</th>
                                <th>Ítems X Tratamiento</th>
                                <th>condicion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="inventarios in arrayInventario" :key="inventarios.id">
                               
                                <td v-text="inventarios.id"></td>
                                <td v-text="inventarios.medicamento"></td>
                                <td v-text="inventarios.casa_farmaceutica"></td>
                                <td v-text="inventarios.concentracion  + inventarios.gramaje" ></td>
                                <td v-text="inventarios.presentacion"></td>
                                <td v-text="inventarios.administracion"></td>
                                <td v-text="inventarios.items"></td>
                                <td v-text="inventarios.cantidad_blister"></td>
                                <td v-text="inventarios.cantidad_tableta"></td>
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
                                <a class="page-link cafe" href="#"
                                    @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page"
                                :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)"
                                    v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link cafe" href="#"
                                    @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
       
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
            criterio: 'cantidad_tableta',
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

        inventarioPdf() {
            window.open('/inventario/inventarioPdf', '_blank');
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
