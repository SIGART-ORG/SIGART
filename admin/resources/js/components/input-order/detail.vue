<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Ordenes de entradas</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto" >
                                <button type="submit" class="btn btn-info mb-2" @click.prevent="cancelIO">
                                    <i class="fa fa-fw fa-lg fa-arrow-left"></i> Regresar
                                </button>
                            </div>
                            <div class="col-auto" v-if="detailData.status && detailData.headers && detailData.headers.status === 1">
                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="approved"
                                        :class="! activeButton ? 'disabled' : ''">
                                    <i class="fa fa-fw fa-lg fa-check"></i> Aprobar
                                </button>
                            </div>
<!--                            <div class="col-auto" v-if="detailData.status && detailData.headers && detailData.headers.status === 1">-->
<!--                                <button type="submit" class="btn btn-danger mb-2" @click.prevent="dispproved">-->
<!--                                    <i class="fa fa-fw fa-lg fa-close"></i> Anular-->
<!--                                </button>-->
<!--                            </div>-->
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
                                    <td><span v-if="detailData.status && detailData.headers">{{ detailData.headers.voucher }}</span></td>
                                    <td>
                                        <span>Orden de compra n° </span><strong v-if="detailData.status && detailData.headers">{{ detailData.headers.purchaseOrder }}</strong><br/>
                                        <strong v-if="detailData.status && detailData.headers && detailData.headers.status === 3">{{ detailData.headers.purchaseTypeVoucher }}-{{ detailData.headers.purchaseVoucher }}</strong>
                                    </td>
                                    <td><span v-if="detailData.status && detailData.headers">{{ detailData.headers.userReg }}</span></td>
                                    <td><span v-if="detailData.status && detailData.headers">{{ detailData.headers.dateReg }}</span></td>
                                    <td><span v-if="detailData.status && detailData.headers">{{ detailData.headers.userApproved }}</span></td>
                                    <td><span v-if="detailData.status && detailData.headers">{{ detailData.headers.dateApproved }}</span></td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <td>Item</td>
                                    <td>SKU</td>
                                    <td colspan="2">Producto</td>
                                    <td>Cantidad</td>
                                    <td>Checklist</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr  v-if="detailData.status" v-for="( item, idx ) in detailData.items" :key="item.id">
                                    <td>{{ idx +1 }}</td>
                                    <td>{{ item.sku }}</td>
                                    <td colspan="2">{{ item.category }} {{ item.product }} {{ item.description }}</td>
                                    <td>{{ item.quantity }} {{ item.unity }}</td>
                                    <td>
                                        <input type="checkbox" v-model="item.is_confirmed" :disabled="detailData.status && detailData.headers && detailData.headers.status !== 1">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "detail",
        props: [
            'id'
        ],
        data() {
            return {
                detailData: [],
            }
        },
        computed: {
            activeButton() {
                let me = this;
                let items = me.detailData.items;
                let active = true;

                items.forEach( function ( element ) {
                    if( ! element.is_confirmed ) {
                        active = false;
                    }
                });

                if( items.length === 0 ) {
                    active = false;
                }

                return active;
            },
        },
        methods: {
            getDetail() {
                let me = this,
                    url = '/input-orders/details/';
                axios.get( url, {
                    params: {
                        id: me.id
                    }
                }).then( function( result ) {
                    let response = result.data;
                    if( response.status ){
                        me.detailData   = response;
                    }
                });
            },
            approved() {
                let me = this,
                    url = '/input-orders/' + me.id + '/approved/';
                axios.post( url ).then( function ( result ) {
                    let response = result.data;
                    if( response.status ) {
                        me.getDetail();
                    } else {
                        console.log( 'error' );
                    }
                });
            },
            cancelIO() {
                window.location = '/input-orders/dashboard/';
            }
        },
        mounted() {
            this.getDetail();
        }
    }
</script>

<style scoped>

</style>
