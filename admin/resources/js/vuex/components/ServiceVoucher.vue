<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Comprobantes de pago</h5>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Comprobante</th>
                                    <th>Emisión</th>
                                    <th>Sub-Total</th>
                                    <th>IGV</th>
                                    <th>Total</th>
                                    <th>Docs</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="( e, i ) in vouchers" :key="e.id">
                                    <td v-text="i + 1"></td>
                                    <td>
                                        {{ e.typeDocument }}: <strong class="text-primary" v-text="e.document"></strong>
                                    </td>
                                    <td><small v-text="e.emission"></small></td>
                                    <td class="text-right">{{ e.subTotal | formatPrice }}</td>
                                    <td class="text-right">{{ e.igv | formatPrice }}</td>
                                    <td class="text-right">{{ e.total | formatPrice }}</td>
                                    <td>
                                        <div class="mw-100 d-flex justify-content-around mb-10 p-3">
                                            <a v-if="e.attachment !== ''" :href="e.attachment" target="_blank" class="text-info font-14"><i class="fa fa-file-o"></i> Ver Comp.</a>
                                            <a href="javascript:;" class="text-danger font-14"><i class="fa fa-file-pdf-o"></i> Ver PDF</a>
                                        </div>
                                        <div class="mw-100 d-flex justify-content-around">
                                            <button v-if="e.attachment === ''" class="btn btn-outline-info btn-xs" title="Subir Documentos" @click="modalUploadVoucher( e.id )">
                                                <i class="fa fa-upload"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-xs">
                                                <i class="fa fa-file-pdf-o"></i>&nbsp;PDF
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <b-modal ref="upload-voucher" title="Subir voucher" @ok="uploadVoucher" @cancel="closeModalUpload" @hide="closeModalUpload">
            <form>
                <div class="form-group">
                    <label for="voucher">Voucher</label>
                    <input type="file" id="voucher" name="image" class="form-control" placeholder="..."
                           v-validate.reject="'image'" @change="validateImage( $event )"
                    >
                    <div class="form-control-feedback mt-1 p-2 rounded alert-danger" v-show="errors.has( 'image:image' )">
                        solo suba los tipos de archivos de imagen.
                    </div>
                    <div class="form-control-feedback mt-1 p-2 rounded alert-danger" v-show="errorImageDimension">
                        La imagen debe tener entre 1204 y 1204 px
                    </div>
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
    import { mapMutations } from 'vuex';
    export default {
        name: "ServiceVoucher",
        created() {
            this.$store.dispatch( 'loadVouchers' );
        },
        data() {
            return {
                idVoucher: 0,
                imageInput: {},
                errorImageDimension: false
            }
        },
        computed: {
            summary: {
                get:function() {
                    return this.$store.state.Sale.serviceSummary;
                }
            },
            vouchers: {
                get:function() {
                    return this.$store.state.Sale.serviceVoucher;
                }
            }
        },
        methods: {
            ...mapMutations(['SET_FILE']),
            modalUploadVoucher( id ) {
                this.idVoucher = id;
                this.$refs['upload-voucher'].show();
            },
            validateImage( event ) {
                let url = window.URL || window.URL;
                this.imageInput = event.target.files[0];
                let img = new Image();
                img.src = url.createObjectURL( this.imageInput );
                img.onload = () => {
                    url.revokeObjectURL( img.src );
                    if( img.naturalWidth > 1204 || img.naturalHeight > 1204 ) {
                        this.errorImageDimension = true;
                    } else {
                        this.errorImageDimension = false;
                    }
                }
            },
            uploadVoucher() {
                let idVoucher = this.idVoucher;
                this.$validator.validateAll().then( (result) => {
                    if( !result || _.isEmpty( this.imageInput.name )) return;

                    this.$store.commit(
                        'SET_FILE',
                        { value: this.imageInput }
                    );

                    this.$store.dispatch({
                        type: 'uploadVoucher',
                        data: {
                            idVoucher: idVoucher
                        }
                    }).then( response => {
                        let result = response.data;
                        if( result.status ) {
                            this.$store.dispatch( 'loadVouchers' );
                        }
                    });

                })
            },
            closeModalUpload() {
                this.idVoucher = 0;
                this.$refs['upload-voucher'].hide();
            }
        }
    }
</script>

<style scoped>

</style>
