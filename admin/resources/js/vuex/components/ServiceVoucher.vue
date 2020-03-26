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
                                            <a href="javascript:;" class="text-info font-14"><i class="fa fa-file-o"></i> Ver Comp.</a>
                                            <a href="javascript:;" class="text-danger font-14"><i class="fa fa-file-pdf-o"></i> Ver PDF</a>
                                        </div>
                                        <div class="mw-100 d-flex justify-content-around">
                                            <button class="btn btn-outline-info btn-xs" title="Subir Documentos">
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
    </div>
</template>

<script>
    export default {
        name: "ServiceVoucher",
        created() {
            this.$store.dispatch( 'loadVouchers' );
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
        }
    }
</script>

<style scoped>

</style>
