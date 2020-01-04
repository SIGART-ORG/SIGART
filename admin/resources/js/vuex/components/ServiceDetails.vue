<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Servicio</h5>
        </section>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Listado</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group">
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="current.sidebar === 'service-detail' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT({ sidebar: 'service-detail', form: 'service-detail' })"
                        >
                            Detalle
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="current.sidebar === 'service-requirement' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT({ sidebar: 'service-requirement', form: 'service-requirement' })"
                        >
                            Requerimientos
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="current.sidebar === 'service-stage' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT({ sidebar: 'service-stage', form: 'service-stage' })"
                        >
                            Etapas
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="current.sidebar === 'service-worker' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT({ sidebar: 'service-worker', form: 'service-worker' })"
                        >
                            Trabajadores
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="current.sidebar === 'service-observation' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT({ sidebar: 'service-observation', form: 'service-observation' })"
                        >
                            Observaciones
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="current.sidebar === 'service-billing' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT({ sidebar: 'service-billing', form: 'service-billing' })"
                                disabled
                        >
                            Facturación
                        </button>
                    </div>
                </div>
                <div class="col-md-9">
                    <service-requirements v-if="current.form === 'service-requirement'"></service-requirements>
                    <service-stages v-if="current.form === 'service-stage'"></service-stages>
                    <service-task v-if="current.form === 'service-task'"></service-task>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import { mapMutations } from 'vuex';
    export default {
        name: "ServiceRequest",
        created() {
            this.$store.dispatch( 'loadSettings' );
        },
        props: [
            'service'
        ],
        computed: {
            current() {
                return this.$store.state.Settings.current;
            },
        },
        methods: {
            ...mapMutations(['CHANGE_CURRENT', 'CHANGE_SERVICE'])
        },
        mounted() {
            this.CHANGE_SERVICE( this.service );
        }
    }
</script>

<style scoped>

</style>
