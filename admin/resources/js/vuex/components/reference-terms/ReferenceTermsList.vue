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
                                <input type="text" v-model="search" @keyup="list( 1 )" class="form-control mb-2" id="inlineFormInput" placeholder="Buscar...">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="list( 1 )">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
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
                                    <th>Solicitud de servicio</th>
                                    <th>Cotización</th>
                                    <th>Clientes</th>
                                    <th>Requerimientos</th>
                                    <th>Orden de servicio</th>
                                    <th>Adjuntos</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="dato in references" :key="dato.id">
                                    <td class="text-center">
                                        <strong v-text="dato.serviceRequest.document"></strong>
                                        <br>
                                        <span class="badge badge-info mb-10" v-text="dato.serviceRequest.name"></span>
                                        <br/>
                                        <small v-text="dato.serviceRequest.send"></small>
                                    </td>
                                    <td class="text-center">
                                        <strong v-text="dato.saleQuotation.document"></strong>
                                    </td>
                                    <td>
                                        <strong v-text="dato.customer.name"></strong>
                                        <br>
                                        <span class="badge badge-info" v-text="dato.customer.document"></span>
                                    </td>
                                    <td>
                                        <div class="mw-100">
                                            <strong>Administración:</strong>
                                            <br>
                                            <span class="text-primary"><i class="fa fa-check-circle"></i></span> Julio Salsavilca
                                        </div>
                                        <div class="mw-100">
                                            <strong>Dirección General:</strong>
                                            <br>
                                            <span class="text-secondary"><i class="fa fa-check-circle"></i></span> ---
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mw-100">
                                            <strong>Dirección General:</strong>
                                            <br>
                                            <span class="text-danger"><i class="fa fa-close"></i></span> Julio Salsavilca
                                        </div>
                                        <div class="mw-100">
                                            <strong>Cliente:</strong>
                                            <br>
                                            <span class="text-secondary"><i class="fa fa-check-circle"></i></span> ---
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
        name: "ReferenceTermsList",
        data() {
            return {
                search: ''
            }
        },
        methods: {
            list( page ) {

            }
        },
        computed: {
            references() {
                return this.$store.state.Referenceterm.referenceTerms;
            }
        },
        created() {
            this.$store.dispatch( 'loadReferences' );
        }
    }
</script>

<style scoped>

</style>
