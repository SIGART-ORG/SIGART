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
                                    <th>Dscto.</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in arrayList" :key="item.id">
                                    <td class="text-center">
                                        <strong class="text-info">{{ item.document }}</strong>
                                        <br/>
                                        <small><mark v-text="item.start"></mark> a <mark v-text="item.end"></mark></small>
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
                                    <td>{{ item.subtotal }}</td>
                                    <td>{{ item.discount }}</td>
                                    <td>{{ item.total }}</td>
                                    <td>
                                        <button class="btn btn-outline-info btn-xs" :disabled="disabled">
                                            <i class="fa fa-info"></i> Ver Cotización
                                        </button>
                                        <button class="btn btn-outline-primary btn-xs" :disabled="disabled" v-if="item.status !== 6" @click.prevent="actionButton( item, 'approval' )">
                                            <i class="fa fa-check"></i>&nbsp;Aprobar
                                        </button>
                                        <button class="btn btn-outline-warning btn-xs" :disabled="disabled" v-if="item.status === 6" @click.prevent="actionButton( item, 'approval-customer' )">
                                            <i class="fa fa-exclamation-triangle"></i>&nbsp;Aprobar por cliente
                                        </button>
                                        <button class="btn btn-outline-danger btn-xs" :disabled="disabled" @click.prevent="actionButton( item, 'cancel' )">
                                            <i class="fa fa-close"></i>&nbsp;Anular
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
    </div>
</template>

<script>
    export default {
        name: "sales-quotation-list",
        data() {
            return {
                search: '',
                nameModule: '',
                arrayList: [],
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
            }
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
                let textSwal = me.textSwal( action );

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
            textSwal( action ) {
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
                        break;
                    case 'cancel':
                        data.title = 'Anular';
                        data.text = 'Estas seguro de anular la cotización {{quotation}}?';
                        data.icon = 'error';
                        data.button = 'Anular';
                        break;
                    case 'approval-customer':
                        data.title = 'Aprobar';
                        data.text = 'Estas seguro de aprobar la solictud( por el cliente ) la cotización {{quotation}}?';
                        data.icon = 'warning';
                        data.button = 'Aprobar';
                        break;
                }
                return data;
            }
        },
        mounted() {
            this.list(1);
        }
    }
</script>

<style scoped>

</style>
