<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">{{ headboard.provider }}</h5>
            <p class="mb-25">Enviado: <b>{{ headboard.create }}</b></p>
            <div class="row">
                <div class="col-sm">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" :class="navtab === 'detail' ? 'active' : ''" href="#req" @click="changeTab( 'detail' )">Detalle</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" :class="navtab === 'attach' ? 'active' : ''" href="#solc" @click="changeTab( 'attach' )">Adjunto</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"><hr/></div>
            </div>
            <div class="row" v-if="navtab === 'detail'">
                <div class="col-sm">
                    <div class="tile">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Prec. Unit</th>
                                    <th>Sub - Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(row, idx) in arrData" :key="row.id">
                                    <td v-text="idx + 1"></td>
                                    <td>{{ row.products }} - {{ row.presentation }}</td>
                                    <td>{{ row.quantity }}</td>
                                    <td>{{ row.unit_price }}</td>
                                    <td>{{ row.total }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="navtab === 'attach'">
                <div class="col-sm">
                    <div class="tile">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Commentario:</th>
                                    <th>{{ comment }}</th>
                                </tr>
                                <tr v-if="attach != ''">
                                    <th>Adjunto</th>
                                    <th>{{ attach }}</th>
                                </tr>
                                </thead>
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
        name: "detail",
        data() {
            return {
                navtab:     'detail',
                headboard:  [],
                arrData:    [],
                comment:    '',
                attach:     ''
            }
        },
        props: [
            'quotation'
        ],
        methods: {
            list() {
                let me = this,
                    url = '/quotations/data/' + me.quotation;

                axios.get( url, {
                    params: {
                        selected: 1
                    }
                }).then( function( result ) {
                    let response = result.data.response;
                    me.headboard = response.headboard;
                    me.arrData = response.details;
                    me.comment  = response.comment;
                    me.attach   = response.attach
                }).catch( function ( errors ) {
                    console.log( errors );
                    swal(
                        'Error! :(',
                        'No se pudo realizar la operación',
                        'error'
                    );
                });
            },
            changeTab( tab ) {
                this.navtab = tab;
            },
        },
        mounted() {
            this.list();
        }
    }
</script>

<style scoped>

</style>
