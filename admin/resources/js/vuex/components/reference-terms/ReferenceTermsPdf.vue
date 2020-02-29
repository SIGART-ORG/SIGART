<template>
    <div class="col-md-9">
        <div class="row mb-20">
            <div class="col-12 text-center">
                <h2>PDF {{ type }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12" style="background-color: black">
                <pdf v-if="type === 'rt'"
                    v-for="i in numPages"
                    :key="i"
                    :src="formPdf"
                    :page="i"
                    style=" max-width: 650px; margin: auto; display: flex; justify-content: center;"
                ></pdf>
                <pdf v-if="type === 'sr'"
                     v-for="i in numPagesSR"
                     :key="i"
                     :src="formPdfSR"
                     :page="i"
                     style=" max-width: 650px; margin: auto; display: flex; justify-content: center;"
                ></pdf>
                <pdf v-if="type === 'so'"
                     v-for="i in numPagesSO"
                     :key="i"
                     :src="formPdfSO"
                     :page="i"
                     style=" max-width: 650px; margin: auto; display: flex; justify-content: center;"
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
                numPages: 0,
                numPagesSR: 0,
                numPagesSO: 0
            }
        },
        props:[
            'type'
        ],
        components: {
            pdf
        },
        computed: {
            formPdf() {
                return this.$store.state.Referenceterm.formPdf;
            },
            formPdfSR() {
                return this.$store.state.Referenceterm.formPdfSR;
            },
            formPdfSO() {
                return this.$store.state.Referenceterm.formPdfSO;
            }
        },
        created() {
            pdf.createLoadingTask( this.formPdf ).then(pdf => {
                this.numPages = pdf.numPages;
            });
            pdf.createLoadingTask( this.formPdfSR ).then(pdf => {
                this.numPagesSR = pdf.numPages;
            });
            pdf.createLoadingTask( this.formPdfSO ).then(pdf => {
                this.numPagesSO = pdf.numPages;
            });
        }
    }
</script>

<style scoped>
    .col-12 canvas {

    }
</style>
