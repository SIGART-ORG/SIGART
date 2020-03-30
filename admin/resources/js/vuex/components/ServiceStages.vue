<template>
    <section class="hk-sec-wrapper">
        <div class="row mb-15">
            <div class="col-md-12">
                <h5>Etapas</h5>
                <button class="btn btn-xs btn-outline-primary" @click.prevent="chargeStages" :disabled="!isEditable">
                    <i class="fa fa-plus-circle"></i> cargar etapas
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Nueva Etapa</h5>
                        <p class="card-text custom-text-card">
                            <button type="button" class="btn btn-outline-primary" :disabled="!isEditable" @click.prevent="openForm">
                                <i class="fa fa-plus"></i>
                            </button>
                        </p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Agregar nueva etapa</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4" v-if="stages.length > 0" v-for="stage in stages" :key="stage.id">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ stage.name }}</h5>
                        <p><statussig section="stage" :status="stage.status"></statussig></p>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-xs btn-outline-info mb-15" type="button" @click="editStage( stage.id )">
                            <i class="fa fa-tasks"></i>&nbsp;Tareas
                        </button>
                        <button class="btn btn-xs btn-outline-danger mb-15" type="button" :disabled="!isEditable">
                            <i class="fa fa-trash-o"></i>&nbsp;Eliminar
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
            </form>
        </b-modal>
    </section>
</template>

<script>
    import { mapMutations } from 'vuex';
    import { Datetime } from 'vue-datetime';
    import 'vue-datetime/dist/vue-datetime.css';
    import statussig from './general/status';

    export default {
        name: "ServiceStages",
        data() {
            return {
                modalTitle: ''
            }
        },
        components: {
            Datetime,
            statussig
        },
        created() {
            this.$store.dispatch( 'loadStages' );
        },
        computed: {
            stages() {
                return this.$store.state.ServiceStages.stages;
            },
            formName: {
                get: function() {
                    return this.$store.state.ServiceStages.name;
                },
                set: function( newName ) {
                    this.$store.state.ServiceStages.name = newName;
                }
            },
            service() {
                return this.$store.state.Service.serviceId;
            },
            isEditable() {
                return this.$store.state.Service.isEditable;
            }
        },
        methods: {
            ...mapMutations(['LOAD_STAGES', 'CHANGE_CURRENT', 'CHANGE_STAGE']),
            openForm() {
                this.modalTitle = 'Agregar nueva etapa';
                this.$refs.modalForm.show();
            },
            addStage( evt ){
                evt.preventDefault();
                let me = this;
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.$store.dispatch( 'addStage' )
                        .then( response => {
                            if( response.data.status ) {
                                me.cancelRegister();
                                me.$store.dispatch( 'loadStages' );
                            }
                        });
                    }
                });
            },
            cancelRegister() {
                this.modalTitle = '';
                this.$nextTick(() => {
                    this.$refs.modalForm.hide();
                })
            },
            editStage( id ) {
                let current = {
                    form: 'service-task'
                };
                this.CHANGE_STAGE( id );
                this.CHANGE_CURRENT( current );
            },
            chargeStages() {
                this.$store.dispatch( 'loadStagesAutomatically' ).then( response => {
                    if( response ) {
                        this.$store.dispatch( 'loadStages' );
                    }
                });
            }
        }
    }
</script>

<style scoped>
    .custom-text-card {
        font-size: 47pt;
    }
</style>
