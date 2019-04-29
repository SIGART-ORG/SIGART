<template xmlns="http://www.w3.org/1999/html">
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
                                <button class="btn btn-success" type="button" @click="generateRequest">
                                    <i class="fa fa-fw fa-lg fa-plus"></i>Generar requerimiento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="tile">
                    <h3 class="tile-title">Stock</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Stock</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="dato in arreglo" :key="dato.id">
                                <td>{{ dato.name }} <br> <small>{{ dato.category }}</small></td>
                                <td></td>
                                <td>
                                    <input type="checkbox" value="1" @change="selectProduct(dato, $event)">
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
            <div class="col-md-5">
                <div class="tile">
                    <h3 class="tile-title">Solicitud de requerimiento</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Unidad</th>
                                <th>Cantidad</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="request.length > 0" v-for="(req, idxReq) in request" :key="req.id">
                                <td>{{ req.name }} <br> <small>{{ req.category }}</small></td>
                                <td>
                                    <select class="form-control">
                                        <option>Unidad</option>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="number" min="1" v-model="req.value">
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-danger btn-sm" @click="deleteRequest( idxReq )">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else>
                                <td colspan="4">No se seleccionaron productos.</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
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
                urlController: '/stock/',
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
            selectProduct( data, event ) {
                var resultado = this.request.find( row => row.id === data.id);
                if( event.target.checked ){
                    if( typeof ( resultado ) === 'undefined') {
                        this.request.push({
                            'id': data.id,
                            'name': data.name,
                            'category': data.category,
                            'unity': 0,
                            'value': 0
                        });
                    }
                }else{
                    this.deleteChecked( data.id );
                }
            },
            deleteChecked( idRow ){
                let me = this;
                const clone = me.request;
                const filter = ( data = [], id) => {

                    if( clone.length === 1 ){
                        return [];
                    }

                    return clone.filter( c => c.id !== id );
                };
                me.request = filter( clone, idRow );
            },
            searchElementRequest( row, value ){
                return row.id === value;
            },
            deleteRequest( index ){
                this.request.splice( index, 1 );
            },
            generateRequest(){
                if( this.request.length > 0){

                }else{
                    swal(
                        'Error! :(',
                        'Debe seleccionar al menos un producto, para poder generar un requerimiento',
                        'error'
                    )
                }
            }
        },
        mounted() {
            this.list(1, this.search);
        }
    }
</script>

<style scoped>

</style>