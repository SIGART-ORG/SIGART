export default {
    state: {
        currentTab: '',
        referenceTerms: [],
        idSQ: 0,
        formId: 0,
        formArea: '',
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
    },
    mutations: {
        CHANGE_CURRENT_RT( state, data ) {
            state.currentTab = data;
        },
        LOAD_DATA( state, data ) {
            state.formId = data.id;
            state.formArea = data.area;
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
        }
    },
    actions: {
        loadReference( { commit, state }) {
            let saleQuotation = state.idSQ;
            axios.get( '/reference-term/' + saleQuotation + '/data' )
                .then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'LOAD_DATA', result.reference );
                    }
                });
        }
    }
}
