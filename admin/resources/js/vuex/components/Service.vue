<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Servicios</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="searchForm"></label>
                                <input type="text" id="searchForm" class="form-control mb-2" placeholder="Buscar"
                                       v-model="search" @keyup="list( 1, search )">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="list( 1, search )">
                                    <i class="fa fa-fw fa-lg fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="hk-sec-wrapper">
            <h6>Listado</h6>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Servicio</th>
                                    <th>Solicitud de Servicio</th>
                                    <th>Cliente</th>
                                    <th>Fecha de Registro</th>
                                    <th>Doc. Adjuntos</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="service in services" :key="service.id">
                                    <td>
                                        <strong v-if="service.serialDoc &&  service.numberDoc">
                                            {{ service.serialDoc }}-{{ service.numberDoc }}
                                        </strong>
                                        <span v-else>---</span>
                                        <br>
                                        <statussig section="service" :status="service.status"></statussig>
                                    </td>
                                    <td>
                                        {{ service.serviceRequest.name }}
                                        <br>
                                        <small>{{ service.serviceRequest.dateEmission }}</small>
                                        <br>
                                        <span class="badge badge-primary">{{ service.serviceRequest.numRequest }}</span>
                                    </td>
                                    <td>
                                        {{ service.customer.name }}
                                        <br>
                                        <span class="badge badge-primary">{{ service.customer.document }}</span>
                                    </td>
                                    <td>{{ service.date }}</td>
                                    <td>
                                        <a v-if="service.serviceRequest.attachment" class="btn btn-outline-danger btn-xs"
                                           :href="service.serviceRequest.attachment"
                                           target="_blank">
                                            <i class="fa fa-files"></i> Ver docs.
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-info btn-xs" type="button" @click="requirement( service.id )">
                                            <i class="fa fa-cogs"></i> Requerimientos
                                        </button>
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
                                <a class="page-link" href="#"
                                   @click.prevent="changePage(pagination.current_page-1, search)">Ant.</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page"
                                :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="changePage(page, search)"
                                   v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#"
                                   @click.prevent="changePage(pagination.current_page+1, search)">Sig.</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import { mapMutations } from 'vuex';
    import statussig from './general/status';
    export default {
        name: "Service",
        data() {
            return {
                search: ''
            }
        },
        components: {
            statussig
        },
        computed: {
            services() {
                return this.$store.state.Service.services;
            },
            pagination() {
                return this.$store.state.Service.pagination;
            },
            offset() {
                return this.$store.state.Service.offset;
            },
            isActived: function () {
                return this.pagination.current_page;
            },
            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;

            }
        },
        methods: {
            ...mapMutations(['LOAD_SERVICE']),
            requirement( id ) {
                let url = URL_PROJECT + '/service/' + id + '/request/';
                window.location = url;
            }
        },
        mounted() {
            this.$store.dispatch( 'loadServices');
        }
    }
</script>

<style scoped>

</style>
