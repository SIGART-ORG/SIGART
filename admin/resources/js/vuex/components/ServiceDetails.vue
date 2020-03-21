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
                                :class="current.sidebar === 'service-stage' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT({ sidebar: 'service-stage', form: 'service-stage' })"
                        >
                            Etapas
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="current.sidebar === 'service-board' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT({ sidebar: 'service-board', form: 'service-board' })"
                        >
                            Tablero
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="current.sidebar === 'service-worker' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT({ sidebar: 'service-worker', form: 'service-worker' })"
                        >
                            Trabajadores
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="current.sidebar === 'service-tool' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT({ sidebar: 'service-tool', form: 'service-tool' })"
                        >
                            Herramientas y Materiales
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
                        >
                            Facturación
                        </button>
                    </div>
                </div>
                <div class="col-md-9">
                    <service-requirements v-if="current.form === 'service-requirement'"></service-requirements>
                    <service-stages v-if="current.form === 'service-stage'"></service-stages>
                    <service-task v-if="current.form === 'service-task'"></service-task>
                    <service-tool v-if="current.form === 'service-tool'"></service-tool>
                    <service-board-v2 v-if="current.form === 'service-board'"></service-board-v2>
                    <service-worker v-if="current.form === 'service-worker'"></service-worker>
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
            this.CHANGE_SERVICE( this.service );
            this.$store.dispatch( 'loadSettings' );
            this.$store.dispatch( 'loadDetailService' );
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
    }
</script>

<style scoped>

</style>
