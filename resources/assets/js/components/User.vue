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
                        <i class="icon-user"></i> Usuarios
                        <button type="button" @click="abrirModal('users','registrar')" class="btn btn-cafe">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="num_documento">Num_Documento</option>
                                      <option value="email">Email</option>
                                      <option value="telefono">Teléfono</option>
                                      <option value="usuario">Usuario</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarUsuario(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarUsuario(1,buscar,criterio)" class="btn btn-cafe">
                                        <i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-responsive table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Tipo Documento</th>
                                    <th>Número</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="users in arrayUsuario" :key="users.id">
                                    <td>
                                        <button type="button" @click="abrirModal('users','actualizar',users)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button>&nbsp;
                                        <template v-if="users.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarUsuario(users.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarUsuario(users.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="users.nombre"></td>
                                    <td v-text="users.tipo_documento"></td>
                                    <td v-text="users.num_documento"></td>
                                    <td v-text="users.direccion"></td>
                                    <td v-text="users.telefono"></td>
                                    <td v-text="users.email"></td>
                                    <td v-text="users.usuario"></td>
                                    <td v-text="users.rol"></td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link cafe" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link cafe" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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
                                    <label class="col-md-9 form-control-label" for="text-input">Nombre
                                        <span style="color:red"  v-show="nombre==0" >(*Ingrese) </span>
                                    </label>
                                     <div>
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Ej.Nombre">                                        
                                     </div>
                                  </div>
                                <div class="form-group col-md-6">
                                    <label class="col-md-9 form-control-label" for="email-input">Email
                                        <span style="color:red"  v-show="email==0" >(*Ingrese) </span>
                                    </label>
                                    <div>
                                        <input type="email" v-model="email" class="form-control" placeholder="Ej.name@example.com">
                                    </div>
                                </div>
                             </div>

                             <div class="form-group row">
                                <div class="form-group col-md-6">
                                    <label class="col-md-9 form-control-label" for="email-input">Teléfono
                                        <span style="color:red"  v-show="telefono==0" >(*Ingrese) </span>
                                    </label>
                                    <div>
                                        <input type="text" v-model="telefono" class="form-control" maxlength="16" placeholder="Ej.22223333 ó 77778888">
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="col-md-3 form-control-label" for="email-input">Dirección
                                        
                                    </label>
                                    <div>
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Ej.San Salvador, El Salvador">
                                    </div>
                                </div>
                            </div>
                                
                                <div class="form-row">
                                   <div class="form-group col-md-6">
                                    <label class="col-md-6 form-control-label" for="text-input">Seleccione_Documento</label>
                                    <div>
                                        <select v-model="tipo_documento" class="form-control">
                                            <option value="">Seleccione</option>
                                            <option value="DNI">DNI</option>
                                            <option value="NIT">NIT</option>
                                            <option value="PASS">PASAPORTE</option>
                                        </select>                                    
                                    </div>
                                </div>
                            
                                <div class="form-group col-md-6">
                                    <label class="col-md-3 form-control-label" for="text-input">Número</label>
                                    <div>
                                        <input type="text" v-model="num_documento" class="form-control" placeholder="Ej.00000xxx">                                        
                                    </div>
                                </div>
                            </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                    <label class="col-md-9 form-control-label" for="email-input">Rol
                                        <span style="color:red"  v-show="idrol==0" >(*Ingrese) </span>
                                    </label>
                                    <div>
                                        <select class="form-control" v-model="idrol">
                                            <option value="0">Seleccione un rol</option>
                                            <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.nombre">
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                
                                 <div class="form-group col-md-4">
                                    <label class="col-md-9 form-control-label" for="email-input">Usuario
                                        <span style="color:red"  v-show="usuario==0" >(*Ingrese) </span>
                                    </label>
                                    <div>
                                        <input type="text" v-model="usuario" id="validationDefaultUsername" class="form-control" placeholder="Ej.Ernesto10" required>
                                    </div>
                                </div>
                                 <div class="form-group col-md-4">
                                    <label class="col-md-9 form-control-label" for="email-input">Password
                                        <span style="color:red"  v-show="password==0" >(*Ingrese) </span>
                                    </label>
                                    <div>
                                        <input type="password" v-model="password" class="form-control" placeholder="********" required>
                                    </div>
                                </div>
                                </div>

                                <div v-show="errorUsuario" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjUsuario" :key="error" v-text="error">
                                        </div>
                                    
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <p>Si seleciona tipo de documento, es obligatorio que ingrese el Número de Documento.</p>
                            <button type="button" class="btn btn-dark" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-cafe" @click="registrarUsuario()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-cafe" @click="actualizarUsuario()">Actualizar</button>
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
        data (){
            return {
                usuario_id: 0,
                nombre : '',
                tipo_documento : '',
                num_documento : '',
                direccion : '',
                telefono : '',
                email : '',
                usuario : '',
                password : '',
                idrol : 0,
                arrayUsuario : [],
                arrayRol : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorUsuario : 0,
                errorMostrarMsjUsuario : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarUsuario(page,buscar,criterio){
                let me=this;
                var url= '/user?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayUsuario= respuesta.users.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectRol(){
                let me=this;
                var url= '/rol/selectRol';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRol = respuesta.roles;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarUsuario(page,buscar,criterio);
            },
            registrarUsuario(){
                if (this.validarUsuario()){
                    return;
                }
                let me = this;
                axios.post('/user/registrar',{
                    'nombre': this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'usuario': this.usuario,
                    'password': this.password,
                    'idrol' : this.idrol
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarUsuario(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarUsuario(){
               if (this.validarUsuario()){
                    return;
                }
                let me = this;
                axios.put('/user/actualizar',{
                    'nombre': this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'usuario': this.usuario,
                    'password': this.password,
                    'idrol' : this.idrol,
                    'id': this.usuario_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarUsuario(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },            
            validarUsuario(){
                this.errorUsuario=0;
                this.errorMostrarMsjUsuario =[];

                if (this.nombre == '' || this.nombre == null)
                {
                    this.errorMostrarMsjUsuario.push("El nombre de la persona no puede estar vacío.");
                } 
                else if(!/^[a-zA-ZÀ-ÿ\u00f1\u00d1 ]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/.test(this.nombre)){
                    this.errorMostrarMsjUsuario.push("El nombre de la persona  no debe contener números");
                }
                else if( !/^[A-Z]/.test(this.nombre)){
                    this.errorMostrarMsjUsuario.push("El nombre de la persona debe iniciar con una letra mayúscula");
                }

                /*Validación del correo*/
                else if(this.email == '' || this.email == null)
                {
                   this.errorMostrarMsjUsuario.push("El email del usuario no puede estar vacío");
                }
                else if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(this.email))
                {
                   this.errorMostrarMsjUsuario.push("Ingrese un correo electronico valido");
                }

                
            /*Validación del número de telefono*/
                else if(this.telefono == '' || this.telefono == null){
                     this.errorMostrarMsjUsuario.push("El teléfono del usuario no puede estar vacío");
                }
                    
                
                /*Validación del  rol*/
                else if(this.idrol==0){
                    this.errorMostrarMsjUsuario.push("Seleccione un rol");
                }
                /*Validación del  usuario*/
                else if(this.usuario == '' || this.usuario == null){
                    this.errorMostrarMsjUsuario.push("El usuario no puede quedar vacío");
                }
                /*Validación de la contraseña*/
                else if(this.password == '' || this.password == null){
                    this.errorMostrarMsjUsuario.push("El password del usuario no puede estar vacío");
                }
                 else if(this.password.length<=7){
                      this.errorMostrarMsjUsuario.push("La contraseña debe de contener mas de 7 caracteres");
                    }
                /*Validación del tipo de documento*/
                if (!this.tipo_documento == '' ){
                    if(this.num_documento == ''){
                      this.errorMostrarMsjUsuario.push("El número de documento del usuario no puede estar vacío.");
                    }
                    /*else if(!/^[0-9]+$/.test(this.num_documento)){
                      this.errorMostrarMsjUsuario.push("El número de documento del usuario no debe contener letras.");
                    }*/
                    else if(this.num_documento.length<=7){
                      this.errorMostrarMsjUsuario.push("El número de documento del usuario no es valido, debe ser mas de 7 caracteres.");
                    }
                }
                    else if(!this.num_documento == ''){
                       if(this.tipo_documento == ''){
                         this.errorMostrarMsjUsuario.push("Seleccione un tipo de documento.");
                        }
                    }

            if (this.errorMostrarMsjUsuario.length) this.errorUsuario = 1;
                return this.errorUsuario;
            },

            validEmail (email) {
            if (!this.email == ''){
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }else{
                return true;
            }
        }, 



        cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.tipo_documento= '';
                this.num_documento='';
                this.direccion='';
                this.telefono='';
                this.email='';
                this.usuario='';
                this.password='';
                this.idrol=0;
                this.errorUsuario=0;
            },
            abrirModal(modelo, accion, data = []){
                this.selectRol();
                switch(modelo){
                    case "users":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Usuario';
                                this.nombre= '';
                                this.tipo_documento='';
                                this.num_documento='';
                                this.direccion='';
                                this.telefono='';
                                this.email='';
                                this.usuario='';
                                this.password='';
                                this.idrol=0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Usuario';
                                this.tipoAccion=2;
                                this.usuario_id=data['id'];
                                this.nombre = data['nombre'];
                                this.tipo_documento = data["tipo_documento"];
                                this.num_documento = data['num_documento'];
                                this.direccion = data['direccion'];
                                this.telefono = data['telefono'];
                                this.email = data['email'];
                                this.usuario = data['usuario'];
                                this.password = data['password'];
                                this.idrol = data['idrol'];
                                break;
                            }
                        }
                    }
                }
            },
            desactivarUsuario(id){
               swal({
                title: 'Esta seguro de desactivar este usuario?',
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
                    axios.put('/user/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarUsuario(1,'','nombre');
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
            activarUsuario(id){
               swal({
                title: 'Esta seguro de activar este usuario?',
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

                    axios.put('/user/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarUsuario(1,'','nombre');
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
            }
        },
        mounted() {
            this.listarUsuario(1,this.buscar,this.criterio);
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
