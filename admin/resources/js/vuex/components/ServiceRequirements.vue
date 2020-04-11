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
                                    <td></td>
                                    <td></td>
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
            ...mapMutations(['CHANGE_PAGE']),
            openPage() {
                this.CHANGE_PAGE( 'require-form' );
            }
        }
    }
</script>

<style scoped>

</style>
