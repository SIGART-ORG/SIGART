import Requirement from "./service-requirement";

export default {
    state: {
        outputs: []
    },
    mutations: {
        LOAD_OUTPUTS( state, data ) {
            state.outputs = data;
        }
    },
    actions: {
        loadOutputsOrders({ commit }) {
            let url = '/output-orders/';
            axios.get( url ).then( response => {
                let result = response.data;
                if( result.status ) {
                    commit( 'LOAD_OUTPUTS', result.outputorders );
                }
            });
        },
        storeOuputOrder({commit, rootState}) {
            return new Promise( (resolve, reject) => {
                let url = '/output-orders/';
                axios.post( url, {
                    requirement: rootState.Requirement.requirementId
                }).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        resolve( result );
                    } else {
                        reject( result );
                    }
                }).catch( errors => {
                    reject( errors );
                })
            });
        }
    }
}
