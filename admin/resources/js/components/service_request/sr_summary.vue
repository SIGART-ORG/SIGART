<template>
    <div class="col-md-9">
        <div class="custom-border">
            <div class="row">
                <div class="col-12">
                    <h2>Solicitud de servicio</h2>
                </div>
            </div>
            <div class="row mt-20">
                <div class="col-12">
                    <form>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Fechas</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-sm" placeholder="Fecha de inicio" v-model="formStart">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-sm" placeholder="Fecha fin" v-model="formEnd">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label text-center">Detalle de servicios</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-8 col-form-label">Detalle de servicios</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" placeholder="Fecha fin" v-model.number="formEnd">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-8 col-form-label">Total</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-sm" placeholder="Fecha fin" v-model.number="formEnd">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "sr_summary",
        props: ['service'],
        data() {
            return {
                formStart: '',
                formEnd: '',
                details: [],
                total: 0
            }
        }
    }
</script>

<style scoped>
    .custom-border {
        border: 1px solid #CFCFCF;
        padding: 10px;
    }
</style>
