export default {
    state: {
        current: {
            sidebar: '',
            form: ''
        },
        currents: {
            req: 'service-detail',
            stage: 'service-detail',
        }
    },
    mutations:{
        LOAD_SETTINGS( state, data ) {
            state.current = data.current;
        },
        CHANGE_CURRENT( state, newCurrent ) {
            if( newCurrent.sidebar ) {
                state.current.sidebar = newCurrent.sidebar;
            }
            if( newCurrent.form ) {
                state.current.form = newCurrent.form;
            }
        }
    },
    actions: {
        loadSettings( context ) {
            let settings = {
                current: {
                    sidebar: 'service-detail',
                    form: 'service-detail'
                }
            };
            context.commit( 'LOAD_SETTINGS', settings );
        },
        changeCurrent( context, newCurrent ) {
            context.commit( 'CHANGE_CURRENT', newCurrent );
        }
    }
}
