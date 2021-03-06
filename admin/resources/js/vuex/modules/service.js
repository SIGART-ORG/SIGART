export default {
    state: {
        services: [],
        serviceDetail: {},
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
        columns: {
            toStart: { total: 0, records: [] },
            inProcess: { total: 0, records: [] },
            finished: { total: 0, records: [] },
            observed: { total: 0, records: [] },
            finalized: { total: 0, records: [] }
        },
        voucherFile: {},
        isEditable: false
    },
    mutations: {
        SET_FILE( state, payload ) {
            state.voucherFile = payload.value;
        },
        LOAD_SERVICE( state, data ) {
            state.services = data.records;
            state.pagination = data.pagination;
        },
        LOAD_SERVICE_DETAILS( state, data ) {
            state.serviceDetail = data;
        },
        CHANGE_SERVICE( state, data ) {
            state.serviceId = parseInt( data );
        },
        LOAD_TASKS( state, data ) {
            state.columns.toStart = data.toStart;
            state.columns.inProcess = data.inProcess;
            state.columns.finished = data.finished;
            state.columns.observed = data.observed;
            state.columns.finalized = data.finalized;
        },
        SET_IS_EDITABLE( state, data ) {
            state.isEditable = data;
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
        loadDetailService({ commit, state }) {
            return new Promise( ( resolve, reject ) => {
                let url = '/service/' + state.serviceId + '/data';
                axios.get( url ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'LOAD_SERVICE_DETAILS', result.data );
                        commit( 'SET_IS_EDITABLE', result.data.idEditable );
                    }
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
        changeColumnTask( { commit, state }, parameters ) {
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
        },
        generatePay({ commit, rootState }) {
            return new Promise( ( resolve, reject ) => {
                let serviceId = rootState.Service.serviceId;
                let url = '/service/' + serviceId + '/generate-second-payment';
                axios.post( url ).then( response => {
                    resolve( response.data.status );
                }).catch( errors => {
                    reject( errors );
                })
            });
        },
        uploadVoucher({ commit, state }, parameters) {
            return new Promise( ( resolve, reject ) => {
                let params = parameters.data;
                let url = '/sales/' + params.idVoucher + '/upload/';
                let formData = new FormData();
                formData.append('voucherFile', state.voucherFile );
                axios.post( url, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(
                    response => {
                        if( response.status ) {
                            commit('SET_FILE', {});
                            resolve( response );
                        }
                        else {
                            reject( response );
                        }
                    }
                ).catch( errors => {
                    reject( errors );
                });
            });
        }
    }
}
