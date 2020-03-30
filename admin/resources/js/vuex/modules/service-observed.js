export default {
    state: {
        observeds: [],
        observedId: 0
    },
    mutations: {
        LOAD_OBSERVEDS( state, observeds ) {
            state.observeds = observeds;
        },
        CHANGE_OBSERVED_ID( state, newId ) {
            state.observedId = newId;
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
                let url = '/task/observed/' + taskId + '/reply/';
                let formData = {
                    typeReply: params.typeReply,
                    description: params.description
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
        }
    }
}
