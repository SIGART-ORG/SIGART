export default {
    state: {
        module: '/mails',
        search: '',
        mails: [],
        idMail: 0,
        pagination: {
            total: 0,
            current_page: 1,
            per_page: 0,
            last_page: 0,
            from: 0,
            to: 0
        },
        mail: {}
    },
    mutations: {
        CHANGE_SEARCH( state, search ) {
            state.search = search;
        },
        LOAD_MAIL_LIST( state, data ) {
            state.mails = data;
        },
        PAGINATE( state, paginate ) {
            state.pagination = paginate;
        },
        CHANGE_ID( state, newId ) {
            state.idMail = newId;
        },
        LOAD_MAIL( state, mail ) {
            state.mail = mail;
        }
    },
    actions: {
        loadMails({ commit, state }) {
            let url = state.module;

            axios.get( url, {
                params: {
                    search: state.search
                }
            }).then( response => {
                let result = response.data;
                if( result.status ) {
                    commit( 'LOAD_MAIL_LIST', result.mails );
                    commit( 'PAGINATE', result.pagination );
                }
            }).catch( errors => {
                console.log( errors );
            });
        },
        detail({ commit, state }) {
            return new Promise( ( resolve, reject ) => {
                let url = state.module + '/' + state.idMail + '/details';
                axios.get( url ).then( response => {
                    let result = response.data;
                    commit( 'LOAD_MAIL', result.mail );
                    resolve( result.status );
                }).catch( errors => {
                    reject( errors );
                })
            });
        }
    }
}
