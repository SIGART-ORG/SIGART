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
            dateEmision: '',
            customerName: '',
            customerDocument: '',
            customerAdress: '',
            customerUbigeo: '',
            details: []
        },
        columns: {
            toStart: { total: 0, records: [] },
            inProcess: { total: 0, records: [] },
            finished: { total: 0, records: [] },
            observed: { total: 0, records: [] },
            finalized: { total: 0, records: [] }
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
                outstanding: 0,
                dateEmision: '',
                customerName: '',
                customerDocument: '',
                customerAdress: '',
                customerUbigeo: '',
                details: []
            }
        },
        LOAD_TASKS( state, data ) {
            state.columns.toStart = data.toStart;
            state.columns.inProcess = data.inProcess;
            state.columns.finished = data.finished;
            state.columns.observed = data.observed;
            state.columns.finalized = data.finalized;
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
        },
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
            })
        },
        loadDetailService({ commit, state }) {
            return new Promise( ( resolve, reject ) => {
                let url = '/service/' + state.serviceId + '/data';
                axios.post( url ).then( response => {

                }).catch( errors => {
                    reject( errors )
                });
            })
        },
        loadTools() {

        },
        loadTasksByService({ commit, state }) {
            return new Promise( ( resolve, reject ) => {
                let url = '/service/' + state.serviceId + '/tasks/';
                axios.get( url ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'LOAD_TASKS', result.columns );
                    } else {
                        reject( ['Error al traer la data, consulte con su administrador.']);
                    }
                }).catch( errors => {
                    reject( errors )
                });
            })
        },
        changeColumnTask( { commit, state }, parameters  ) {
            return new Promise( ( resolve, reject ) => {
                let params = parameters.data;
                let url = '/service/task/column/';
                let form = {
                    task: params.task,
                    column: params.column
                };
                axios.post( url, form ).then( response => {
                    resolve( response.data.status );
                }).catch( errors => {
                    reject( errors );
                })
            });
        }
    }
}
