<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Nuevo comprobante</h5>
            <form class="form" v-if="error === '' && code === ''">
                <div class="form-row align-items-left mw-100 w-100">
                    <div class="col-8">
                        <label class="sr-only" for="inlineFormInput">Comprobante</label>
                        <autocomplete
                            id="inlineFormInput"
                            ref="autocompleteVoucher"
                            placeholder="Buscar Orden de servicio o cliente"
                            :source="apiSearchVoucher"
                            input-class="form-control"
                            results-property="data"
                            :results-display="formattedDisplayVoucher"
                            @selected="selectVourcher"
                            @clear="clearSeachProduct">
                        </autocomplete>
                        <small class="text-muted">Puede buscar por número de servicio o por el cliente</small>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-outline-danger" :disabled="form.service === 0" @click.prevent="clearSeachProduct">
                            <i class="fa fa-close"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div v-if="error !== ''" class="bd-callout bd-callout-danger">
                <p v-html="error"></p>
            </div>
        </section>
        <form ref='formPurchase' @submit="save($event)" v-if="!formConfig.disabled">
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Comprobante de pago</h5>
                <div class="row">
                    <div class="col-sm form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success mb-2" :disabled="formConfig.disabled">
                                    <i class="fa fa-fw fa-lg fa-plus-circle"></i> Registrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="cbo-type-voucher">Comprobante <span class="text-danger">(*)</span></label>
                                <select class="form-control custom-select d-block w-100" id="cbo-type-voucher"
                                        v-model="form.typeVoucher"
                                        v-validate="'required|excluded:0'"
                                        name="comprobante">
                                    <option value="0">Seleccionar...</option>
                                    <option v-for="tv in formConfig.typeDocuments" :key="tv.id" :value="tv.id" v-text="tv.name"></option>
                                </select>
                                <span v-show="errors.has('comprobante')" class="text-danger">{{ errors.first('comprobante') }}</span>
                            </div>
                            <div class="col-md-9 form-group">
                                <label for="ipt-serie">N° <span class="text-danger">(*)</span></label>
                                <input class="form-control" id="ipt-serie" placeholder="correlativo" v-model="form.document"
                                       type="text"
                                       v-validate="'required|max:16'"
                                       name="serie"
                                        readonly>
                                <span v-show="errors.has('correlativo')"
                                      class="text-danger">{{ errors.first('correlativo') }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="prov-document">Cliente: </label>
                                <span id="prov-document">{{ form.customerDocument }}</span>
                            </div>
                            <div class="col-md-9 form-group">
                                <label class="sr-only" for="prov-name">Nombre</label>
                                <span id="prov-name">{{ form.customerName }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="prov-address">Dirección: </label>
                                <span id="prov-address">{{ form.customerAdress }} - {{ form.customerUbigeo }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="ipt-date-em">Fecha de Emisión</label>
                                <datetime
                                    id="ipt-date-em"
                                    v-model="form.dateEmision"
                                    name="fecha"
                                    v-validate="'required'"
                                    format="yyyy-MM-dd"
                                    input-class="form-control"
                                    value-zone="America/Lima"
                                    :auto="true"
                                    :max-datetime="formConfig.today"
                                ></datetime>
                                <span v-show="errors.has('fecha')"
                                      class="text-danger">{{ errors.first('fecha') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-8 mb-20">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <tbody>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Precio Unitario</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                    </tr>
                                    <tr v-for="row in form.details">
                                        <th scope="row">
                                            {{ row.description }}
                                        </th>
                                        <td>
                                            {{ row.priceUnit | formatPrice }}
                                        </td>
                                        <td>
                                            {{ row.quantity }}
                                        </td>
                                        <td class="text-dark">
                                            {{ row.total | formatPrice }}
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td class="text-right"></td>
                                        <td class="text-right" colspan="2">
                                            <small class="pr-5 text-muted font-weight-500">Sub Total:</small>
                                        </td>
                                        <td class="text-right" colspan="2">
                                            <span class="text-dark font-weight-500">{{ form.subTotal | formatPrice }}</span>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 mb-20">
                        <div class="card">
                            <h6 class="card-header border-0">
                                <i class="ion ion-md-clipboard font-21 mr-10"></i>Total
                            </h6>
                            <div class="card-body pa-0">
                                <div class="table-wrap">
                                    <div class="table-responsive">
                                        <table class="table table-sm mb-0">
                                            <tbody>
                                            <tr>
                                                <th class="w-40" scope="row">Sub Total</th>
                                                <th class="w-60 text-right" scope="row">{{ form.subTotal | formatPrice }}</th>
                                            </tr>
                                            <tr>
                                                <td class="w-40">IGV 18%</td>
                                                <td class="w-60 text-right">{{ form.igv | formatPrice }}
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr class="bg-light">
                                                <th class="text-dark text-uppercase" scope="row">Total</th>
                                                <th class="text-dark font-16 text-right" scope="row">{{ form.total | formatPrice }}</th>
                                            </tr>
                                            <tr class="bg-light">
                                                <th class="text-primary text-uppercase" scope="row">Cancelado</th>
                                                <th class="text-dark font-18 text-right" scope="row">{{ form.outstanding | formatPrice }}</th>
                                            </tr>
                                            <tr class="bg-light">
                                                <th class="text-primary text-uppercase" scope="row">Importe</th>
                                                <th class="text-dark font-18 text-right" scope="row">
                                                    <input v-model.number="formConfig.amount" class="normal w-100" v-validate="{ required: true, min_value: form.minPay, max_value: form.maxPay }"
                                                           name="importe" :readonly="formConfig.readOnly"
                                                    />
                                                    <small v-show="errors.has('importe')" class="text-danger">{{ errors.first('importe') }}</small>
                                                </th>
                                            </tr>
                                            <tr class="bg-light">
                                                <th class="text-primary text-uppercase" scope="row">Saldo</th>
                                                <th class="text-dark font-18 text-right" scope="row">{{ balance | formatPrice }}</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
        <b-modal ref="my-modal" hide-footer title="Using Component Methods">
            <div class="d-block text-center">
                <h3>
                    <i class="fa fa-check-circle"></i> Comprobante registrado correctamente
                </h3>
            </div>
            <b-button class="mt-3" variant="outline-info" block @click="backList">
                <i class="fa fa-reply"></i> Volver al listado
            </b-button>
            <b-button class="mt-2" variant="outline-danger" block @click="seePdf">
                <i class="fa fa-file-pdf-o"></i> Ver Documento
            </b-button>
        </b-modal>
    </div>
</template>

<script>
    import { mapMutations } from 'vuex';
    import Autocomplete from 'vuejs-auto-complete';
    import { Datetime } from 'vue-datetime';
    import 'vue-datetime/dist/vue-datetime.css';
    export default {
        name: "sale-new",
        components: {
            Autocomplete,
            Datetime
        },
        data() {
            return {
                urlProject: URL_PROJECT,
                filePdf: '',
            }
        },
        props: ['code'],
        created() {
            this.$store.dispatch({
                type: 'chargeDataByCode',
                data: {
                    code: this.code,
                }
            });
        },
        methods: {
            ...mapMutations(['CHANGE_FORM_DATA', 'CHANGE_CONFIG_FORM']),
            save( e ) {
                e.preventDefault();
                this.$validator.validateAll().then((result) => {
                    if( result ) {
                        let me = this;
                        me.$store.dispatch({
                            type: 'registerSales',
                            data: {
                                amount: me.formConfig.amount,
                                code: me.code,
                            }
                        }).then( response => {
                            let result = response.data;
                            if( result.status ) {
                                me.filePdf = result.pdf;
                                me.formConfig.disabled = true;
                                me.clearSeachProduct();
                                this.$refs['my-modal'].show();
                            } else {
                                swal(
                                    'Error! :(',
                                    'No se pudo realizar la operación',
                                    'error'
                                )
                            }
                        }).catch( errors => {
                            console.log( errors );
                            swal(
                                'Error! :(',
                                'No se pudo realizar la operación',
                                'error'
                            )
                        })
                    }
                });
            },
            apiSearchVoucher(input) {
                return this.urlProject + '/sales/search/?search=' + input;
            },
            formattedDisplayVoucher(result) {
                return result.customer.name + ' - ' + result.customer.document + ' | ' + result.document + ' | ' + result.total;
            },
            selectVourcher(evt) {
                let selected = evt.selectedObject;
                let formNew = {
                    service: selected.id,
                    document: selected.voucher.document,
                    typeVoucher: selected.voucher.typeDocument,
                    subTotal: selected.subTotal,
                    igv: selected.igv,
                    total: selected.total,
                    paidOut: selected.paidOut,
                    minPay: selected.minPay,
                    maxPay: selected.maxPay,
                    outstanding: selected.outstanding,
                    details: selected.details,
                    dateEmision: selected.dateEmision,
                    customerName: selected.customer.name,
                    customerDocument: selected.customer.typeDocumentName + ' ' + selected.customer.document,
                    customerAdress: selected.customer.address,
                    customerUbigeo: selected.customer.ubigeo,
                };
                this.CHANGE_FORM_DATA( formNew );
                this.CHANGE_CONFIG_FORM({
                    disabled: false,
                    readOnly: false,
                    typeDocuments: selected.voucher.typeDocuments,
                    amount: selected.minPay,
                    today: selected.today
                });
            },
            clearSeachProduct() {
                if ( this.form.service > 0 ) {
                    let formNew = {
                        service: 0,
                        document: '',
                        typeVoucher: 0,
                        subTotal: 0,
                        igv: 0,
                        total: 0,
                        paidOut: 0,
                        minPay: 0,
                        maxPay: 0,
                        outstanding: 0,
                        dateEmision: '',
                        customerName: '',
                        customerDocument: '',
                        customerAdress: '',
                        customerUbigeo: '',
                        details: []
                    };
                    this.$refs.autocompleteVoucher.clear();
                    this.CHANGE_FORM_DATA( formNew );
                    this.CHANGE_CONFIG_FORM({
                        disabled: true,
                        readOnly: true,
                        typeDocuments: [],
                        amount: 0,
                        today: '',
                    });
                }
            },
            seePdf() {
                var win = window.open( this.filePdf, '_blank' );
                // this.$nextTick(() => {
                    this.$refs['my-modal'].hide();
                // })
                this.filePdf = '';
                win.focus();
            },
            backList() {
                location.href = URL_PROJECT + '/sales/dashboard/';
            }
        },
        computed: {
            formConfig: {
                get: function() {
                    return this.$store.state.Sale.configForm;
                },
                set: function( newValue ) {
                    this.$store.state.Sale.configForm = newValue;
                }
            },
            form: {
                get: function() {
                    return this.$store.state.Sale.form;
                },
                set: function( newValue ) {
                    this.$store.state.Sale.form = newValue;
                }
            },
            balance() {
                let amount = this.formConfig.amount ? this.formConfig.amount : 0;
                return parseFloat( this.form.paidOut ) - parseFloat( amount );
            },
            error() {
                return this.$store.state.Sale.error;
            }
        }
    }
</script>

<style scoped>
    .autocomplete__inputs input {
        width: 100% !important;
        max-width: 100% !important;
    }
</style>
