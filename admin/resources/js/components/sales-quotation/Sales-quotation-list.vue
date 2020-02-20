<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title" v-text="nameModule"></h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="searchForm"></label>
                                <input type="text" id="searchForm" class="form-control mb-2" placeholder="Buscar"
                                       v-model="search" @keyup="list( 1 )">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="list( 1 )">
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
                                    <th>Cotización</th>
                                    <th>Solicitud de Servicio</th>
                                    <th>Cliente</th>
                                    <th>Sub-Total</th>
                                    <th>I.G.V.</th>
                                    <th>Total</th>
                                    <th v-if="type === 'cancel'">Estado</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in arrayList" :key="item.id">
                                    <td class="text-center">
                                        <strong class="text-info">{{ item.document }}</strong>
                                    </td>
                                    <td>
                                        {{ item.serviceRequest.document }}
                                        <br/>
                                        <small>{{ item.serviceRequest.send }}</small>
                                    </td>
                                    <td>
                                        {{ item.customer.name }}
                                        <br>
                                        <small><mark v-text="item.customer.document"></mark></small>
                                    </td>
                                    <td>{{ item.subtotal | formatPrice }}</td>
                                    <td>{{ item.igv | formatPrice }}</td>
                                    <td>{{ item.total | formatPrice }}</td>
                                    <td v-if="type === 'cancel'">
                                        <g-status section="sale-quotation" :status="item.status"></g-status>
                                        <br v-if="item.canceled.status"/>
                                        <small v-if="item.canceled.status" class="text-danger">{{ item.canceled.user }}</small>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-info btn-xs" :disabled="disabled" @click="showDetail( item )">
                                            <i class="fa fa-info"></i> Ver Cotización
                                        </button>
                                        <button class="btn btn-outline-primary btn-xs" :disabled="disabled" v-if="item.status !== 6 && ( item.status === 3 || item.status === 4 )" @click.prevent="actionButton( item, 'approval' )">
                                            <i class="fa fa-check"></i>&nbsp;{{ nameBtnApproved }}
                                        </button>
                                        <button class="btn btn-outline-danger btn-xs" :disabled="disabled" v-if="item.status !== 6 && ( item.status === 3 || item.status === 4 )" @click.prevent="actionButton( item, 'again' )">
                                            <i class="fa fa-reply"></i>&nbsp;Cotizar nuevamente
                                        </button>
                                        <button class="btn btn-outline-warning btn-xs" :disabled="disabled" v-if="item.status === 6" @click.prevent="actionButton( item, 'approval-customer' )">
                                            <i class="fa fa-exclamation-triangle"></i>&nbsp;Aprobar por cliente
                                        </button>
                                        <button class="btn btn-outline-danger btn-xs" :disabled="disabled" v-if="( item.status === 3 || item.status === 4 || item.status === 6 )" @click.prevent="actionButton( item, 'cancel' )">
                                            <i class="fa fa-close"></i>&nbsp;Anular
                                        </button>
                                        <button class="btn btn-outline-primary btn-xs" v-if="item.status === 8 && !item.existReferenceTerm" @click.prevent="generateReferenceTerm( item )">
                                            <i class="fa fa-check"></i>&nbsp;Generar términos de referencia
                                        </button>
                                        <button class="btn btn-outline-primary btn-xs" v-if="item.status === 8 && item.existReferenceTerm" @click.prevent="redirectreferenceTermDetail( item.id )">
                                            <i class="fa fa-cogs"></i>&nbsp;Config. términos de referencia
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
        <b-modal id="modalDetail" size="lg" ref="modalDetail" :title="modalTitle" @ok="closeModal">
            <info v-if="formId > 0" :saleQuotation="formId"></info>
        </b-modal>
    </div>
</template>

