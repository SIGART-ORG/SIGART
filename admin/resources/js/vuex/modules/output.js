export default {
    state: {
        outputId: 0,
        outputs: [],
        output: {},
        outputsDetails: []
    },
    mutations: {
        LOAD_OUTPUT( state, data ) {
            state.output = data;
        },
        LOAD_OUTPUTS( state, data ) {
            state.outputs = data;
        },
        CHANGE_OUTPUT_ID( state, newId ) {
            state.outputId = newId;
        },
        LOAD_OUTPUTS_DETAILS( state, data ) {
            state.outputsDetails = data;
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
        },
        loadDetails({commit, state}) {
            return new Promise( (resolve, reject) => {
                let url = '/output-orders/' + state.outputId + '/details/';
                axios.get( url ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'LOAD_OUTPUT', result.outputOrder );
                        commit( 'LOAD_OUTPUTS_DETAILS', result.details );
                    }
                    resolve( result );
                }).catch( errors => {
                    reject( errors );
                })
            });
        },
        saveOutputorder({commit, state}) {
            return new Promise(( resolve, reject ) => {
                let url = '/output-orders/' + state.outputId + '/save/';
                let form = {
                    userOutput: state.output.userOutput,
                    details: state.outputsDetails
                };

                axios.post( url, form ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'CHANGE_OUTPUT_ID', 0 );
                        commit( 'LOAD_OUTPUT', {} );
                        commit( 'LOAD_OUTPUTS_DETAILS', [] );

                    }
                    resolve( result );
                }).catch( errors => {
                    reject( errors );
                })
            });
        },
        sendOutputorder({commit, state}) {
            return new Promise(( resolve, reject ) => {
                let url = '/output-orders/' + state.outputId + '/send/';

                axios.post( url ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'CHANGE_OUTPUT_ID', 0 );
                    }
                    resolve( result );
                }).catch( errors => {
                    reject( errors );
                })
            });
        }
    }
}
