<template>
    <div class="service-board">
        <div class="row flex-nowrap">
            <div class="col-sm-4">
                <h5 clas="hk-sec-title">Por iniciar <strong>({{listToStart.total}})</strong></h5>
                <draggable class="list-group mt-20" :list="listToStart.records" group="people" @change="logStart" handle=".handle">
                    <div class="list-group-item" v-for="(element, index) in listToStart.records"
                         :key="element.id">
                        <div class="content-btn__top">
                            <i class="fa fa-arrows handle" title="Mover Tarea"></i>
                            <a href="javascript:;" class="text-info"><i class="fa fa-eye"></i></a>
                        </div>
                        <h6 class="list-group-item-heading mt-5">{{ element.name }}</h6>
                        <p class="list-group-item-text"><span class="badge badge-warning">{{ element.stageName }}</span></p>
                        <p class="list-group-item-text">{{ element.description }}</p>
                        <p class="list-group-item-text">
                            <i class="fa fa-users"></i>&nbsp{{ element.user.total }}
                            &nbsp;|&nbsp;
                            <i class="fa fa-comment"></i>&nbsp;45
                        </p>
                    </div>
                </draggable>
            </div>
            <div class="col-sm-4">
                <h5 clas="hk-sec-title">En Proceso <strong>({{listInProcess.total}})</strong></h5>
                <draggable class="list-group mt-20" :list="listInProcess.records" group="people" @change="logInProcess" handle=".handle">
                    <div class="list-group-item" v-for="(element, index) in listInProcess.records"
                         :key="element.id">
                        <div class="content-btn__top">
                            <i class="fa fa-arrows handle" title="Mover Tarea"></i>
                            <a href="javascript:;" class="text-info"><i class="fa fa-eye"></i></a>
                        </div>
                        <h6 class="list-group-item-heading mt-5">{{ element.name }}</h6>
                        <p class="list-group-item-text"><span class="badge badge-info">{{ element.stageName }}</span></p>
                        <p class="list-group-item-text">{{ element.description }}</p>
                        <p class="list-group-item-text">
                            <i class="fa fa-users"></i>&nbsp;{{ element.user.total }}
                            &nbsp;|&nbsp;
                            <i class="fa fa-comment"></i>&nbsp;45
                        </p>
                    </div>
                </draggable>
            </div>
            <div class="col-sm-4">
                <h5 clas="hk-sec-title">Terminado <strong>({{listFinished.total}})</strong></h5>
                <draggable class="list-group mt-20" :list="listFinished.records" group="people" @change="logFinished" handle=".handle">
                    <div class="list-group-item" v-for="(element, index) in listFinished.records"
                         :key="element.id">
                        <div class="content-btn__top">
                            <i class="fa fa-arrows handle" title="Mover Tarea"></i>
                            <a href="javascript:;" class="text-info"><i class="fa fa-eye"></i></a>
                        </div>
                        <h6 class="list-group-item-heading mt-5">{{ element.name }}</h6>
                        <p class="list-group-item-text"><span class="badge badge-primary">{{ element.stageName }}</span></p>
                        <p class="list-group-item-text">{{ element.description }}</p>
                        <p class="list-group-item-text">
                            <i class="fa fa-users"></i>&nbsp;{{ element.user.total }}
                            &nbsp;|&nbsp;
                            <i class="fa fa-comment"></i>&nbsp;45
                        </p>
                    </div>
                </draggable>
            </div>
            <div class="col-sm-4">
                <h5 clas="hk-sec-title">Observado <strong>({{listOrserved.total}})</strong></h5>
                <draggable class="list-group mt-20" :list="listOrserved.records" group="people" @change="logOrserved" handle=".handle">
                    <div class="list-group-item" v-for="(element, index) in listOrserved.records"
                         :key="element.id">
                        <div class="content-btn__top">
                            <i class="fa fa-arrows handle" title="Mover Tarea"></i>
                            <a href="javascript:;" class="text-info"><i class="fa fa-eye"></i></a>
                        </div>
                        <h6 class="list-group-item-heading mt-5">{{ element.name }}</h6>
                        <p class="list-group-item-text"><span class="badge badge-danger">{{ element.name }}</span></p>
                        <p class="list-group-item-text">{{ element.description }}</p>
                        <p class="list-group-item-text">
                            <i class="fa fa-users"></i>&nbsp;{{ element.user.total }}
                            &nbsp;|&nbsp;
                            <i class="fa fa-comment"></i>&nbsp;45
                        </p>
                    </div>
                </draggable>
            </div>
            <div class="col-sm-4">
                <h5 clas="hk-sec-title">Finalizado <strong>({{listFinalized.total}})</strong></h5>
                <small class="text-muted">Validado por el cliente</small>
                <draggable class="list-group mt-20" :list="listFinalized.records" group="people" @change="logFinalized" handle=".handle">
                    <div class="list-group-item" v-for="(element, index) in listFinalized.records"
                         :key="element.id">
                        <div class="content-btn__top">
                            <i class="fa fa-arrows handle" title="Mover Tarea"></i>
                            <a href="javascript:;" class="text-info"><i class="fa fa-eye"></i></a>
                        </div>
                        <h6 class="list-group-item-heading mt-5">{{ element.name }}</h6>
                        <p class="list-group-item-text"><span class="badge badge-danger">{{ element.name }}</span></p>
                        <p class="list-group-item-text">{{ element.description }}</p>
                        <p class="list-group-item-text">
                            <i class="fa fa-users"></i>&nbsp;{{ element.user.total }}
                            &nbsp;|&nbsp;
                            <i class="fa fa-comment"></i>&nbsp;45
                        </p>
                    </div>
                </draggable>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable';
    import { mapMutations } from 'vuex';
    export default {
        name: "ServiceBoardV2",
        created() {
            this.$store.dispatch( 'loadTasksByService' );
        },
        components: {
            draggable
        },
        computed: {
            listToStart: {
                get:function() {
                    return this.$store.state.Service.columns.toStart;
                },
                set:function( newValue ) {
                    this.$store.state.Service.columns.toStart = newValue;
                }
            },
            listInProcess: {
                get:function() {
                    return this.$store.state.Service.columns.inProcess;
                },
                set:function( newValue ) {
                    this.$store.state.Service.columns.inProcess = newValue;
                }
            },
            listFinished: {
                get:function() {
                    return this.$store.state.Service.columns.finished;
                },
                set:function( newValue ) {
                    this.$store.state.Service.columns.finished = newValue
                }
            },
            listOrserved: {
                get:function() {
                    return this.$store.state.Service.columns.observed;
                },
                set:function( newValue ) {
                    this.$store.state.Service.columns.observed = newValue;
                }
            },
            listFinalized: {
                get:function() {
                    return this.$store.state.Service.columns.finalized;
                },
                set:function( newValue ) {
                    this.$store.state.Service.columns.finalized = newValue;
                }
            }
        },
        methods: {
            changeColumn( column, task ) {
                this.$store.dispatch({
                    type: 'changeColumnTask',
                    data: {
                        task: task,
                        column: column
                    }
                }).then( response => {
                    if( response ) {
                        this.$store.dispatch( 'loadTasksByService' );
                    }
                })
            },
            logStart: function( evt ) {
                if( evt.added ) {
                    let element = evt.added.element;
                    this.changeColumn( 'start', element.id );
                }
            },
            logInProcess: function( evt ) {
                if( evt.added ) {
                    let element = evt.added.element;
                    this.changeColumn( 'inProcess', element.id );
                }
            },
            logFinished: function( evt ) {
                if( evt.added ) {
                    let element = evt.added.element;
                    this.changeColumn( 'finished', element.id );
                }
            },
            logOrserved: function( evt ) {
                if( evt.added ) {
                    let element = evt.added.element;
                    this.changeColumn( 'observed', element.id );
                }
            },
            logFinalized: function( evt ) {
                if( evt.added ) {
                    let element = evt.added.element;
                    this.changeColumn( 'finalized', element.id );
                }
            }
        }
    }
</script>

<style scoped>

</style>
