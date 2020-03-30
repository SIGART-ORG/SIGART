//import ServiceStages from "./service-stage";

export default {
    state: {
        tasks: [],
        taskId: 0,
        headData: {
            service: {},
            stage: {},
            provider: {}
        },
        summary: [],
        formId: 0,
        formName: '',
        formDescription: '',
        formUsers: [],
    },
    mutations: {
        CHANGE_TASK_ID( state, newId ) {
            state.taskId = newId;
        },
        LOAD_HEAD( state, data ) {
            state.headData = data;
        },
        LOAD_TASKS( state, data ) {
            state.tasks = data.tasks;
            state.summary = data.summary;
        },
        CLEAR_FORM_TASK( state ) {
            state.formId = 0;
            state.formName = '';
            state.formDescription = '';
            state.formUsers = [];
        },
        LOAD_WORKERS( state, data ) {
            state.formUsers = data.workers;
        }
    },
    actions: {
        loadService({ commit, rootState }){
            let serviceStage = rootState.ServiceStages.stageId;
            let url = '/service/stage/task/' + serviceStage + '/head/';
            axios.get( url ).then( response => {
                let result = response.data;
                if( result.status ) {
                    commit( 'LOAD_HEAD', result.head );
                }
            }).catch( errors => {
                console.log( errors );
            });
        },
        addTask({ commit, state, rootState }) {
            return new Promise(( resolve, reject ) => {
                let url = '/service/task/new/';
                let service = rootState.Service.serviceId;
                let stage = rootState.ServiceStages.stageId;
                let form = {
                    id: state.formId,
                    name: state.formName,
                    description: state.formDescription,
                    users: state.formUsers,
                    stage,
                    service
                };

                if( state.formId > 0 ) {
                    url = '/service/task/update/';
                }

                axios.post( url, form ).then(
                    response => {
                        if( response.status ) {
                            commit( 'CLEAR_FORM_TASK' );
                        }
                        resolve( response );
                    }
                ).catch( errors => {
                    reject( errors );
                });
            });
        },
        loadTasks({ commit, rootState }) {
            let serviceStage = rootState.ServiceStages.stageId;
            let url = '/service/' + serviceStage + '/task/';
            axios.get( url ).then( response => {
                if( response.data.status ) {
                    commit( 'LOAD_TASKS', response.data );
                }
            }).catch( errors => {
                console.log( errors );
            })
        },
        loadWorkers({ commit, state }) {
            let url = '/service/task/workers/' + state.formId;
            axios.get( url ).then( response => {
                if( response.data.status ) {
                    commit( 'LOAD_WORKERS', response.data );
                } else {
                    console.log( 'Error al cargar data.' );
                }
            }).catch( errors => {
                console.log( errors );
            })
        },
        deleteTask({ commit, state }) {
            return new Promise( ( resolve, reject ) => {
                let url = '/service/task/' + state.formId + '/delete/';
                axios.get( url ).then( response => {
                    commit( 'CLEAR_FORM_TASK' );
                    resolve( response );
                }).catch( errors => {
                    reject( errors );
                });
            });
        }
    }
}
