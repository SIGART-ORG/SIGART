export default {
    state: {
        stages: [],
        name: '',
        service: 0,
        dateStart: '',
        dateEnd: ''
    },
    mutations: {
        LOAD_STAGES( state, data ) {
            state.stages = data;
        },
        CLEAR_FORM( state ) {
            state.name = '';
            state.dateStart = '';
            state.dateEnd = '';
        }
    },
    actions: {
        loadStages( context ) {
            let data = [];
            context.commit( 'LOAD_STAGES', data );
        },
        addStage({ commit, state }) {
            let form = {
                name: state.name,
                start: state.dateStart,
                end: state.dateEnd,
                service: 50
            };

            axios.post( '/service/stage/new/', form ).then(
                response => {
                    if ( response.status ) {
                        commit( 'CLEAR_FORM' );
                    }
                }
            );
        }
    }
}
