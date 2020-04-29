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
                                <th>Registro</th>
                                <th>Materiales / Herramientas</th>
                                <th>Estado</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="row in requirements" :key="row.id">
                                <td v-text="row.service.document"></td>
                                <td v-text="row.register"></td>
                                <td v-text="row.items"></td>
                                <td>
                                    <span v-if="row.stage === 0" class="badge badge-info">Por enviar</span>
                                    <span v-if="row.stage === 1" class="badge badge-info">Pendiente de entregrar</span>
                                    <span v-if="row.stage === 2" class="badge badge-warning">Preparando<br>Herramientas</span>
                                    <span v-if="row.stage === 3" class="badge badge-primary">Entregado</span>
                                    <span v-if="row.stage === 4" class="badge badge-success">Devuelto</span>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-outline-info" @click="generateOuputOrder( row.id )">
                                        <i class="fa fa-send"></i> Generar Orden de entrega
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
        name: "output-order-requirement",
        created() {
            this.CHANGE_STAGE( 1 );
            this.$store.dispatch( 'listRequirementsByStage' );
        },
        methods: {
            ...mapMutations(['CHANGE_STAGE', 'CHANGE_REQUIREMENT_ID']),
            generateOuputOrder( id ) {
                this.CHANGE_REQUIREMENT_ID( id );
                this.$store.dispatch( 'storeOuputOrder' ).then( response => {
                    if( response.status ) {
                        this.CHANGE_REQUIREMENT_ID( 0 );
                        this.$store.dispatch( 'listRequirementsByStage' );
                    }
                })
            }
        },
        computed: {
            requirements() {
                return this.$store.state.Requirement.requirements;
            }
        }
    }
</script>

<style scoped>

</style>
