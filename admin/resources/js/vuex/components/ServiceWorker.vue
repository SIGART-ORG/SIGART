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
                                    <th>Item</th>
                                    <th>Nombre y Apellidos</th>
                                    <th>Tareas</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="( e, i ) in workers" :key="e.user">
                                    <td v-text="i + 1"></td>
                                    <td>
                                        {{ e.name }}
                                        <br>
                                        <small class="text-primary" v-text="e.document"></small>
                                    </td>
                                    <td>
                                        <div v-for="( t, i2 ) in e.tasks" :key="t.id" class="bd-callout bd-callout-primary">
                                            <h6>{{ i2 + 1 }}) {{ t.name }} - <span class="badge badge-primary" v-text="t.statusName"></span></h6>
                                            <p><strong>Etapa: <code v-text="t.stage"></code></strong></p>
                                            <p v-text="t.description"></p>
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
        name: "ServiceWorker",
        created() {
            this.$store.dispatch( 'loadWorkersV2' );
        },
        computed: {
            workers: {
                get:function() {
                    return this.$store.state.Workers.workers;
                }
            }
        }
    }
</script>

<style scoped>

</style>
