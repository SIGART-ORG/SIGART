<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Compras</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="searchForm"></label>
                                <input type="text" id="searchForm" class="form-control mb-2" placeholder="Buscar" v-model="search" @keyup="list( 1, search )">
                            </div>
                            <div class="col-auto" >
                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="list( 1, search )">
                                    <i class="fa fa-fw fa-lg fa-search"></i> Buscar
                                </button>
                            </div>
                            <div class="col-auto" >
                                <button type="submit" class="btn btn-success mb-2" @click.prevent="redirectPage( 'new' )">
                                    <i class="fa fa-fw fa-lg fa-plus"></i> Registrar compra
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
                                    <th>Opciones</th>
                                    <th>Comprobante</th>
                                    <th>Código</th>
                                    <th>Proveedor</th>
                                    <th>Sub-Total</th>
                                    <th>IGV</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="( row, idx ) in arrData" :key="row.id">
                                    <td v-text="idx + 1"></td>
                                    <td>
                                        <button v-if="row.status === 1" type="button" class="btn btn-outline-info btn-sm" title="Aprobar Orden de Compra" @click.prevent="approve( row )">
                                            <i class="fa fa-fw fa-lg fa-check"></i> Aprobar
                                        </button>
                                        <button v-if="row.status === 1" type="button" class="btn btn-outline-danger btn-sm" title="Cancelar Orden de Compra">
                                            <i class="fa fa-fw fa-lg fa-close"></i> Cancelar
                                        </button>
                                        <button v-if="row.status === 3" type="button" class="btn btn-outline-success btn-sm" title="Cancelar Orden de Compra">
                                            <i class="fa fa-fw fa-lg fa-shopping-cart"></i> Generar Compra
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" title="Detalle - Orden de Compra">
                                            <i class="fa fa-fw fa-lg fa-search"></i> Detalle
                                        </button>
                                    </td>
                                    <td>{{ row.code }}</td>
                                    <td>{{ row.code }}</td>
                                    <td>
                                        {{ row.name }}
                                        <span class="badge badge-secondary">{{ row.document }}</span>
                                    </td>
                                    <td>{{ row.subtotal }}</td>
                                    <td>{{ row.igv }}</td>
                                    <td>{{ row.total }}</td>
                                    <td>
                                        <span v-if="row.status === 0"class="badge badge-warning"><i class="fa fa-ban"></i>Desactivado</span>
                                        <span v-if="row.status === 1" class="badge badge-info"><i class="fa fa-check fa-fw"></i>Pendiente Aprobación</span>
                                        <span v-if="row.status === 3" class="badge badge-success"><i class="fa fa-shopping-bag fa-fw"></i>Aprobado</span>
                                        <span v-if="row.status === 4" class="badge badge-danger"><i class="fa fa-close fa-fw"></i>Cancelado</span>
                                        <span v-if="row.status === 5" class="badge badge-primary"><i class="fa fa-close fa-fw"></i>Compra Generado</span>
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
    </div>
</template>

<script>
    export default {
        name: "purchase-index",
        data() {
            return {
                urlProject: URL_PROJECT,
                search:     '',
                arrData:    [],
                pagination: {
                    'total'         : 0,
                    'current_page'  : 0,
                    'per_page'      : 0,
                    'last_page'     : 0,
                    'from'          : 0,
                    'to'            : 0,
                },
                offset      : 3,
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
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
                me.list( page, search );
            },
            list( page, search ) {
                let me = this,
                    url = '/purchases/';

                axios.get( url, {
                    params: {
                        page: page,
                        search: search
                    }
                }).then( function( result ) {
                    let response    = result.data;
                    me.arrData      = response.records.data;
                    me.pagination   = response.pagination;
                }).catch( function( errors ) {
                    console.log( errors );
                })
            },
            redirectPage( action ) {
                let url = this.urlProject + '/purchases/';

                switch( action ) {
                    case 'new':
                        url += 'new';
                        break;
                }

                document.location.href = url;
            }
        },
        mounted() {
            this.list( 1, '' );
        }
    }
</script>

<style scoped>

</style>
