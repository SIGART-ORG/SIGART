<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Referencias</h5>
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
            <h6 class="hk-sec-title">Listado</h6>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Tipo de comp.</th>
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
                                    <td></td>
                                    <td v-text="row.document"></td>
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import { mapMutations } from 'vuex';
    import Sale from "../../modules/sale";
    export default {
        name: "sale-list",
        data() {
            return {
                search: ''
            }
        },
        computed: {
            sales() {
                return this.$store.state.Sale.sales;
            }
        },
        methods: {
            ...mapMutations(['LOAD_SALES']),
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
            }
        },
        created() {
            this.list( 1 );
        }
    }
</script>

<style scoped>

</style>
