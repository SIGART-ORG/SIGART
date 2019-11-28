<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Herramientas</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Buscar</label>
                                <input type="text" v-model="search" @keyup="list( 1, search )" class="form-control mb-2"
                                       id="inlineFormInput" placeholder="Buscar...">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click="list( 1, search )">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="hk-sec-wrapper">
            <h6 class="hk-sec-title">Listado</h6>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>SKU</th>
                                    <th>Nombre</th>
                                    <th>Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="arrList.length > 0" v-for="( row, idx ) in arrList" :key="row.id">
                                    <td>{{ idx + 1 }}</td>
                                    <td v-text="row.sku"></td>
                                    <td v-text="row.description"></td>
                                    <td>
                                        <button class="btn btn-outline-info" title="Editar" @click.prevent="openModal( 'update', row )">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-warning">
                                            <i class="fa fa-ban"></i>
                                        </button>
                                        <button class="btn btn-outline-success">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="btn btn-outline-danger">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                        <button class="btn btn-outline-gold">
                                            <i class="fa fa-cubes"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="hk-sec-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page-1, search)">Ant.</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="changePage(page, search)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page+1, search)">Sig.</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
        <b-modal ref="modal-form" size="lg" @ok="proccess" @hide="closeModal"></b-modal>
    </div>
</template>

<script>
    export default {
        name: "toolindex",
        data() {
            return {
                search: '',
                offset: 3,
                arrList: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                modal: {
                    action: '',
                    title: '',
                    data: {},
                }
            }
        },
        computed: {
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;

            }
        },
        methods: {

            changePage( page, search ){
                let me = this;
                me.pagination.current_page = page;
                me.list( page,search );
            },

            list( page, search ) {
                let me = this,
                    url = '/tool/?page=' + page + '&search='+ search;

                axios.get( url ).then( function( response ) {

                    let result = response.data;
                    me.arrList = result.records.data;
                    me.pagination = result.pagination;

                }).catch( function( error ) {
                    console.log( error );
                });
            },
            openModal( action, data = [] ) {
                let me = this;

                me.modal.action = action;

                switch ( action ) {
                    case 'update':
                        me.modal.title = data.description + ' - Editar';
                        me.modal.data = data;
                        break;
                }
            },
            proccess() {

            },
            closeModal() {

            }

        },
        mounted() {
            this.list( 1, '' );
        }
    }
</script>

<style scoped>

</style>
