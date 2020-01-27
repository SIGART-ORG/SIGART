<template>
    <div class="col-md-9">
        <div class="row mb-20">
            <div class="col-12 text-center">
                <h2>Generar Listado de Materiales</h2>
                <button class="btn btn-outline-primary btn-xs" :disabled="aListMaterials.length === 0 ? true : false" @click.prevent="generateRequest">
                    Guardar listado de materiales
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-5 custom-border">
                <h6 class="hk-sec-title">Requerimientos</h6>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-20">
                            <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>cantidad</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="serviceRequest.length" v-for="sr in serviceRequest" :key="sr.id">
                                <td v-text="sr.description"></td>
                                <td v-text="sr.quantity"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-7 custom-border">
                <h6 class="hk-sec-title">Materiales</h6>
                <div class="row">
                    <div class="col-10">
                        <autocomplete
                            id="iptProduct"
                            ref="autocompleteProduct"
                            placeholder="Buscar Producto"
                            :source="apiSearchProduct"
                            input-class="form-control form-control-sm"
                            results-property="data"
                            :results-display="formattedDisplayProduct"
                            @selected="selectProduct"
                            @clear="clearSeachProduct">
                        </autocomplete>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary mb-2 btn-xs" @click.prevent="addProduct">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-20">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Stock</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Sub-Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="aListMaterials.length > 0" v-for="( lm, idx ) in aListMaterials">
                                <td>
                                    <small><strong v-text="lm.product.sku"></strong></small>
                                    <br/>
                                    <small v-text="lm.product.category"></small>
                                    <br>
                                    <small v-text="lm.product.name"></small>
                                </td>
                                <td>
                                    <span :class="( lm.stock >= lm.quantity ) ? 'text-info' : 'text-danger'">{{ lm.stock | formatStock( lm.unity ) }}</span>
                                    <br v-if="lm.quantity > lm.stock" />
                                    <small v-if="lm.quantity > lm.stock" class="text-danger">No hay suficientes productos en stock.</small>
                                </td>
                                <td>
                                    <input v-model.number="lm.quantity" type="text" class="normal mw-75p"
                                           min="0" max="1000"/>
                                </td>
                                <td>
                                    <input v-model.number="lm.price" type="text" class="normal mw-75p"
                                           min="0" max="10000"/>
                                </td>
                                <td>{{ lm.subtotal | formatPrice }}</td>
                                <td>
                                    <button type="button" class="close" aria-label="Close" @click.prevent="deleteItem( lm.id )">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">TOTAL:</th>
                                <th colspan="2" class="text-right">{{ total | formatPrice }}</th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Autocomplete from 'vuejs-auto-complete';

    export default {
        name: "sr_list-materials",
        props: ['service'],
        data() {
            return {
                urlProject: URL_PROJECT,
                serviceRequest: [],
                selectedProduct: {
                    id: 0,
                    quantity: 1,
                    priceBuy: 0,
                    name: {},
                    stock: 0,
                    unity: ''
                },
                aListMaterials: []
            }
        },
        components: {
            Autocomplete
        },
        computed: {
            total: function () {
                return this.aListMaterials.reduce((total, item) => {
                    return total + ( parseFloat(item.quantity) * parseFloat(item.price));
                }, 0);
            }
        },
        watch: {
            aListMaterials: {
                handler: function( newVal, oldval ) {
                    this.aListMaterials.forEach( p => {
                        p.subtotal = p.quantity * p.price;
                    })
                }, deep: true
            }
        },
        methods: {
            listMaterials() {
                let me = this;
                let url = '/service_request/list-materials/load/' + me.service;

                axios.get(url).then(response => {
                    let result = response.data;
                    me.serviceRequest = result.records;
                }).catch(errors => {
                    console.log(errors);
                })
            },
            clearSeachProduct() {
                if (this.selectedProduct.id > 0) {
                    this.selectedProduct.id = 0;
                    this.selectedProduct.quantity = 1;
                    this.selectedProduct.priceBuy = 0;
                    this.selectedProduct.name = {};
                    this.selectedProduct.stock = 0;
                    this.selectedProduct.unity = '';
                    this.$refs.autocompleteProduct.clear();
                }
            },
            apiSearchProduct(input) {
                return this.urlProject + '/product/search/?type=buy&search=' + input;
            },
            formattedDisplayProduct(result) {
                return result.sku + ' - ' + result.category + ' ' + result.product + ' ' + result.name;
            },
            selectProduct(evt) {
                let selected = evt.selectedObject;
                this.selectedProduct.id = selected.id;
                this.selectedProduct.name = {
                    sku: selected.sku,
                    category: selected.category,
                    product: selected.product,
                    name: selected.name
                };
                this.selectedProduct.stock = selected.stock;
                this.selectedProduct.unity = selected.unity;
                this.selectedProduct.priceBuy = selected.priceBuy;
            },
            addProduct() {
                if (this.selectedProduct.id > 0) {
                    this.aListMaterials.push({
                        'id': this.selectedProduct.id,
                        'product': this.selectedProduct.name,
                        'presentation': this.selectedProduct.id,
                        'unity': this.selectedProduct.unity,
                        'quantity': this.selectedProduct.quantity ? parseFloat(this.selectedProduct.quantity) : 0,
                        'stock': this.selectedProduct.stock ? parseInt(this.selectedProduct.stock) : 0,
                        'price': this.selectedProduct.priceBuy ? this.selectedProduct.priceBuy : 0
                    });
                    this.clearSeachProduct();
                }
            },
            deleteItem( idRow ) {
                let me = this;
                const clone = me.aListMaterials;
                const filter = (data = [], id) => {
                    return clone.filter(c => c.id !== id);
                };
                me.aListMaterials = filter(clone, idRow);
            },
            generateRequest() {
                if (this.aListMaterials.length > 0) {
                    this.$validator.validateAll().then((result) => {
                        if (result) {
                            let me = this;
                            axios.post('/service_request/list-materials/store/', {
                                'id_service': this.service,
                                'listmatariales': this.aListMaterials
                            }).then(function (response) {
                                swal(
                                    'Exito! :)',
                                    'Se registro correctamente la solicitud de compra.',
                                    'success'
                                )
                            }).catch(function (error) {
                                swal(
                                    'Error! :(',
                                    'Ocurrio un error al intentar realizar la operación.',
                                    'error'
                                )
                            });
                        }
                    });
                } else {
                    swal(
                        'Error! :(',
                        'Debe seleccionar al menos un producto, para poder generar un requerimiento',
                        'error'
                    )
                }
            }
        },
        mounted() {
            this.listMaterials();
        }
    }
</script>

<style scoped>
    .custom-border {
        border: 1px solid #CFCFCF;
    }
</style>
