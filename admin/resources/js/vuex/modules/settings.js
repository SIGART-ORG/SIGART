export default {
    state: {
        current: '',
        currents: {
            req: 'service-requirement',
            stage: 'service-stage',
        }
    },
    mutations:{
        LOAD_SETTINGS( state, data ) {
            state.current = data.current;
        },
        CHANGE_CURRENT( state, newCurrent ) {
            state.current = newCurrent;
        }
    },
    actions: {
        loadSettings( context ) {
            let settings = {
                current: 'service-requirement'
            };
            context.commit( 'LOAD_SETTINGS', settings );
        },
        changeCurrent( context, newCurrent ) {
            context.commit( 'CHANGE_CURRENT', newCurrent );
        }
    }
}
