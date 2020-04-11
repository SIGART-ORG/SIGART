export default {
    state: {
        idVoucher: 0,
        vouchers: [],
    },
    mutations: {
        LOAD_VOUCHERS( state, data ) {
            state.vouchers = data;
        },
        CHANGE_VOUCHER_ID( state, id ) {
            state.idVoucher = id;
        },
    },
    actions: {
        loadVouchersSend({ commit }) {
            let url = '/sales/vouchers/v2/';
            axios.get( url ).then( response => {
                let result = response.data;
                if( result.status ) {
                    commit( 'LOAD_VOUCHERS', result.vouchers );
                }
            }).catch( errors => {
                console.log( errors );
            });
        },
        approvedVoucher({ commit, state }) {
            return new Promise(( resolve, reject ) => {
                let url = '/sales/voucher/' + state.idVoucher +  '/approved/';
                axios.post( url ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'CHANGE_VOUCHER_ID', 0 );
                        resolve( result );
                    }
                }).catch( errors => {
                    reject( errors );
                });
            });
        },
        invalidVoucher({ commit, state })  {
            return new Promise(( resolve, reject ) => {
                let url = '/sales/voucher/' + state.idVoucher +  '/invalid/';
                axios.post( url ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'CHANGE_VOUCHER_ID', 0 );
                        resolve( result );
                    }
                }).catch( errors => {
                    reject( errors );
                });
            });
        },
    }
}
