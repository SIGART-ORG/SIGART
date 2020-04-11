export default {
    state: {
        page: 'list',
        requirements: [],
        requirementsDetails: []
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
        }
    }
}
