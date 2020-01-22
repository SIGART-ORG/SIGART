<template>
    <div class="col-md-9">
        <div class="row mb-20">
            <div class="col-12 text-center">
                <h2>PDF</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <pdf
                    v-for="i in numPages"
                    :key="i"
                    :src="formPdf"
                    :page="i"
                    style="display: inline-block; width: 100%"
                ></pdf>
            </div>
        </div>
    </div>
</template>

<script>
    import pdf from 'vue-pdf';
    export default {
        name: "ReferenceTermsPdf",
        data() {
            return {
                numPages: 0
            }
        },
        components: {
            pdf
        },
        computed: {
            formPdf() {
                return this.$store.state.Referenceterm.formPdf;
            }
        },
        created() {
            pdf.createLoadingTask( this.formPdf ).then(pdf => {
                this.numPages = pdf.numPages;
            });
        }
    }
</script>

<style scoped>

</style>
