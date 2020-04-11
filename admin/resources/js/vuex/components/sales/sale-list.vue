<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Comprobantes de venta</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input @keyup="list( 1 )" class="form-control mb-2" id="inlineFormInput" placeholder="Buscar..."
                                       type="text" v-model="search">
                            </div>
                            <div class="col-auto">
                                <button @click.prevent="list( 1 )" class="btn btn-primary mb-2" type="submit">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                            <div class="col-auto">
                                <button @click.prevent="newSale" class="btn btn-primary mb-2" type="submit">
                                    <i class="fa fa-fw fa-lg fa-plus-circle"></i>&nbsp;&nbsp;Nueva
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="hk-sec-wrapper">
            <div class="row mb-20">
                <div class="col-sm">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" :class="navtab === 'sales' ? 'active' : ''" href="#sales" @click="changeTabv2( 'sales' )">Comprobantes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" :class="navtab === 'vouchers' ? 'active' : ''" href="#vouchers" @click="changeTabv2( 'vouchers' )">Vouchers enviados</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 sales__table" v-if="navtab === 'sales'">
                                <thead>
                                <tr>
                                    <th>Comprobante</th>
                                    <th>Cliente</th>
                                    <th>Servicio</th>
                                    <th>Costo Servicio</th>
                                    <th>Sub Total</th>
                                    <th>I.G.V</th>
                                    <th>Total</th>
                                    <th>Documentos</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="row in sales" :key="row.id">
                                    <td>
                                        <small><strong v-text="row.typeDocument"></strong></small>
                                        {{ row.document }}
                                    </td>
                                    <td v-text="row.customer.name"></td>
                                    <td v-text="row.service.document"></td>
                                    <td v-text="row.service.total"></td>
                                    <td v-text="row.subtotal"></td>
                                    <td v-text="row.igv"></td>
                                    <td v-text="row.total"></td>
                                    <td>
                                        <a class="btn btn-xs btn-outline-danger" :href="row.pdf" v-if="row.pdf" target="_blank">
                                            <i class="fa fa-file-pdf-o"></i> PDF
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-outline-danger" @click="generatePDF( row.newPdf )">
                                            <i class="fa fa-rotate-left"></i> Generar PDF
                                        </button>
                                        <br/>
                                        <button class="btn btn-xs btn-outline-info">
                                            <i class="fa fa-send"></i> Enviar a Mail
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table table-hover mb-0 sales__table" v-if="navtab === 'vouchers'">
                                <thead>
                                <tr>
                                    <th>Envio</th>
                                    <th>Servicio</th>
                                    <th>N° Operación</th>
                                    <th>Monto</th>
                                    <th>Voucher</th>
                                    <th>Estado</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="row in vouchers" :key="row.id">
                                    <td v-text="row.register"></td>
                                    <td v-text="row.service.document"></td>
                                    <td v-text="row.numberOper"></td>
                                    <td v-text="row.mount"></td>
                                    <td>
                                        <div class="media" @click="mediaImage( row )">
                                            <img :src="row.file" class="mr-3 sales__image-gallery" :alt="row.numberOper" />
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-info" v-if="row.isValid === 0">Por validar</span>
                                        <span class="badge badge-success" v-if="row.isValid === 1">validado</span>
                                        <span class="badge badge-danger" v-if="row.isValid === 2">No Valido</span>
                                        <span class="badge badge-primary" v-if="row.isValid === 3">Comprobante<br>Generado</span>
                                    </td>
                                    <td>
                                        <div class="mw-100 d-flex justify-content-around">
                                            <button v-if="row.isValid === 0" class="btn btn-outline-info btn-xs" @click.prevent="approved( row )">
                                                <i class="fa fa-check-circle"></i> Validar
                                            </button>
                                            <button v-if="row.isValid === 0" class="btn btn-outline-danger btn-xs" @click.prevent="cancel( row )">
                                                <i class="fa fa-close"></i> No Valido
                                            </button>
                                            <button v-if="row.isValid === 1" class="btn btn-outline-primary btn-xs" @click.prevent="generateVoucher( row )">
                                                <i class="fa fa-money"></i> Generar comprobante
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
        <div class="sales" v-if="modalImage.image !== ''">
            <div id="myModal" class="modal">
                <span class="close" @click.prevent="mediaImageClose">&times;</span>
                <img class="modal-content" id="img01" :src="modalImage.image">
                <div id="caption" v-text="modalImage.caption"></div>
            </div>

        </div>
    </div>
</template>

<script>
    import { mapMutations } from 'vuex';
    import Sale from "../../modules/sale";
    import Voucher from "../../modules/service-voucher";
    export default {
        name: "sale-list",
        data() {
            return {
                search: '',
                navtab: 'sales',
                modalImage: {
                    image: '',
                    caption: ''
                }
            }
        },
        computed: {
            sales() {
                return this.$store.state.Sale.sales;
            },
            vouchers() {
                return this.$store.state.Voucher.vouchers;
            }
        },
        methods: {
            ...mapMutations(['LOAD_SALES', 'CHANGE_VOUCHER_ID']),
            list( page ) {
                let me = this;
                me.$store.dispatch({
                    type: 'loadSales',
                    data: {
                        search: me.search
                    }
                }).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        this.LOAD_SALES( result.records );
                    }
                }).catch( errors => {
                    console.log( errors );
                });
            },
            newSale() {
                location.href = URL_PROJECT + '/sales/new/';
            },
            generatePDF( link ) {
                axios.get( link ).then( response => {
                    this.list( 1 );
                }).catch( errors => {
                    console.log( errors );
                })
            },
            changeTabv2( newtab ) {
                this.navtab = newtab;
                if( newtab === 'vouchers' ) {
                    this.$store.dispatch( 'loadVouchersSend' );
                }
            },
            approved( data ) {
                let me = this;
                let title = 'Estas seguro de aprobar este voucher ' + data.numberOper;
                swal( title, {
                    buttons: {
                        cancel: "Cancelar",
                        catch: {
                            text: "Aprobar",
                            value: true,
                        },
                    },
                }).then((value) => {
                    if(  value ) {
                        me.CHANGE_VOUCHER_ID( data.id );
                        me.$store.dispatch( 'approvedVoucher' ).then( response => {
                            if( response.status ) {
                                this.$store.dispatch( 'loadVouchersSend' );
                            }
                        }).catch( errors => {
                            console.log( errors );
                        });
                    }
                });
            },
            cancel( data ) {
                let me = this;
                let title = 'Estas seguro de invalidar este voucher ' + data.numberOper;
                swal( title, {
                    buttons: {
                        cancel: "Cancelar",
                        catch: {
                            text: "Invalidar",
                            value: true,
                        },
                    },
                }).then((value) => {
                    if(  value ) {
                        me.CHANGE_VOUCHER_ID( data.id );
                        me.$store.dispatch( 'invalidVoucher' ).then( response => {
                            if( response.status ) {
                                this.$store.dispatch( 'loadVouchersSend' );
                            }
                        }).catch( errors => {
                            console.log( errors );
                        });
                    }
                });
            },
            generateVoucher( data ) {
                let code = data.code;
                location.href = '/sales/new/?code=' + code;
            },
            mediaImage( data ) {
                this.modalImage.image = data.file;
                this.modalImage.caption = data.service.document + ' - ' + data.numberOper;
            },
            mediaImageClose() {
                this.modalImage.image = '';
                this.modalImage.caption = '';
            }
        },
        created() {
            this.list( 1 );
        }
    }
</script>

<style scoped>

</style>
