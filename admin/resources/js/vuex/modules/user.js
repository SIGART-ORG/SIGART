export default {
    state: {
        users: []
    },
    mutations: {
        LOAD_USERS( state, data ) {
            state.users = data;
        }
    },
    actions: {
        loadUser({commit}) {
            let url = '/output-orders/user/';
            axios.get( url ).then( response => {
                let result = response.data;
                if( result ) {
                    commit( 'LOAD_USERS', result.users );
                }
            }).catch( errors => {
                console.log( errors )
            });
        }
    }
}
