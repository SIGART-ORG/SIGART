<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Correos</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input type="text" v-model="search" @keyup="list( 1 )" class="form-control mb-2" id="inlineFormInput" placeholder="Buscar...">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="list( 1 )">
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
                            <table class="table table-hover mb-0 sales__table">
                                <thead>
                                <tr>
                                    <th>Envio</th>
<!--                                    <th>De:</th>-->
                                    <th>Email:</th>
                                    <th>Asunto</th>
                                    <th>Adjunto</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in mails" :key="item.id">
                                        <td>
                                            <code v-text="item.dateSend"></code>
                                        </td>
<!--                                        <td v-text="item.from"></td>-->
                                        <td v-text="item.to"></td>
                                        <td v-text="item.subject"></td>
                                        <td>
                                            <a v-if="item.attach" :href="item.attach" target="_blank" class="btn btn-outline-success btn-xs">
                                                <i class="fa fa-clipboard"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <span v-if="item.status === 0" class="badge badge-secondary">No enviado</span>
                                            <span v-if="item.status === 1" class="badge badge-primary">Enviado</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-info btn-xs" @click="detail(item.id)">
                                                <i class="fa fa-eye"></i>
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
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page-1 )">Ant.</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="changePage(page)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page+1)">Sig.</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
        <b-modal id="detail" size="lg" ref="detail" title="Detalle" @ok="closeModal">
            <div class="form-group row">
                <label class="col-md-3 form-control-label">Asunto:</label>
                <div class="col-md-9">{{ mail.subject }}</div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">Destinatario:</label>
                <div class="col-md-9">{{ mail.to }}</div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 form-control-label">Fecha de envió:</label>
                <div class="col-md-9">{{ mail.dateSend }}</div>
            </div>
            <div v-if="mail.attach" class="form-group row">
                <label class="col-md-3 form-control-label">Adjunto:</label>
                <div class="col-md-9">
                    <a :href="mail.attach" target="_blank">
                        <i class="fa fa-clipboard"></i>
                    </a>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <iframe id="preview"
                            title="Previsualización de correo"
                            width="100%"
                            height="auto"
                            :src="mail.preview">
                    </iframe>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import {mapMutations} from 'vuex';
    export default {
        name: "Mail",
        computed: {
            search: {
                get: function() {
                    return this.$store.state.Mail.search;
                },
                set: function ( newSearch ) {
                    this.$store.state.Mail.search = newSearch;
                }
            },
            mails: {
                get: function() {
                    return this.$store.state.Mail.mails;
                },
                set: function ( newData ) {
                    this.$store.state.Mail.mails = newData;
                }
            },
            mail: {
                get: function() {
                    return this.$store.state.Mail.mail;
                },
                set: function ( newData ) {
                    this.$store.state.Mail.mail = newData;
                }
            },
            offset: {
                get: function () {
                    return this.$store.state.Mail.offset;
                },
                set: function ( offset ) {
                    this.$store.state.Mail.offset = offset;
                }
            },
            pagination: {
                get: function () {
                    return this.$store.state.Mail.pagination;
                },
                set: function ( pagination ) {
                    this.$store.state.Mail.pagination = pagination;
                }
            },
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
            ...mapMutations(['CHANGE_ID', 'LOAD_MAIL', 'CHANGE_PAGE_MAIL']),
            changePage( page ){
                let me = this;
                me.pagination.current_page = page;
                me.list( page );
            },
            list: function( page = 1 ) {
                this.CHANGE_PAGE_MAIL( page );
                this.$store.dispatch( 'loadMails' );
            },
            detail( id ) {
                let me = this;
                me.CHANGE_ID( id );
                me.$store.dispatch( 'detail' ).then( response => {
                    if( response ) {
                        me.$refs['detail'].show();
                    }
                });
            },
            closeModal() {
                this.CHANGE_ID( 0 );
                this.LOAD_MAIL({});
                this.$refs['detail'].hide();
            }
        },
        created() {
            this.list();
        }
    }
</script>

<style scoped>

</style>
