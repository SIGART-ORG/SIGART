export default {
    state: {
        observeds: [],
    },
    mutations: {
        LOAD_OBSERVEDS( state, observeds ) {
            state.observeds = observeds;
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
        }
    }
}
