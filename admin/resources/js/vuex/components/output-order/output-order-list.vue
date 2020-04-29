<template>
    <div>
        <div class="row">
            <div class="col-sm">
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 sales__table">
                            <thead>
                            <tr>
                                <th>Servicio</th>
                                <th>Requerimiento</th>
                                <th>Venta</th>
                                <th>Materiales / Herramientas</th>
                                <th>Registro</th>
                                <th>Estado</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="row in outputs" :key="row.id">
                                <td v-text="row.service.document"></td>
                                <td v-text="row.serviceRequirement.document"></td>
                                <td>---</td>
                                <td v-text="row.items"></td>
                                <td v-text="row.register"></td>
                                <td></td>
                                <td>
                                    <button class="btn btn-xs btn-outline-info">
                                        <i class="fa fa-send"></i> Entregar
                                    </button>
                                    <button class="btn btn-xs btn-outline-danger">
                                        <i class="fa fa-trash"></i> Entregar
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapMutations } from 'vuex';
    export default {
        name: "output-order-list",
        created() {
            this.$store.dispatch( 'loadOutputsOrders' );
        },
        methods: {

        },
        computed: {
            outputs: {
                get: function () {
                    return this.$store.state.OutputOrder.outputs;
                }
            }
        }
    }
</script>

<style scoped>

</style>
