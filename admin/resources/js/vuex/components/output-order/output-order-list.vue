<template>
    <div>
        <div class="row">
            <div class="col-sm">
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 sales__table">
                            <thead>
                            <tr>
                                <th>Servicio</th>
                                <th>Requerimiento</th>
                                <th>Venta</th>
                                <th>Materiales / Herramientas</th>
                                <th>Registro</th>
                                <th>Estado</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="row in outputs" :key="row.id">
                                <td v-text="row.service.document"></td>
                                <td v-text="row.serviceRequirement.document"></td>
                                <td>---</td>
                                <td v-text="row.items"></td>
                                <td v-text="row.register"></td>
                                <td>
                                    <span class="badge badge-primary" v-if="row.stage === 0">Recepcionado</span>
                                    <span class="badge badge-warning" v-if="row.stage === 1">Preparando</span>
                                    <span class="badge badge-warning" v-if="row.stage === 1">Preparando</span>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-outline-info" @click="deliver( row.id )">
                                        <i class="fa fa-send"></i> Entregar
                                    </button>
                                    <button class="btn btn-xs btn-outline-danger">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <b-modal id="modal-detail" size="lg" ref="modal-detail" :title="modalTitle" @ok="processForm">
            <form @submit.stop.prevent="cerrarModal">
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Nombre <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
<!--                        <input type="text" v-model="nombre" name="nombre" v-validate="'required'" class="form-control" placeholder="Nombre" :class="{'is-invalid': errors.has('nombre')}">-->
<!--                        <span v-show="errors.has('nombre')" class="text-danger">{{ errors.first('nombre') }}</span>-->
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 sales__table">
                                    <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Producto</th>
                                        <th>Stock</th>
                                        <th class="w-20">Cantidad</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="( det, key ) in outputsDetails" :key="det.id">
                                        <td v-text="det.sku"></td>
                                        <td v-text="det.product"></td>
                                        <td v-text="det.stock"></td>
                                        <td>
                                            <input type="number" v-model="det.deliveredQuantity" v-validate="{required: true, min_value:0, max_value: det.quantity }" class="form-control" />
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-danger btn-xs" @click="deleteItem( $event, key, det )">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
    import { mapMutations } from 'vuex';
    export default {
        name: "output-order-list",
        data() {
            return {
                modalTitle: ''
            }
        },
        created() {
            this.$store.dispatch( 'loadOutputsOrders' );
        },
        methods: {
            ...mapMutations(['CHANGE_OUTPUT_ID']),
            deliver( id ) {
                let _this = this;
                this.CHANGE_OUTPUT_ID( id );
                this.$store.dispatch( 'loadDetails' ).then( response => {
                    if( response ) {
                        _this.modalTitle = 'Verificar Orden de salida - ' + _this.output.document;
                        _this.$refs['modal-detail'].show();
                    }
                });
            },
            processForm() {

            },
            cerrarModal() {
                this.$refs['modal-detail'].hide();
            },
            deleteItem( e, key, data ) {
                e.preventDefault();
                swal({
                    title: "Eliminar!",
                    text: "Esta seguro de eliminar este producto - " + data.product + "?",
                    icon: "error",
                    button: "Eliminar"
                }).then((result) => {
                    if (result) {
                        this.outputsDetails.splice( key, 1 );
                    }
                });
            }
        },
        computed: {
            output: {
                get: function () {
                    return this.$store.state.OutputOrder.output;
                },
                set: function( newValue ) {
                    this.$store.state.OutputOrder.output = newValue;
                }
            },
            outputsDetails: {
                get: function () {
                    return this.$store.state.OutputOrder.outputsDetails;
                },
                set: function( newValue ) {
                    this.$store.state.OutputOrder.outputsDetails = newValue;
                }
            },
            outputs: {
                get: function () {
                    return this.$store.state.OutputOrder.outputs;
                }
            }
        }
    }
</script>

<style scoped>

</style>
