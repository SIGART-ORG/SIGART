<template>
    <div>


        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Registrar Feriado</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <select class="form-control " v-model="month" name="month" v-validate="'excluded:0'" :class="{'is-invalid': errors.has('month')}" @change="loadDays()">
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
                            </div>
                            <div class="col-md-4">
                                <select class="form-control " v-model="day" name="day" v-validate="'excluded:0'" :class="{'is-invalid': errors.has('day')}">
                                    <option value="0">- Día -</option>
                                    <option v-for="rDay in aDays" :key="rDay" :value="rDay" v-text="rDay"></option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Día festivo" v-model="description" name="description" v-validate="'required'" :class="{'is-invalid': errors.has('description')}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4">

                                <button type="button" v-if="id==0" class="btn btn-success" @click="guardar()"><i class="fa fa-plus"></i> Registrar</button>
                                <button type="button" v-if="id>0" class="btn btn-primary" @click="guardar()"><i class="fa fa-edit"></i> Actualizar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal" @click="cancelar()">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Feriados</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input type="text" v-model="buscar" @keyup="listar(1, buscar)" class="form-control mb-2" id="inlineFormInput" placeholder="Buscar...">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="listar(1, buscar)">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </section>


        <section class="hk-sec-wrapper">
            <h6 class="hk-sec-title">Listado</h6>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="dato in arreglo" :key="dato.id">
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" @click="actualizar(dato)">
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="hk-sec-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page-1, buscar)">Ant.</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="changePage(page, buscar)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page+1, buscar)">Sig.</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
    </div>


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
            actualizar(data){
                this.month = data.month;
                this.loadDays();
                this.id = data.id;
                this.day = data.day;
                this.description = data.description;
            },
            activar(id){
                swal({
                    title: "Activar Feriado!",
                    text: "Esta seguro de activar este feriado?",
                    icon: "success",
                    button: "Activar"
                }).then((result) => {
                    if (result) {
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


                    }
                })
            },
            desactivar(id){
                swal({
                    title: "Desactivar Feriado!",
                    text: "Esta seguro de desactivar este Feriado?",
                    icon: "warning",
                    button: "Desactivar",
                }).then((result) => {
                    if (result) {
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


                    }
                })
            },
            eliminar(id){
                swal({
                    title: "Eliminar!",
                    text: "Esta seguro de eliminar este Feriado?",
                    icon: "danger",
                    button: "Eliminar"
                }).then((result) => {
                    if (result) {
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
