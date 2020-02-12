<template>
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm">
                <h4 class="title-line">Resumen</h4>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-20">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Cliente</th>
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
                                <td>{{ detail.customer.name }}
                                    <br>
                                    <span class="badge badge-info" v-text="detail.customer.document"></span>
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
                <h5>Información</h5>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th>Actividad</th>
                                <td colspan="3" class="text-justify" v-text="detail.activity"></td>
                            </tr>
                            <tr>
                                <th>Objectivo</th>
                                <td colspan="3" class="text-justify" v-text="detail.objective"></td>
                            </tr>
                            <tr>
                                <th>Ejecución</th>
                                <td colspan="3" class="text-justify"><strong>{{ detail.execution}} día(s)</strong>; se dará inicio después de haber sido aprobada y pagado la primera parte del servicio.</td>
                            </tr>
                            <tr>
                                <th>Métodos de pago</th>
                                <td colspan="3" class="text-justify" v-text="detail.paymentMethods"></td>
                            </tr>
                            <tr>
                                <th>Garantía</th>
                                <td class="text-justify" v-text="detail.warranty"></td>
                                <th>Vencimiento</th>
                                <td class="text-justify">
                                    {{ detail.effective }} día(s)
                                    <br>
                                    <mark v-if="detail.dateExpiration" v-text="detail.dateExpiration"></mark>
                                </td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th class="mw-50">Descriptición</th>
                                <th>Cant</th>
                                <th>Mano de obra</th>
                                <th>Productos</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="detail.details.length > 0" v-for="( i, idx ) in detail.details">
                                <td v-text="idx + 1"></td>
                                <td v-text="i.description" class="text-justify"></td>
                                <td class="text-right">{{ i.quantity }}</td>
                                <td class="text-right">{{ i.workforce | formatPrice }}</td>
                                <td v-if="i.includesProducts === 1" class="text-right">{{ i.totalProducts | formatPrice }}</td>
                                <td v-else class="text-right">{{ 0 | formatPrice }}</td>
                                <td class="text-right">{{ i.total | formatPrice }}</td>
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
    import GStatus from '../../vuex/components/general/status'
    export default {
        name: "sr_information",
        props: ['service'],
        data() {
            return {
                detail: []
            }
        },
        components: {
            GStatus
        },
        methods: {
            information() {
                let me = this,
                    url = '/sale-quotation/' + me.service + '/info/v2/';

                axios.get( url ).then( function( response ) {
                    let result = response.data;

                    if( result.status ) {
                        me.detail = result.data;
                    }
                }).catch( function( errors ) {
                    console.log( errors );
                })
            },
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
        created() {
            this.information();
        }
    }
</script>

<style scoped>

</style>
