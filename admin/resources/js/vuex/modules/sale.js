export default {
    state: {
        sales: [],
        serviceVoucher: [],
        serviceSummary: [],
        code: '',
        error: '',
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
            dateEmision: '',
            customerName: '',
            customerDocument: '',
            customerAdress: '',
            customerUbigeo: '',
            details: [],
            code: ''
        },
        configForm: {
            disabled: true,
            readOnly: true,
            typeDocuments: [],
            amount: 0,
            today: ''
        }
    },
    mutations: {
        CHANGE_FORM_DATA( state, data ) {
            state.form = data;
        },
        CHANGE_FORM_DATA_V2( state ) {
            state.form = {
                service: 0,
                document: '',
                typeVoucher: 0,
                subTotal: 0,
                igv: 0,
                total: 0,
                paidOut: 0,
                minPay: 0,
                maxPay: 0,
                outstanding: 0,
                dateEmision: '',
                customerName: '',
                customerDocument: '',
                customerAdress: '',
                customerUbigeo: '',
                details: [],
                code: ''
            }
        },
        LOAD_SALES( state, data ) {
            state.sales = data;
        },
        LOAD_VOUCHERS( state, data ) {
            state.serviceVoucher = data.vouchers;
            state.serviceSummary = data.summary;
        },
        CHANGE_VOUCHER_CODE( state, code ) {
            state.code = code;
        },
        ADD_ERROR( state, error ) {
            state.error = error;
        },
        CHANGE_CONFIG_FORM( state, data ) {
            state.configForm.disabled = data.disabled;
            state.configForm.readOnly = data.readOnly;
            state.configForm.typeDocuments = data.typeDocuments;
            state.configForm.amount = data.amount;
            state.configForm.today = data.today;
        }
    },
    actions: {
        registerSales({ commit, state }, parameters ) {
            return new Promise( ( resolve, reject ) => {
                let params = parameters.data;
                let url = '/sales/new/';
                let form = {
                    service: state.form.service,
                    amount: params.amount,
                    emission: state.form.dateEmision
                };
                axios.post( url, form ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'CHANGE_FORM_DATA_V2' );
                    }
                    resolve( response );
                }).catch( errors => {
                    reject( errors )
                })
            });
        },
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
        },
        chargeDataByCode({ commit, state}, parameters ) {
            let params = parameters.data;
            if( params.code ) {
                let url = '/sale/search-by-code/' + params.code + '/';
                this.commit( 'CHANGE_VOUCHER_CODE', params.code );
                axios.get( url ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        let selected = result.service;
                        let formNew = {
                            service: selected.id,
                            document: selected.voucher.document,
                            typeVoucher: selected.voucher.typeDocument,
                            subTotal: selected.subTotal,
                            igv: selected.igv,
                            total: selected.total,
                            paidOut: selected.paidOut,
                            minPay: selected.minPay,
                            maxPay: selected.maxPay,
                            outstanding: selected.outstanding,
                            details: selected.details,
                            dateEmision: selected.dateEmision,
                            customerName: selected.customer.name,
                            customerDocument: selected.customer.typeDocumentName + ' ' + selected.customer.document,
                            customerAdress: selected.customer.address,
                            customerUbigeo: selected.customer.ubigeo,
                            code: selected.code,
                        };
                        let configForm = {
                            disabled: false,
                            readOnly: false,
                            typeDocuments: selected.voucher.typeDocuments,
                            amount: selected.minPay,
                            today: selected.today
                        };

                        commit( 'CHANGE_CONFIG_FORM', configForm );
                        commit( 'CHANGE_FORM_DATA', formNew );
                    } else {
                        this.commit( 'ADD_ERROR', result.msg );
                    }
                }).catch( errors => {
                    this.commit( 'ADD_ERROR', errors );
                })
            }
        }
    }
}
