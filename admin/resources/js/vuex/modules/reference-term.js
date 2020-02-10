export default {
    state: {
        currentTab: '',
        referenceTerms: [],
        idSQ: 0,
        formId: 0,
        formArea: '',
        formDelivery: '',
        formActivity: '',
        formObjective: '',
        formSpecializedArea: '',
        formDaysExecution: 1,
        formExecutionAddress: '',
        formAddressReference: null,
        formMethodPayment: '',
        formConformanceGrant: '',
        formWarrantyMonth: 1,
        formObervations: null,
        formDetails: null,
        formPdf: null,
        formCustomer: {},
        formUbigeo: {
            departament: '0',
            province: '0',
            district: '0',
        },
        arrDepartaments: [],
        arrProvinces: [],
        arrDistricts: [],
    },
    mutations: {
        LOAD_DEPARTAMENTS( state, data ) {
            state.arrDepartaments = data;
            state.arrProvinces = [];
            state.arrDistricts = [];
        },
        LOAD_PROVINCES( state, data ) {
            state.arrProvinces = data;
            state.arrDistricts = [];
        },
        LOAD_DISTRICTS( state, data ) {
            state.arrDistricts = data;
        },
        CHANGE_CURRENT_RT( state, data ) {
            state.currentTab = data;
        },
        LOAD_REFERENCES( state, data ) {
            state.referenceTerms = data;
        },
        LOAD_DATA( state, data ) {
            state.formId = data.id;
            state.formArea = data.area;
            state.formDelivery = data.delivery;
            state.formActivity = data.activity;
            state.formObjective = data.objective;
            state.formSpecializedArea = data.specializedArea;
            state.formDaysExecution = data.daysExecution;
            state.formExecutionAddress = data.executionAddress;
            state.formAddressReference = data.addressReference;
            state.formMethodPayment = data.methodPayment;
            state.formConformanceGrant = data.conformanceGrant;
            state.formWarrantyMonth = data.warrantyMonth;
            state.formObervations = data.obervations;
            state.formDetails = data.details;
            state.formPdf = data.pdf;
            state.formPdfSR = data.pdfSR;
            state.formPdfSO = data.pdfSO;
            state.formCustomer = data.customer;
            state.formUbigeo = data.ubigeo;
        }
    },
    actions: {
        loadDepartaments( context ) {
            axios.get( '/departaments/' )
                .then( response => {
                    context.commit( 'LOAD_DEPARTAMENTS', response.data.departaments );
                });
        },
        loadProvinces( { commit, state } ) {
            axios.get( '/provinces/' + state.formUbigeo.departament )
                .then( response => {
                    commit( 'LOAD_PROVINCES', response.data.provinces )
                });
        },
        loadDistrict( { commit, state } ) {
            axios.get( '/districts/' + state.formUbigeo.departament + '/' + state.formUbigeo.province )
                .then( response => {
                    commit( 'LOAD_DISTRICTS', response.data.districts );
                });
        },
        loadReferences( { commit }) {
            axios.get( '/reference-term/' )
                .then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'LOAD_REFERENCES', result.references );
                    }
                });
        },
        loadReference( { commit, state }) {
            let saleQuotation = state.idSQ;
            axios.get( '/reference-term/' + saleQuotation + '/data' )
                .then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'LOAD_DATA', result.reference );
                    }
                });
        },
        saveRT({ state }) {
            return new Promise( ( resolve, reject ) => {
                let url = '/reference-term/update/';
                let form = {
                    id: state.formId,
                    activity: state.formActivity,
                    objective: state.formObjective,
                    daysExecution: state.formDaysExecution,
                    executionAddress: state.formExecutionAddress,
                    addressReference: state.formAddressReference,
                    district: state.formUbigeo.district,
                    methodPayment: state.formMethodPayment,
                    warrantyMonth: state.formWarrantyMonth,
                    obervations: state.formObervations,
                    details: state.formDetails,
                };

                axios.put( url, form ).then( response => {
                    resolve( response );
                }).catch( errors => {
                    reject( errors )
                })
            })
        },
        action({ state }, parameters ) {
            return new Promise( ( resolve, reject ) => {
                let params = parameters.data;
                let url = '/reference-term/action/';
                let form = {
                    id: params.id,
                    action: params.action,
                    type: params.type,
                    typeAdm: params.typeAdm
                };
                axios.put( url, form ).then( response => {
                    resolve( response );
                }).catch( errors => {
                    reject( errors );
                });
            })
        },
        sendOrderPay({ state }, parameters ) {
            return new Promise(( resolve, reject ) => {
                let params = parameters.data;
                let url = '/service/send-order-pay/';
                let form = {
                    service: params.service
                };
                axios.put( url, form ).then( response => {
                    resolve( response );
                }).catch( errors => {
                    reject( errors );
                })
            })
        }
    }
}
