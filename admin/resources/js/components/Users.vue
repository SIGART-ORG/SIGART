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
                                <th>Nombre(s) y Apellidos</th>
                                <th>DNI</th>
                                <th>Correo</th>
                                <th># Celular</th>
                                <th>Rol</th>
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
                                        <i class="fa fa-trash-o"></i>
                                    </button> &nbsp;
                                    <template v-if="dato.status == 1">
                                        <button type="button" class="btn btn-success btn-sm" @click="desactivar(dato.id)">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-warning btn-sm" @click="activar(dato.id)">
                                            <i class="fa fa-ban"></i>
                                        </button>
                                    </template>
                                </td>
                                <td v-text="dato.name+' '+dato.last_name"></td>
                                <td v-text="dato.document"></td>
                                <td v-text="dato.email"></td>
                                <td v-text="dato.phone"></td>
                                <td v-text="dato.role_name"></td>
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
        <b-modal id="modalPrevent" size="lg" ref="modal" title="Registro de Colaboradores" @ok="processForm">
            <form @submit.stop.prevent="cerrarModal">
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Rol <span class="text-danger">(*)</span></label>
                    <div class="col-md-4">
                        <select class="form-control" v-model="rol" name="rol" v-validate="{is_not: 0}" :class="{'is-invalid': errors.has('rol')}">
                            <option value="0" disabled>Seleccione</option>
                            <option v-for="role in arrayRoles" :key="role.id" :value="role.id" v-text="role.name"></option>
                        </select>
                        <span v-show="errors.has('rol')" class="text-danger">{{ errors.first('rol') }}</span>
                    </div>
                    <label class="col-md-2 form-control-label">N° DNI <span class="text-danger">(*)</span></label>
                    <div class="col-md-4">
                        <input type="text" v-model="documento" name="documento" v-validate="{ required: true, regex: /^([0-9]+)$/, min:8, max:8 }" class="form-control" placeholder="Nro Documento" :class="{'is-invalid': errors.has('documento')}">
                        <span v-show="errors.has('documento')" class="text-danger">{{ errors.first('documento') }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Nombre <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <input type="text" v-model="nombre" name="nombre" v-validate="'required'" class="form-control" placeholder="Nombre" :class="{'is-invalid': errors.has('nombre')}">
                        <span v-show="errors.has('nombre')" class="text-danger">{{ errors.first('nombre') }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Apellido <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <input type="text" v-model="apellido" name="apellido" v-validate="'required'" class="form-control" placeholder="Apellidos" :class="{'is-invalid': errors.has('apellido')}">
                        <span v-show="errors.has('apellido')" class="text-danger">{{ errors.first('apellido') }}</span>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-md-3 form-control-label">E-Mail <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <input type="text" v-model="correo" name="correo" v-validate="{ required: true, email: true}" class="form-control" placeholder="Correo" :class="{'is-invalid': errors.has('correo')}">
                        <span v-show="errors.has('correo')" class="text-danger">{{ errors.first('correo') }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Dirección <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <input type="text" v-model="direccion" name="direccion" v-validate="{ required: true}" class="form-control" placeholder="Dirección" :class="{'is-invalid': errors.has('direccion')}">
                        <span v-show="errors.has('direccion')" class="text-danger">{{ errors.first('direccion') }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label"># Celular</label>
                    <div class="col-md-4">
                        <input type="number" v-model="phone" name="phone" v-validate="'numeric|max:9'" class="form-control" placeholder="# Celular" :class="{'is-invalid': errors.has('phone')}">
                        <span v-show="errors.has('phone')" class="text-danger">{{ errors.first('phone') }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Cumpleaños <span class="text-danger">(*)</span></label>
                    <div class="col-md-4">
                        <datepicker v-model="cumpleanos" name="cumpleanos" :config="options" :input-class="['form-control']" v-validate="{ required: true, date_format:'yyyy-MM-dd'}"></datepicker>
                        <span v-show="errors.has('cumpleanos')" class="text-danger">{{ errors.first('cumpleanos') }}</span>
                    </div>
                    <label class="col-md-2 form-control-label">Ingreso <span class="text-danger">(*)</span></label>
                    <div class="col-md-4">
                        <datepicker v-model="ingreso" name="ingreso" :config="options" :input-class="['form-control']" v-validate="{ required: true, date_format:'yyyy-MM-dd'}"></datepicker>
                        <span v-show="errors.has('ingreso')" class="text-danger">{{ errors.first('ingreso') }}</span>
                    </div>
                </div>
            </form>
        </b-modal>
    </div>
</template>
<script>
    import moment from 'moment';
    import datepicker from 'vue-bootstrap-datetimepicker';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';

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
        datepicker
    },
    data(){
        return{
            action: 'registrar',
            id: 0,
            rol: 0,
            nombre: "",
            apellido: "",
            correo: "",
            direccion: "",
            documento: "",
            cumpleanos: "",
            phone: "",
            ingreso: "",
            arrayRoles: [],
            arreglo: [],
            modalTitulo: '',
            modal: 0,
            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
            },
            offset : 3,
            buscar : '',
            options: {
                format: 'YYYY-MM-DD',
                useCurrent: false,
                showClear: true,
                showClose: true,
            }
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
        customFormatter(date) {
            return moment(date).format('YYYY-MM-DD');
        },
        listar(page,buscar){
            var me = this;
            var url= '/user?page=' + page + '&buscar='+ buscar;
            axios.get(url).then(function (response) {
                var respuesta= response.data;
                me.arreglo = respuesta.records.data;
                me.pagination= respuesta.pagination;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        cambiarPagina(page,buscar){
            let me = this;
            //Actualiza la página actual
            me.pagination.current_page = page;
            //Envia la petición para visualizar la data de esa página
            me.listar(page,buscar);
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
                    this.phone = '';
                    this.$refs.modal.show();
                break;
                case 'actualizar':
                    var formatDateEntry = new Date(data.year_entry, data.month_entry, data.day_entry);
                    this.modal = 1;
                    this.id = data.id;
                    this.rol = data.role_id
                    this.modalTitulo = 'Actualizar Rol - '+data.name;
                    this.nombre = data.name;
                    this.apellido = data.last_name;
                    this.documento = data.document;
                    this.correo = data.email;
                    this.direccion = data.address;
                    this.cumpleanos = data.birthday;
                    this.ingreso = formatDateEntry;
                    this.phone = data.phone;
                    this.action = 'actualizar';
                    this.$refs.modal.show();
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
            this.phone = '';
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
                    axios.post('/user/register',{
                        'rol': this.rol,
                        'nombre': this.nombre,
                        'apellido': this.apellido,
                        'documento': this.documento,
                        'correo': this.correo,
                        'direccion': this.direccion,
                        'cumpleanos': this.cumpleanos,
                        'ingreso': this.ingreso,
                        'phone': this.phone
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
                        'ingreso': this.ingreso,
                        'phone': this.phone
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
                title: "Activar Usuario!",
                text: "Esta seguro de activar este administrador?",
                icon: "success",
                button: "Activar"
            }).then((result) => {
                if (result) {
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
                        swal(
                            'Error! :(',
                            'No se pudo realizar la operación',
                            'error'
                        );
                    });


                }
            })
        },
        desactivar(id){
            swal({
                title: "Desactivar Usuario!",
                text: "Esta seguro de desactivar este administrador?",
                icon: "warning",
                button: "Desactivar",
            }).then((result) => {
                if (result) {
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
                title: "Eliminar!",
                text: "Esta seguro de eliminar este administrador?",
                icon: "error",
                button: "Eliminar"
            }).then((result) => {
                if (result) {
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
        this.listar(1,this.buscar);
    }
}
</script>
