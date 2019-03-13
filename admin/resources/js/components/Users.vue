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
                    <h3 class="tile-title">Responsive Table</h3>
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

    </div>
</template>
<script>
    import moment from 'moment';
    //import Datepicker from 'vuejs-datepicker';
    //import {en, es} from 'vuejs-datepicker/dist/locale'

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
        //Datepicker
    },
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
            phone: "",
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
            buscar : '',
            // en: en,
            // es: es
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
                    this.phone = '';
                break;
                case 'actualizar':
                    var formatDateEntry = new Date(data.year_entry, data.month_entry, data.day_entry);
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
                    this.ingreso = formatDateEntry;
                    this.phone = data.phone;
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
                        console.log(error);
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
                        console.log(error);
                    });


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
        this.listar(1,this.buscar);
    }
}
</script>
