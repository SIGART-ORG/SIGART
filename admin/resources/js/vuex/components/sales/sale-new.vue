<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Nuevo comprobante</h5>
            <form class="form">
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
                        <button class="btn btn-outline-success">
                            <i class="fa fa-plus-circle"></i>
                        </button>
                        <button class="btn btn-outline-danger" :disabled="form.service === 0" @click.prevent="clearSeachProduct">
                            <i class="fa fa-close"></i>
                        </button>
                    </div>
                </div>
            </form>
        </section>
        <form ref='formPurchase' @submit="save($event)">
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Comprobante de pago</h5>
                <div class="row">
                    <div class="col-sm form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success mb-2">
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
                                    <option v-for="tv in typeDocuments" :key="tv.id" :value="tv.id" v-text="tv.name"></option>
                                </select>
                                <span v-show="errors.has('comprobante')" class="text-danger">{{ errors.first('comprobante') }}</span>
                            </div>
                            <div class="col-md-9 form-group">
                                <label for="ipt-serie">N° <span class="text-danger">(*)</span></label>
                                <input class="form-control" id="ipt-serie" placeholder="correlativo" v-model="form.document"
                                       type="text"
                                       v-validate="'required|max:16'"
                                       name="serie">
                                <span v-show="errors.has('correlativo')"
                                      class="text-danger">{{ errors.first('correlativo') }}</span>
                            </div>
                        </div>
<!--                        <div class="row">-->
<!--                            <div class="col-md-3 form-group">-->
<!--                                <label class="sr-only" for="prov-document">Documento</label>-->
<!--                                <input type="text" id="prov-document" readonly="readonly" class="form-control"-->
<!--                                       v-model="provider.doc" placeholder="Documento"-->
<!--                                       name="documento"-->
<!--                                />-->
<!--                            </div>-->
<!--                            <div class="col-md-9 form-group">-->
<!--                                <label class="sr-only" for="prov-name">Nombre</label>-->
<!--                                <input type="text" id="prov-name" readonly="readonly" class="form-control"-->
<!--                                       v-model="provider.name" placeholder="Nombre y/o Razón Social"-->
<!--                                       name="nombre"-->
<!--                                />-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="row">-->
<!--                            <div class="col-md-4 form-group">-->
<!--                                <label for="ipt-date-em">Fecha de Emisión</label>-->
<!--                                <datetime-->
<!--                                    id="ipt-date-em"-->
<!--                                    v-model="formDate"-->
<!--                                    name="fecha"-->
<!--                                    v-validate="'required'"-->
<!--                                    format="yyyy-MM-dd"-->
<!--                                    input-class="form-control"-->
<!--                                    value-zone="America/Lima"-->
<!--                                    :auto="true"-->
<!--                                    :max-datetime="dateEnd"-->
<!--                                ></datetime>-->
<!--                                <span v-show="errors.has('fecha')"-->
<!--                                      class="text-danger">{{ errors.first('fecha') }}</span>-->
<!--                            </div>-->
<!--                            <div class="col-md-6 form-group">-->
<!--                                <label>Adjuntar Comprobante</label>-->
<!--                                <input type="file" class="form-control-file" v-validate="'image'"-->
<!--                                       name="imagen"-->
<!--                                       @change="uploadImage( $event )"-->
<!--                                       accept="image/jpeg, image/jpg, image/png"-->
<!--                                >-->
<!--                                <span v-show="errors.has('imagen')"-->
<!--                                      class="text-danger">{{ errors.first('imagen') }}</span>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-8 mb-20">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <tbody>
                                    <tr>
                                        <th colspan="2">Producto</th>
                                        <th>Precio Unitario</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                    </tr>
                                    <tr v-for="row in form.details">
                                        <td><img class="w-60p" :src="row.image" alt="icon"/></td>
                                        <th scope="row">
                                            <strong>{{ row.sku }}</strong><br>
                                            {{ row.name }}
                                        </th>
                                        <td>
                                            <input v-model.number="row.priceUnit" type="text" class="normal mw-75p"
                                                   min="0" max="1000"/>
                                        </td>
                                        <td>
                                            <input v-model.number="row.quantity" type="text" class="normal mw-75p"
                                                   min="0" max="100"/>
                                        </td>
                                        <td class="text-dark">
                                            <input v-model.number="row.subTotal" type="text" class="normal mw-75p"
                                                   min="0"/>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td></td>
                                        <td class="text-right"></td>
                                        <td class="text-right" colspan="2">
                                            <small class="pr-5 text-muted font-weight-500">Sub Total:</small>
                                        </td>
                                        <td class="text-right" colspan="2">
                                            <span class="text-dark font-weight-500">S/ {{ form.subTotal }}</span>
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
                                                <th class="w-70" scope="row">Sub Total</th>
                                                <th class="w-30" scope="row"> S/{{ form.subTotal }}</th>
                                            </tr>
                                            <tr>
                                                <td class="w-70">IGV 18%</td>
                                                <td class="w-30"> S/{{ form.igv }}
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr class="bg-light">
                                                <th class="text-dark text-uppercase" scope="row">Total</th>
                                                <th class="text-dark font-18" scope="row">S/{{ form.total }}</th>
                                            </tr>
                                            <tr class="bg-light">
                                                <th class="text-primary text-uppercase" scope="row">Cancelado</th>
                                                <th class="text-dark font-18" scope="row">S/{{ form.outstanding }}</th>
                                            </tr>
                                            <tr class="bg-light">
                                                <th class="text-primary text-uppercase" scope="row">Importe</th>
                                                <th class="text-dark font-18" scope="row">
                                                    <input v-model.number="amount" class="normal w-100" min="0"
                                                           name="importe" :readonly="readOnly"
                                                    />
                                                </th>
                                            </tr>
                                            <tr class="bg-light">
                                                <th class="text-primary text-uppercase" scope="row">Saldo</th>
                                                <th class="text-dark font-18" scope="row">S/{{ balance }}</th>
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
    </div>
</template>

<script>
    import { mapMutations } from 'vuex';
    import Autocomplete from 'vuejs-auto-complete';
    export default {
        name: "sale-new",
        components: {
            Autocomplete
        },
        data() {
            return {
                urlProject: URL_PROJECT,
                typeDocuments: [],
                amount: 0,
                readOnly: true
            }
        },
        methods: {
            ...mapMutations(['CHANGE_FORM_DATA']),
            save( e ) {
                e.preventDefault();
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
                    outstanding: selected.outstanding,
                    details: []
                };
                this.CHANGE_FORM_DATA( formNew );
                this.typeDocuments = selected.voucher.typeDocuments;
                this.readOnly = false;
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
                        outstanding: 0,
                        details: []
                    };
                    this.$refs.autocompleteVoucher.clear();
                    this.CHANGE_FORM_DATA( formNew );
                    this.typeDocuments = [];
                    this.readOnly = true;
                }
            },
        },
        computed: {
            form: {
                get: function() {
                    return this.$store.state.Service.form;
                },
                set: function( newValue ) {
                    this.$store.state.Service.form = newValue;
                }
            },
            balance() {
                return parseFloat( this.form.paidOut ) - parseFloat( this.amount );
            },
        }
    }
</script>

<style scoped>
    .autocomplete__inputs input {
        width: 100% !important;
        max-width: 100% !important;
    }
</style>
