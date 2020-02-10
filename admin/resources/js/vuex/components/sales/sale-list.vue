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
                                    <th>Servicio</th>
                                    <th>Sub Total</th>
                                    <th>I.G.V</th>
                                    <th>Total</th>
                                    <th>Monto Pagado</th>
                                </tr>
                                </thead>
                                <tbody>
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
        name: "sale-list",
        data() {
            return {
                search: ''
            }
        },
        methods: {
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
                        me.list( 1 );
                    }
                }).catch( errors => {
                    console.log( errors );
                });
            },
            newSale() {
                location.href = URL_PROJECT + '/sales/new/';
            }
        },
        created() {
            this.list( 1 );
        }
    }
</script>

<style scoped>

</style>
