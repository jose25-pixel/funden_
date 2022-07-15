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
                        <i class="fa fa-align-justify"></i> Gramajes
                        <button type="button" @click="abrirModal('gramaje','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="gramaje">Gramaje</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listargramaje(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" class="btn btn-primary" @click="listargramaje(1,buscar,criterio)"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Gramaje</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="gramaje in arraygramaje" :key="gramaje.id">
                                    <td>
                                        <button type="button" @click="abrirModal('gramaje','actualizar',gramaje)" class="btn btn-warning btn-sm">
                                        <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="gramaje.condicion">
                                         <button type="button" class="btn btn-danger btn-sm" @click="desactivargramaje(gramaje.id)">
                                          <i class="icon-trash"></i>
                                        </button>  
                                        </template> 
                                        <template v-else>
                                         <button type="button" class="btn btn-info btn-sm" @click="activargramaje(gramaje.id)">
                                          <i class="icon-check"></i>
                                        </button> 
                                        </template> 
                                    </td>
                                    <td v-text="gramaje.gramaje"> </td>
                                    <td> 
                                        <div v-if="gramaje.condicion">
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
                                <li class="page-item" v-if="pagination.current_page >1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page  + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                          
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Gramaje</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="gramaje" class="form-control" placeholder="ingresa el gramaje">
                                    </div>
                                </div>

                                <div v-show="errorgramaje" class="form-group row div-error">
                                 <div class="text-center text-error">
                                 <div v-for="error in errorMostrarMsjgramaje" :key="error" v-text="error">
                                 </div>
                                 </div>
                                </div>


                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrargramaje()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizargramaje()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <!-- Inicio del modal Eliminar -->
            
            <!-- Fin del modal Eliminar -->
            
        </main>
</template>

<script>
    export default {
        data(){
            return{
                gramaje_id: 0,
                gramaje: '',
                arraygramaje:[],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorgramaje: 0,
                errorMostrarMsjgramaje: [],
                pagination : {
                    'total' : 0,
                    'current_page': 0,
                     'per_page': 0,
                      'last_page': 0,
                       'from': 0,
                        'to': 0,
                },
                offset:3,
                criterio: 'gramaje',
                buscar: ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function(){
                if(!this.pagination.to){
                    return[];
                }
                var from = this.pagination.current_page - this.offset;
                if(from < 1){
                    from =1;
                }
                var to = from +(this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },

        methods: {
            //listar gramajes
            listargramaje(page, buscar, criterio){
                
                let me=this;
                var url = '/gramaje?page=' + page + '&buscar=' + buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    //handle sucess
                    me.arraygramaje = respuesta.gramajes.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error){
                    //handle error
                    console.log(error);
                });
            },
            cambiarPagina(page, buscar, criterio){
                let me = this;

                me.pagination.current_page = page;
                me.listargramaje(page, buscar, criterio);
            },
            registrargramaje(){
                if (this.validargramaje()){
                    return;

                }
                let me = this;

                axios.post('/gramaje/registrar',{
                  'gramaje': this.gramaje
                }).then(function(response){
                    me.cerrarModal();
                    me.listargramaje(1,'','gramaje');
                }).catch(function(error){
                    console.log(error);
                });

        },
        actualizargramaje(){
            if (this.validargramaje()){
                    return;

                }
                let me = this;

                axios.put('/gramaje/actualizar',{
                  'gramaje': this.gramaje,
                  'id': this.gramaje_id
                }).then(function(response){
                    me.cerrarModal();
                    me.listargramaje(1,'','gramaje');
                }).catch(function(error){
                    console.log(error);
                });

        },
        desactivargramaje(id){
            swal({
            title: 'Esta seguro de desactivar este gramaje?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'green',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!',
            cancelButtonText: 'Cancelar!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                let me = this;

                axios.put('/gramaje/desactivar',{
                  'id': id
                }).then(function(response){
                    me.listargramaje(1,'','nombre');
                    swal(
                'Desactivado!',
                'El registro ha sido Desactivado con éxito.',
                'success'
                )

                }).catch(function(error){
                    console.log(error);
                });

                
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swal(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
                )
            }
            })

        },

        activargramaje(id){
            swal({
            title: 'Esta seguro de activar esta gramaje?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'green',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!',
            cancelButtonText: 'Cancelar!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                let me = this;

                axios.put('/gramaje/activar',{
                  'id': id
                }).then(function(response){
                    me.listargramaje(1,'','nombre');
                    swal(
                'Activado!',
                'El registro ha sido activado con éxito.',
                'success'
                )

                }).catch(function(error){
                    console.log(error);
                });

                
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swal(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
                )
            }
            })

        },

        validargramaje(){
            this.errorgramaje=0,
            this.errorMostrarMsjgramaje =[];

            if (!this.gramaje) this.errorMostrarMsjgramaje.push("El nombre del gramaje no puede estar vacío");
            if (this.errorMostrarMsjgramaje.length) this.errorgramaje = 1;
            return this.errorgramaje;
        },
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.nombre='';


        },
        abrirModal(modelo, accion, data = []){
            switch (modelo){
                case "gramaje":
                {
                    switch(accion){
                        case 'registrar':
                        {
                            this.modal = 1;
                            this.tituloModal = 'Registrar Gramaje';
                            this.gramaje = '';
                            this.tipoAccion = 1;
                            break;
                            
                        }
                        case 'actualizar':
                        {
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Actualizar Gramaje';
                            this.tipoAccion=2;
                            this.gramaje_id=data['id'];
                            this.gramaje = data['gramaje'];
                            break;

                        }
                    }
                }
            }
        }

    },

        mounted() {
            this.listargramaje(1,this.buscar, this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>