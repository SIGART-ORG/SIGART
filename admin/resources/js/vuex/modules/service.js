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
        form: {
            service: 0,
            document: '',
            typeVoucher: 0,
            subTotal: 0,
            igv: 0,
            total: 0,
            paidOut: 0,
            minPay: 0,
            outstanding: 0,
            details: []
        }
    },
    mutations: {
        LOAD_SERVICE( state, data ) {
            state.services = data.records;
            state.pagination = data.pagination;
        },
        CHANGE_SERVICE( state, data ) {
            state.serviceId = parseInt( data );
        },
        CHANGE_FORM_DATA( state, data ) {
            state.form = data;
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
