export default {
    state: {
        sales: [],
        serviceVoucher: [],
        serviceSummary: []
    },
    mutations: {
        LOAD_SALES( state, data ) {
            state.sales = data;
        },
        LOAD_VOUCHERS( state, data ) {
            state.serviceVoucher = data.vouchers;
            state.serviceSummary = data.summary;
        }
    },
    actions: {
        loadSales( { state }, parameters ) {
            return new Promise(( resolve, reject ) => {
                let params = parameters.data;
                let url = '/sales/';
                let form = {
                    search: params.search
                };
                axios.get( url, form ).then( response => {
                    resolve( response );
                }).catch( errors => {
                    reject( errors );
                })
            });
        },
        loadVouchers({ commit, rootState }) {
            let service = rootState.Service.serviceId;
            let url = '/service/' + service + '/voucher/';
            axios.get( url ).then( response => {
                let result = response.data;
                if( result.status ) {
                    commit( 'LOAD_VOUCHERS', result.data );
                }
            }).catch( errors => {
                console.log( errors );
            })
        }
    }
}
