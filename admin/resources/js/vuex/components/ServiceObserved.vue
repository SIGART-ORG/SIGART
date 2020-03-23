<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Trabajadores</h5>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Registro</th>
                                    <th>Código</th>
                                    <th>Tarea</th>
                                    <th>Observación</th>
                                    <th>Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="e in observeds" :key="e.id">
                                    <td><small class="text-muted" v-text="e.created"></small></td>
                                    <td><small class="text-muted" v-text="e.name"></small></td>
                                    <td><small class="text-muted" v-text="e.task"></small></td>
                                    <td>{{ e.description }}</td>
                                    <td>
                                        <div class="mw-100">
                                            <span v-if="e.status === 1" class="badge badge-info" v-text="e.statusName"></span>
                                            <span v-if="e.status === 3" class="badge badge-primary" v-text="e.statusName"></span>
                                            <span v-if="e.status === 4" class="badge badge-danger" v-text="e.statusName"></span>
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
    import { mapMutations } from 'vuex';
    export default {
        name: "ServiceObserved",
        created() {
            this.$store.dispatch( 'loadOberveds' );
        },
        computed: {
            observeds: {
                get:function() {
                    return this.$store.state.Oberved.observeds;
                }
            }
        }
    }
</script>

<style scoped>

</style>
