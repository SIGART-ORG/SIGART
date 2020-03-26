<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title text-center">
                Detalle de servicio - <strong>{{ serviceData.document }}</strong><br>
                <status-sigart section="service" :status="serviceData.status"></status-sigart>
            </h5>
            <h6 class="text-center">
                <span class="badge badge-warning" v-if="serviceData.orderPay === 3">Orden de pago generada</span>
            </h6>
            <div class="row" v-if="serviceData.status === 5">
                <div class="col-md-12 d-flex justify-content-around mb-10 p-3">
                    <button class="btn btn-outline-primary" @click.prevent="sendPay">
                        <i class="fa fa-check-circle"></i> Generar orden de pago
                    </button>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import statusSigart from './general/status';
    export default {
        name: "ServiceData",
        components: {
            statusSigart
        },
        created() {
            this.$store.dispatch( 'loadDetailService' );
        },
        computed: {
            serviceData: {
                get:function () {
                    return this.$store.state.Service.serviceDetail;
                }
            }
        },
        methods: {
            sendPay() {
                let me = this;
                let text = "Se generará y enviará la orden de pago al cliente " + me.serviceData.customer.name;
                text += " por el servicio " + me.serviceData.document + "!";

                swal({
                    title: "Estas seguro?",
                    text: text,
                    icon: "warning",
                    buttons: {
                        generate: {
                            text: 'Generar',
                            value: true
                        },
                        cancel: 'Cancelar'
                    },
                    dangerMode: true,
                }).then( (value) => {
                    if ( value ) {
                        this.$store.dispatch( 'generatePay' ).then( result => {
                            if( result ) {
                                swal("Se realizó correctamente la operación.", {
                                    icon: "success",
                                });
                                this.$store.dispatch( 'loadDetailService' );
                            } else {
                                swal("Ocurrio un error al realizar la operación, consulte con su administrador.", {
                                    icon: "error",
                                });
                            }
                        }).catch( errors => {
                            console.log( errors );
                            swal("Ocurrio un error al realizar la operación, consulte con su administrador.", {
                                icon: "error",
                            });
                        });
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
