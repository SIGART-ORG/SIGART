<template>
    <div class="col-md-12">
        <div class="custom-border">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Solicitud de servicio</h2>
                    <button v-if="formStatus === 1" class="btn btn-outline-primary btn-xs" type="button" @click.prevent="saveQuotation">
                        <i class="fa fa-save"></i> Guardar Cotización
                    </button>
                    <button v-if="formStatus === 1" class="btn btn-outline-info btn-xs" type="button" @click.prevent="sendQuotation">
                        <i class="fa fa-send"></i> Enviar a solicitud de aprobación
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
                                    <option>Método de Pago</option>
                                    <option v-if="arrPaymentMethods.length > 0" v-for="mp in arrPaymentMethods" :key="mp.id" v-bind:value="mp.id" v-text="mp.title" ></option>
                                </select>
                                <small class="text-muted">Método de pago</small>
                            </div>
                            <div class="col-sm-3">
                                <input type="number" class="form-control form-control-sm" placeholder="Tiempo de ejecución ( Diás )" v-model.number="formExecution" :readonly="readOnly">
                                <small class="text-muted">Tiempo de ejecución ( Diás )</small>
                                <small v-if="formDelivery" class="text-muted">Fecha de entrega - cliente <strong class="text-info" v-text="formDelivery"></strong></small>
                            </div>
                            <div class="col-sm-3">
                                <input type="number" class="form-control form-control-sm" placeholder="Garantía ( Meses )" v-model.number="forWarranty" :readonly="readOnly">
                                <small class="text-muted">Garantía ( Meses )</small>
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
                                                <th>IGV (18%)</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-if="details.length > 0" v-for="det in details" :key="det.id">
                                                <td>
                                                    <textarea class="form-control" :readonly="readOnly" v-model="det.description"></textarea>
                                                </td>
                                                <td v-text="det.quantity"></td>
                                                <td>
                                                    <input type="number" class="form-control mw-75p" placeholder="Mano de obra" v-model.number="det.workforce" :readonly="readOnly" min="0">
                                                </td>
                                                <td>
                                                    <div class="mw-100">
                                                        {{ det.totalProducts | formatPrice }}
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" v-model="det.includesProducts">
                                                        <label class="form-check-label">Incluir Productos</label>
                                                    </div>
                                                </td>
                                                <td>{{ det.subTotal | formatPrice }}</td>
                                                <td>{{ det.igv | formatPrice }}</td>
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
                        let includesProducts = p.includesProducts;
                        let tProducts = p.totalProducts ? parseFloat( p.totalProducts ): 0;
                        let workforce = p.workforce ? parseFloat( p.workforce ): 0;
                        let subTotal = includesProducts ? tProducts + workforce : workforce;
                        let igv = ( 0.18 ) * subTotal;

                        igv = igv ? igv : 0;

                        p.subTotal = subTotal;
                        p.igv = igv;
                        p.total = subTotal + igv;

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
                        swal(
                            'Guardado!',
                            'Se guardo correctamente la cotización.',
                            'success'
                        )
                    } else {
                        console.log( result.msg );
                    }
                }).catch( function( errors ) {
                    console.log( errors );
                });
            },
            sendQuotation() {
                let me = this,
                    url = '/sale-quotation/send/';

                axios.post( url, {
                    'quotation': me.formQuotation
                }).then( function( response ) {
                    let result = response.data;
                    if( result.status ) {
                        me.getData();
                        swal(
                            'Enviado!',
                            'Se envió la cotización al Área de Administración ( Recuerda que ya no se podra editar la cotización mientras se encuentre en solicitud de aprobación ).',
                            'success'
                        )
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
