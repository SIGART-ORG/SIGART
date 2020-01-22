<template>
    <div>
        <reference-term-detail v-if="saleQuotation > 0"></reference-term-detail>
    </div>
</template>

<script>
    import referenceTermDetail from './reference-terms/ReferenceTermsDetail';
    export default {
        name: "ReferenceTerms",
        props: [
            'saleQuotation'
        ],
        components: {
            referenceTermDetail
        },
        computed: {
            formId: {
                get: function() {
                    return this.$store.state.Referenceterm.formId;
                },
                set: function( newValue) {
                    this.$store.state.Referenceterm.formId = newValue;
                }
            }
        },
        created() {
            this.formId = this.saleQuotation;
        }
    }
</script>

<style scoped>

</style>
