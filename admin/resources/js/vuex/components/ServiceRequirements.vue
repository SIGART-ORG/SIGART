<template>
    <div>
        <section class="hk-sec-wrapper" v-if="page === 'list'">
            <h5 class="hk-sec-title">Requerimientos</h5>
            <div class="mw-100 mb-15">
<!--            <button class="btn btn-xs btn-outline-primary" @click.prevent="chargeStages" :disabled="!isEditable">-->
                <button class="btn btn-xs btn-outline-primary" @click.prevent="openPage">
                    <i class="fa fa-plus-circle"></i> Nuevo Requerimiento de herramientas
                </button>
            </div>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Requerimiento</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="( e, i ) in requirements" :key="e.id">
                                    <td>
                                        <strong class="text-muted" v-text="e.name"></strong>
                                    </td>
                                    <td v-text="e.register"></td>
                                    <td class="0ddd">
                                        <span v-if="e.stage === 0" class="badge badge-info">Por enviar</span>
                                        <span v-if="e.stage === 1" class="badge badge-info">Pendiente de entregrar</span>
                                        <span v-if="e.stage === 2" class="badge badge-warning">Preparando<br>Herramientas</span>
                                        <span v-if="e.stage === 3" class="badge badge-primary">Entregado</span>
                                        <span v-if="e.stage === 4" class="badge badge-success">Devuelto</span>
                                    </td>
                                    <td>
                                        <div class="mw-100 d-flex justify-content-around">
                                            <button v-if="e.stage === 0" @click="send_requirement( e.id )" class=" btn btn-xs btn-outline-primary">
                                                <i class="fa fa-send-o"></i> Enviar
                                            </button>
                                            <button v-if="e.stage === 0" class="btn btn-xs btn-outline-info">
                                                <i class="fa fa-edit"></i> Editar
                                            </button>
                                            <button class="btn btn-xs btn-outline-success">
                                                <i class="fa fa-eye"></i> Ver
                                            </button>
                                            <button v-if="e.stage === 0" class="btn btn-xs btn-outline-danger">
                                                <i class="fa fa-close"></i> Eliminar
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
        <service-tool v-if="page === 'require-form'"></service-tool>
    </div>
</template>

<script>
    import { mapMutations } from 'vuex';
    export default {
        name: "ServiceRequirements",
        created() {
            this.$store.dispatch( 'listRequirements' );
        },
        computed: {
            page() {
                return this.$store.state.Requirement.page;
            },
            requirements() {
                return this.$store.state.Requirement.requirements;
            }
        },
        methods: {
            ...mapMutations(['CHANGE_PAGE', 'CHANGE_REQUIREMENT_ID']),
            openPage() {
                this.CHANGE_PAGE( 'require-form' );
            },
            send_requirement( id ) {
                this.CHANGE_REQUIREMENT_ID( id );
                this.$store.dispatch( 'send_requirements' ).then( response => {
                    if( response.status ) {
                        this.$store.dispatch( 'listRequirements' );
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
