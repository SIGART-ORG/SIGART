<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Registro de compra</h5>
            <div class="row">
                <div class="col-sm">
                    <form>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="cbo-type-voucher">Comprobante</label>
                                <select class="form-control custom-select d-block w-100" id="cbo-type-voucher" v-model="formTypeVoucher">
                                    <option value="0">Seleccionar...</option>
                                    <option value="4">Boleta</option>
                                    <option value="5">Factura</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="ipt-serie" >Serie</label>
                                <input class="form-control" id="ipt-serie" placeholder="Serie" value="" type="text">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="ipt-number">Número</label>
                                <input class="form-control" id="ipt-number" placeholder="Número" value="" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="ipt-number">Proveedor</label>
                                <autocomplete
                                    ref="autocomplete"
                                    placeholder="Buscar proveedor"
                                    :source="apiSearchProvider"
                                    input-class="form-control"
                                    results-property="data"
                                    :results-display="formattedDisplayProvider"
                                    @selected="selectedProvider">
                                </autocomplete>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label class="sr-only" for="prov-document">Documento</label>
                                <input type="text" id="prov-document" readonly="readonly" class="form-control" v-model="iptProviderReadonly.document" placeholder="Documento" />
                            </div>
                            <div class="col-md-7 form-group">
                                <label class="sr-only" for="prov-name">Nombre</label>
                                <input type="text" id="prov-name" readonly="readonly" class="form-control" v-model="iptProviderReadonly.name" placeholder="Nombre y/o Razón Social" />
                            </div>
                            <div class="col-md-2 form-group">
                                <button type="button" class="btn btn-danger" @click.prevent="clearSearchProvider">
                                    <i class="fa fa-rotate-left"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="ipt-date-em" >Fecha de Emisión</label>
                                <input class="form-control" id="ipt-date-em" placeholder="1991-01-01" value="" type="text">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 mb-20">
                    <hr/>
                </div>
            </div>
            <h6 class="hk-sec-title">Agregar</h6>
            <div class="row">
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
            <div class="row">
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
                                <tr v-for="( row, idx ) in formDetails">
                                    <td><img class="w-80p" :src="row.image" alt="icon" /></td>
                                    <th scope="row">{{ row.name }}</th>
                                    <td>
                                        <input v-model="row.priceUnit" type="number" class="normal" value="1" min="0" max="1000" step="any" />
                                    </td>
                                    <td>
                                        <input v-model="row.quantity" type="number" class="normal" value="1" min="0" max="100" step="any" />
                                    </td>
                                    <td class="text-dark">{{ subTotalItem( idx ) }}</td>
                                    <td>
                                        <button type="button" class="close" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="2">
<!--                                        <div class="input-group">-->
<!--                                            <input type="text" class="form-control filled-input" placeholder="Enter coupon code">-->
<!--                                            <div class="input-group-append">-->
<!--                                                <button class="btn btn-primary" type="button">Apply</button>-->
<!--                                            </div>-->
<!--                                        </div>-->
                                    </td>
                                    <td class="text-right" colspan="2">
<!--                                        <small class="pr-5 text-muted font-weight-500">Discount:</small>-->
<!--                                        <span class="text-dark font-weight-500">$15</span>-->
                                    </td>
                                    <td class="text-right">
                                        <small class="pr-5 text-muted font-weight-500">Sub Total:</small>
                                    </td>
                                    <td class="text-right">
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
                                            <th class="w-30" scope="row">S/{{ subTotal }}</th>
                                        </tr>
                                        <tr>
                                            <td class="w-70">IGV 18%</td>
                                            <td class="w-30">S/{{ igv }}</td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr class="bg-light">
                                            <th class="text-dark text-uppercase" scope="row">To Pay</th>
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
    </div>
</template>

<script>
    import Autocomplete from 'vuejs-auto-complete';
    export default {
        name: "purchase-form",
        components: {
            Autocomplete
        },
        data() {
            return {
                urlProject: URL_PROJECT,
                formTypeVoucher: 0,
                formProviderId: 0,
                formDetails: [],
                iptProviderReadonly: {
                    'name': '',
                    'document': ''
                },
                selectedProduct: {
                    id: 0,
                    quantity: 0,
                    priceUnit: 0,
                    name: ''
                }
            }
        },
        computed: {
            subTotal() {
                let subTotal = 0;

                this.formDetails.map( function ( e ) {
                    let quantity = parseFloat( e.quantity );
                    let priceUnit = parseFloat( e.priceUnit );
                    let totalItem = quantity * priceUnit;

                    subTotal += totalItem;
                });

                return subTotal.toFixed( 2 );
            },
            igv() {
                let igv = 0;
                if( parseInt( this.formTypeVoucher ) === 5 ) {
                    igv = (0.18 * this.subTotal);
                }

                return igv.toFixed( 2 );
            },
            total() {
                let total = ( parseFloat( this.subTotal ) + parseFloat(this.igv ) );

                return total.toFixed( 2 );
            }
        },
        methods: {
            clearSearchProvider() {
                this.formProviderId = 0;
                this.iptProviderReadonly.name = '';
                this.iptProviderReadonly.document = '';
            },
            clearSeachProduct(){
                if( this.selectedProduct.id > 0 ) {
                    this.selectedProduct.id = 0;
                    this.selectedProduct.quantity = 0;
                    this.selectedProduct.priceUnit = 0;
                    this.selectedProduct.name = '';
                    this.$refs.autocompleteProduct.clear();
                }
            },
            apiSearchProvider( input ){
                return this.urlProject + '/provider/search/?search=' + input;
            },
            apiSearchProduct( input ) {
                return this.urlProject + '/product/search/?search=' + input;
            },
            formattedDisplayProvider( result ) {
                return result.typeDocument + ' ' + result.document + ' - ' + result.name;
            },
            formattedDisplayProduct( result ) {
                return result.sku + ' - ' + result.category + ' ' + result.product + ' ' + result.name;
            },
            selectedProvider( evt ) {
                let selected = evt.selectedObject;
                this.formProviderId = selected.id;
                this.iptProviderReadonly.name = selected.name;
                this.iptProviderReadonly.document = selected.typeDocument + ' ' + selected.document;
                this.$refs.autocomplete.clear();
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
            subTotalItem( idx ) {
                let pu = parseFloat( this.formDetails[ idx ].priceUnit ),
                    quantity = parseFloat( this.formDetails[ idx ].quantity ),
                    subtotal = pu * quantity;

                return subtotal.toFixed( 2 );
            }
        },
    }
</script>

<style scoped>

</style>
