<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item"><a href="#" @click.prevent="update_side_bar(1)">Módulos</a></li>
            <li class="breadcrumb-item active">Páginas</li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Páginas
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
                                <th>URL</th>
                                <th>Mostrar en Panel</th>
                                <th>Permisos</th>
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
                                <td v-text="dato.url"></td>
                                <td>
                                    <span v-if="dato.view_panel == 1" class="badge badge-success">Si</span>
                                    <span v-else class="badge badge-danger">No</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" @click="update_side_bar(5, {page: dato.id})">
                                        <i class="icon-key"></i>
                                    </button>
                                </td>
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
                                <label class="col-md-2 form-control-label" for="text-input">Módulo <span class="text-danger">(*)</span></label>
                                <div class="col-md-4">
                                    <select class="form-control" v-model="modulo" name="modulo" v-validate="{is_not: 0}" :class="{'is-invalid': errors.has('modulo')}">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="module in arrayModules" :key="module.id" :value="module.id" v-text="module.name"></option>
                                    </select>
                                    <span v-show="errors.has('modulo')" class="text-danger">{{ errors.first('modulo') }}</span>
                                </div>
                                <label class="col-md-2 form-control-label" for="text-input">Mostrat en Panel</label>
                                <div class="col-md-4">
                                    <input type="checkbox" v-model="vistaPanel" value="1" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="text-input">Página <span class="text-danger">(*)</span></label>
                                <div class="col-md-4">
                                    <input type="text" v-model="nombre" name="nombre" v-validate="'required'" class="form-control" placeholder="Página" :class="{'is-invalid': errors.has('nombre')}">
                                    <span v-show="errors.has('nombre')" class="text-danger">{{ errors.first('nombre') }}</span>
                                </div>
                                <label class="col-md-2 form-control-label" for="text-input">URL <span class="text-danger">(*)</span></label>
                                <div class="col-md-4">
                                    <input type="text" v-model="url" name="url" v-validate="'required'" class="form-control" placeholder="URL" :class="{'is-invalid': errors.has('url')}">
                                    <span v-show="errors.has('url')" class="text-danger">{{ errors.first('url') }}</span>
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
    import moment from 'moment';
    import Datepicker from 'vuejs-datepicker';
    import {en, es} from 'vuejs-datepicker/dist/locale'

    function getDate () {
        const toTwoDigits = num => num < 10 ? '0' + num : num;
        let today = new Date();
        let year = today.getFullYear();
        let month = toTwoDigits(today.getMonth() + 1);
        let day = toTwoDigits(today.getDate());
        return `${day}/${month}/${year}`;
    }

export default {
    name: 'users-adm',
    components: {
        Datepicker
    },
    
    data(){
        return{
            modulo_filter: this.$parent.modulo_filter,
            id: 0,
            modulo: 0,
            nombre: "",
            url: "",
            vistaPanel: 1,
            arrayModules: [],
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
            buscar : '',
            en: en,
            es: es
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
        update_side_bar(idSideBar, datos = {}){
            this.$emit('update_side_bar', idSideBar, datos);
        },
        customFormatter(date) {
            return moment(date).format('YYYY-MM-DD');
        },
        listar(page,buscar,criterio){
            var me = this;
            var url= '/page?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio+'&module_filter='+this.modulo_filter;
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
        selectModule(){
            let me=this;
            var url = '/module/select';
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayModules = respuesta.modules;
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
                    this.modulo = 0;
                    this.modalTitulo = 'Registrar Página';
                    this.nombre = '';
                    this.url = '';
                break;
                case 'actualizar':
                    this.modal = 1;
                    this.tipoAccion = 2;
                    this.id = data.id;
                    this.modulo = data.module_id;
                    this.modalTitulo = 'Actualizar Página - '+data.name;
                    this.nombre = data.name;
                    this.url = data.url;
                    this.vistaPanel = data.view_panel;
                break;
            }
            this.selectModule();
        },
        cerrarModal(){
            this.modal = 0;
            this.modulo = 0;
            this.id = 0;
            this.modalTitulo = '';
            this.nombre = '';
            this.url = '';
        },
        registrar(){
            this.$validator.validateAll().then((result) => {
                if (result) {
                    let me = this;
                    axios.post('/page/register',{
                        'modulo': this.modulo,
                        'nombre': this.nombre,
                        'url': this.url,
                        'vistaPanel': this.vistaPanel
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
                    axios.put('/page/update',{
                        'id': this.id,
                        'modulo': this.modulo,
                        'nombre': this.nombre,
                        'url': this.url,
                        'vistaPanel': this.vistaPanel
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
                title: 'Esta seguro de activar esta Página?',
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

                    axios.put('/page/activate',{
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
                title: 'Esta seguro de desactivar esta Página?',
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

                    axios.put('/page/deactivate',{
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
                title: 'Esta seguro de eliminar esta Página?',
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

                    axios.put('/page/delete',{
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