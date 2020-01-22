<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Término de referencia</h5>
        </section>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Opciones</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group">
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="currentTab === 'form-rt' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT_RT( 'form-rt' )"
                        >
                            Término de referencia
                        </button>
                        <button type="button" class="list-group-item list-group-item-action"
                                :class="currentTab === 'pdf-rt' ? 'active': ''"
                                @click.prevent="CHANGE_CURRENT_RT( 'pdf-rt' )"
                        >
                            Término de referencia PDF
                        </button>
                    </div>
                </div>
                <reference-terms-form v-if="currentTab === 'form-rt'"></reference-terms-form>
                <reference-terms-pdf v-if="currentTab === 'pdf-rt'"></reference-terms-pdf>
            </div>
        </section>

    </div>
</template>

<script>
    import { mapMutations } from 'vuex';
    import ReferenceTermsPdf from "./ReferenceTermsPdf";
    import ReferenceTermsForm from "./ReferenceTermsForm";
    export default {
        name: "ReferenceTermsDetail",
        components: {
            ReferenceTermsForm,
            ReferenceTermsPdf
        },
        computed: {
            idSQ() {
                return this.$store.state.Referenceterm.idSQ;
            },
            currentTab() {
                return this.$store.state.Referenceterm.currentTab;
            },
        },
        created() {
            this.$store.dispatch( 'loadReference' );
            this.CHANGE_CURRENT_RT( 'form-rt' );
        },
        methods: {
            ...mapMutations(['CHANGE_CURRENT_RT'])
        },
    }
</script>

<style scoped>

</style>
