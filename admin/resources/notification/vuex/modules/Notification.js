export default {
    state: {
        module: '/notifications',
        lastsNotifications: []
    },
    mutations: {
        LOAD_NOTIFICATION( state, data ) {
            state.lastsNotifications = data;
        }
    },
    actions: {
        loadlastNotifications({ commit, state }) {
            let url = state.module + '/lasts';
            axios.get( url ).then( response => {
                let result = response.data;
                if( result.status ) {
                    commit( 'LOAD_NOTIFICATION', result.notifications );
                }
            }).catch( errors => {
                console.log( errors );
            });
        }
    }
}
