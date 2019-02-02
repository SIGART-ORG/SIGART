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
                events: [],
                config: {
                    defaultView: 'month',
                    eventRender: function(event, element) {
                        //console.log(event)
                    }
                },
                url: '/calendar',
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
            listar(page,buscar){
                var me = this;
                var url= me.url + '?page=' + page + '&buscar='+ buscar;
                axios.get(url).then(function (response) {
                    var eventos = response.data.events;
                    eventos.forEach(function(element) {
                        var beforeEvents = {
                            title: element.summary,
                            allDay: false,
                            start: moment(element.start.date),
                            end: moment(element.end.date)
                        };
                        me.events.push(beforeEvents);
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.listar(1,this.buscar);
        }
    }
</script>