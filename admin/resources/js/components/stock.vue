<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Productos</h3>
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
                                <button class="btn btn-success" type="button" @click="">
                                    <i class="fa fa-fw fa-lg fa-plus"></i>Generar requerimiento
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
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Stock</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="dato in arreglo" :key="dato.id">
                                <td v-text="dato.name"></td>
                                <td v-text="dato.category"></td>
                                <td></td>
                                <td>
                                    <input type="checkbox" value="1" @change="selectProduct(dato)">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
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
        </div>
    </div>
</template>

<script>

    export default {
        name: "Products",
        data() {
            return {
                urlProject: URL_PROJECT,
                urlController: '/products/',
                arreglo: [],
                search: '',
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                request: [],
                offset : 3,
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
        components:{

        },
        methods:{
            changePage( page, search ){
                let me = this;
                me.pagination.current_page = page;
                me.list( page, search );
            },
            redirectDasboard(page){
                var redirect = URL_PROJECT + '/' + page + '/dashboard/';
                window.open( redirect, '_blank' );
            },
            list(page,search){
                var me = this;
                var url= me.urlController + '?page=' + page + '&search='+ search;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arreglo = respuesta.records.data;
                    me.pagination= respuesta.pagination;
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            selectProduct() {

            }
        },
        mounted() {
            this.list(1, this.search);
        }
    }
</script>

<style scoped>

</style>