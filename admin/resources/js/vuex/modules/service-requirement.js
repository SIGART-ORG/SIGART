export default {
    state: {
        page: 'list',
        requirementId: 0,
        requirements: [],
        requirementsDetails: [],
        stage: 0,
    },
    mutations: {
        LOAD_REQUIREMENTS( state, data ) {
            state.requirements = data;
        },
        CHANGE_PAGE( state, newValue ) {
            state.page = newValue;
        },
        ADD_DETAILS( state, data ) {
            state.requirementsDetails.push(data);
        },
        CHANGE_DETAILS( state, data ) {
            state.requirementsDetails = data;
        },
        CHANGE_REQUIREMENT_ID( state, newId ) {
            state.requirementId = newId;
        },
        CHANGE_STAGE( state, newState ) {
            state.stage = newState;
        }
    },
    actions: {
        listRequirements({commit, rootState}) {
            let  url = '/service/' + rootState.Service.serviceId + '/requirements/';
            axios.get( url ).then( response => {
                let result = response.data;
                if( result.status ) {
                    commit( 'LOAD_REQUIREMENTS', result.requirements )
                }
            }).catch( errors => {
                console.log( errors );
            });
        },
        listRequirementsByStage({commit, state }) {
            let  url = '/output-orders/requirements/' + state.stage;
            axios.get( url ).then( response => {
                let result = response.data;
                if( result.status ) {
                    commit( 'LOAD_REQUIREMENTS', result.requirements )
                }
            }).catch( errors => {
                console.log( errors );
            });
        },
        registerRequirement({ commit, rootState, state }) {
            return new Promise( ( resolve, reject ) => {
                let url = '/service/requirements/';
                let from = {
                    service: rootState.Service.serviceId,
                    details: state.requirementsDetails
                };

                axios.post( url, from ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'CHANGE_DETAILS', [] );
                        resolve( result );
                    }
                }).catch( errors => {
                    reject( errors );
                });
            });
        },
        send_requirements({ commit, state }) {
            return new Promise( ( resolve, reject ) => {
                let url = '/service/requirements/' + state.requirementId + '/send/' ;

                axios.put( url ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        resolve( result );
                    }
                }).catch( errors => {
                    reject( errors );
                });
            });
        }
    }
}
