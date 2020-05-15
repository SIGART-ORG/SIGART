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
                                    <span class="badge badge-warning" v-if="row.stage === 1">Por Entregar</span>
                                    <span class="badge badge-warning" v-if="row.stage === 2">Entregado</span>
                                    <span class="badge badge-warning" v-if="row.stage === 3">Devuelto</span>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-outline-info" v-if="row.stage === 2" @click="prepare( row.id )">
                                        <i class="fa fa-spinner"></i> Ingresar Herramientas
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
                    <div class="col-md-12">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 sales__table">
                                    <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Producto</th>
                                        <th>Stock</th>
                                        <th>Entregado</th>
                                        <th class="w-20">Cantidad</th>
                                        <th>Comentario</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="( det, key ) in outputsDetails" :key="det.id">
                                        <td>
                                            <small v-text="det.sku"></small>
                                        </td>
                                        <td v-text="det.product"></td>
                                        <td v-text="det.stock"></td>
                                        <td v-text="det.deliveredQuantity"></td>
                                        <td>
                                            <input type="number" :name="'Cantidad-' + key" v-model="det.giveBack" v-validate="{required: true, min_value:0, max_value: det.deliveredQuantity }" min="0" :max="det.deliveredQuantity" class="form-control" />
                                            <span v-show="errors.has('Cantidad-' + key)" class="text-danger">{{ errors.first('Cantidad-' + key) }}</span>
                                        </td>
                                        <td>
                                            <textarea v-model="det.comment" class="form-control"></textarea>
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
    export default {
        name: "output-orders",
        data() {
            return {
                modalTitle: '',
                output: {},
                outputs: [],
                outputsDetails: []
            }
        },
        watch: {
            outputsDetails: {
                handler: function( newVal, oldval ) {
                    this.outputsDetails.forEach( p => {
                        p.comment = '';
                        p.giveBack = p.deliveredQuantity;
                    })
                }, deep: false
            }
        },
        methods: {
            loadOutputs: function() {
                let url = '/output-orders/?type=delivered';
                axios.get( url ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        this.outputs = result.outputorders;
                    }
                });
            },
            prepare( id ) {
                let _this = this;
                let url = '/output-orders/' + id + '/details/';
                axios.get( url ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        _this.output = result.outputOrder;
                        _this.outputsDetails = result.details;
                        _this.modalTitle = 'Verificar Devolución de herramientas - ' + _this.output.document;
                        _this.$refs['modal-detail'].show();
                    }
                }).catch( errors => {
                    console.log( errors );
                })
            },
            processForm( e ) {
                e.preventDefault();
                let me = this;
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if( me.outputsDetails.length > 0 ) {
                            me.recordEntryOrder().then( response => {
                                if( response.status ) {
                                    me.resetForms();
                                    me.loadOutputs();
                                    me.$refs['modal-detail'].hide();
                                }
                            }).then( errors => {
                                console.log( errors );
                            });
                        }
                    }
                });
            },
            recordEntryOrder: function() {
                return new Promise(( resolve, reject ) => {
                    let url = '/input-orders/register';
                    axios.post( url, {
                        output: this.output.id,
                        details: this.outputsDetails
                    }).then( response => {
                        let result = response.data;
                        if( result.status ) {
                            resolve( result );
                        } else {
                            reject( result );
                        }
                    }).catch( errors => {
                        reject( errors );
                    })
                });
            },
            resetForms: function() {
                this.output = {};
                this.outputsDetails = [];
                this.modalTitle = '';
            },
            cerrarModal() {
                this.$refs['modal-detail'].hide();
            },
        },
        mounted() {
            this.loadOutputs();
        }
    }
</script>

<style scoped>

</style>
