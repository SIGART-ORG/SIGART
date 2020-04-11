<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Registro de requerimiento</h5>
            <div class="mw-100 mb-15 d-flex justify-content-around">
                <button class="btn btn-xs btn-outline-primary">
                    <i class="fa fa-save"></i> Guardar
                </button>
                <button class="btn btn-xs btn-outline-danger">
                    <i class="fa fa-close"></i> Cancelar
                </button>
            </div>
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
                <div class="col-md-4 form-group">
                    <label for="ipt-quantity" class="sr-only">Cantidad</label>
                    <input class="form-control" v-model="selectedProduct.quantity" id="ipt-quantity"
                           placeholder="Cantidad" value="" type="text">
                </div>
                <div class="col-md-2 form-group">
                    <div class="mw-100 d-flex justify-content-around">
                        <button type="button" class="btn btn-danger mb-2 btn-xs"
                                :class="selectedProduct.id == 0 ? 'disabled' : ''"
                                @click.prevent="clearSeachProduct()"
                        >
                            <i class="fa fa-fw fa-lg fa-close"></i>
                        </button>
                        <button type="button" class="btn btn-primary mb-2 btn-xs"
                                :class="selectedProduct.id == 0 || selectedProduct.quantity == 0 || selectedProduct.priceUnit == 0 ? 'disabled' : ''"
                                @click.prevent="addProduct"
                        >
                            <i class="fa fa-fw fa-lg fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                <tr>
                                    <th>SKU</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                </tr>
                                <tr v-for="row in requirementsDetails">
                                    <td><strong>{{ row.sku }}</strong></td>
                                    <th scope="row">
                                        {{ row.name }}
                                    </th>
                                    <td>
                                        <input v-model.number="row.quantity" type="text" class="normal mw-75p"
                                               min="0" max="100"/>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import Autocomplete from 'vuejs-auto-complete';
    import { mapMutations } from 'vuex';
    export default {
        name: "ServiceTool",
        data() {
            return {
                urlProject: URL_PROJECT,
                selectedProduct: {
                    id: 0,
                    quantity: 0,
                    name: '',
                    sku: ''
                }
            }
        },
        components: {
            Autocomplete,
        },
        methods: {
            ...mapMutations(['CHANGE_PAGE', 'ADD_DETAILS']),
            clearSeachProduct() {
                if (this.selectedProduct.id > 0) {
                    this.selectedProduct.id = 0;
                    this.selectedProduct.quantity = 0;
                    this.selectedProduct.sku = '';
                    this.selectedProduct.name = '';
                    this.$refs.autocompleteProduct.clear();
                }
            },
            apiSearchProduct(input) {
                return this.urlProject + '/product/tool/search/?search=' + input;
            },
            formattedDisplayProduct(result) {
                return result.sku + ' - ' + result.name;
            },
            selectProduct(evt) {
                let selected = evt.selectedObject;
                this.selectedProduct.id = selected.id;
                this.selectedProduct.sku = selected.sku;
                this.selectedProduct.name = selected.name;
            },
            addProduct() {
                if (this.selectedProduct.id > 0) {
                    this.ADD_DETAILS({
                        id: this.selectedProduct.id,
                        name: this.selectedProduct.name,
                        sku: this.selectedProduct.sku,
                        quantity: parseFloat(this.selectedProduct.quantity),
                    });
                    this.clearSeachProduct();
                }
            },
        },
        computed: {
            requirementsDetails: {
                get: function() {
                    return this.$store.state.Requirement.requirementsDetails;
                },
                set: function( newValue ) {
                    this.$store.state.Requirement.requirementsDetails = newValue;
                }
            }
        }
    }
</script>

<style scoped>

</style>
