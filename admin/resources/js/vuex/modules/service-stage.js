export default {
    state: {
        stages: [],
        name: '',
        errors: [],
        stageId: 0
    },
    mutations: {
        LOAD_STAGES( state, data ) {
            state.stages = data;
        },
        CLEAR_FORM( state ) {
            state.name = '';
        },
        ADD_ERRORS( state, data ) {
            state.errors.push( data );
        },
        CHANGE_STAGE( state, newStage ) {
            state.stageId = newStage
        }
    },
    actions: {
        loadStages({ commit, rootState }) {

            let service = rootState.Service.serviceId;
            let url = '/service/' + service + '/stage';
            axios.get( url ).then( response => {
                let result = response.data;
                if( result.status ) {
                    commit( 'LOAD_STAGES', result.stages );
                }
            }).catch( errors => {
                commit( 'ADD_ERRORS', errors );
            })
        },
        addStage({ commit, state, rootState }) {
            return new Promise( ( resolve, reject ) => {
                let form = {
                    name: state.name,
                    service: rootState.Service.serviceId
                };
                let url = '/service/stage/new/';
                axios.post( url, form ).then(
                    response => {
                        if ( response.status ) {
                            commit( 'CLEAR_FORM' );
                        }
                        resolve( response );
                    }
                ).catch( errors => {
                    reject( errors );
                });
            });
        },
        changeStage( context, newStage ) {
            context.commit( 'CHANGE_STAGE', newStage );
        }
    }
}
