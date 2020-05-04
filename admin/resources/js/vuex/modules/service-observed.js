export default {
    state: {
        observeds: [],
        observedId: 0,
        tasks: []
    },
    mutations: {
        LOAD_OBSERVEDS( state, observeds ) {
            state.observeds = observeds;
        },
        CHANGE_OBSERVED_ID( state, newId ) {
            state.observedId = newId;
        },
        LOAD_TASKS( state, data ) {
            state.tasks = data;
        }
    },
    actions: {
        loadOberveds({ commit, rootState }) {
            let service = rootState.Service.serviceId;
            let url = '/service/' + service + '/observations/';
            axios.get( url ).then( response => {
                let result = response.data;
                if( result.status ) {
                    commit( 'LOAD_OBSERVEDS', result.observations );
                }
            }).catch( errors => {
                console.log( errors );
            })
        },
        registerReply({ commit, state }, parameters) {
            return new Promise( ( resolve, reject ) => {
                let taskId = state.observedId;
                let params = parameters.data;
                let url = '/stage/observed/' + taskId + '/reply/';
                let formData = {
                    typeReply: params.typeReply,
                    description: params.description,
                    tasksSelected: params.tasksSelected
                };

                axios.post(url, formData).then( response => {
                    if( response.status ) {
                        resolve( response );
                    }
                    else {
                        reject( response );
                    }
                });
            });
        },
        loadtasks({ commit, state }) {
            let url = '/stage/' + state.observedId + '/tasks-obs/';
            axios.get( url ).then( response => {
                if( response.status ) {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'LOAD_TASKS', result.tasks );
                    }
                }
            });
        }
    }
}
