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
                                :class="current === 'service-detail' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT( 'service-detail' )"
                        >
                            Detalle
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="current === 'service-requirement' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT( 'service-requirement' )"
                        >
                            Requerimientos
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="current === 'service-stage' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT( 'service-stage' )"
                        >
                            Etapas
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="current === 'service-worker' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT( 'service-worker' )"
                        >
                            Trabajadores
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="current === 'service-observation' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT( 'service-observation' )"
                        >
                            Observaciones
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="current === 'service-billing' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT( 'service-billing' )"
                                disabled
                        >
                            Facturación
                        </button>
                    </div>
                </div>
                <div class="col-md-9">
                    <service-requirements v-if="current === 'service-requirement'"></service-requirements>
                    <service-stages v-if="current === 'service-stage'"></service-stages>
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
