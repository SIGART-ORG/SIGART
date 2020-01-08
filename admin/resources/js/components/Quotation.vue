<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Cotizaciones</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="searchForm"></label>
                                <input type="text" v-model="search" @keyup="list( 1, search )" class="form-control mb-2" id="searchForm" placeholder="Buscar">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="list( 1, search )" >
                                    <i class="fa fa-fw fa-lg fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="hk-sec-wrapper" >
            <h6 class="hk-sec-title">Listado</h6>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
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
                                <tr v-if="arrData.length == 0">
                                    <td colspan="5" class="text-center">
                                        <span>No se encontraron registros.</span>
                                    </td>
                                </tr>
                                <tr v-else v-for="dato in arrData" :key="dato.id">
                                    <td>
                                        <button v-if="dato.status == 4" type="button" class="btn btn-outline-info btn-sm" title="Generar Orden de Compra" @click.prevent="generatePO( dato )">
                                            <i class="fa fa-fw fa-lg fa-check"></i> Generar OC
                                        </button>
                                        <button v-if="dato.status == 4" type="button" class="btn btn-outline-danger btn-sm" title="Cancelar cotización" @click.prevent="cancelQuotation( dato )">
                                            <i class="fa fa-fw fa-lg fa-close"></i> Cancelar
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" title="Ver detalle" @click.prevent="openModal( 'details', dato )">
                                            <i class="fa fa-fw fa-lg fa-search"></i> Ver detalle
                                        </button>
                                    </td>
                                    <td>
                                        {{ dato.name }}
                                        <br v-show="dato.business_name != ''"/>
                                        <small v-show="dato.business_name != ''"><b>{{ dato.business_name }}</b></small>
                                    </td>
                                    <td v-text="dato.code"></td>
                                    <td v-text="dato.date"></td>
                                    <td>
                                        <span v-if="dato.status == 4" class="badge badge-info">Pendiente</span>
                                        <span v-else-if="dato.status == 5" class="badge badge-success">Orden de compra generado</span>
                                        <span v-else class="badge badge-danger">Cancelado</span>
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
        </section>
        <b-modal ref="detail" size="lg" :title="modalTitle" @ok="closeModal" @hidden="closeModal">
            <quotationDetail v-if="action === 'details' && id > 0" :quotation="id"></quotationDetail>
        </b-modal>
    </div>
</template>

<script>
    import quotationDetail from '../components/quotation/detail';
    export default {
        name: "Quotation",
        data(){
            return{
                url         : '/quotations/',
                loading     : true,
                arrData     : [],
                id          : 0,
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
            }
        },
        components: {
            quotationDetail
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
                    }, 1500);
                    console.log(error);
                });
            },
            openModal( action, data = [] ){
                this.action = action;
                switch( action ) {
                    case 'details':
                        this.modalTitle = 'Detalle de cotización - ' + data.name;
                        this.id = data.id;
                        this.$refs.detail.show();
                        break;
                }
            },
            closeModal(){
                let action = this.action;
                this.action = '';
                switch( action ) {
                    case 'details':
                        this.modalTitle = '';
                        this.id = 0;
                        this.$nextTick(() => {
                            this.$refs.detail.hide();
                        });
                        break;
                }
            },
            processForm( evt ){
                evt.preventDefault();
            },
            generatePO( data ) {
                swal({
                    title: "Generar Orden de Compra",
                    text: "Esta seguro de generar la orden de compra para la cotización del proveedor " + data.name + "?",
                    icon: "warning",
                    button: "Generar",
                }).then( ( result ) => {
                    if( result ) {
                        let me = this,
                            url = '/purchase-order/generate/';
                        axios.post( url, {
                            'id': data.id
                        }).then( function( result ) {
                            let response = result.data;
                            if( response.status ) {
                                me.list( 1, '' );
                                swal(
                                    'Generado!',
                                    'Se genero correctamente la orden de compra.',
                                    'success'
                                )
                            } else {
                                swal(
                                    'Error! :(',
                                    'No se pudo realizar la operación',
                                    'error'
                                );
                            }
                        }).catch( function( errors ) {
                            console.log( errors );
                        });
                    }
                })
            },
            cancelQuotation( data ) {
                swal({
                    title: "Cancelar Corización",
                    text: "Esta seguro de cancelar la cotización del proveedor " + data.name + "?",
                    icon: "error",
                    button: "Cancelar",
                }).then( ( result ) => {
                    if( result ) {
                        let me = this,
                            url = '/quotation/cancel/';

                        axios.put( url, {
                            'id': data.id
                        }).then( function ( result ) {
                            let response = result.data;
                            if( response.status ) {
                                me.list( 1, '' );
                                swal(
                                    'Cancelado!',
                                    'Se canceló correctamente la cotización.',
                                    'success'
                                );
                            } else {
                                swal(
                                    'Error! :(',
                                    'No se pudo realizar la operación',
                                    'error'
                                );
                            }
                        }).catch( function ( errors ) {
                            console.log( errors );
                        });
                    }
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
