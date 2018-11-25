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
                    <i class="fa fa-align-justify"></i> Días Festivos
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-2" v-model="month" name="month" v-validate="'excluded:0'" :class="{'is-invalid': errors.has('month')}" @change="loadDays()">
                                    <option value="0">- Mes -</option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                                <select class="form-control col-md-2" v-model="day" name="day" v-validate="'excluded:0'" :class="{'is-invalid': errors.has('day')}">
                                    <option value="0">- Día -</option>
                                    <option v-for="rDay in aDays" :key="rDay" :value="rDay" v-text="rDay"></option>
                                </select>
                                <input type="text" class="form-control" placeholder="Día festivo" v-model="description" name="description" v-validate="'required'" :class="{'is-invalid': errors.has('description')}">
                                <button type="button" v-if="id==0" class="btn btn-success" @click="guardar()"><i class="fa fa-plus"></i> Registrar</button>
                                <button type="button" v-if="id>0" class="btn btn-primary" @click="guardar()"><i class="fa fa-edit"></i> Actualizar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal" @click="cancelar()">Cancelar</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="nombre">Festividad</option>
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
                            <th>Fecha</th>
                            <th>Festividad</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="dato in arreglo" :key="dato.id">
                            <td>
                                <button type="button" class="btn btn-info btn-sm" @click="actualizar(dato)">
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
                            <td v-text="dato.day+' de '+month_to_human(dato.month)"></td>
                            <td v-text="dato.description"></td>
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
    </main>
</template>

<script>
    export default {
        name: "Holidays",
        data(){
            return{
                id: 0,
                url : '/holidays',
                day: 0,
                month: 0,
                description: '',
                aDays: [],
                nombre: "",
                arreglo: [],
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
                var url=  me.url+'?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arreglo = respuesta.records.data;
                    me.pagination= respuesta.pagination;
                }).catch(function (error) {
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
            guardar(){
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let me = this;
                        if(this.id > 0){
                            var url_action = this.url+'/update'
                            axios.put(url_action,{
                                'id': this.id,
                                'day': this.day,
                                'month': this.month,
                                'description': this.description
                            }).then(function (response) {
                                me.cancelar();
                                me.listar(1,'','nombre');
                            }).catch(function (error) {
                                console.log(error);
                            });
                        }else{
                            var url_action = this.url+'/register';
                            axios.post(url_action,{
                                'id': this.id,
                                'day': this.day,
                                'month': this.month,
                                'description': this.description
                            }).then(function (response) {
                                me.cancelar();
                                me.listar(1,'','nombre');
                            }).catch(function (error) {
                                console.log(error);
                            });
                        }

                    }
                });
            },
            actualizar(data){
                this.month = data.month;
                this.loadDays();
                this.id = data.id;
                this.day = data.day;
                this.description = data.description;
            },
            activar(id){
                swal({
                    title: 'Esta seguro de activar este rol de administrador?',
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
                        var url_action = this.url+'/activate';
                        axios.put(url_action,{
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
                    title: 'Esta seguro de desactivar este rol de administrador?',
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
                        var url_action = this.url+'/deactivate';
                        axios.put(url_action,{
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
                    title: 'Esta seguro de activar este rol de administrador?',
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
                        var url_action = this.url+'/delete';
                        axios.put(url_action,{
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
            },
            cancelar(){
                this.id = 0;
                this.day = 0;
                this.aDays = [];
                this.month = 0;
                this.description = '';
            },
            loadDays(){
                let me = this;
                me.day = 0;
                me.aDays = [];

                if(me.month > 0){
                    var url=  '/ajax/days?month=' + me.month;
                    axios.get(url).then(function (response) {
                        var respuesta= response.data;
                        me.aDays = respuesta.days;
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            },
            month_to_human(month_id){
                var monthText = '';
                switch(month_id){
                    case 1:
                        monthText = 'Enero';
                        break;
                    case 2:
                        monthText = 'Febrero';
                        break;
                    case 3:
                        monthText = 'Marzo';
                        break;
                    case 4:
                        monthText = 'Abril';
                        break;
                    case 5:
                        monthText = 'Mayo';
                        break;
                    case 6:
                        monthText = 'Junio';
                        break;
                    case 7:
                        monthText = 'Julio';
                        break;
                    case 8:
                        monthText = 'Agosto';
                        break;
                    case 9:
                        monthText = 'Septiembre';
                        break;
                    case 10:
                        monthText = 'Octubre';
                        break;
                    case 11:
                        monthText = 'Noviembre';
                        break;
                    case 12:
                        monthText = 'Diciembre';
                        break;
                }
                return monthText;
            }
        },
        mounted() {
            this.listar(1,this.buscar,this.criterio);
        }
    }
</script>

<style scoped>

</style>