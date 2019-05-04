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
                            <div v-show="request.length > 0" class="form-group col-md-3 align-self-end">
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
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">Stock</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Stock</th>
                                <th>Seleccionar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="dato in arreglo" :key="dato.presentation_id">
                                <td><b>{{ dato.name }}</b><br>{{ dato.presentation }}<br> <small>{{ dato.category }}</small></td>
                                <td>{{ dato.stock }} {{ dato.unity }}</td>
                                <td>
                                    <input :title="'Seleccionar ' + dato.name + ' ' + dato.presentation"
                                           type="checkbox"
                                           v-model="selected"
                                           :value="dato.presentation_id"
                                           @change="selectProduct(dato, $event)">
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
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">Solicitud de requerimiento</h3>
                    <form>
                        <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(req, idxReq) in request" :key="req.id">
                                <td><b>{{ req.name }}</b><br>{{ req.presentation }}<br> <small>{{ req.category }}</small></td>
                                <td>
                                    <input class="form-control" name="cantidad" type="number"
                                           v-validate="{ required: true, numeric: true, regex: /^[0-9]+$/, min_value: 1}"
                                           :class="{'is-invalid': errors.has('cantidad')}"
                                           v-model="req.value"
                                    > {{ req.unityName }}
                                    <br v-show="errors.has('cantidad')">
                                    <span v-show="errors.has('cantidad')" class="text-danger">{{ errors.first('cantidad') }}</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-danger btn-sm" @click="deleteRequest( idxReq )">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-show="request.length == 0">
                                <td colspan="3">No se seleccionaron productos.</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    </form>
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
                selected: [],
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
                var resultado = this.request.find( row => row.id === data.presentation_id );
                if( event.target.checked ){
                    if( typeof ( resultado ) === 'undefined') {
                        this.request.push({
                            'id': data.presentation_id,
                            'name': data.name,
                            'presentation': data.presentation,
                            'category': data.category,
                            'unity': data.unity_id,
                            'unityName': data.unity,
                            'value': 0
                        });
                    }
                }else{
                    this.deleteChecked( data.presentation_id );
                }
            },
            deleteChecked( idRow ){
                let me = this;
                const clone = me.request;
                const filter = ( data = [], id) => {
                    return clone.filter( c => c.id !== id );
                };
                me.request = filter( clone, idRow );
            },
            searchElementRequest( row, value ){
                return row.id === value;
            },
            deleteRequest( index ){
                var pres = this.request[index].id;
                var idxPress = this.selected.indexOf( pres );
                this.selected.splice( idxPress, 1 );
                this.request.splice( index, 1 );
            },
            generateRequest(){
                if( this.request.length > 0){
                    this.$validator.validateAll().then((result) => {
                        if (result) {
                            let me = this;
                            axios.post('/purchase-request/',{
                                'purchaseRequest': this.request
                            }).then(function (response) {
                                me.request = [];
                                me.selected = [];
                                swal(
                                    'Exito! :)',
                                    'Se registro correctamente la solicitud de compra.',
                                    'success'
                                )
                            }).catch(function (error) {
                                swal(
                                    'Error! :(',
                                    'Ocurrio un error al intentar realizar la operación.',
                                    'error'
                                )
                            });
                        }
                    });
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