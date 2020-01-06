<template>
    <div>
        <div class="row">
            <div class="col-xl-12">
<!--                <div class="alert alert-primary alert-wth-icon alert-dismissible fade show" role="alert">-->
<!--                    <span class="alert-icon-wrap"><i class="zmdi zmdi-help"></i></span> You're profile is waiting to be activated. Once done, you can request meetings with them.-->
<!--                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">-->
<!--                        <span aria-hidden="true">×</span>-->
<!--                    </button>-->
<!--                </div>-->
                <div class="hk-row">
                    <div class="col-md-4">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="d-block font-12 font-weight-500 text-dark text-uppercase mb-5">Usuarios</span>
                                        <span class="d-block display-6 font-weight-400 text-info">
                                            <a href="#" class="text-info" @click="redirect( 'users' )">
                                                <i class="icon fa fa-user-secret"></i>&nbsp;{{ summary.users }}
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="d-block font-12 font-weight-500 text-dark text-uppercase mb-5">Clientes</span>
                                        <span class="d-block display-6 font-weight-400 text-purple">
                                            <a href="#" class="text-purple" @click="redirect( 'customers' )">
                                                <i class="icon fa fa-users"></i>&nbsp;{{ summary.customers }}
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="d-block font-12 font-weight-500 text-dark text-uppercase mb-5">Servicios</span>
                                        <span class="d-block display-6 font-weight-400 text-primary">
                                            <a href="#" class="text-primary" @click="redirect( 'services' )">
                                                <i class="icon fa fa-paste"></i>&nbsp;{{ summary.services }}
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-40 mb-20">
                    <h4>Proyectos - Estado</h4>
                    <button class="btn btn-sm btn-link" @click="redirect( 'services' )">Ver todos</button>
                </div>
                <div class="card">
                    <div class="card-body pa-0">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Servicio</th>
                                        <th>Aprobación</th>
                                        <th>Cliente</th>
                                        <th>Estado</th>
                                        <th>Tareas</th>
                                        <th>Progreso</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-if="services.length > 0" v-for="(service, ser) in services" :key="service.id">
                                        <td>{{ ser + 1 }}</td>
                                        <td>
                                            <a href="#" class="text-primary" @click="redirect( 'services', service.id )">
                                                {{ service.document }}
                                            </a>
                                        </td>
                                        <td>
                                            <mark>Aprobación: {{ service.aproved }}</mark>
                                            <br/>
                                            <mark>Aprobación cliente: {{ service.aprovedCustomer }}</mark>
                                        </td>
                                        <td>
                                            {{ service.customer.name }}
                                            <br/>
                                            <span class="badge badge-info">{{ service.customer.document }}</span>
                                        </td>
                                        <td>
                                            <estado section="service" :status="service.status"></estado>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ service.task.finalizado }} / {{ service.task.all }}</span>
                                        </td>
                                        <td>
                                            <div class="progress-wrap lb-side-left mnw-125p">
                                                <div class="progress-lb-wrap">
                                                    <label class="progress-label mnw-25p">{{ service.task.porc }}%</label>
                                                    <div class="progress progress-bar-xs">
                                                        <div class="progress-bar" :class="[service.task.class, 'w-' + service.task.porc]" role="progressbar" :aria-valuenow="service.task.porc" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Estado from '../../vuex/components/general/status';
    export default {
        name: "dashboard-admin",
        data() {
            return {
                summary: [],
                services: []
            }
        },
        components: {
            Estado
        },
        created() {
            this.getInformation();
        },
        methods: {
            getInformation() {
                let me = this;
                let url = '/information/data/';
                axios.get( url ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        me.summary = result.summary;
                        me.services = result.services;
                    }
                }).catch( errors => {
                    console.log( errors );
                })
            },
            redirect( route, id = 0 ) {
                let access = false;
                let location = '';

                switch( route ) {
                    case 'users':
                        location = '/user/dashboard/';
                        access = true;
                        break;
                    case 'customers':
                        location = '/customers/dashboard/';
                        access = true;
                        break;
                    case 'services':
                        location = '/service/dashboard/';
                        if( id > 0 ) {
                            location = '/service/' + id + '/request';
                        }
                        access = true;
                        break;
                }

                if( access ) {
                    window.location.href = URL_PROJECT + location;
                }
            }
        }
    }
</script>

<style scoped>

</style>
