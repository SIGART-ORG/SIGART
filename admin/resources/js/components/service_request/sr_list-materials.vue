<template>
    <div class="col-md-12">
        <div class="row mb-20">
            <div class="col-12 text-center">
                <h2>Generar Listado de Materiales</h2>
                <button class="btn btn-outline-primary btn-xs" v-if="status === 1" @click.prevent="generateRequest">
                    Guardar listado de materiales
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 custom-border">
                <h6 class="hk-sec-title">Requerimientos</h6>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-20">
                            <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-if="salesQuotationDetails.length > 0" v-for="( sqd, idx ) in salesQuotationDetails" >
                                <tr class="text-primary" :key="sqd.id">
                                    <td v-text="sqd.description"></td>
                                    <td v-text="sqd.quantity"></td>
                                    <td>{{ sqd.totalProducts | formatPrice}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <table class="table table-hover mb-20">
                                            <thead>
                                            <tr>
                                                <th colspan="5">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <autocomplete
                                                                :ref="'autocompleteProduct' + idx"
                                                                placeholder="Buscar Producto"
                                                                :source="apiSearchProduct"
                                                                input-class="form-control form-control-sm"
                                                                results-property="data"
                                                                :results-display="formattedDisplayProduct"
                                                                @selected="selectProduct"
                                                                @clear="clearSeachProduct( idx )">
                                                            </autocomplete>
                                                        </div>
                                                        <div class="col-2">
                                                            <button type="submit" class="btn btn-primary mb-2 btn-xs" @click.prevent="addProduct( sqd.id, idx )">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Stock</th>
                                                <th>Cantidad</th>
                                                <th>P.U.</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-if="sqd.products.length > 0" v-for="pro in sqd.products" :key="pro.id">
                                                <td v-text="pro.product"></td>
                                                <td>
                                                    <span :class="( pro.stock >= pro.quantity ) ? 'text-info' : 'text-danger'">{{ pro.stock | formatStock( pro.unity ) }}</span>
                                                    <br v-if="pro.quantity > pro.stock" />
                                                    <small v-if="pro.quantity > pro.stock" class="text-danger">No hay suficientes productos en stock.</small>
                                                </td>
                                                <td>
                                                    <input v-model.number="pro.quantity" type="number" class="normal mw-75p"
                                                           min="0" max="1000"/>
                                                </td>
                                                <td>{{ pro.price | formatPrice }}</td>
                                                <td>{{ ( pro.price * pro.quantity )| formatPrice }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
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
                saleQuotation: 0,
                status: 1,
                salesQuotationDetails: [],
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
                    me.salesQuotationDetails = result.records;
                    me.saleQuotation = result.saleQuotation;
                    me.status = result.status;
                }).catch(errors => {
                    console.log(errors);
                })
            },
            clearSeachProduct( idx ) {
                if (this.selectedProduct.id > 0) {
                    let ref = 'autocompleteProduct' + idx;

                    this.selectedProduct.id = 0;
                    this.selectedProduct.quantity = 1;
                    this.selectedProduct.priceBuy = 0;
                    this.selectedProduct.name = {};
                    this.selectedProduct.stock = 0;
                    this.selectedProduct.unity = '';
                    this.$refs[ref][0].clear();
                    // this.$refs.autocompleteProduct.clear();
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
                this.selectedProduct.name = selected.sku + ' - ' + selected.category + ' ' + selected.product + ' ' + selected.name;
                this.selectedProduct.stock = selected.stock;
                this.selectedProduct.unity = selected.unity;
                this.selectedProduct.priceBuy = selected.priceBuy;
            },
            addProduct( qdet, idx ) {
                if (qdet > 0 && this.selectedProduct.id > 0) {

                    this.salesQuotationDetails[idx].products.push({
                        'id': this.selectedProduct.id,
                        'product': this.selectedProduct.name,
                        'presentation': this.selectedProduct.id,
                        'unity': this.selectedProduct.unity,
                        'quantity': this.selectedProduct.quantity ? parseFloat(this.selectedProduct.quantity) : 0,
                        'stock': this.selectedProduct.stock ? parseInt(this.selectedProduct.stock) : 0,
                        'price': this.selectedProduct.priceBuy ? this.selectedProduct.priceBuy : 0
                    });
                    this.clearSeachProduct( idx );
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
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let me = this;
                        axios.post('/service_request/list-materials/store/', {
                            'id_service': this.service,
                            'saleQuotation': this.saleQuotation,
                            'details': this.salesQuotationDetails
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
