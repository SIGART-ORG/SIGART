<template>
    <section class="hk-sec-wrapper">
        <div class="row">
            <div class="col-12 text-center">
                <h5 class="font-weight-light">Etapa: <strong class="text-primary text-uppercase">{{ servicedata.stage.name }}</strong></h5>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th>Servicio</th>
                                <th>Adjunto</th>
                                <th>Etapa</th>
                                <th>Cliente</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <strong class="text-info">{{ servicedata.service.document }}</strong>
                                    <br v-if="servicedata.service.document !== ''">
                                    <g-status section="service" :status="servicedata.service.status"></g-status>
                                </td>
                                <td>
                                    <a v-if="servicedata.service.attachment !== ''" :href="servicedata.service.attachment" target="_blank" class="btn btn-xs btn-outline-danger">
                                        <i class="fa fa-file-o"></i>
                                    </a>
                                </td>
                                <td>
                                    <strong class="text-info">{{ servicedata.stage.name }}</strong>
                                    <br>
                                    <g-status section="stage" :status="servicedata.stage.status"></g-status>
                                </td>
                                <td>
                                    <strong class="text-uppercase">{{ servicedata.provider.name }}</strong>
                                    <br>
                                    <span class="badge badge-info">{{ servicedata.provider.document }}</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h6>Resumen</h6>
                <div class="progress mb-10">
                    <div v-if="summary.details.length" v-for="det in summary.details" :key="det.id"
                         class="progress-bar progress-bar-striped" :class="'progress-bar-' + det.class"
                         :style="'width: ' + det.porc + '%'">
                        <span class="sr-only">{{ det.label }}</span>
                    </div>
                </div>
                <div class="mw-100 d-flex flex-md-wrap justify-content-around">
                    <span v-if="summary.details.length" v-for="det2 in summary.details" :key="det2.id" class="badge" :class="'badge-' + det2.class">
                        {{ det2.label }}: {{ det2.total }} ({{ det2.porc }}%)
                    </span>
                </div>
            </div>
        </div>
        <div class="row mt-20">
            <div class="col-12">
                <h6>Tareas</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Agregar tarea</h5>
                                <p class="card-text custom-text-card">
                                    <button type="button" class="btn btn-outline-primary" :disabled="!isEditable" @click.prevent="openForm">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Agregar nueva tarea</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" v-if="tasks.length > 0" v-for="task in tasks" :key="task.id">
                        <div class="card">
                            <div class=""></div>
                            <div class="card-body">
                                <h5 class="card-title">{{ task.code }}</h5>
                                <h6 class="card-subtitle text-capitalize">{{ task.name }}</h6>
                                <g-status section="task" :status="task.status"></g-status>
                                <p class="card-text" v-if="task.descriptionShort !== ''">{{ task.descriptionShort }}</p>
                                <p class="card-text font-italic" v-else>Sin descripción</p>
                                <small><i class="fa fa-users"></i>&nbsp;{{ task.users }}</small>
                                &nbsp;|&nbsp;
                                <small :class="task.observeds > 0 ? 'text-danger' : 'text-secondary'" :title="task.observeds > 0 ? 'Esta tarea tiene una observación' : ''"><i class="fa fa-exclamation-triangle"></i> {{ task.observeds }}</small>
                            </div>
                            <div class="card-footer text-center">
                                <button class="btn btn-xs btn-outline-success mb-15" type="button" @click.prevent="showTask( task )">
                                    <i class="fa fa-eye"></i>
                                </button>
                                &nbsp;&nbsp;
                                <button class="btn btn-xs btn-outline-info mb-15" type="button" :disabled="!isEditable" @click.prevent="openForm( task )">
                                    <i class="fa fa-edit"></i>
                                </button>
                                &nbsp;&nbsp;
                                <button class="btn btn-xs btn-outline-danger mb-15" type="button" :disabled="!isEditable" @click.prevent="deleteTask( task.id )">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <b-modal id="modalForm" size="lg" ref="modalForm" :title="modalTitle" @ok="addTask" @cancel="cancelRegister">
            <form>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Nombre <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <input type="text" name="Nombre" class="form-control" v-model="formName" v-validate="'required'">
                        <span v-show="errors.has('Nombre')" class="text-danger">{{ errors.first('Nombre') }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Trabajadores <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <vue-tags-input
                            v-model="tag"
                            :tags="formUsers"
                            :autocomplete-items="autocompleteItems"
                            :add-only-from-autocomplete="true"
                            @tags-changed="update"
                        />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Descripción</label>
                    <div class="col-md-9">
                        <textarea v-model="formDescription" class="form-control" ></textarea>
                    </div>
                </div>
            </form>
        </b-modal>
        <b-modal id="modalShow" size="lg" ref="modalShow" :title="modalTitle" @ok="closeModalShow" @cancel="closeModalShow" >
            <div class="card">
                <div class="card-body">
                    <g-status section="task" :status="dataForm.status"></g-status>

                    <p class="card-text" v-if="dataForm.description !== ''">{{ dataForm.description }}</p>
                    <p class="card-text font-italic" v-else >Sin descripción</p>

                    <small><i class="fa fa-hourglass"></i>&nbsp;<mark>{{ dataForm.startProgF }}</mark> a <mark>{{ dataForm.endProgF }}</mark></small>
                    &nbsp;|&nbsp;
                    <small><i class="fa fa-users"></i>&nbsp;{{ dataForm.users }}</small>
                    &nbsp;|&nbsp;
                    <small :class="dataForm.isObs ? 'text-danger' : 'text-secondary'" :title="dataForm.isObs ? 'Esta tarea tiene una observación' : ''"><i class="fa fa-exclamation-triangle"></i></small>
                </div>
            </div>
        </b-modal>
    </section>
</template>

<script>
    import { mapMutations } from 'vuex';
    import { Datetime } from 'vue-datetime';
    import 'vue-datetime/dist/vue-datetime.css';
    import statussig from './general/status';
    import VueTagsInput from '@johmun/vue-tags-input';
    import moment from 'moment';

    export default {
        name: "ServiceTasks",
        data() {
            return {
                modalTitle: '',
                tag: '',
                autocompleteItems: [],
                debounce: null,
                dataForm: {}
            }
        },
        created() {
            this.$store.dispatch( 'loadService' );
            this.$store.dispatch( 'loadTasks' );
        },
        components: {
            'g-status': statussig,
            Datetime,
            VueTagsInput
        },
        computed: {
            servicedata() {
                return this.$store.state.ServiceTask.headData;
            },
            tasks() {
                return this.$store.state.ServiceTask.tasks;
            },
            summary() {
                return this.$store.state.ServiceTask.summary;
            },
            formId: {
                get: function() {
                    return this.$store.state.ServiceTask.formId;
                },
                set: function( id ) {
                    this.$store.state.ServiceTask.formId = id;
                }
            },
            formName: {
                get: function() {
                    return this.$store.state.ServiceTask.formName;
                },
                set: function( name ) {
                    this.$store.state.ServiceTask.formName = name;
                }
            },
            formDescription: {
                get: function () {
                    return this.$store.state.ServiceTask.formDescription;
                },
                set: function( description ) {
                    this.$store.state.ServiceTask.formDescription = description;
                }
            },
            formUsers: {
                get: function() {
                    return this.$store.state.ServiceTask.formUsers;
                },
                set: function( users ) {
                    this.$store.state.ServiceTask.formUsers = users;
                }
            },
            isEditable() {
                return this.$store.state.Service.isEditable;
            }
        },
        watch: {
            'tag': 'initItems',
        },
        methods: {
            ...mapMutations(['LOAD_WORKERS', 'CLEAR_FORM_TASK']),
            update( newTags ) {
                this.autocompleteItems = [];
                this.formUsers = newTags;
            },
            initItems() {
                if (this.tag.length < 2) return;
                const url = `/user/workers/?search=${this.tag}`;

                clearTimeout( this.debounce );
                this.debounce = setTimeout(() => {
                    axios.get( url ).then(response => {
                        this.autocompleteItems = response.data.results.map(a => {
                            return {
                                id: a.id,
                                text: a.name + ' ' + a.last_name
                            };
                        });
                    }).catch(() => console.warn('Oh. Something went wrong'));
                }, 600);
            },
            openForm( data = [] ) {
                let title = 'Agregar Tarea';
                if( data.id ) {
                    title = 'Editar Tarea';
                    this.formId = data.id;
                    this.formName = data.name;
                    this.formDescription = data.description;
                    this.$store.dispatch( 'loadWorkers' );
                }

                this.modalTitle = title;
                this.$refs.modalForm.show();
            },
            addTask( evt ) {
                evt.preventDefault();
                let me = this;
                this.$validator.validateAll().then( (result) => {
                    if( result ) {
                        this.$store.dispatch( 'addTask' )
                        .then( response => {
                            if( response.data.status ) {
                                me.cancelRegister();
                                me.$store.dispatch( 'loadTasks' );
                            }
                        })
                    }
                }).catch( ( errors ) => {
                    console.log( errors );
                });
            },
            cancelRegister() {
                this.modalTitle = '';
                this.$nextTick(() => {
                    this.$refs.modalForm.hide();
                })
            },
            deleteTask( id ) {
                this.formId = id;
                this.$store.dispatch( 'deleteTask' ).then( response => {
                    if( response.data.status ) {
                        this.$store.dispatch( 'loadTasks' );
                    }
                }).catch( errors => {
                    console.log( errors );
                });
            },
            showTask( data ) {
                this.modalTitle = 'Tarea: ' + data.name;
                this.formId = data.id;
                this.dataForm = data;
                this.$store.dispatch( 'loadWorkers' );
                this.$refs.modalShow.show();
            },
            closeModalShow() {
                this.modalTitle = '';
                this.formId = 0;
                this.$nextTick(() => {
                    this.$refs.modalShow.hide();
                });
                this.CLEAR_FORM_TASK();
            }
        }
    }
</script>

<style scoped>

    .progress-bar-success {
        background-color: #5cb85c;
    }
    .progress-bar-primary {
        background-color: #88c241;
    }
    .progress-bar-info {
        background-color: #1ebccd;
    }
    .progress-bar-warning {
        background-color: #ffbf36;;
    }
    .progress-bar-danger {
        background-color: #ff2f26;
    }
    /* style the background and the text color of the input ... */
    .vue-tags-input {
        color: #324148;
        height: calc(2.25rem + 4px);
        max-width: 100%;
    }

    .ti-new-tag-input {
        font-family: "Nunito", sans-serif !important;
    }

    .vue-tags-input .ti-new-tag-input {
        background: transparent;
        color: #b7c4c9;
    }

    .vue-tags-input .ti-input {
        padding: 4px 10px;
        transition: border-bottom 200ms ease;
    }

    /* we cange the border color if the user focuses the input */
    .vue-tags-input.ti-focus .ti-input {
        border-width: 2px;
        border-color: #e0e3e4;
    }

    /* some stylings for the autocomplete layer */
    .vue-tags-input .ti-autocomplete {
        background: #283944;
        border: 1px solid #8b9396;
        border-top: none;
    }

    /* the selected item in the autocomplete layer, should be highlighted */
    .vue-tags-input .ti-item.ti-selected-item {
        background: #ebde6e;
        color: #283944;
    }

    /* style the placeholders color across all browser */
    .vue-tags-input ::-webkit-input-placeholder {
        color: #a4b1b6;
    }

    .vue-tags-input ::-moz-placeholder {
        color: #a4b1b6;
    }

    .vue-tags-input :-ms-input-placeholder {
        color: #a4b1b6;
    }

    .vue-tags-input :-moz-placeholder {
        color: #a4b1b6;
    }

    /* default styles for all the tags */
    .vue-tags-input .ti-tag {
        position: relative;
        background: #ebde6e;
        color: #283944;
    }

    /* we defined a custom css class in the data model, now we are using it to style the tag */
    .vue-tags-input .ti-tag.custom-class {
        background: transparent;
        border: 1px solid #ebde6e;
        color: #ebde6e;
        margin-right: 4px;
        border-radius: 0px;
        font-size: 13px;
    }

    /* the styles if a tag is invalid */
    .vue-tags-input .ti-tag.ti-invalid {
        background-color: #e88a74;
    }

    /* if the user input is invalid, the input color should be red */
    .vue-tags-input .ti-new-tag-input.ti-invalid {
        color: #e88a74;
    }

    /* if a tag or the user input is a duplicate, it should be crossed out */
    .vue-tags-input .ti-duplicate span,
    .vue-tags-input .ti-new-tag-input.ti-duplicate {
        text-decoration: line-through;
    }

    /* if the user presses backspace, the complete tag should be crossed out, to mark it for deletion */
    .vue-tags-input .ti-tag:after {
        transition: transform .2s;
        position: absolute;
        content: '';
        height: 2px;
        width: 108%;
        left: -4%;
        top: calc(50% - 1px);
        background-color: #000;
        transform: scaleX(0);
    }

    .vue-tags-input .ti-deletion-mark:after {
        transform: scaleX(1);
    }
</style>
