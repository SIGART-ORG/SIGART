export default {
    state: {
        module: '/notifications',
        search: '',
        notifications: [],
        pagination: {
            total: 0,
            current_page: 1,
            per_page: 0,
            last_page: 0,
            from: 0,
            to: 0
        },
    },
    mutations: {
        LOAD_NOTIFICATION_LIST( state, data ) {
            state.notifications = data;
        },
        PAGINATE( state, paginate ) {
            state.pagination = paginate;
        },
    },
    actions: {
        loadNotifications({ commit, state }) {
            let url = state.module;

            axios.get( url, {
                params: {
                    search: state.search
                }
            }).then( response => {
                let result = response.data;
                if( result.status ) {
                    commit( 'LOAD_NOTIFICATION_LIST', result.notifications );
                    commit( 'PAGINATE', result.pagination );
                }
            }).catch( errors => {
                console.log( errors );
            });
        },
    }
}
