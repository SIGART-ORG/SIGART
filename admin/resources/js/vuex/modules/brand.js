export default {
    state: {
        module: '/brands',
        idBrand: 0,
        activate: false,
        search: '',
        brands: [],
        brand: {
            id: 0,
            name: '',
            description: ''
        },
        page: 1,
        pagination: {
            total : 0,
            current_page : 0,
            per_page : 0,
            last_page : 0,
            from : 0,
            to : 0,
        },
        offset: 3
    },
    mutations: {
        LOAD_BRANDS( state, brands ) {
            state.brands = brands;
        },
        LOAD_BRAND( state, brand ) {
            state.brand = brand;
        },
        LOAD_PAGINATION( state, pagination ) {
            state.pagination = pagination;
        },
        CHANGE_PAGE_BRAND( state, page ) {
            state.page = page;
        },
        CHANGE_BRAND_ID( state, newId ) {
            state.idBrand = newId;
        },
        CHANGE_ACTIVATE( state, newActivate ) {
            state.activate = newActivate;
        }
    },
    actions: {
        loadBrands({ commit, state }) {
            let url = state.module;
            axios.get( url, {
                params: {
                    page: state.page,
                }
            }).then( response => {
                let result = response.data;
                commit( 'LOAD_BRANDS', result.brands );
                commit( 'LOAD_PAGINATION', result.pagination );
            }).catch( errors => {
                console.log( errors );
            });
        },
        storeBrand({ commit, state }) {
            return new Promise( (resolve, reject) => {
                let url = state.module + '/store';
                axios.post( url, {
                    name: state.brand.name,
                    description: state.brand.description,
                }).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'LOAD_BRAND', {
                            id: 0,
                            name: '',
                            description: ''
                        })
                    }
                    resolve( result );
                }).catch( errors => {
                    reject( errors );
                });
            });
        },
        updatebrand({commit, state}) {
            return new Promise( (resolve, reject) => {
                let url = state.module + '/update';
                axios.put( url, {
                    id: state.brand.id,
                    name: state.brand.name,
                    description: state.brand.description,
                }).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'LOAD_BRAND', {
                            id: 0,
                            name: '',
                            description: ''
                        })
                    }
                    resolve( result );
                }).catch( errors => {
                    reject( errors );
                });
            });
        },
        deleteBrand({commit, state}) {
            return new Promise( (resolve, reject) => {
                let url = state.module + '/' + state.idBrand;
                axios.delete( url ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        commit( 'CHANGE_BRAND_ID', 0 );
                    }
                    resolve( result );
                }).catch( errors => {
                    reject( errors );
                });
            });
        },
        activateBrand({commit, state}) {
            return new Promise( (resolve, reject) => {
                let url = state.module + '/' + state.idBrand + '/activate';
                axios.put( url, {
                    activate: state.activate
                }).then( response => {
                    let result = response.data;
                    if( result.state ) {
                        commit( 'CHANGE_BRAND_ID', 0 );
                        commit( 'CHANGE_ACTIVATE', false );
                    }
                    resolve( result );
                }).catch( errors => {
                    reject( errors );
                });
            });
        }
    }
}
