<template>
    <div>{{ formId }}</div>
</template>

<script>
    export default {
        name: "ReferenceTermsDetail",
        computed: {
            formId() {
                return this.$store.state.Referenceterm.formId;
            }
        },
        created() {
            this.$store.dispatch( 'getLoadDetail' );
        }
    }
</script>

<style scoped>

</style>
