export default {
    state: {
        workers: []
    },
    mutations: {
        LOAD_WORKERS( state, workers ) {
            state.workers = workers;
        }
    },
    actions: {
        loadWorkersV2({ commit, rootState }) {
            let service = rootState.Service.serviceId;
            let url = '/service/' + service + '/workers/';
            axios.get( url ).then( response => {
                let result = response.data;
                if( result.status ) {
                    commit( 'LOAD_WORKERS', result.workers );
                }
            }).catch( errors => {
                commit( 'ADD_ERRORS', errors );
            })
        }
    }
}
