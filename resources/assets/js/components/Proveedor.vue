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
                    <i class="fa fa-align-justify"></i> Proveedores
                    <button type="button" @click="abrirModal('proveedor', 'registrar')" class="btn btn-cafe">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="nombre">Nombre</option>
                                    <option value="tipo_documento">Documento</option>
                                    <option value="num_documento">Núm_Documento</option>
                                    <option value="email">Email</option>
                                    <option value="telefono">Teléfono</option>
                                    <option value="contacto">contacto</option>
                                    <option value="telefono_contacto">Teléfono_Contacto</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarProveedor(1, buscar, criterio)"
                                    class="form-control" placeholder="Texto a buscar">
                                <button type="submit" class="btn btn-cafe"
                                    @click="listarProveedor(1, buscar, criterio)"><i class="fa fa-search"></i>
                                    Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Documento</th>
                                <th>Número</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Contacto</th>
                                <th>Tel:Contacto</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="proveedor in arrayProveedor" :key="proveedor.id">
                                <td>
                                    <button type="button" @click="abrirModal('proveedor', 'actualizar', proveedor)"
                                        class="btn btn-warning btn-sm">
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <template v-if="proveedor.condicion == 1">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            @click="desactivarProveedor(proveedor.id)">

                                            <i class="icon-trash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-info btn-sm"
                                            @click="activarProveedor(proveedor.id)">
                                            <i class="icon-check"></i>
                                        </button>
                                    </template>

                                </td>
                                <td v-text="proveedor.nombre"> </td>
                                <td v-text="proveedor.tipo_documento"> </td>
                                <td v-text="proveedor.num_documento"> </td>
                                <td v-text="proveedor.direccion"> </td>
                                <td v-text="proveedor.telefono"> </td>
                                <td v-text="proveedor.email"> </td>
                                <td v-text="proveedor.contacto"> </td>
                                <td v-text="proveedor.telefono_contacto"> </td>
                                <td>
                                    <div v-if="proveedor.condicion">
                                        <span class="badge badge-success">Activo</span>
                                    </div>
                                    <div v-else><span class="badge badge-danger">Inactivo</span>
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
                    <div class="modal-header cafe">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <div class="form-group col-md-6">
                                    <label class="col-md-6 form-control-label" for="text-input">Nombre
                                        <span style="color:red" v-show="nombre == 0">(*Ingrese) </span>
                                    </label>
                                    <div>
                                        <input type="text" v-model="nombre" class="form-control"
                                            placeholder="Ej.Nombre de proveedor">
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="col-md-6 form-control-label" for="email-input">Dirección
                                        <span style="color:red" v-show="direccion == 0">(*Ingrese) </span>
                                    </label>

                                    <div>
                                        <input type="text" v-model="direccion" class="form-control"
                                            placeholder="Ej.San Salvador">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="col-md-3 form-control-label" for="email-input">Teléfono</label>
                                    <div>
                                        <input type="text" v-model="telefono" class="form-control" maxlength="16"
                                            placeholder="Ej. 22202222 ó 77896543">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="col-md-3 form-control-label" for="email-input">Email</label>
                                    <div>
                                        <input type="email" v-model="email" class="form-control"
                                            placeholder="Ej.example@gmail.com">
                                    </div>
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="col-md-6 form-control-label" for="text-input">Tipo Documento</label>
                                    <div>
                                        <select v-model="tipo_documento" class="form-control">
                                            <option value="">Seleccione</option>
                                            <option value="DNI">DNI</option>
                                            <option value="RUC">RUC</option>
                                            <option value="NIT">NIT</option>
                                            <option value="PASAPORTE">PASAPORTE</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="col-md-3 form-control-label" for="text-input">Número</label>
                                    <div>
                                        <input type="text" v-model="num_documento" class="form-control"
                                            placeholder="Ej.000000xx">
                                    </div>
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="col-md-6 form-control-label" for="email-input">Contacto
                                        <span style="color:red" v-show="contacto == 0">(*Ingrese) </span>
                                    </label>
                                    <div>
                                        <input type="text" v-model="contacto" class="form-control"
                                            placeholder="Ej. Nombre de contacto">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="col-md-9 form-control-label" for="email-input">Telefono de contacto
                                        <span style="color:red" v-show="telefono_contacto == 0">(*Ingrese) </span>
                                    </label>
                                    <div>
                                        <input type="text" v-model="telefono_contacto" class="form-control"
                                            maxlength="16" placeholder="Ej. 77897654">
                                    </div>
                                </div>
                            </div>
                            <div v-show="errorProveedor" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjProveedor" :key="error" v-text="error">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <p>Si seleciona tipo de documento, es obligatorio que ingrese el Número de Documento.</p>
                        <button type="button" class="btn btn-dark" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion == 1" class="btn btn-cafe"
                            @click="registrarProveedor()">Guardar</button>
                        <button type="button" v-if="tipoAccion == 2" class="btn btn-cafe"
                            @click="actualizarProveedor()">Actualizar</button>
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
export default {
    data() {
        return {
            proveedor_id: 0,
            nombre: '',
            tipo_documento: '',
            num_documento: '',
            direccion: '',
            telefono: '',
            email: '',
            contacto: '',
            telefono_contacto: '',
            arrayProveedor: [],
            modal: 0,
            tituloModal: '',
            tipoAccion: 0,
            errorProveedor: 0,
            errorMostrarMsjProveedor: [],
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
            buscar: ''
        }
    },
    computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
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
        //listar clientes
        listarProveedor(page, buscar, criterio) {

            let me = this;
            var url = '/proveedor?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                //handle sucess
                me.arrayProveedor = respuesta.proveedores.data;
                me.pagination = respuesta.pagination;
            })
                .catch(function (error) {
                    //handle error
                    console.log(error);
                });
        },
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            me.pagination.current_page = page;
            me.listarProveedor(page, buscar, criterio);
        },
        registrarProveedor() {
            if (this.validarProveedor()) {
                return;
            }
            let me = this;
            axios.post('/proveedor/registrar', {
                'nombre': this.nombre,
                'tipo_documento': this.tipo_documento,
                'num_documento': this.num_documento,
                'direccion': this.direccion,
                'telefono': this.telefono,
                'email': this.email,
                'contacto': this.contacto,
                'telefono_contacto': this.telefono_contacto
            }).then(function (response) {
                me.cerrarModal();
                me.listarProveedor(1, '', 'nombre');
            }).catch(function (error) {
                console.log(error);
            });
        },
        actualizarProveedor() {
            if (this.validarProveedor()) {
                return;
            }
            let me = this;
            axios.put('/proveedor/actualizar', {
                'nombre': this.nombre,
                'tipo_documento': this.tipo_documento,
                'num_documento': this.num_documento,
                'direccion': this.direccion,
                'telefono': this.telefono,
                'email': this.email,
                'contacto': this.contacto,
                'telefono_contacto': this.telefono_contacto,
                'id': this.proveedor_id
            }).then(function (response) {
                me.cerrarModal();
                me.listarProveedor(1, '', 'nombre');
            }).catch(function (error) {
                console.log(error);
            });
        },
        validarProveedor() {
            this.errorProveedor = 0,
                this.errorMostrarMsjProveedor = [];

            /*Validación del nombre del proveedor*/
            if (this.nombre == '' || this.nombre == null) {
                this.errorMostrarMsjProveedor.push("El nombre del proveedor no puede estar vacío");
            }
            else if (!/^[a-zA-ZÀ-ÿ\u00f1\u00d1 ]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/.test(this.nombre)) {
                this.errorMostrarMsjProveedor.push("El nombre del proveedor no puede contener números");
            }
            else if (!/^[A-Z]/.test(this.nombre)) {
                this.errorMostrarMsjProveedor.push("El nombre del proveedor debe iniciar con una letra mayúscula");
            }

            /*Validación de la dirección*/
            else if (this.direccion == '' || this.direccion == null) {
                this.errorMostrarMsjProveedor.push("La dirección del proveedor no puede estar vacía.");
            }

            /*Validación del email*/
            if (!this.validEmail(this.email)) {
                this.errorMostrarMsjProveedor.push('El correo electrónico debe ser válido.');
            }

            /*Validación del tipo de documento*/
            else if (!this.tipo_documento == '') {
                if (this.num_documento == '') {
                    this.errorMostrarMsjProveedor.push("El número de documento del proveedor no puede estar vacío.");
                }

                else if (this.num_documento.length <= 7) {
                    this.errorMostrarMsjProveedor.push("El número de documento del proveedor  no es valido, debe ser mas de 7 caracteres.");
                }
                else if (this.num_documento.length >= 14) {
                    this.errorMostrarMsjProveedor.push("El número de documento del proveedor  no es valido, debe ser menos de 14 caracteres.");
                }
            }
            else if (!this.num_documento == '') {
                if (this.tipo_documento == '') {
                    this.errorMostrarMsjProveedor.push("Seleccione un tipo de documento.");
                }
            }


            /*Validación del nombre del contacto*/
            if (this.contacto == '' || this.contacto == null) {
                this.errorMostrarMsjProveedor.push("El nombre del contacto no puede estar vacío");
            }
            else if (!/^[a-zA-ZÀ-ÿ\u00f1\u00d1 ]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/.test(this.contacto)) {
                this.errorMostrarMsjProveedor.push("El nombre del contacto no puede contener números");
            }
            else if (!/^[A-Z]/.test(this.contacto)) {
                this.errorMostrarMsjProveedor.push("El nombre del contacto debe iniciar con una letra mayúscula");
            }

            if (this.telefono_contacto == '' || this.telefono_contacto == null) {
                this.errorMostrarMsjProveedor.push("El telefono del contacto del proveedor no pude estar vacío");
            }

            if (this.errorMostrarMsjProveedor.length) this.errorProveedor = 1;
            return this.errorProveedor;
        },

        validEmail(email) {
            if (!this.email == '') {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);

            } else {
                return true;
            }

        },
        cerrarModal() {
            this.modal = 0;
            this.tituloModal = '';
            this.nombre = '';
            this.tipo_documento = '';
            this.num_documento = '';
            this.direccion = '';
            this.telefono = '';
            this.email = '';
            this.contacto = '';
            this.telefono_contacto = '';
            this.errorProveedor = 0;
        },
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "proveedor":
                    {
                        switch (accion) {
                            case 'registrar':
                                {
                                    this.modal = 1;
                                    this.tituloModal = 'Registrar Proveedor';
                                    this.nombre = '';
                                    this.tipo_documento = '';
                                    this.num_documento = '';
                                    this.direccion = '';
                                    this.telefono = '';
                                    this.email = '';
                                    this.contacto = '';
                                    this.telefono_contacto = '';
                                    this.tipoAccion = 1;
                                    break;
                                }
                            case 'actualizar':
                                {
                                    //console.log(data);
                                    this.modal = 1;
                                    this.tituloModal = 'Actualizar Proveedor';
                                    this.tipoAccion = 2;
                                    this.proveedor_id = data['id'];
                                    this.nombre = data['nombre'];
                                    this.tipo_documento = data['tipo_documento'];
                                    this.num_documento = data['num_documento'];
                                    this.direccion = data['direccion'];
                                    this.telefono = data['telefono'];
                                    this.email = data['email'];
                                    this.contacto = data['contacto'];
                                    this.telefono_contacto = data['telefono_contacto'];
                                    break;
                                }
                        }
                    }
            }
        },
        desactivarProveedor(id) {
            swal({
                title: 'Esta seguro de desactivar este proveedor?',
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
                    axios.put('/proveedor/desactivar', {
                        'id': id
                    }).then(function (response) {
                        me.listarProveedor(1, '', 'nombre');
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
        activarProveedor(id) {
            swal({
                title: 'Esta seguro de activar este proveedor?',
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
                    axios.put('/proveedor/activar', {
                        'id': id
                    }).then(function (response) {
                        me.listarProveedor(1, '', 'nombre');
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

    },
    mounted() {
        this.listarProveedor(1, this.buscar, this.criterio);
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