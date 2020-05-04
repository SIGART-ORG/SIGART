<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Ordenes de entradas</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="searchForm"></label>
                                <input type="text" id="searchForm" class="form-control mb-2" placeholder="Buscar" v-model="search" @keyup="list( 1, search )">
                            </div>
                            <div class="col-auto" >
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
            <h6 class="hk-sec-title">Listado</h6>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Opciones</th>
                                    <th>Código</th>
                                    <th>Fecha registro</th>
                                    <th>Fecha ingreso</th>
                                    <th>Comprobante</th>
                                    <th>Proveedor</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="( row, idx ) in arrData" :key="row.id">
                                    <td v-text="idx + 1"></td>
                                    <td>
                                        <button v-if="row.status === 1" type="button" class="btn btn-outline-info btn-sm"
                                                title="Ingresar Orden de entrada"
                                                @click.prevent="openDetailModal( row.id )">
                                            <i class="fa fa-fw fa-lg fa-check"></i> Ingresar compra
                                        </button>
                                        <button v-if="row.status === 3" type="button" class="btn btn-outline-success btn-sm"
                                                title="Ver Orden de entrada"
                                                @click.prevent="openDetailModal( row.id )">
                                            <i class="fa fa-fw fa-lg fa-eye"></i> Ver detalle
                                        </button>
                                    </td>
                                    <td>{{ row.code }}</td>
                                    <td>{{ row.date_input_reg | formatDate }}</td>
                                    <td v-if="row.status === 3">{{ row.date_input | formatDate }}</td>
                                    <td v-else>---</td>
                                    <td>{{ row.typeVouchersName }}: <b>{{ row.serial_doc }}-{{ row.number_doc }}</b></td>
                                    <td>
                                        {{ row.providerName }}
                                        <span class="badge badge-secondary">{{ row.typeDocuments }}: {{ row.document }}</span>
                                    </td>
                                    <td>
                                        <span v-if="row.status === 0"class="badge badge-danger"><i class="fa fa-ban"></i>Desactivado</span>
                                        <span v-if="row.status === 1" class="badge badge-warning"><i class="fa fa-shopping-bag fa-fw"></i>Pendiente de ingreso</span>
                                        <span v-if="row.status === 2" class="badge badge-danger"><i class="fa fa-close fa-fw"></i>Anulado</span>
                                        <span v-if="row.status === 3" class="badge badge-success"><i class="fa fa-check fa-fw"></i>Registrado</span>
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
                            <li class="page-item disabled" v-if="pagination.current_page === 0">
                                <a class="page-link" href="#">1</a>
                            </li>
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
        <b-modal id="modalApproved" size="lg" ref="modalApproved" :title="modalTitle" @ok="saveInputOrder" @cancel="closeModal" @modal-ok="true">
            <form @submit.stop.prevent="closeModal">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th>Orden de entrada</th>
                                        <th>Comprobante relacionado</th>
                                        <th>Registró</th>
                                        <th>Fecha ingreso</th>
                                        <th>Aprobó</th>
                                        <th>Fecha aprobación</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td v-if="detailData.status">{{ detailData.headers.voucher }}</td>
                                        <td v-if="detailData.status">
                                            {{ detailData.headers.purchaseTypeVoucher }}-{{ detailData.headers.purchaseVoucher }}
                                        </td>
                                        <td v-if="detailData.status">{{ detailData.headers.userReg }}</td>
                                        <td v-if="detailData.status">{{ detailData.headers.dateReg }}</td>
                                        <td v-if="detailData.status">{{ detailData.headers.userApproved }}</td>
                                        <td v-if="detailData.status">{{ detailData.headers.dateApproved }}</td>
                                    </tr>
                                    <tr>
                                        <td>Item</td>
                                        <td>SKU</td>
                                        <td colspan="2">Producto</td>
                                        <td>Cantidad</td>
                                        <td>Checklist</td>
                                    </tr>
                                    <tr  v-if="detailData.status" v-for="( item, idx ) in detailData.items" :key="item.id">
                                        <td>{{ idx +1 }}</td>
                                        <td>{{ item.sku }}</td>
                                        <td colspan="2">{{ item.category }} {{ item.product }} {{ item.description }}</td>
                                        <td>{{ item.quantity }} {{ item.unity }}</td>
                                        <td>
                                            <input type="checkbox" >
                                        </td>
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
        name: "list",
        data() {
            return {
                urlProject: URL_PROJECT,
                search:     '',
                arrData:    [],
                pagination: {
                    'total'         : 0,
                    'current_page'  : 0,
                    'per_page'      : 0,
                    'last_page'     : 0,
                    'from'          : 0,
                    'to'            : 0,
                },
                offset: 3,
                modalTitle: '',
                detailData: [],
                detailId: 0
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
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
            changePage( page, search ){
                let me = this;
                me.pagination.current_page = page;
                me.list( page, search );
            },
            list( page, search ) {
                let me = this,
                    url = '/input-orders/';

                axios.get( url, {
                    params: {
                        page: page,
                        search: search
                    }
                }).then( function( result ) {
                    let response    = result.data;
                    me.arrData      = response.records.data;
                    me.pagination   = response.pagination;
                }).catch( function( errors ) {
                    console.log( errors );
                })
            },
            openDetailModal( id ) {
                window.location = '/input-orders/' + id + '/approved/';
            },
            saveInputOrder() {
                let me = this,
                    url = '/input-orders/' + me.detailId + '/approved/';
                axios.post( url ).then( function ( result ) {
                    let response = result.data;
                    if( response.status ) {
                        me.closeModal();
                        me.list( 1, '' );
                    } else {
                        console.log( 'error' );
                    }
                });
            },
            getDetail( id ) {
                let me = this,
                    url = '/input-orders/details/';
                axios.get( url, {
                    params: {
                        id
                    }
                }).then( function( result ) {
                    let response    = result.data;
                    if( response.status ){
                        me.detailId = id;
                        me.detailData   = response;
                    }
                });
            },
            closeModal() {
                this.modalTitle = '';
                this.detailData = [];
                this.detailId = 0;
                this.$nextTick(() => {
                    this.$refs.modalApproved.hide();
                })
            }
        },
        mounted() {
            this.list( 1, '' );
        }
    }
</script>

<style scoped>

</style>
