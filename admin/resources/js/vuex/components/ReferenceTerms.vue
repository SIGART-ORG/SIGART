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
            idSQ: {
                get: function() {
                    return this.$store.state.Referenceterm.idSQ;
                },
                set: function( newValue) {
                    this.$store.state.Referenceterm.idSQ = newValue;
                }
            }
        },
        created() {
            this.idSQ = this.saleQuotation;
        }
    }
</script>

<style scoped>

</style>
