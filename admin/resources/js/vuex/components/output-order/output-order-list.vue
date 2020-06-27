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
                                <th>Trabajador - recepción</th>
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
                                <td>{{ row.user.name }}</td>
                                <td v-text="row.register"></td>
                                <td>
                                    <span class="badge badge-primary" v-if="row.stage === 0">Recepcionado</span>
                                    <span class="badge badge-warning" v-if="row.stage === 1">Por Entregar</span>
                                    <span class="badge badge-warning" v-if="row.stage === 2">Entregado</span>
                                    <span class="badge badge-warning" v-if="row.stage === 3">Devuelto</span>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-outline-info" v-if="row.stage !== 2" @click="prepare( row.id )">
                                        <i class="fa fa-spinner"></i> Preparar
                                    </button>
                                    <button class="btn btn-xs btn-outline-danger">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                    <button class="btn btn-xs btn-outline-primary" v-if="row.stage !== 2 && row.stage !== 3" @click="deliver( row.id )">
                                        <i class="fa fa-send"></i> Entregar
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
                    <label class="col-md-3 form-control-label">Recepcionista <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <v-select name="Recepcionista" data-vv-value-path="mutableValue"  label="name" :options="arrUser" v-validate="{required: true}" @input="updateUser"></v-select>
                        <span v-show="errors.has('Recepcionista')" class="text-danger">{{ errors.first('Recepcionista') }}</span>
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
                                            <input type="number" :name="'Cantidad-' + key" v-model="det.deliveredQuantity" v-validate="{required: true, min_value:0, max_value: det.stock }" class="form-control" />
                                            <span v-show="errors.has('Cantidad-' + key)" class="text-danger">{{ errors.first('Cantidad-' + key) }}</span>
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
                modalTitle: '',
            }
        },
        created() {
            this.$store.dispatch( 'loadOutputsOrders' );
        },
        methods: {
            ...mapMutations(['CHANGE_OUTPUT_ID']),
            deliver( id ) {
                let me = this;
                me.CHANGE_OUTPUT_ID( id );
                me.$store.dispatch( 'sendOutputorder' ).then( response => {
                    if( response.status ) {
                        me.$store.dispatch('loadOutputsOrders');
                    }
                });
            },
            prepare( id ) {
                let _this = this;
                this.CHANGE_OUTPUT_ID( id );
                this.$store.dispatch('loadUser');
                this.$store.dispatch( 'loadDetails' ).then( response => {
                    if( response ) {
                        _this.modalTitle = 'Verificar Orden de salida - ' + _this.output.document;
                        _this.$refs['modal-detail'].show();
                    }
                });
            },
            updateUser( input ) {
                this.output.userOutput = input.id;
            },
            processForm( e ) {
                e.preventDefault();
                let me = this;
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if( me.outputsDetails.length > 0 ) {
                             this.$store.dispatch( 'saveOutputorder' ).then( response => {
                                 if( response.status ) {
                                     me.$store.dispatch('loadOutputsOrders');
                                     me.$refs['modal-detail'].hide();
                                 }
                             });
                        }
                    }
                });
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
            arrUser() {
                return this.$store.state.User.users;
            },
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
