<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Solicitudes de compra</h3>
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
<!--                            <div class="form-group col-md-3 align-self-end">-->
<!--                                <button class="btn btn-success" type="button" @click="openModel('registrar')">-->
<!--                                    <i class="fa fa-fw fa-lg fa-plus"></i>Nuevo -->
<!--                                </button>-->
<!--                            </div>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
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
                                                <a class="dropdown-item" @click="viewDetail( dato )">
                                                    <i class="fa fa-eye"></i>&nbsp;Ver detalles
                                                </a>
                                                <a class="dropdown-item" @click="quote( dato )">
                                                    <i class="fa fa-check-square-o"></i>&nbsp;Cotizar
                                                </a>
<!--                                                <a class="dropdown-item" @click="">-->
<!--                                                    <i class="fa fa-file-pdf-o"></i>&nbsp;PDF-->
<!--                                                </a>-->
<!--                                                <div class="dropdown-divider"></div>-->
<!--                                                <a class="dropdown-item" @click="openModel('actualizar', dato)" >-->
<!--                                                    <i class="fa fa-edit"></i>&nbsp;Editar-->
<!--                                                </a>-->
<!--                                                <a class="dropdown-item" @click="eliminar(dato.id)" >-->
<!--                                                    <i class="fa fa-trash"></i>&nbsp;Eliminar-->
<!--                                                </a>-->
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
        <b-modal id="modalPreventDetails" size="lg" ref="details" :title="modalTitle" @ok="processForm" @hidden="closeModal">
            <form id="detailsForm" data-vv-scope="detailsForm">
                <div class="row">
                    <div class="col-12">
                        <div class="tile">
                            <h3 class="tile-title">Solicitud de compra - {{ dataPR.code }}</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Código:</th>
                                        <th>{{ dataPR.code }}</th>
                                        <th>Fecha de registro:</th>
                                        <th>{{ dataPR.date }}</th>
                                        <th>Usuario:</th>
                                        <th>{{ dataPR.userName }}<br><small>{{ dataPR.userLastName }}</small></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th class="text-center">Item</th>
                                        <th class="text-center">Categoría</th>
                                        <th class="text-center" colspan="2">Producto</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Unidad</th>
                                    </tr>
                                    <tr v-for="(rowPR, idxPR) in dataPR.details" :key="rowPR.id">
                                        <td class="text-center">{{ idxPR + 1 }}</td>
                                        <td class="text-center">{{ rowPR.category }}</td>
                                        <td class="text-center" colspan="2">{{ rowPR.products }} {{ rowPR.description }}</td>
                                        <td class="text-right">{{ rowPR.quantity }}</td>
                                        <td class="text-center">{{ rowPR.unity }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </b-modal>
        <b-modal id="modalPreventQuote" size="sm" ref="quote" :title="modalTitle" @ok="processForm" >
            <form id="quoteForm" data-vv-scope="quoteForm">
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Proveedor <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <select class="form-control" name="proveedor" v-model="dataQuote.idProvider"
                                v-validate="{ required: true }"
                                :class="{'is-invalid': errors.has('quoteForm.proveedor')}"
                        >
                            <option value="" disabled selected hidden >Proveedor</option>
                            <option v-for="pro in arrProvider" v-bind:value="pro.id" v-text="pro.name"></option>
                        </select>
                        <span v-show="errors.has('quoteForm.proveedor')" class="text-danger">{{ errors.first('quoteForm.proveedor') }}</span>
                    </div>
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
    export default {
        name: "purchase-request",
        data () {
            return {
                url: '/purchase-request/',
                search: '',
                id: 0,
                dataPR: {
                    'id': 0,
                    'code': '',
                    'date': '',
                    'details': [],
                    'userName': '',
                    'userLastName': ''
                },
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
                dataQuote: {
                    'idPR': 0,
                    'idProvider': ''
                },
                arrProvider: []
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
            viewDetail( data ){
                this.toggleHidden();
                this.dataPR = {
                    'id': data.id,
                    'code': data.code,
                    'date': data.date,
                    'details': [],
                    'userName': data.name,
                    'userLastName': data.last_name
                };
                this.loadDataDetails();
                this.modalTitle = 'Solicitud de compra - ' + data.code;
                this.action = 'details';
                this.$refs.details.show();
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
                switch( this.action ){
                    case 'details':
                        this.$refs.details.hide();
                        break;
                    case 'quote':
                        this.$refs.quote.hide();
                        break;
                    default:
                        //this.$refs.modal.hide();
                }
                this.$nextTick(() => {
                });
                this.modalTitle = '';
                this.action = '';
                this.dataPR = {
                    'id': 0,
                    'code': '',
                    'date': '',
                    'details': [],
                    'userName': '',
                    'userLastName': ''
                };
                this.dataQuote = {
                    'idPR': 0,
                    'idProvider': ''
                };
            },
            processForm(evt){
                evt.preventDefault();
                switch ( this.action ) {
                    case 'details':
                        this.closeModal();
                        break;
                    case 'quote':
                        this.quoteProccess();
                        break;
                }
            },
            loadDataDetails(){
                let me = this;
                if( me.dataPR.id > 0 ){
                    var url = me.url + 'get-details/' + me.dataPR.id;
                    axios.get(url).then(function (response) {
                        var respuesta= response.data;
                        me.dataPR.details = respuesta.response;
                    }).catch(function (error) {
                        swal(
                            'Error! :(',
                            'Ocurrio un error al intentar traer los datos.',
                            'error'
                        )
                    });
                }else{
                    swal(
                        'Error! :(',
                        'No se pudo realizar la operación',
                        'error'
                    )
                }
            },
            quote( data ){
                this.modalTitle = 'Generar Cotización - ' + data.code;
                this.action = 'quote';
                this.loadProvider();
                this.dataQuote = {
                    'idPR': data.id,
                    'idProvider': ''
                };
                this.$refs.quote.show();
            },
            loadProvider(){
                if( this.arrProvider.length === 0 ) {
                    let me = this;
                    var url = '/get-providers/';
                    axios.get(url).then(function (response) {
                        var respuesta = response.data;
                        me.arrProvider = respuesta.response;
                    }).catch(function (error) {
                        swal(
                            'Error! :(',
                            'Ocurrio un error al intentar traer los datos.',
                            'error'
                        )
                    });
                }
            },
            quoteProccess(){
                this.$validator.validateAll('quoteForm').then((result) => {
                    if (result) {
                        let me = this;
                        axios.post('/quotation',{
                            'quotation': me.dataQuote
                        }).then(function (response) {
                            me.closeModal();
                            me.list( 1, '' );
                        }).catch(function (error) {
                            console.log(error);
                        });
                    }
                });
            }
        },
        mounted() {
            this.list( 1, this.search );
        }
    }
</script>

<style scoped>

</style>