export default {
    state: {
        services: [],
        serviceId: 0,
        pagination: {
            'total': 0,
            'current_page': 0,
            'per_page': 0,
            'last_page': 0,
            'from': 0,
            'to': 0,
        },
        offset: 3,
    },
    mutations: {
        LOAD_SERVICE( state, data ) {
            state.services = data.records;
            state.pagination = data.pagination;
        },
        CHANGE_SERVICE( state, data ) {
            state.serviceId = parseInt( data );
        }
    },
    actions: {
        loadServices( context ) {
            axios.get( '/service' )
                .then( response => {
                    context.commit( 'LOAD_SERVICE', response.data );
                });
        },
        changeService( context, id ) {
            context.commit( 'CHANGE_SERVICE', id );
        }
    }
}
