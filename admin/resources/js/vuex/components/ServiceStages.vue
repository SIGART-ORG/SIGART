<template>
    <section class="hk-sec-wrapper">
        <div class="row mb-15">
            <div class="col-md-12">
                <h5>Etapas</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Nueva Etapa</h5>
                        <p class="card-text custom-text-card">
                            <button type="button" class="btn btn-outline-primary" @click.prevent="openForm">
                                <i class="fa fa-plus"></i>
                            </button>
                        </p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Agregar nueva etapa</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Primera etapa</h5>
                        <p class="card-text">Elaboración de sillas de madera</p>
                        <small><i class="fa fa-hourglass"></i>&nbsp;<mark>24/12/2019</mark> a <mark>31/12/2019</mark></small>
                        <br>
                        <small><i class="fa fa-users"></i>&nbsp;45</small>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-xs btn-outline-info">
                            <i class="fa fa-eye"></i>&nbsp;Ver detalle
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Segunda etapa</h5>
                        <p class="card-text">Pintado de 50 puertas</p>
                        <small><i class="fa fa-hourglass"></i>&nbsp;<mark>01/01/2020</mark> a <mark>15/01/2020</mark></small>
                        <br>
                        <small><i class="fa fa-users"></i>&nbsp;5</small>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-xs btn-outline-info">
                            <i class="fa fa-eye"></i>&nbsp;Ver detalle
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tercera etapa</h5>
                        <p class="card-text">Pintado de 50 puertas</p>
                        <small><i class="fa fa-hourglass"></i>&nbsp;<mark>01/01/2020</mark> a <mark>15/01/2020</mark></small>
                        <br>
                        <small><i class="fa fa-users"></i>&nbsp;5</small>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-xs btn-outline-info">
                            <i class="fa fa-eye"></i>&nbsp;Ver detalle
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <b-modal id="modalForm" size="lg" ref="modalForm" :title="modalTitle" @ok="addStage" @cancel="cancelRegister">
            <form>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Nombre <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <input type="text" name="Nombre" class="form-control" v-model="formName" v-validate="'required'">
                        <span v-show="errors.has('Nombre')" class="text-danger">{{ errors.first('Nombre') }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Fecha <span class="text-danger">(*)</span></label>
                    <div class="col-md-4">
                        <Datetime
                            name="Inicio"
                            v-model="formDateStart"
                            input-class="form-control"
                            value-zone="America/Lima"
                            :auto="true"
                            v-validate="'required'"
                        >
                        </Datetime>
                        <span v-show="errors.has('Inicio')" class="text-danger">{{ errors.first('Inicio') }}</span>
                    </div>
                    <div class="col-md-5">
                        <Datetime
                            name="Fin"
                            v-model="formDateEnd"
                            input-class="form-control"
                            value-zone="America/Lima"
                            :auto="true"
                            v-validate="'required'"
                        >
                        </Datetime>
                        <span v-show="errors.has('Fin')" class="text-danger">{{ errors.first('Fin') }}</span>
                    </div>
                </div>
            </form>
        </b-modal>
    </section>
</template>

<script>
    import { mapMutations } from 'vuex';
    import { Datetime } from 'vue-datetime';
    import 'vue-datetime/dist/vue-datetime.css';
    export default {
        name: "ServiceStages",
        data() {
            return {
                modalTitle: ''
            }
        },
        components: {
            Datetime
        },
        computed: {
            formName: {
                get: function() {
                    return this.$store.state.ServiceStages.name;
                },
                set: function( newName ) {
                    this.$store.state.ServiceStages.name = newName;
                }
            },
            formDateStart: {
                get: function() {
                    return this.$store.state.ServiceStages.dateStart;
                },
                set: function( newDate ) {
                    this.$store.state.ServiceStages.dateStart = newDate;
                }
            },
            formDateEnd: {
                get: function() {
                    return this.$store.state.ServiceStages.dateEnd;
                },
                set: function( newDate ) {
                    this.$store.state.ServiceStages.dateEnd = newDate;
                }
            },
            service() {
                return this.$store.state.Service.serviceId;
            }
        },
        methods: {
            ...mapMutations(['LOAD_STAGES']),
            openForm() {
                this.modalTitle = 'Agregar nueva etapa';
                this.$refs.modalForm.show();
            },
            addStage( evt ){
                evt.preventDefault();
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.$store.dispatch( 'addStage' );
                    }
                });
            },
            cancelRegister() {
                this.modalTitle = '';
                this.$nextTick(() => {
                    this.$refs.modalForm.hide();
                })
            }
        },
        mounted() {
            this.LOAD_STAGES();
        }
    }
</script>

<style scoped>
    .custom-text-card {
        font-size: 72pt;
    }
</style>
