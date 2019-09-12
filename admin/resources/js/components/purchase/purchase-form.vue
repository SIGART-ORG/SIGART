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
                                <select class="form-control custom-select d-block w-100" id="cbo-type-voucher">
                                    <option value="">Seleccionar...</option>
                                    <option>United States</option>
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
                <div class="col-md-8 form-group">
                    <label for="ipt-prod" class="sr-only">Producto</label>
                    <input class="form-control" id="ipt-prod" placeholder="Producto" value="" type="text">
                </div>
                <div class="col-md-2 form-group">
                    <label for="ipt-quantity" class="sr-only">Cantidad</label>
                    <input class="form-control" id="ipt-quantity" placeholder="Cantidad" value="" type="text">
                </div>
                <div class="col-md-2 form-group">
                    <button type="button" class="btn btn-primary mb-2">
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
                                    <th colspan="2">Product</th>
                                    <th>Price</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td><img class="w-80p" src="dist/img/product-thumb1.png" alt="icon" /></td>
                                    <th scope="row">Apple iPhone8 - 32GB</th>
                                    <td>$1240</td>
                                    <td>
                                        <input type="number" class="normal" value="1" min="0" max="100" step="10" />
                                    </td>
                                    <td class="text-dark">$1240</td>
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
                                        <div class="input-group">
                                            <input type="text" class="form-control filled-input" placeholder="Enter coupon code">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">Apply</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right" colspan="2"><small class="pr-5 text-muted font-weight-500">Discount:</small><span class="text-dark font-weight-500">$15</span></td>
                                    <td class="text-right" colspan="2"><small class="pr-5 text-muted font-weight-500">Sub Total:</small><span class="text-dark font-weight-500">$859</span></td>
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
                                            <th class="w-30" scope="row">$859</th>
                                        </tr>
                                        <tr>
                                            <td class="w-70">Offers Discount</td>
                                            <td class="w-30">$89</td>
                                        </tr>
                                        <tr>
                                            <td class="w-70">Packging charges</td>
                                            <td class="w-30">$8</td>
                                        </tr>
                                        <tr>
                                            <td class="w-70">Tax</td>
                                            <td class="w-30">18%</td>
                                        </tr>
                                        <tr>
                                            <td class="w-70 text-success">Delivery charges</td>
                                            <td class="w-30 text-success">Free</td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr class="bg-light">
                                            <th class="text-dark text-uppercase" scope="row">To Pay</th>
                                            <th class="text-dark font-18" scope="row">$1245</th>
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
                formProviderId: 0,
                iptProviderReadonly: {
                    'name': '',
                    'document': ''
                }
            }
        },
        methods: {
            clearSearchProvider() {
                this.formProviderId = 0;
                this.iptProviderReadonly.name = '';
                this.iptProviderReadonly.document = '';
            },
            apiSearchProvider( input ){
                return this.urlProject + '/provider/search/?search=' + input;
            },
            formattedDisplayProvider( result ) {
                return result.typeDocument + ' ' + result.document + ' - ' + result.name;
            },
            selectedProvider( evt ) {
                let selected = evt.selectedObject;
                this.formProviderId = selected.id;
                this.iptProviderReadonly.name = selected.name;
                this.iptProviderReadonly.document = selected.typeDocument + ' ' + selected.document;
                this.$refs.autocomplete.clear();
            }
        },
    }
</script>

<style scoped>

</style>
