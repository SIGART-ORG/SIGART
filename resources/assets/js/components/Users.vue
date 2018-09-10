<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Usuarios
                    <button type="button" @click="abrirModal('registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="nombre">Nombre</option>
                                    <option value="apellidos">Apellidos</option>
                                    <option value="correo">Correo</option>
                                    <option value="documento">DNI</option>
                                    <option value="rol">Rol</option>
                                </select>
                                <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" @keyup="listar(1, buscar, criterio)">
                                <button type="submit" @click="listar(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>DNI</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Cumpleaños</th>
                                <th>Ingreso</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="dato in arreglo" :key="dato.id">
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" @click="abrirModal('actualizar', dato)">
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <button type="button" class="btn btn-danger btn-sm" @click="eliminar(dato.id)">
                                        <i class="icon-trash"></i>
                                    </button> &nbsp;
                                    <template v-if="dato.status == 1">
                                        <button type="button" class="btn btn-success btn-sm" @click="desactivar(dato.id)">
                                            <i class="icon-check"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-warning btn-sm" @click="activar(dato.id)">
                                            <i class="icon-check"></i>
                                        </button>
                                    </template>
                                </td>
                                <td v-text="dato.name"></td>
                                <td v-text="dato.last_name"></td>
                                <td v-text="dato.document"></td>
                                <td v-text="dato.email"></td>
                                <td v-text="dato.role_name"></td>
                                <td v-text="dato.birthday"></td>
                                <td v-text="dato.date_entry"></td>
                                <td>
                                    <div v-if="dato.status">
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
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" :class="{'mostrar' : modal}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="modalTitulo"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"  @click="cerrarModal()">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Rol <span class="text-danger">(*)</span></label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="rol" name="rol" v-validate="{is_not: 0}" :class="{'is-invalid': errors.has('rol')}">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="role in arrayRoles" :key="role.id" :value="role.id" v-text="role.name"></option>
                                    </select>
                                    <span v-show="errors.has('rol')" class="text-danger">{{ errors.first('rol') }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="text-input">Nombre <span class="text-danger">(*)</span></label>
                                <div class="col-md-4">
                                    <input type="text" v-model="nombre" name="nombre" v-validate="'required'" class="form-control" placeholder="Nombre" :class="{'is-invalid': errors.has('nombre')}">
                                    <span v-show="errors.has('nombre')" class="text-danger">{{ errors.first('nombre') }}</span>
                                </div>
                                <label class="col-md-2 form-control-label" for="text-input">Apellido <span class="text-danger">(*)</span></label>
                                <div class="col-md-4">
                                    <input type="text" v-model="apellido" name="apellido" v-validate="'required'" class="form-control" placeholder="Apellidos" :class="{'is-invalid': errors.has('apellido')}">
                                    <span v-show="errors.has('apellido')" class="text-danger">{{ errors.first('apellido') }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="text-input">N° DNI <span class="text-danger">(*)</span></label>
                                <div class="col-md-4">
                                    <input type="text" v-model="documento" name="documento" v-validate="{ required: true, regex: /^([0-9]+)$/, min:8, max:8 }" class="form-control" placeholder="Nro Documento" :class="{'is-invalid': errors.has('documento')}">
                                    <span v-show="errors.has('documento')" class="text-danger">{{ errors.first('documento') }}</span>
                                </div>
                                <label class="col-md-2 form-control-label" for="text-input">E-Mail <span class="text-danger">(*)</span></label>
                                <div class="col-md-4">
                                    <input type="text" v-model="correo" name="correo" v-validate="{ required: true, email: true}" class="form-control" placeholder="Correo" :class="{'is-invalid': errors.has('correo')}">
                                    <span v-show="errors.has('correo')" class="text-danger">{{ errors.first('correo') }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Dirección <span class="text-danger">(*)</span></label>
                                <div class="col-md-9">
                                    <input type="text" v-model="direccion" name="direccion" v-validate="{ required: true}" class="form-control" placeholder="Dirección" :class="{'is-invalid': errors.has('direccion')}">
                                    <span v-show="errors.has('direccion')" class="text-danger">{{ errors.first('direccion') }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="text-input">Cumpleaños <span class="text-danger">(*)</span></label>
                                <div class="col-md-4">
                                    <input type="text" v-model="cumpleanos" name="cumpleanos" v-validate="{ required: true, date_format:'YYYY-MM-DD'}" class="form-control" placeholder="YYYY-MM-DD" :class="{'is-invalid': errors.has('cumpleanos')}">
                                    <span v-show="errors.has('cumpleanos')" class="text-danger">{{ errors.first('cumpleanos') }}</span>
                                </div>
                                <label class="col-md-2 form-control-label" for="text-input">Ingreso <span class="text-danger">(*)</span></label>
                                <div class="col-md-4">
                                    <input type="text" v-model="ingreso" name="ingreso" v-validate="{ required: true, date_format:'YYYY-MM-DD'}" class="form-control" placeholder="YYYY-MM-DD" :class="{'is-invalid': errors.has('ingreso')}">
                                    <span v-show="errors.has('ingreso')" class="text-danger">{{ errors.first('ingreso') }}</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrar()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizar()">Actualizar</button>
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
    name: 'users-adm',
    data(){
        return{
            id: 0,
            rol: 0,
            nombre: "",
            apellido: "",
            correo: "",
            direccion: "",
            documento: "",
            cumpleanos: "",
            ingreso: "",
            arrayRoles: [],
            arreglo: [],
            modalTitulo: '',
            modal: 0,
            tipoAccion: 0,
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
    methods:{
        listar(page,buscar,criterio){
            var me = this;
            var url= '/user?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
            axios.get(url).then(function (response) {
                var respuesta= response.data;
                me.arreglo = respuesta.records.data;
                me.pagination= respuesta.pagination;
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
            me.listar(page,buscar,criterio);
        },
        selectRole(){
            let me=this;
            var url = '/role/select';
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayRoles = respuesta.roles;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        abrirModal(action, data=[]){
            switch(action){
                case 'registrar':
                    this.modal = 1;
                    this.tipoAccion = 1;
                    this.id = 0;
                    this.rol = 0;
                    this.modalTitulo = 'Registrar Rol';
                    this.nombre = '';
                    this.apellido = '';
                    this.documento = '';
                    this.correo = '';
                    this.direccion = '';
                    this.cumpleanos = '';
                    this.ingreso = '';
                break;
                case 'actualizar':
                    this.modal = 1;
                    this.tipoAccion = 2;
                    this.id = data.id;
                    this.rol = data.role_id
                    this.modalTitulo = 'Actualizar Rol - '+data.name;
                    this.nombre = data.name;
                    this.apellido = data.last_name;
                    this.documento = data.document;
                    this.correo = data.email;
                    this.direccion = data.address;
                    this.cumpleanos = data.birthday;
                    this.ingreso = data.date_entry;
                break;
            }
            this.selectRole();
        },
        cerrarModal(){
            this.modal = 0;
            this.rol = 0;
            this.id = 0;
            this.modalTitulo = '';
            this.nombre = '';
            this.apellido = '';
            this.documento = '';
            this.correo = '';
            this.direccion = '';
            this.cumpleanos = '';
            this.ingreso = '';
        },
        registrar(){
            this.$validator.validateAll().then((result) => {
                if (result) {
                    let me = this;
                    axios.post('/user/register',{
                        'rol': this.rol,
                        'nombre': this.nombre,
                        'apellido': this.apellido,
                        'documento': this.documento,
                        'correo': this.correo,
                        'direccion': this.direccion,
                        'cumpleanos': this.cumpleanos,
                        'ingreso': this.ingreso
                    }).then(function (response) {
                        me.cerrarModal();
                        me.listar(1,'','nombre');
                    }).catch(function (error) {
                         console.log(error);
                    });
                }
            });
        },
        actualizar(){
            this.$validator.validateAll().then((result) => {
                if (result) {
                    let me = this;
                    axios.put('/user/update',{
                        'id': this.id,
                        'rol': this.rol,
                        'nombre': this.nombre,
                        'apellido': this.apellido,
                        'documento': this.documento,
                        'correo': this.correo,
                        'direccion': this.direccion,
                        'cumpleanos': this.cumpleanos,
                        'ingreso': this.ingreso
                    }).then(function (response) {
                        me.cerrarModal(); 
                        me.listar(1,'','nombre');
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            });
        },
        activar(id){
            swal({
                title: 'Esta seguro de activar este administrador?',
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

                    axios.put('/user/activate',{
                        'id': id
                    }).then(function (response) {
                        me.listar(1,'','nombre');
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
        desactivar(id){
            swal({
                title: 'Esta seguro de desactivar este administrador?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-danger',
                cancelButtonClass: 'btn btn-info',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/user/deactivate',{
                        'id': id
                    }).then(function (response) {
                        me.listar(1,'','nombre');
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
        eliminar(id){
            swal({
                title: 'Esta seguro de eliminar este administrador?',
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

                    axios.put('/user/delete',{
                        'id': id
                    }).then(function (response) {
                        me.listar(1,'','nombre');
                        swal(
                        'Eliminado!',
                        'El registro ha sido eliminado con éxito.',
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
        this.listar(1,this.buscar,this.criterio);
    }
}
</script>