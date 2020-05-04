<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Trabajadores</h5>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Observación</th>
                                    <th>Observación</th>
                                    <th>Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="( e, i ) in observeds" :key="e.id">
                                    <td>
                                        <strong class="text-muted" v-text="e.name"></strong>
                                        <br/>
                                        <small class="text-muted"><strong v-text="e.code"></strong> - {{ e.stage }}</small>
                                        <br/>
                                        <small class="text-muted" v-text="e.created"></small>
                                    </td>
                                    <td>
                                        {{ e.description }}
                                        <div v-if="e.reply" class="bd-callout bd-callout-primary">
                                            <h6>Rpta:</h6>
                                            <p v-if="typeof e.replyLong === 'undefined' || e.replyLong === false">
                                                <code v-text="e.replyDate"></code> - {{ e.reply.slice( 0, 200 ) }}
                                                <a v-if="e.reply.length > 200" href="javascript:;" @click="expandText( i )">Ver más</a>
                                            </p>
                                            <p v-if="e.replyLong === true" >
                                                <code v-text="e.replyDate"></code> - {{ e.reply }}
                                                <a href="javascript:;" @click="contractText( i )">Ver menos</a>
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mw-100 mb-10">
                                            <span v-if="e.status === 1" class="badge badge-info" v-text="e.statusName"></span>
                                            <span v-if="e.status === 3" class="badge badge-primary" v-text="e.statusName"></span>
                                            <span v-if="e.status === 4" class="badge badge-danger" v-text="e.statusName"></span>
                                        </div>
                                        <div class="mw-100" v-if="e.status === 1">
                                            <button class="btn btn-xs btn-outline-success" @click.prevent="openModalObs( e )" :disabled="!isEditable">
                                                <i class="fa fa-reply"></i> Responder obs.
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <b-modal ref="register-reply" size="lg" :title="modalTitle" @ok="registerReply" @cancel="closeModalReply" @hide="hideModal">
            <form>
                <div class="form-group">
                    <label for="observation">Observación</label>
                    <div class="form-control-feedback mt-1 p-2 rounded" id="observation" v-text="observation"></div>
                </div>
                <div class="form-group">
                    <label for="type">Respuesta<strong class="text-danger">(*)</strong></label>
                    <select name="tipo" v-model="typeReply" class="form-control" id="type" v-validate="'required|excluded:0'">
                        <option value="0">Pendiente de respuesta</option>
                        <option value="3">Aceptado</option>
                        <option value="4">Denegado</option>
                    </select>
                    <span class="text-danger" v-show="errors.has( 'tipo' )">{{ errors.first( 'tipo' ) }}</span>
                </div>
                <div class="form-group" v-if="typeReply === '3'">
                    <label for="tasks">Tareas<strong class="text-danger">(*)</strong></label>
                    <select class="form-control" v-model="tasksSelected" name="Tareas" multiple id="tasks" size="4" v-validate="'required|excluded:0'">
                        <option value="0" disabled>Seleccione 1 o más tareas relacionada(s) a esta observación.</option>
                        <option v-for="t in tasks":key="t.id" :value="t.id">{{ t.code }} - {{ t.name }}({{ t.status }})</option>
                    </select>
                    <span class="text-danger" v-show="errors.has( 'Tareas' )">{{ errors.first( 'Tareas' ) }}</span>
                </div>
                <div class="form-group">
                    <label for="description">Descripción<strong class="text-danger">(*)</strong></label>
                    <textarea id="description" v-model="description" name="descripción" class="form-control" v-validate="'required'"></textarea>
                    <span class="text-danger" v-show="errors.has( 'descripción' )">{{ errors.first( 'descripción' ) }}</span>
                </div>
                <div class="form-group">
                    <label>Leyenda:</label>
                    <div class="form-control-feedback  rounded">
                        <p class="font-italic"><strong class="text-danger">(*)</strong> Campo requerido</p>
                    </div>
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
    import { mapMutations } from 'vuex';
    export default {
        name: "ServiceObserved",
        created() {
            this.$store.dispatch( 'loadOberveds' );
        },
        data() {
            return {
                modalTitle: '',
                observation: '',
                typeReply: 0,
                description: '',
                tasksSelected: []
            }
        },
        computed: {
            observeds: {
                get:function() {
                    return this.$store.state.Oberved.observeds;
                },
                set:function( newValue ) {
                    this.$store.state.Oberved.observeds = newValue;
                }
            },
            tasks: {
                get:function() {
                    return this.$store.state.Oberved.tasks;
                }
            },
            isEditable() {
                return this.$store.state.Service.isEditable;
            }
        },
        methods: {
            ...mapMutations(['CHANGE_OBSERVED_ID', 'LOAD_TASKS']),
            openModalObs( data ) {
                this.modalTitle = 'Responder observación - ' + data.name;
                this.observation = data.description;
                this.description = '';
                this.typeReply = 0;
                this.tasksSelected = [];
                this.LOAD_TASKS([]);
                this.CHANGE_OBSERVED_ID( data.id );
                this.$store.dispatch( 'loadtasks' );
                this.$refs['register-reply'].show();
            },
            registerReply( evt ) {
                let typeReply = this.typeReply;
                let description = this.description;
                let tasksSelected = this.tasksSelected;
                evt.preventDefault();
                this.$validator.validateAll().then( (result) => {
                    if( result ) {
                        this.$store.dispatch({
                            type: 'registerReply',
                            data: {
                                typeReply: typeReply,
                                description: description,
                                tasksSelected: tasksSelected
                            }
                        }).then( response => {
                            let result = response.data;
                            this.CHANGE_OBSERVED_ID( 0 );
                            if( result.status ) {
                                this.$store.dispatch( 'loadOberveds' );
                                this.closeModalReply();
                            }
                        });
                    }
                });
            },
            hideModal(){
                this.$refs['register-reply'].hide();
            },
            closeModalReply( evt ) {
                this.modalTitle = '';
                this.observation = '';
                this.description = '';
                this.typeReply = 0;
                this.tasksSelected = [];
                this.LOAD_TASKS([]);
                this.$refs['register-reply'].hide();
            },
            expandText( index ) {
                this.observeds[index].replyLong = true;
            },
            contractText( index ) {
                this.observeds[index].replyLong = false;
            }
        }
    }
</script>

<style scoped>

</style>
