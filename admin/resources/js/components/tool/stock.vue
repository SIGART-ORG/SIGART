<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">{{ tool }} - {{ sku}}</h5>
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
                                <button type="submit" class="btn btn-info mb-2" @click="list( 1, search )">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="hk-sec-wrapper">
            <h6 class="hk-sec-title">Movimientos - {{ site }}</h6>
            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th><i class="fa fa-sign-in"></i> Entrada</th>
                                    <th><i class="fa fa-sign-out"></i> Salida</th>
                                    <th>Total</th>
                                    <th>Descripción</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="arrLists.length > 0" v-for="row in arrLists" :key="row.id">
                                    <td v-text="row.createdAt"></td>
                                    <td>
                                        <strong v-if="row.input > 0" class="text-primary" v-text="row.input"></strong>
                                        <span v-else v-text="row.input"></span>
                                    </td>
                                    <td>
                                        <strong v-if="row.output < 0" class="text-danger" v-text="row.output"></strong>
                                        <span v-else v-text="row.output"></span>
                                    </td>
                                    <td v-text="row.total"></td>
                                    <td class="text-justify font-italic" v-text="row.comment"></td>
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
    </div>
</template>

<script>
    export default {
        name: "toolStock",
        props: ['presentation'],
        data() {
            return {
                search: '',
                site: '',
                tool: '',
                sku: '',
                arrLists: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
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
            list( page ) {
                let me = this,
                    url = '/tool/' + me.presentation +'/stock/?page=' + page + '&search='+ me.search;

                axios.get( url ).then( function( response ) {

                    let result = response.data;
                    me.arrLists = result.logs;
                    me.site = result.site;
                    me.tool = result.tool;
                    me.sku = result.sku;
                    me.pagination = result.pagination;

                }).catch( function( error ) {
                    console.log( error );
                });
            },
        },
        mounted() {
            this.list( 1 );
        }
    }
</script>

<style scoped>

</style>
