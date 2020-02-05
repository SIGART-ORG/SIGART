<template>
    <div class="col-md-9">
        <div class="custom-border">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Solicitud de servicio</h2>
                    <button v-if="formStatus === 1" class="btn btn-outline-primary btn-xs" type="button" @click.prevent="saveQuotation">
                        <i class="fa fa-check-circle"></i> Guardar Cotización
                    </button>
                </div>
            </div>
            <div class="row mt-20">
                <div class="col-12">
                    <form>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Actividad</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" placeholder="Actividad" v-model="formActivity" :readonly="readOnly">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Objetivo</label>
                            <div class="col-sm-10">
                                <textarea class="form-control form-control-sm" v-model="formObjective" placeholder="Objetivo del servicio." :readonly="readOnly"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Detalle</label>
                            <div class="col-sm-4">
                                <select class="form-control form-control-sm" v-model="formPaymentMethods">
                                    <option>Metodo de Pago</option>
                                    <option v-if="arrPaymentMethods.length > 0" v-for="mp in arrPaymentMethods" :key="mp.id" v-bind:value="mp.id" v-text="mp.title" ></option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="number" class="form-control form-control-sm" placeholder="Tiempo de ejecución ( Diás )" v-model.number="formExecution" :readonly="readOnly">
                                <small v-if="formDelivery" class="text-muted">Fecha de entrega - cliente <strong class="text-info" v-text="formDelivery"></strong></small>
                            </div>
                            <div class="col-sm-3">
                                <input type="number" class="form-control form-control-sm" placeholder="Garantía ( Meses )" v-model.number="forWarranty" :readonly="readOnly">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label text-center">Detalle de servicios</label>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-wrap">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-20">
                                            <thead>
                                            <tr>
                                                <th>Descripción</th>
                                                <th>Cant</th>
                                                <th>Mano de obra</th>
                                                <th>productos</th>
                                                <th>Sub Total</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-if="details.length > 0" v-for="det in details" :key="det.id">
                                                <td>
                                                    <textarea class="form-control" :readonly="readOnly" v-model="det.description"></textarea>
                                                </td>
                                                <td v-text="det.quantity"></td>
                                                <td v-if="det.type === 1">{{ det.subTotal | formatPrice }}</td>
                                                <td v-else>
                                                    <input type="number" class="form-control mw-75p" placeholder="Mano de obra" v-model.number="det.subTotal" :readonly="readOnly" min="0">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control mw-75p" placeholder="Descuento" v-model.number="det.totalProducts" :readonly="true" min="0">
                                                    <input type="checkbox" class="form-control" v-model="det.includesProducts" > Incluir Productos
                                                </td>
                                                <td>{{ det.total | formatPrice }}</td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>

                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { Datetime } from 'vue-datetime';
    import 'vue-datetime/dist/vue-datetime.css';
    import { Settings } from 'luxon';
    Settings.defaultLocale = 'es';
    export default {
        name: "sr_summary",
        props: ['service'],
        data() {
            return {
                formQuotation: 0,
                formDelivery: '',
                formActivity: '',
                formObjective: '',
                formPaymentMethods: 1,
                formExecution: 1,
                forWarranty: 1,
                formStart: '',
                formEnd: '',
                formStatus: 1,
                details: [],
                total: 0,
                readOnly: false,
                arrPaymentMethods: []
            }
        },
        components: {
            datetime: Datetime
        },
        watch: {
            details: {
                handler: function( newVal, oldval ) {
                    this.details.forEach( p => {
                        let discount = p.discount ? p.discount : 0;
                        let subTotal = p.subTotal ? p.subTotal : 0;
                        p.total = subTotal - discount;
                    })
                }, deep: true
            }
        },
        methods: {
            getData() {
                let me = this,
                    url = '/service-request/' + me.service + '/data/';

                axios.get( url ).then( function( response ) {
                    let result = response.data;

                    if( result.status ) {
                        let summary = result.summary;
                        let quotation = summary.quotations;
                        me.formQuotation = quotation.id;
                        me.formDelivery = quotation.dateDelivery;
                        me.formActivity = quotation.activity;
                        me.formObjective = quotation.objective;
                        me.formPaymentMethods = quotation.paymentMethods;
                        me.formExecution = quotation.execution;
                        me.forWarranty = quotation.warranty;
                        me.formStart = quotation.start;
                        me.formEnd = quotation.end;
                        me.details = quotation.details;
                        me.subTotal = quotation.subTotal;
                        me.total = quotation.total;
                        me.readOnly = quotation.status !== 1;
                        me.formStatus = quotation.status;
                        me.arrPaymentMethods = summary.methodPayments;
                    }
                }).catch( function( errors ) {
                    console.log( errors );
                })
            },
            saveQuotation() {
                let me = this,
                    url = '/sale-quotation/save/';

                axios.post( url, {
                    'type': 'first-approval',
                    'sr': me.service,
                    'quotation': me.formQuotation,
                    'activity': me.formActivity,
                    'objective': me.formObjective,
                    'paymentMethods': me.formPaymentMethods,
                    'execution': me.formExecution,
                    'warranty': me.forWarranty,
                    'start': me.formStart,
                    'end': me.formEnd,
                    'details': me.details,
                    'subTotal': me.subTotal,
                    'total': me.total,
                }).then( function( response ) {
                    let result = response.data;
                    if( result.status ) {
                        me.getData();
                    } else {
                        console.log( result.msg );
                    }
                }).catch( function( errors ) {
                    console.log( errors );
                });
            }
        },
        created() {
            this.getData();
        }
    }
</script>

<style scoped>
    .custom-border {
        border: 1px solid #CFCFCF;
        padding: 10px;
    }
</style>
