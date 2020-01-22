export default {
    state: {
        currentTab: '',
        referenceTerms: [],
        formId: 0
    },
    mutations: {
        LOAD_DATA( state, data ) {

        }
    },
    actions: {
        getLoadDetail( { commit, state }) {
            let saleQuotation = state.formId;
            axios.get( '/reference-term/' + saleQuotation + '/data' )
                .then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'LOAD_SERVICE', result.reference );
                    }
                });
        }
    }
}
