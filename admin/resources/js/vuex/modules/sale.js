export default {
    state: {
        sales: []
    },
    mutations: {
        LOAD_SALES( state, data ) {
            state.sales = data;
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
        }
    }
}
