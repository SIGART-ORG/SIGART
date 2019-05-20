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
<!--                            <div class="form-group col-md-3 align-self-end">-->
<!--                                <button class="btn btn-success" type="button" @click="openModal('register')">-->
<!--                                    <i class="fa fa-fw fa-lg fa-plus"></i>Nueva cotización-->
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
                    <h3 class="tile-title">Cotizaciones</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Proveedor</th>
                                <th>Solicitud de compra</th>
                                <th>Fecha de reg.</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="loading">
                                <td colspan="5">
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="loader"></div>
                                    </div>
                                    <div class="d-flex justify-content-center mb-3">Cargando ...</div>
                                </td>
                            </tr>
                            <tr v-else-if="arrData.length == 0">
                                <td colspan="5" class="text-center">
                                    <span>No se encontraron registros.</span>
                                </td>
                            </tr>
                            <tr v-else v-for="dato in arrData" :key="dato.id">
                                <td>
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button @click="toggleShow(dato.id)" class="btn btn-success dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Acciones
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" :class="showMenu == dato.id ? 'show' : ''">
                                                <a class="dropdown-item" @click="registerQuotation( dato )">
                                                    <i class="fa fa-edit"></i> Ingresar cotizción
                                                </a>
                                                <a class="dropdown-item" @click="">
                                                    <i class="fa fa-paperclip"></i>&nbsp;Adjuntar cotización
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" @click="">
                                                    <i class="fa fa-trash"></i>&nbsp;Cancelar Solicitud
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ dato.name }}
                                    <br v-show="dato.business_name != ''"/>
                                    <small v-show="dato.business_name != ''"><b>{{ dato.business_name }}</b></small>
                                </td>
                                <td v-text="dato.code"></td>
                                <td v-text="dato.date"></td>
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
        <b-modal id="modalPreventRegister" size="lg" ref="details" :title="modalTitle" @ok="processForm" @hidden="closeModal">
            <form id="detailsForm" data-vv-scope="detailsForm">
                <div class="row">
                    <div class="col-12">
                        <div class="tile">
                            <h3 class="tile-title">Solicitud de compra - {{ detailsForm.code }}</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Código:</th>
                                        <th>{{ detailsForm.code }}</th>
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
    </div>
</template>

<script>
    export default {
        name: "Quotation",
        data(){
            return{
                url         : '/quotations/',
                loading     : true,
                arrData     : [],
                action      : 'register',
                modalTitle  : '',
                pagination  : {
                    'total'         : 0,
                    'current_page'  : 0,
                    'per_page'      : 0,
                    'last_page'     : 0,
                    'from'          : 0,
                    'to'            : 0,
                },
                offset      : 3,
                search      : '',
                showMenu    : 0,
                detailsForm : []
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
                me.loading = true;
                var url = me.url + '?page=' + page + '&search=' + search;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrData = respuesta.records.data;
                    setTimeout( function(){
                        me.loading = false;
                        me.pagination= respuesta.pagination;
                    }, 3000);
                }).catch(function (error) {
                    setTimeout( function(){
                        me.loading = false;
                    }, 3000);
                    console.log(error);
                });
            },
            processForm(){

            },
            registerQuotation( data ){
                let me = this;
                me.toggleHidden();
                me.modalTitle   = 'Cotización - ' + data.code;
                var url         = me.url + 'data/' + data.id;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;

                }).catch( function (error) {

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