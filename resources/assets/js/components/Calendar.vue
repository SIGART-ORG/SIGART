<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Google Calendar</li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Categorías
                    <button type="button" @click="abrirModal('registrar')" class="btn btn-success">
                        <i class="icon-plus"></i>&nbsp;Nuevo evento
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" @keyup="listar(1, buscar)">
                                <button type="submit" @click="listar(1, buscar)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <full-calendar :config="config" :events="events"></full-calendar>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
    </main>
</template>
<script>
    import { FullCalendar } from 'vue-full-calendar';
    import "fullcalendar/dist/fullcalendar.min.css";
    import moment from 'moment';
    export default {
        name: 'calendard-adm',
        data(){
            return{
                events: [
                    {
                        title: 'test',
                        allDay: true,
                        start: moment(),
                        end: moment().add(1, 'd'),
                    },
                    {
                        title: 'another test',
                        start: moment().add(2,'d'),
                        end: moment().add(2, 'd').add(2, 'h'),
                    },
                ],
                config: {
                    defaultView: 'month',
                    eventRender: function(event, element) {
                        console.log(event)
                    }
                },
                url: '/calendario/list',
                id: 0,
                buscar: ''
            }
        },
        components:{
            FullCalendar
        },
        computed:{

        },
        methods:{
            update_side_bar(idSideBar, datos = {}){
                this.$emit('update_side_bar', idSideBar, datos);
            },
            listar(page,buscar,criterio){
                var me = this;
                var url= me.url + '?page=' + page + '&buscar='+ buscar;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arreglo = respuesta.records.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.listar(1,this.buscar,this.criterio);
        }
    }
</script>