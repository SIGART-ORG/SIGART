<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Cotizaciones</h3>
                    <div class="tile-body">
                        <form class="row">
                            <div class="form-group col-md-6">
                                <input class="form-control" v-model="search" type="text" placeholder="Buscar" @keyup="list(1, search)">
                            </div>
                            <div class="form-group col-md-3 align-self-end">
                                <button class="btn btn-primary" type="button" @click="list(1, search)">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                            <div class="form-group col-md-3 align-self-end">
                                <button class="btn btn-success" type="button" @click="openModal('registrar')">
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
                    <h3 class="tile-title">Cotizaciones</h3>
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
                            <tr v-if="loading">
                                <td colspan="4">
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="loader"></div>
                                    </div>
                                    <div class="d-flex justify-content-center mb-3">Cargando ...</div>
                                </td>
                            </tr>
                            <tr v-else-if="arrData.length == 0">
                                <td colspan="4" class="text-center">
                                    <span>No se encontraron registros.</span>
                                </td>
                            </tr>
                            <tr v-else v-for="dato in arrData" :key="dato.id">
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
    </div>
</template>

<script>
    export default {
        name: "Quotation",
        data(){
            return{
                url: '/quotations/',
                loading: true,
                arrData: [],
                action: 'registrar',
                modalTitle: '',
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                search : ''
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
        methods: {
            list( page, search ) {
                let me = this;
                me.loading = true;
                var url = me.url + '?page=' + page + '&search=' + search;
                axios.get(url).then(function (response) {
                    setTimeout( function(){
                        var respuesta= response.data;
                        me.loading = false;
                        me.arrData = respuesta.records.data;
                        me.pagination= respuesta.pagination;
                    }, 3000);
                }).catch(function (error) {
                    setTimeout( function(){
                        me.loading = false;
                    }, 3000);
                    console.log(error);
                });
            },
        },
        mounted() {
            this.list( 1, this.search );
        }
    }
</script>

<style scoped>

</style>