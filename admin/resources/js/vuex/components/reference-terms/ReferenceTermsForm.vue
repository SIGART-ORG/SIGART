<template>
    <div class="col-md-9">
        <div class="row mb-20">
            <div class="col-12 text-center">
                <h2>Editar Término de referencia</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">Área <span class="text-danger">(*)</span></label>
                        <div class="col-md-9">
                            <input type="text" v-model="formArea" name="area" v-validate="'required'" class="form-control form-control-sm" placeholder="Nombre" :class="{'is-invalid': errors.has('area')}">
                            <span v-show="errors.has('area')" class="text-danger">{{ errors.first('area') }}</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ReferenceTermsForm",
        computed: {
            formId() {
                return this.$store.state.Referenceterm.formId;
            },
            formArea: {
                get: function() {
                    return this.$store.state.Referenceterm.formArea;
                },
                set: function( newVal ) {
                    this.$store.state.Referenceterm.formArea = newVal;
                }
            },
            formActivity: {
                get: function() {
                    return this.$store.state.Referenceterm.formActivity;
                },
                set: function( newVal ) {
                    this.$store.state.Referenceterm.formActivity = newVal;
                }
            },
            formObjective: {
                get: function() {
                    return this.$store.state.Referenceterm.formObjective;
                },
                set: function( newVal ) {
                    this.$store.state.Referenceterm.formObjective = newVal;
                }
            },
            formSpecializedArea: {
                get: function() {
                    return this.$store.state.Referenceterm.formSpecializedArea;
                },
                set: function( newVal ) {
                    this.$store.state.Referenceterm.formSpecializedArea = newVal;
                }
            },
            formDaysExecution: {
                get: function() {
                    return this.$store.state.Referenceterm.formDaysExecution;
                },
                set: function( newVal ) {
                    this.$store.state.Referenceterm.formDaysExecution = newVal;
                }
            },
            formExecutionAddress: {
                get: function() {
                    return this.$store.state.Referenceterm.formExecutionAddress;
                },
                set: function( newVal ) {
                    this.$store.state.Referenceterm.formExecutionAddress = newVal;
                }
            },
            formAddressReference: {
                get: function() {
                    return this.$store.state.Referenceterm.formAddressReference;
                },
                set: function( newVal ) {
                    this.$store.state.Referenceterm.formAddressReference = newVal;
                }
            },
            formMethodPayment: {
                get: function() {
                    return this.$store.state.Referenceterm.formMethodPayment;
                },
                set: function( newVal ) {
                    this.$store.state.Referenceterm.formMethodPayment = newVal;
                }
            },
            formConformanceGrant: {
                get: function() {
                    return this.$store.state.Referenceterm.formConformanceGrant;
                },
                set: function( newVal ) {
                    this.$store.state.Referenceterm.formConformanceGrant = newVal;
                }
            },
            formWarrantyMonth: {
                get: function() {
                    return this.$store.state.Referenceterm.formWarrantyMonth;
                },
                set: function( newVal ) {
                    this.$store.state.Referenceterm.formWarrantyMonth = newVal;
                }
            },
            formObervations: {
                get: function() {
                    return this.$store.state.Referenceterm.formObervations;
                },
                set: function( newVal ) {
                    this.$store.state.Referenceterm.formObervations = newVal;
                }
            },
            formDetails: {
                get: function() {
                    return this.$store.state.Referenceterm.formDetails;
                },
                set: function( newVal ) {
                    this.$store.state.Referenceterm.formDetails = newVal;
                }
            },
        },
    }
</script>

<style scoped>

</style>
