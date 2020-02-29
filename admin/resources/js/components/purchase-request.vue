<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Solicitud de Compras</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input type="text" v-model="search" @keyup="list(1, search)" class="form-control mb-2" id="inlineFormInput" placeholder="Buscar...">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="list(1, search)">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!--<div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Solicitudes de compras</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Código</th>
                                <th>Fecha de solicitud</th>
                                <th># Items</th>
                                <th>Usuario</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="dato in arrData" :key="dato.id">
                                <td>
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button @click="toggleShow(dato.id)" class="btn btn-success dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Acciones
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" :class="showMenu == dato.id ? 'show' : ''">
                                                <a :href="urlProject + url + dato.id + '/details'" class="dropdown-item">
                                                    <i class="fa fa-eye"></i>&nbsp;Ver detalles
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td v-text="dato.code"></td>
                                <td v-text="dato.date"></td>
                                <td v-text="dato.items"></td>
                                <td>
                                    {{ dato.name }}<br><small>{{ dato.last_name }}</small>
                                </td>
                                <td>
                                    <div v-if="dato.status == 1">
                                        <span class="badge badge-warning">Pendiente</span>
                                    </div>
                                    <div v-else-if="dato.status == 3">
                                        <span class="badge badge-success">Cotizada</span>
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
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1, search)">Ant.</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, search)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1, search)">Sig.</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>-->

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
                                    <th>Código</th>
                                    <th>Fecha de solicitud</th>
                                    <th># Items</th>
                                    <th>Usuario</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="dato in arrData" :key="dato.id">
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button @click="toggleShow(dato.id)" class="btn btn-success dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Acciones
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" :class="showMenu == dato.id ? 'show' : ''">
                                                    <a :href="urlProject + url + dato.id + '/details'" class="dropdown-item">
                                                        <i class="fa fa-eye"></i>&nbsp;Ver detalles
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td v-text="dato.code"></td>
                                    <td v-text="dato.date"></td>
                                    <td v-text="dato.items"></td>
                                    <td>
                                        {{ dato.name }}<br><small>{{ dato.last_name }}</small>
                                    </td>
                                    <td>
                                        <div v-if="dato.status == 1">
                                            <span class="badge badge-warning">Pendiente</span>
                                        </div>
                                        <div v-else-if="dato.status == 3">
                                            <span class="badge badge-success">Cotizada</span>
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
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page-1, search)">Ant.</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="changePage(page, search)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page+1, search)">Sig.</a>
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
        name: "purchase-request",
        data () {
            return {
                urlProject: URL_PROJECT,
                url: '/purchase-request/',
                search: '',
                id: 0,
                arrData: [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                showMenu: 0,
                action: 'registrar',
                modalTitle: '',
                show: false
            }
        },
        computed: {
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
            cambiarPagina( page, search ){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.list( page, search );
            },
            toggleShow( id ){
                if( this.showMenu === 0){
                    this.showMenu = id;
                }else{
                    if( id === this.showMenu ){
                        this.showMenu = 0;
                    }else{
                        this.showMenu = id;
                    }
                }
            },
            toggleHidden(){
                this.showMenu = 0;
            },
            list( page, search ) {
                let me = this;
                var url = me.url + '?page=' + page + '&search=' + search;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrData = respuesta.records.data;
                    me.pagination= respuesta.pagination;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            closeModal(){
                this.modalTitle = '';
                this.action = '';
            },
            processForm(evt){
                evt.preventDefault();
            },

        },
        mounted() {
            this.list( 1, this.search );
        }
    }
</script>

<style scoped>

</style>
