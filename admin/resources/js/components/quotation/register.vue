<template>
    <div>
        <div class="row">
            <div class="col-sm">
                <form class="form-inline" id="quoteReg" data-vv-scope="quoteReg">
                    <div class="form-row align-items-center w-100 mw-100">
                        <div class="col-md-6 col-xs-12" style="max-width: 50%;min-width: 50%;">
                            <label class="sr-only" for="inlineProv">Name</label>
                            <select class="form-control mb-2" name="proveedor" v-model="quotationId" id="inlineProv"
                                    :disabled="blockSavePR || status === 3"
                                    style="width: 100%"
                                    v-validate="{ required: true, excluded:0 }"
                                    :class="{'is-invalid': errors.has('quoteForm.proveedor')}"
                            >
                                <option value="0" disabled selected hidden >Proveedor</option>
                                <option v-for="pro in arrProvider" v-bind:value="pro.id" v-text="pro.name" :key="pro.id"></option>
                            </select>
                            <span v-show="errors.has('quoteReg.proveedor')" class="text-danger">{{ errors.first('quoteReg.proveedor') }}</span>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <button v-if="!inProccess" type="button" class="btn btn-primary mb-2" @click="selectQuotation( $event )" :disabled="status === 3">
                                <i class="fa fa-save"></i>&nbsp;Seleccionar Cotización
                            </button>
                            <button v-if="inProccess" type="button" class="btn btn-primary mb-2" @click="regQuotation( $event )">
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
        <div class="row" v-if="inProccess">
            <div class="col-sm">
                <form class="form-inline" id="uploadExcel" data-vv-scope="uploadExcel">
                    <div class="form-row align-items-center w-100 mw-100">
                        <div class="col-md-6 col-xs-12">
                            <label class="sr-only" for="inlineExcel">Excel</label>
                            <input id="inlineExcel" type="file" class="form-control-file" name="excel"
                                   @change="changeExcel( $event )"
                                   v-if="uploadReady"
                                   v-validate="{ required: true, mimes: ['application/vnd.ms-excel' ,'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'] }"
                            />
                            <span v-show="errors.has('uploadExcel.excel')" class="text-danger">{{ errors.first('uploadExcel.excel') }}</span>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <button type="button" class="btn btn-info mb-2" @click="uploadExcel">
                                <i class="fa fa-upload"></i> Subir Excel
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
                                <td><input type="text" name="precio" v-model="row.unit_price" class="form-control"/></td>
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
    const typePermits     = [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];
    export default {
        name: "quotation-register",
        props: [
            'pr',
            'status'
        ],
        data() {
            return {
                inProccess:     false,
                arrProvider:    [],
                detail:         [],
                comment:        [],
                quotationId:    0,
                general:        [],
                blockSavePR:    false,
                uploadFile:     '',
                uploadReady:    true
            }
        },
        computed: {
            total() {
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
                return $total.toFixed( 2 );
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
                        me.selectQuotationAxios( me.quotationId );
                    }
                });
            },
            selectQuotationAxios( quotation ) {
                let me = this;
                me.inProccess = true;
                me.blockSavePR = true;
                var url = '/quotations/data/' + quotation;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.detail = respuesta.response.details;
                    me.comment = respuesta.response.comment;
                }).catch(function ( error ) {
                    console.log( error );
                });
            },
            calculateSubTotal( cantidad, precunit ) {
                if( cantidad === "" ){
                    cantidad = 0;
                }
                if( precunit === ""){
                    precunit = 0;
                }
                cantidad = parseInt( cantidad );
                precunit = parseFloat( precunit );

                var sub_total = parseFloat( cantidad * precunit );
                return sub_total.toFixed( 2 );
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
                this.blockSavePR    = false;
                this.detail         = [];
                this.comment        = '';
                this.quotationId    = 0;
                this.general        = [];
                this.uploadFile     = ''
            },
            changeExcel( event ) {
                let fileName        = event.target.files[0];
                if( typePermits.includes( fileName.type ) ){
                    this.uploadFile = fileName;
                }
            },
            uploadExcel() {
                this.$validator.validateAll('uploadExcel').then((result) => {
                    if (result) {
                        let me = this,
                            url = '/purchase-request/' + me.quotationId + '/upload/';

                        let formData = new FormData();
                        formData.append('file-upload', me.uploadFile );

                        axios.post( url, formData ).then( function( result ) {

                            let resp = result.data;
                            if( resp.status ) {
                                me.selectQuotationAxios( me.quotationId );
                                me.uploadReady = false
                                me.$nextTick(() => {
                                    me.uploadReady = true
                                })
                            }

                        }).catch( function( errors ) {
                            console.log( errors );
                        });
                    }
                });
            }
        },
        mounted() {
            this.list();
        }
    }
</script>

<style scoped>

</style>
