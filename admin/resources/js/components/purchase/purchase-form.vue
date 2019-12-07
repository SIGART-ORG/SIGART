<template>
    <div>
        <form ref='formPurchase' @submit="savePurchase($event)">
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">Registro de compra</h5>
                <div class="row">
                    <div class="col-sm form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto" >
                                <button type="submit" class="btn btn-success mb-2">
                                    <i class="fa fa-fw fa-lg fa-save"></i> Actualizar compra
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
                                <select class="form-control custom-select d-block w-100" id="cbo-type-voucher" v-model="formTypeVoucher"
                                    v-validate="'required|excluded:0'"
                                    name="comprobante">
                                    <option value="0">Seleccionar...</option>
                                    <option value="4">Boleta</option>
                                    <option value="5">Factura</option>
                                </select>
                                <span v-show="errors.has('comprobante')" class="text-danger">{{ errors.first('comprobante') }}</span>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="ipt-serie" >Serie <span class="text-danger">(*)</span></label>
                                <input class="form-control" id="ipt-serie" placeholder="Serie" v-model="formSerie" type="text"
                                    v-validate="'required|alpha_num|max:5'"
                                    name="serie">
                                <span v-show="errors.has('serie')" class="text-danger">{{ errors.first('serie') }}</span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="ipt-number">Número <span class="text-danger">(*)</span></label>
                                <input class="form-control" id="ipt-number" placeholder="Número" v-model="formNumber" type="text"
                                    v-validate="'required|max:11'"
                                    name="number">
                                <span v-show="errors.has('number')" class="text-danger">{{ errors.first('number') }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="ipt-number">Proveedor</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label class="sr-only" for="prov-document">Documento</label>
                                <input type="text" id="prov-document" readonly="readonly" class="form-control"
                                       v-model="provider.doc" placeholder="Documento"
                                       name="documento"
                                />
                            </div>
                            <div class="col-md-9 form-group">
                                <label class="sr-only" for="prov-name">Nombre</label>
                                <input type="text" id="prov-name" readonly="readonly" class="form-control"
                                       v-model="provider.name" placeholder="Nombre y/o Razón Social"
                                       name="nombre"
                                />
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="ipt-date-em" >Fecha de Emisión</label>
                                    <datetime
                                        id="ipt-date-em"
                                        v-model="formDate"
                                        name="fecha"
                                        v-validate="'required'"
                                        format="yyyy-MM-dd"
                                        input-class="form-control"
                                        value-zone="America/Lima"
                                        :auto="true"
                                    ></datetime>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="row" v-if="showFields">
                    <div class="col-xl-12 mb-20">
                        <hr/>
                    </div>
                </div>
                <h6 class="hk-sec-title" v-if="showFields">Agregar</h6>
                <div class="row" v-if="showFields">
                    <div class="col-md-6 form-group">
                        <label class="sr-only">Producto</label>
                        <autocomplete
                            ref="autocompleteProduct"
                            placeholder="Buscar Producto"
                            :source="apiSearchProduct"
                            input-class="form-control"
                            results-property="data"
                            :results-display="formattedDisplayProduct"
                            @selected="selectProduct"
                            @clear="clearSeachProduct">
                        </autocomplete>
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="ipt-price-unit" class="sr-only">P/U</label>
                        <input class="form-control" v-model="selectedProduct.priceUnit" id="ipt-price-unit" placeholder="P/U" value="" type="text">
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="ipt-quantity" class="sr-only">Cantidad</label>
                        <input class="form-control" v-model="selectedProduct.quantity" id="ipt-quantity" placeholder="Cantidad" value="" type="text">
                    </div>
                    <div class="col-md-2 form-group">
                        <button type="button" class="btn btn-danger mb-2"
                                :class="selectedProduct.id == 0 ? 'disabled' : ''"
                                @click.prevent="clearSeachProduct()"
                        >
                            <i class="fa fa-fw fa-lg fa-close"></i>
                        </button>
                        <button type="button" class="btn btn-primary mb-2"
                                :class="selectedProduct.id == 0 || selectedProduct.quantity == 0 || selectedProduct.priceUnit == 0 ? 'disabled' : ''"
                                @click.prevent="addProduct"
                        >
                            <i class="fa fa-fw fa-lg fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="row" v-if="showFields">
                    <div class="col-xl-12 mb-20">
                        <hr/>
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
                                        <th></th>
                                    </tr>
                                    <tr v-for="row in formDetails">
                                        <td><img class="w-60p" :src="row.image" alt="icon" /></td>
                                        <th scope="row">
                                            <strong>{{ row.sku }}</strong><br>
                                            {{ row.name }}
                                        </th>
                                        <td>
                                            <input v-model.number="row.priceUnit" type="text" class="normal width-65-px" min="0" max="1000" />
                                        </td>
                                        <td>
                                            <input v-model.number="row.quantity" type="text" class="normal width-65-px" min="0" max="100" />
                                        </td>
                                        <td class="text-dark">
                                            <input v-model.number="row.subTotal" type="text" class="normal width-65-px" min="0" />
                                        </td>
                                        <td>
                                            <button type="button" class="close" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
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
                                            <span class="text-dark font-weight-500">S/ {{ subTotal }}</span>
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
                                <i class="ion ion-md-clipboard font-21 mr-10"></i>Summary
                            </h6>
                            <div class="card-body pa-0">
                                <div class="table-wrap">
                                    <div class="table-responsive">
                                        <table class="table table-sm mb-0">
                                            <tbody>
                                            <tr>
                                                <th class="w-70" scope="row">Sub Total</th>
                                                <th class="w-30" scope="row">
                                                    <input v-model.number="subTotal" class="normal width-65-px" min="0"
                                                           v-validate="'required|min:1|decimal:2'"
                                                    />
                                                </th>
                                            </tr>
                                            <tr>
                                                <td class="w-70">IGV 18%</td>
                                                <td class="w-30">
                                                    <input v-model.number="igv" class="normal width-65-px" min="0"
                                                           v-validate="'required|min:1|decimal:2'"
                                                    />
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr class="bg-light">
                                                <th class="text-dark text-uppercase" scope="row">Total</th>
                                                <th class="text-dark font-18" scope="row">S/{{ total }}</th>
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
    import Autocomplete from 'vuejs-auto-complete';
    import { Datetime } from 'vue-datetime';
    import { Settings } from 'luxon';
    Settings.defaultLocale = 'es';
    import 'vue-datetime/dist/vue-datetime.css';
    export default {
        name: "purchase-form",
        components: {
            Autocomplete,
            datetime: Datetime
        },
        props: [
            'purchase'
        ],
        data() {
            return {
                urlProject: URL_PROJECT,
                showFields: false,
                formSerie: '',
                formNumber: '',
                formTypeVoucher: 0,
                formProviderId: 0,
                formDetails: [],
                formDate: '',
                provider: {
                    'name': '',
                    'document': ''
                },
                selectedProduct: {
                    id: 0,
                    quantity: 0,
                    priceUnit: 0,
                    name: ''
                },
                subTotal: 0,
                igv: 0
            }
        },
        computed: {
            total() {
                let total = ( parseFloat( this.subTotal ) + parseFloat(this.igv ) );
                console.log( typeof total );

                return total.toFixed( 2 );
            }
        },
        methods: {
            loadPurchase() {
                let me = this,
                    url = '/purchases/' + me.purchase + '/show';

                axios.get( url ).then( function( resp ) {
                    let response = resp.data;
                    if( response.status ) {
                        me.provider = response.header.provider;
                        me.formDetails = response.details;
                    }
                }).catch( function( errors ) {
                    console.log( errors );
                });

            },
            /*------------old-model-------------*/
            clearSeachProduct(){
                if( this.selectedProduct.id > 0 ) {
                    this.selectedProduct.id = 0;
                    this.selectedProduct.quantity = 0;
                    this.selectedProduct.priceUnit = 0;
                    this.selectedProduct.name = '';
                    this.$refs.autocompleteProduct.clear();
                }
            },
            apiSearchProduct( input ) {
                return this.urlProject + '/product/search/?search=' + input;
            },
            formattedDisplayProduct( result ) {
                return result.sku + ' - ' + result.category + ' ' + result.product + ' ' + result.name;
            },
            selectProduct( evt ) {
                let selected = evt.selectedObject;
                this.selectedProduct.id = selected.id;
                this.selectedProduct.name = selected.sku + ' - ' + selected.category + ' ' + selected.product + ' ' + selected.name;;
            },
            addProduct() {
                if( this.selectedProduct.id > 0 ) {
                    this.formDetails.push({
                        id: this.selectedProduct.id,
                        name: this.selectedProduct.name,
                        quantity: parseFloat( this.selectedProduct.quantity ),
                        priceUnit: parseFloat( this.selectedProduct.priceUnit ),
                        image: this.urlProject + '/assets//dist/img/product-thumb1.png'
                    });
                    this.clearSeachProduct();
                }
            },
            savePurchase( event ) {
                event.preventDefault();
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let me = this;
                        axios.post( '/purchases/new/', {
                            serial: me.formSerie,
                            number: me.formNumber,
                            date: me.formDate,
                            provider: me.formProviderId,
                            typeVoucher: me.formTypeVoucher,
                            details: me.formDetails
                        }).then( function( result ) {
                            let response = result.data;
                            if( response.status ) {
                                window.location.href = me.urlProject + "/purchases/dashboard/";
                            }else{
                                swal(
                                    'Error! :(',
                                    'No se pudo registrar la compra.',
                                    'error'
                                );
                            }
                        }).catch( function( errors ) {
                            swal(
                                'Error! :(',
                                'No se pudo realizar la operación',
                                'error'
                            );
                        });
                    }
                });
            }
        },
        mounted() {
            this.loadPurchase();
        }
    }
</script>

<style scoped>
    .width-65-px {
        width: 65px !important;
    }
</style>
