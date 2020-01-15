<template>
    <div class="col-md-9">
        <div class="custom-border">
            <div class="row">
                <div class="col-12">
                    <h2>Solicitud de servicio</h2>
                </div>
            </div>
            <div class="row mt-20">
                <div class="col-12">
                    <form>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Fechas</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-sm" placeholder="Fecha de inicio" v-model="formStart" :readonly="readOnly">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-sm" placeholder="Fecha fin" v-model="formEnd" :readonly="readOnly">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label text-center">Detalle de servicios</label>
                        </div>
                        <div class="form-group row" v-if="details.length > 0" v-for="det in details" :key="det.id">
                            <label class="col-sm-4 col-form-label" v-text="det.description"></label>
                            <div class="col-sm-3">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Sub-Total</div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Sub - Total" v-model.number="det.subTotal" readonly>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Dscto</div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Descuento" v-model.number="det.discount" :readonly="readOnly">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" placeholder="Total" v-model.number="det.total" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-8 col-form-label">Total</label>
                            <div class="col-sm-4">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Dscto</div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Total" v-model.number="total" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" v-if="!readOnly">
                            <div class="cols-sm-12 text-center">
                                <button class="btn btn-primary" type="button" @click.prevent="saveQuotation">
                                    <i class="fa fa-check-circle"></i> Guardar Cotización
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "sr_summary",
        props: ['service'],
        data() {
            return {
                formQuotation: 0,
                formStart: '',
                formEnd: '',
                details: [],
                total: 0,
                readOnly: false
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
                        me.formStart = quotation.start;
                        me.formEnd = quotation.end;
                        me.details = quotation.details;
                        me.subTotal = quotation.subTotal;
                        me.total = quotation.total;
                        me.readOnly = quotation.status !== 1;
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
