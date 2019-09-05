<template>
    <div>
        <div class="row">
            <div class="col-sm">
                <form class="form-inline" id="quoteReg" data-vv-scope="quoteReg">
                    <div class="form-row align-items-center" style="min-width: 100%">
                        <div class="col-auto" style="max-width: 50%;min-width: 50%;">
                            <label class="sr-only" for="inlineProv">Name</label>
                            <select class="form-control mb-2" name="proveedor" v-model="quotationId" id="inlineProv"
                                    style="width: 100%"
                                    v-validate="{ required: true, excluded:0 }"
                                    :class="{'is-invalid': errors.has('quoteForm.proveedor')}"
                            >
                                <option value="0" disabled selected hidden >Proveedor</option>
                                <option v-for="pro in arrProvider" v-bind:value="pro.id" v-text="pro.name" :key="pro.id"></option>
                            </select>
                            <span v-show="errors.has('quoteReg.proveedor')" class="text-danger">{{ errors.first('quoteReg.proveedor') }}</span>
                        </div>
                        <div class="col-auto">
                            <button v-if="!inProccess" type="button" class="btn btn-primary mb-2" @click="selectQuotation( $event )">
                                <i class="fa fa-save"></i>&nbsp;Seleccionar Cotización
                            </button>
                            <button v-if="inProccess" type="button" class="btn btn-success mb-2" @click="regQuotation( $event )">
                                <i class="fa fa-save"></i> Registrar Cotización
                            </button>
                            <button v-if="inProccess" type="button" class="btn btn-danger mb-2" @click="cancelQuotation( $event )">
                                <i class="fa fa-rotate-left"></i> Cancelar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row" v-if="detail.length > 0">
            <div class="col-sm-12"><hr/></div>
        </div>
        <div class="row" v-if="detail.length > 0">
            <div class="col-12">
                <div class="tile">
                    <h3 class="tile-title">Registrar cotización {{ general.code }}</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Código:</th>
                                <th>{{ general.code }}</th>
                                <th>Fecha de registro:</th>
                                <th>{{ general.date }}</th>
                                <th colspan="2">{{ general.userName }}<br><small>{{ general.userLastName }}</small></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th class="text-center">Item</th>
                                <th class="text-center">Producto</th>
                                <th class="text-right">Cantidad</th>
                                <th class="text-center">Prec. unit.</th>
                                <th class="text-center">Sub total</th>
                            </tr>
                            <tr v-for="row in detail" :key="row.id">
                                <td v-text=" row.cont "></td>
                                <td>{{ row.products }} {{ row.presentation }}</td>
                                <td v-text="row.quantity"></td>
                                <td><input type="text" name="precio" v-model="row.unit_price" v-on:keyup="addTotal" class="form-control"/></td>
                                <td><input type="text" readonly class="form-control" :value="calculateSubTotal(row.quantity, row.unit_price)"></td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="4" class="text-right"><b>Total:</b></td>
                                <td>
                                    <input type="text" readonly class="form-control" v-model="total">
                                </td>
                            </tr>
                            <tr>
                                <td>Observaciones:</td>
                                <td colspan="4"><textarea class="form-control" v-model="comment"></textarea></td>
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
    export default {
        name: "quotation-register",
        props: [
            'pr'
        ],
        data() {
            return {
                inProccess:     false,
                arrProvider:    [],
                detail:         [],
                comment:        [],
                quotationId:    0,
                total:          0,
                general:        []
            }
        },
        methods: {
            list() {
                let me = this,
                    url = '/quotation/' + me.pr + '/data-providers';

                axios.get( url ).then( function( response ) {
                    let result = response.data;
                    if( result.status ) {
                        me.arrProvider = result.response;
                    }
                }).catch( function( error ) {
                    console.log( error );
                });
            },
            selectQuotation( e ){
                e.preventDefault();
                this.$validator.validateAll('quoteReg').then((result) => {
                    if (result) {
                        let me = this;
                        me.inProccess = true;
                        var url = '/quotations/data/' + me.quotationId;
                        axios.get(url).then(function (response) {
                            var respuesta = response.data;
                            me.detail = respuesta.response.details;
                            me.comment = respuesta.response.comment;
                        }).catch(function (error) {

                        });
                    }
                });
            },
            addTotal() {
                let $total = 0;
                if (typeof this.detail !== 'undefined') {
                    this.detail.forEach(function ( row ) {
                        var cant = parseFloat( row.quantity );
                        var price   = parseFloat( row.unit_price );
                        if( price === "" ){
                            price = 0;
                        }
                        $total += ( cant * price );
                    });
                }
                this.total = $total;
            },
            calculateSubTotal( cantidad, precunit ) {
                if( cantidad == "" ){
                    cantidad = 0;
                }
                if( precunit == ""){
                    precunit = 0;
                }
                cantidad = parseInt( cantidad );
                precunit = parseFloat( precunit );

                var sub_total = parseFloat( ( cantidad * precunit ).toPrecision(3) );
                return sub_total;
            },
            regQuotation( e ) {
                e.preventDefault();
                this.$validator.validateAll('quoteReg').then((result) => {
                    if( result ) {
                        let me = this,
                            url= '/quotations/save/';
                        if( me.quotationId > 0 && me.detail ) {
                            axios.post( url, {
                                'id': me.quotationId,
                                'quotation': me.detail,
                                'comment': me.comment
                            }).then( function ( result ) {
                                let response = result.data;
                                if( response.status ) {
                                    me.cancelQuotation( e );
                                }
                            }).catch( function ( errors ) {
                                console.log( errors );
                            });
                        }
                    }
                });
            },
            cancelQuotation( e ) {
                e.preventDefault();
                this.inProccess     = false;
                this.detail         = [];
                this.comment        = '';
                this.quotationId    = 0;
                this.general        = [];
            }
        },
        mounted() {
            this.list();
        }
    }
</script>

<style scoped>

</style>
