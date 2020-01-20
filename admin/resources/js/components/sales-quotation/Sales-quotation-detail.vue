<template>
    <div>
        <div class="row">
            <div class="col-sm">
                <h4 class="title-line">Resumen</h4>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-20">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Sub-Total</th>
                                <th>Descuento</th>
                                <th>I.G.V.</th>
                                <th>Total</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <strong class="text-info" v-text="detail.document"></strong>
                                    <br/>
                                    <small></small>
                                </td>
                                <td v-text="detail.subtotal"></td>
                                <td>
                                    {{ detail.discount }}
                                    <br>
                                    <small v-text="detail.discountPorc + '%'"></small>
                                </td>
                                <td>
                                    {{ detail.igv }}
                                    <br>
                                    <small v-text="detail.igvPorc + '%'"></small>
                                </td>
                                <td v-text="detail.total"></td>
                                <td>
                                    <g-status section="sale-quotation" :status="detail.status"></g-status>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <h4 class="title-line">Solicitud de servicio</h4>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-20">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Envio</th>
                                <th>Aprobación</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td v-if="sr" v-text="sr.document"></td>
                                <td v-if="sr" v-text="sr.description"></td>
                                <td v-if="sr" v-text="sr.send"></td>
                                <td v-if="sr" v-text="sr.approved"></td>
                                <td v-if="sr">
                                    <g-status section="service-request" :status="sr.status"></g-status>
                                </td>
                            </tr>
                            <tr v-if="sr && sr.observation">
                                <td colspan="5">
                                    <strong>Observación:</strong>&nbsp;{{ sr.observation }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h5>Detalle</h5>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-20">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                            </tr>
                            </thead>
                            <tbody v-if="sr && sr.details">
                            <tr v-for="(srd, idx) in sr.details" :key="srd.id">
                                <td>{{ idx + 1 }}</td>
                                <td v-text="srd.item"></td>
                                <td v-text="srd.quantity"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <h4 class="title-line">Cotización</h4>
                <h5>Aprobaciones</h5>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th>Administración</th>
                                <th>Dirección General</th>
                                <th>Clientes</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td v-if="administration">
                                    {{ administration.user }}
                                    <br/>
                                    <span v-if="administration.type === 'Aprobado'" class="badge badge-primary" v-text="administration.type"></span>
                                    <span v-else class="badge badge-danger" v-text="administration.type"></span>
                                </td>
                                <td v-if="gd">
                                    {{ gd.user }}
                                    <br/>
                                    <span v-if="gd.type === 'Aprobado'" class="badge badge-primary" v-text="gd.type"></span>
                                    <span v-else class="badge badge-danger" v-text="gd.type"></span>
                                </td>
                                <td v-if="customer">
                                    {{ customer.user }}
                                    <br/>
                                    <span v-if="customer.action === 'Aprobado'" class="badge badge-primary" v-text="customer.login"></span>
                                    <span v-else class="badge badge-danger" v-text="customer.login"></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h5>Detalle</h5>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import GStatus from '../../vuex/components/general/status'
    export default {
        name: "Sales-quotation-detail",
        data() {
            return {
                detail: []
            }
        },
        props: [
            'saleQuotation'
        ],
        components: {
            GStatus
        },
        methods: {
            getInfo() {
                let me = this;
                let url = '/sale-quotation/' + me.saleQuotation + '/info/';

                axios.get( url ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        me.detail = result.data;
                    }
                }).catch( errors => {
                    console.log( errors );
                })
            }
        },
        computed: {
            sr() {
                return this.detail.serviceRequest;
            },
            administration() {
                return this.detail.administration;
            },
            gd() {
                return this.detail.generalDirection;
            },
            customer() {
                return this.detail.customer;
            }
        },
        mounted() {
            this.getInfo();
        }
    }
</script>

<style scoped>
    .title-line {
        border-bottom: 2px #79b62f solid;
    }
</style>