<script>
    import GStatus from '../../vuex/components/general/status';
    import info from '../sales-quotation/Sales-quotation-detail';
    export default {
        name: "sales-quotation-list",
        data() {
            return {
                search: '',
                nameModule: '',
                arrayList: [],
                modalTitle: '',
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                disabled: false,
                nameBtnApproved: 'Aprobar',
                formId: 0
            }
        },
        components: {
            GStatus,
            info
        },
        props: [
            'type'
        ],
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
            changePage( page ){
                let me = this;
                me.pagination.current_page = page;
                me.list( page );
            },
            list(page) {
                let me = this;
                let url = '/service-request/' + me.type + '/?search=' + me.search + '&page=' + page;

                if( me.type === 'to-be-approved' ) {
                    me.nameBtnApproved = 'Enviar a Gerencia';
                }

                axios.get(url).then(response => {
                    let result = response.data;
                    if (result.status) {
                        me.nameModule = result.title;
                        me.pagination = result.pagination;
                        me.arrayList = result.data;
                    }
                }).catch(errors => {
                    console.log(errors);
                });
            },
            actionButton( data, action ) {
                let me = this;
                let url = '/sale-quotation/action/';
                let textSwal = me.textSwal( action, data.status );

                swal({
                    title: textSwal.title,
                    text: textSwal.text.replace( '{{quotation}}', data.document ),
                    icon: textSwal.icon,
                    button: textSwal.button
                }).then( result => {
                    if( result ) {

                        me.disabled = true;

                        axios.put( url, {
                            quotation: data.id,
                            type: me.type,
                            action: action
                        }).then( response => {
                            let result = response.data;
                            me.disabled = false;
                            if( result.status ) {
                                me.list( 1 );
                            }
                        }).catch( errors => {
                            me.disabled = false;
                            console.log( errors );
                        });
                    }
                }).catch( errors => {
                    console.log( errors );
                });
            },
            textSwal( action, status ) {
                let data = {
                    title: '',
                    text: '',
                    icon: '',
                    button: ''
                };

                switch( action ) {
                    case 'approval':
                        data.title = 'Aprobar';
                        data.text = 'Estas seguro de aprobar la cotización {{quotation}}?';
                        data.icon = 'success';
                        data.button = 'Aprobar';
                        if( status === 3 ) {
                            data.title = 'Enviar a Gerencia';
                            data.text = 'Estas enviar a gerencia la cotización {{quotation}}?';
                        }
                        break;
                    case 'cancel':
                        data.title = 'Anular';
                        data.text = 'Estas seguro de anular la cotización {{quotation}}?';
                        data.icon = 'error';
                        data.button = 'Anular';
                        break;
                    case 'again':
                        data.title = 'Volver a cotizar';
                        data.text = 'Estas seguro de enviar a elaborar nuevamente la cotización {{quotation}}?';
                        data.icon = 'warning';
                        data.button = 'Volver a cotizar';
                        break;
                    case 'approval-customer':
                        data.title = 'Aprobar';
                        data.text = 'Estas seguro de aprobar la solictud( por el cliente ) la cotización {{quotation}}?';
                        data.icon = 'warning';
                        data.button = 'Aprobar';
                        break;
                }
                return data;
            },
            showDetail( data ) {
                this.formId = data.id;
                this.modalTitle = 'Ver detalle Cotización - ' + data.document;
                this.$refs.modalDetail.show();
            },
            closeModal() {
                this.formId = 0;
                this.modalTitle = '';
                this.$nextTick(() => {
                    this.$refs.modalDetail.hide();
                })
            },
            generateReferenceTerm( data ) {
                let me = this;
                let url = '/reference-term/generate/';

                swal({
                    title: 'Generar término de referencia',
                    text: '¿Estas seguro de generar el término de referencia para la cotización N° ' + data.document + '?',
                    icon: 'success',
                    button: 'Generar'
                }).then( result => {
                    if( result ) {
                        axios.post( url, {
                            saleQuotation: data.id
                        }).then(  response => {
                            let result = response.data;
                            if( result.status ) {
                                me.list(1);
                            }
                        }).catch( errors => {
                            console.log( errors );
                        })
                    }
                }).catch( errors => {
                    console.log( errors );
                });
            },
            redirectreferenceTermDetail( id ) {
                window.location = URL_PROJECT + '/reference-term/dashboard/' + id;
            }
        },
        mounted() {
            this.list(1);
        }
    }
</script>

<style scoped>

</style>
