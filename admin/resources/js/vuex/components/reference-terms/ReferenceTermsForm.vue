<template>
    <div class="col-md-9">
        <div class="row mb-20">
            <div class="col-12 text-center">
                <h2>Editar Término de referencia</h2>
                <button class="btn btn-outline-primary btn-xs" type="button" @click.prevent="saveRT">
                    <i class="fa fa-check-circle"></i> Guardar
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">Área</label>
                        <div class="col-md-9">
                            <input type="text" v-model="formArea" name="area"
                                   class="form-control form-control-sm" placeholder="Área"
                                   readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">Actividad <span class="text-danger">(*)</span></label>
                        <div class="col-md-9">
                            <input type="text" v-model="formActivity" name="activity" v-validate="'required'"
                                   class="form-control form-control-sm" placeholder="Actividad"
                                   :class="{'is-invalid': errors.has('activity')}">
                            <span v-show="errors.has('activity')" class="text-danger">{{ errors.first('activity') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">Cliente</label>
                        <div class="col-md-9">
                            <input type="text" name="area" v-model="customertext"
                                   class="form-control form-control-sm" placeholder="Cliente"
                                   readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">1. Objetivo del servicio <span class="text-danger">(*)</span></label>
                        <div class="col-md-9">
                            <textarea type="text" v-model="formObjective" name="objetivo" v-validate="'required'"
                                   class="form-control form-control-sm"
                                      :class="{'is-invalid': errors.has('objetivo')}"></textarea>
                            <span v-show="errors.has('objetivo')" class="text-danger">{{ errors.first('objetivo') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">2. Área ususarioa y/o especializada</label>
                        <div class="col-md-9">
                            <input type="text" v-model="formSpecializedArea"
                                   class="form-control form-control-sm"
                                   readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">3. Descripción detallada del servicio</label>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-20">
                                                <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Descripción</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-if="formDetails.length > 0" v-for="(det, idx) in formDetails" :key="det.id">
                                                    <td v-text="idx + 1"></td>
                                                    <td>
                                                        <input type="text" class="form-control" placeholder="Descripción" v-model="det.description">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control mw-75p" placeholder="Cantidad" v-model.number="det.quantity">
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">4. Plazo de ejecución del servicio <span class="text-danger">(*)</span></label>
                        <div class="col-md-9">
                            <input type="text" v-model="formDaysExecution" name="plazo" v-validate="'required'"
                                   class="form-control form-control-sm" placeholder="Plazo de ejecución del servicio"
                                   :class="{'is-invalid': errors.has('plazo')}">
                            <small class="text-muted">La ejecución del presente servicio se realizará en el plazo máximo de <strong>{{ textPlazo }}</strong> calendario.
                                La vigencia del servicio se extendera a partir del día siguiente de notificada la orden de servicio,</small>
                            <span v-show="errors.has('plazo')" class="text-danger">{{ errors.first('plazo') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">5. Lugar de prestación del servicio <span class="text-danger">(*)</span></label>
                        <div class="col-md-9">
                            <div class="row mb-10">
                                <div class="col-12">
                                    <input type="text" v-model="formExecutionAddress" name="dirección" v-validate="'required'"
                                           class="form-control form-control-sm" placeholder="Dirección"
                                           :class="{'is-invalid': errors.has('dirección')}">
                                    <span v-show="errors.has('dirección')" class="text-danger">{{ errors.first('dirección') }}</span>
                                </div>
                            </div>
                            <div class="row mb-10">
                                <div class="col-4">
                                    <select class="form-control" v-model="departament" @change="loadProvince">
                                        <option disabled>Departamento</option>
                                        <option v-for="dep in arrDepartaments" :key="dep.id" :value="dep.id">{{ dep.name }}</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select class="form-control" v-model="province" @change="loadDistrict">
                                        <option disabled>Provincia</option>
                                        <option v-for="prov in arrProvinces" v-bind:value="prov.id" v-text="prov.name"></option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select class="form-control" v-model="district">
                                        <option disabled>Distrito</option>
                                        <option v-for="dist in arrDistricts" v-bind:value="dist.id" v-text="dist.name"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <textarea type="text" v-model="formObervations"  class="form-control form-control-sm"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">6. Formas de pago <span class="text-danger">(*)</span></label>
                        <div class="col-md-9">
                            <textarea type="text" v-model="formMethodPayment" name="forma-de-pago" v-validate="'required'"
                                      class="form-control form-control-sm"
                                      :class="{'is-invalid': errors.has('forma-de-pago')}"></textarea>
                            <span v-show="errors.has('forma-de-pago')" class="text-danger">{{ errors.first('forma-de-pago') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">7. Otorgamiento de conformidad del servicio <span class="text-danger">(*)</span></label>
                        <div class="col-md-9">
                            <textarea type="text" v-model="formConformanceGrant"
                                      class="form-control form-control-sm" readonly></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">8. Garantía del servicio <span class="text-danger">(*)</span></label>
                        <div class="col-md-9">
                            <input type="text" v-model="formWarrantyMonth" name="mes" v-validate="'required'"
                                   class="form-control form-control-sm" placeholder="Meses"
                                   :class="{'is-invalid': errors.has('mes')}">
                            <small class="text-muted">Declaración jurada de que el servicio tendrá <strong>{{ warrantyText }}</strong> de garantía.</small>
                            <span v-show="errors.has('mes')" class="text-danger">{{ errors.first('mes') }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label">8. Observaciones</label>
                        <div class="col-md-9">
                            <textarea type="text" v-model="formObervations"  class="form-control form-control-sm"></textarea>
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
                get: function () {
                    return this.$store.state.Referenceterm.formArea;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formArea = newVal;
                }
            },
            formActivity: {
                get: function () {
                    return this.$store.state.Referenceterm.formActivity;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formActivity = newVal;
                }
            },
            formObjective: {
                get: function () {
                    return this.$store.state.Referenceterm.formObjective;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formObjective = newVal;
                }
            },
            formSpecializedArea: {
                get: function () {
                    return this.$store.state.Referenceterm.formSpecializedArea;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formSpecializedArea = newVal;
                }
            },
            formDaysExecution: {
                get: function () {
                    return this.$store.state.Referenceterm.formDaysExecution;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formDaysExecution = newVal;
                }
            },
            formExecutionAddress: {
                get: function () {
                    return this.$store.state.Referenceterm.formExecutionAddress;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formExecutionAddress = newVal;
                }
            },
            formAddressReference: {
                get: function () {
                    return this.$store.state.Referenceterm.formAddressReference;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formAddressReference = newVal;
                }
            },
            formMethodPayment: {
                get: function () {
                    return this.$store.state.Referenceterm.formMethodPayment;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formMethodPayment = newVal;
                }
            },
            formConformanceGrant: {
                get: function () {
                    return this.$store.state.Referenceterm.formConformanceGrant;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formConformanceGrant = newVal;
                }
            },
            formWarrantyMonth: {
                get: function () {
                    return this.$store.state.Referenceterm.formWarrantyMonth;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formWarrantyMonth = newVal;
                }
            },
            formObervations: {
                get: function () {
                    return this.$store.state.Referenceterm.formObervations;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formObervations = newVal;
                }
            },
            formDetails: {
                get: function () {
                    return this.$store.state.Referenceterm.formDetails;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formDetails = newVal;
                }
            },
            district: {
                get: function () {
                    return this.$store.state.Referenceterm.formUbigeo.district;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formUbigeo.district = newVal;
                }
            },
            province: {
                get: function () {
                    return this.$store.state.Referenceterm.formUbigeo.province;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formUbigeo.province = newVal;
                }
            },
            departament: {
                get: function () {
                    return this.$store.state.Referenceterm.formUbigeo.departament;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.formUbigeo.departament = newVal;
                }
            },
            formCustomer() {
                return this.$store.state.Referenceterm.formCustomer;
            },
            textPlazo() {
                return this.formDaysExecution > 1 ? this.formDaysExecution + ' días' :  this.formDaysExecution + ' día';
            },
            warrantyText() {
                return this.formWarrantyMonth > 1 ? this.formWarrantyMonth + ' meses' :  this.formWarrantyMonth + ' mes';
            },
            customertext() {
                return this.formCustomer.document + ' ' + this.formCustomer.name;
            },
            arrDepartaments() {
                return this.$store.state.Referenceterm.arrDepartaments;
            },
            arrProvinces() {
                return this.$store.state.Referenceterm.arrProvinces;
            },
            arrDistricts() {
                return this.$store.state.Referenceterm.arrDistricts;
            },
        },
        created() {
            this.$store.dispatch( 'loadDepartaments' );
        },
        methods: {
            loadProvince() {
                this.$store.dispatch({
                    type: 'loadProvinces',
                });
            },
            loadDistrict(){
                this.$store.dispatch({
                    type: 'loadDistrict'
                });
            },
            saveRT() {
                let me = this;
                this.$validator.validateAll().then( (result) => {
                    if( result ) {
                        me.$store.dispatch( 'saveRT' )
                        .then( response => {
                            let result = response.data;
                            if( result.status ) {
                                swal(
                                    'Exito!',
                                    'Se actualizó correctamente el Término de referencia',
                                    'success'
                                )
                            } else {
                                swal(
                                    'Error! :(',
                                    'No se pudo realizar la operación',
                                    'error'
                                )
                            }
                        }).catch( errors => {
                            console.log( errors );
                            swal(
                                'Error! :(',
                                'No se pudo realizar la operación',
                                'error'
                            )
                        })
                    }
                }).catch( errors => {
                    console.log( errors );
                })
            }
        },
        mounted() {
            let me = this;
            setTimeout( function () {
                me.loadProvince();
                me.loadDistrict();
            }, 1500);
        }
    }
</script>

<style scoped>

</style>
