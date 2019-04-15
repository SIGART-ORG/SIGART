<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Colaboradores</h3>
                    <div class="tile-body">
                        <form class="row">
                            <div class="form-group col-md-6">
                                <input class="form-control" v-model="buscar" type="text" placeholder="Buscar" @keyup="listar(1, buscar)">
                            </div>
                            <div class="form-group col-md-3 align-self-end">
                                <button class="btn btn-primary" type="button" @click="listar(1, buscar)">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                            <div class="form-group col-md-3 align-self-end">
                                <button class="btn btn-success" type="button" @click="abrirModal('registrar')">
                                    <i class="fa fa-fw fa-lg fa-plus"></i>Nuevo colaborador
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Usuarios</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Accesos</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="dato in arreglo" :key="dato.id">
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" @click="abrirModal('actualizar', dato)">
                                        <i class="fa fa-edit"></i>
                                    </button> &nbsp;
                                    <button type="button" class="btn btn-danger btn-sm" @click="eliminar(dato.id)">
                                        <i class="fa fa-trash"></i>
                                    </button> &nbsp;
                                    <template v-if="dato.status == 1">
                                        <button type="button" class="btn btn-warning btn-sm" @click="desactivar(dato.id)">
                                            <i class="fa fa-ban"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-success btn-sm" @click="activar(dato.id)">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </template>
                                </td>
                                <td v-text="dato.name"></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" @click.prevent="redirect(dato.id)">
                                        <i class="fa fa-sign-in"></i>
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
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1, buscar)">Ant.</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1, buscar)">Sig.</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <b-modal id="modalPrevent" size="lg" ref="modal" :title="modalTitulo" @ok="processForm">
            <form @submit.stop.prevent="cerrarModal">
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Rol <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <input type="text" v-model="nombre" name="nombre" v-validate="'required'" class="form-control" placeholder="Nombre de rol" :class="{'is-invalid': errors.has('nombre')}">
                        <span v-show="errors.has('nombre')" class="text-danger">{{ errors.first('nombre') }}</span>
                    </div>
                </div>
            </form>
        </b-modal>
    </div>
</template>
<script>
export default {
    name: 'roles-adm',
    data(){
        return{
            id: 0,
            nombre: "",
            arreglo: [],
            action: 'registrar',
            modalTitulo: '',
            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
            },
            offset : 3,
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
        redirect(role){
            window.location = URL_PROJECT + '/access/dashboard/' + role;
        },
        listar( page, buscar ){
            var me = this;
            var url= '/role?page=' + page + '&buscar='+ buscar;
            axios.get(url).then(function (response) {
                var respuesta= response.data;
                me.arreglo = respuesta.records.data;
                me.pagination= respuesta.pagination;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        cambiarPagina( page, buscar ){
            let me = this;
            //Actualiza la página actual
            me.pagination.current_page = page;
            //Envia la petición para visualizar la data de esa página
            me.listar( page, buscar );
        },
        abrirModal(action, data=[]){
            switch(action){
                case 'registrar':
                    this.id = 0;
                    this.modalTitulo = 'Registrar Rol';
                    this.nombre = '';
                    this.$refs.modal.show();
                break;
                case 'actualizar':
                    this.id = data.id;
                    this.modalTitulo = 'Actualizar Rol - '+data.name;
                    this.nombre = data.name;
                    this.action = 'actualizar';
                    this.$refs.modal.show();
                break;
            }
        },
        cerrarModal(){
            this.modalTitulo = '';
            this.nombre = '';
            this.action = 'registrar';
            this.$nextTick(() => {
                // Wrapped in $nextTick to ensure DOM is rendered before closing
                this.$refs.modal.hide();
            })
        },
        processForm(evt){
            evt.preventDefault();
            switch(this.action){
                case 'registrar':
                    this.registrar();
                    break;
                case 'actualizar':
                    this.actualizar();
                    break;
            }
        },
        registrar(){
            this.$validator.validateAll().then((result) => {
                if (result) {
                    let me = this;
                    axios.post('/role/register',{
                        'nombre': this.nombre
                    }).then(function (response) {
                        me.cerrarModal();
                        me.listar( 1, '' );
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
                    axios.put('/role/update',{
                        'id': this.id,
                        'nombre': this.nombre
                    }).then(function (response) {
                        me.cerrarModal(); 
                        me.listar( 1, '' );
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            });
        },
        activar(id){
            swal({
                title: "Activar Rol!",
                text: "Esta seguro de activar este rol de administrador?",
                icon: "success",
                button: "Desactivar",
            }).then((result) => {
                if (result) {
                    let me = this;

                    axios.put('/role/activate',{
                        'id': id
                    }).then(function (response) {
                        me.listar( 1, '' );
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        swal(
                            'Error! :(',
                            'No se pudo realizar la operación',
                            'error'
                        )
                    });
                }
            })
        },
        desactivar(id){
            swal({
                title: "Desactivar Rol!",
                text: "Esta seguro de desactivar este rol de administrador?",
                icon: "warning",
                button: "Desactivar"
            }).then((result) => {
                if (result) {
                    let me = this;

                    axios.put('/role/deactivate',{
                        'id': id
                    }).then(function (response) {
                        me.listar( 1, '' );
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        swal(
                            'Error! :(',
                            'No se pudo realizar la operación',
                            'error'
                        )
                    });
                }
            })
        },
        eliminar(id){
            swal({
                title: "Eliminar Rol!",
                text: "Esta seguro de activar este rol de administrador?",
                icon: "error",
                button: "Desactivar"
            }).then((result) => {
                if (result) {
                    let me = this;

                    axios.put('/role/delete',{
                        'id': id
                    }).then(function (response) {
                        me.listar( 1, '' );
                        swal(
                        'Eliminado!',
                        'El registro ha sido eliminado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        swal(
                            'Error! :(',
                            'No se pudo realizar la operación',
                            'error'
                        )
                    });
                }
            })
        }
    },
    mounted() {
        this.listar( 1, this.buscar );
    }
}
</script>