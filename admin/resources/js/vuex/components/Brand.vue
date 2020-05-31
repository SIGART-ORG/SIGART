<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Marcas</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input type="text" v-model="search" @keyup="list()" class="form-control mb-2" id="inlineFormInput" placeholder="Buscar...">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="list()">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-info mb-2" @click.prevent="openModal('registrar')">
                                    <i class="fa fa-fw fa-lg fa-plus"></i> Nuevo
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
                                    <th>Nombre</th>
                                    <th>Presentaciones asociadas</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="dato in brands" :key="dato.id">
                                    <td v-text="dato.name"></td>
                                    <td>
                                        <i class="fa fa-cubes"></i> {{ dato.presentations }}
                                    </td>
                                    <td>
                                        <div v-if="dato.status">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-outline-info" @click.prevent="openModal('actualizar', dato )">
                                            <i class="fa fa-edit"></i> Editar
                                        </button>
                                        <button v-if="dato.status === 1" class="btn btn-xs btn-outline-warning" @click.prevent="desactivar( dato.id )">
                                            <i class="fa fa-ban"></i> Desactivar
                                        </button>
                                        <button v-else class="btn btn-xs btn-outline-success" @click.prevent="activar( dato.id )">
                                            <i class="fa fa-check"></i> Activar
                                        </button>
                                        <button class="btn btn-xs btn-outline-danger" @click.prevent="deleteBrand( dato.id )">
                                            <i class="fa fa-trash"></i> Eliminar
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
        <b-modal id="modalPrevent" size="lg" ref="modal" :title="modalTitle" @ok="processForm">
            <form @submit.stop.prevent="closeModal">
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Nombre <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <input type="text" v-model="brand.name" name="nombre" v-validate="'required'" class="form-control" placeholder="Nombre" :class="{'is-invalid': errors.has('nombre')}">
                        <span v-show="errors.has('nombre')" class="text-danger">{{ errors.first('nombre') }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Descripción</label>
                    <div class="col-md-9">
                        <textarea class="form-control" v-model="brand.description"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <small class="text-danger"><strong>(*)</strong>: Campos requeridos.</small>
                    </div>
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
    import {mapMutations} from 'vuex';
    export default {
        name: "Brand",
        data() {
            return {
                modalTitle: '',
                action: ''
            }
        },
        created() {
            this.list();
        },
        computed: {
            search: {
                get: function () {
                    return this.$store.state.Brand.search;
                },
                set: function ( search ) {
                    this.$store.state.Brand.search = search;
                }
            },
            offset: {
                get: function () {
                    return this.$store.state.Brand.offset;
                },
                set: function ( offset ) {
                    this.$store.state.Brand.offset = offset;
                }
            },
            pagination: {
                get: function () {
                    return this.$store.state.Brand.pagination;
                },
                set: function ( pagination ) {
                    this.$store.state.Brand.pagination = pagination;
                }
            },
            brands: {
                get: function () {
                    return this.$store.state.Brand.brands;
                }
            },
            brand: {
                get: function () {
                    return this.$store.state.Brand.brand;
                },
                set: function( brand ) {
                    this.$store.state.Brand.brand = brand;
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
            ...mapMutations(['CHANGE_PAGE_BRAND', 'LOAD_BRAND', 'CHANGE_BRAND_ID', 'CHANGE_ACTIVATE']),
            list( page = 1 ) {
                this.CHANGE_PAGE_BRAND( page );
                this.$store.dispatch( 'loadBrands' );
            },
            changePage( page ){
                let me = this;
                me.pagination.current_page = page;
                me.list( page );
            },
            openModal( action, data=[] ) {
                this.LOAD_BRAND({
                    id: 0,
                    name: '',
                    description: ''
                });
                switch( action ) {
                    case 'registrar':
                        this.modalTitle = 'Registrar marca';
                        this.action = action;
                        this.$refs.modal.show();
                        break;
                    case 'actualizar':
                        this.modalTitle = 'Actualizar marca - ' + data.name;
                        this.brand.id = data.id;
                        this.brand.name = data.name;
                        this.brand.description = data.description;
                        this.action = action;
                        this.$refs.modal.show();
                        break;
                }
            },
            processForm(evt){
                evt.preventDefault();
                switch( this.action ){
                    case 'registrar':
                        this.register();
                        break;
                    case 'actualizar':
                        this.updated();
                        break;
                }
            },
            register() {
                let me = this;
                me.$validator.validateAll().then((result) => {
                    if (result) {
                        me.$store.dispatch('storeBrand').then( response => {
                            if( response.status ) {
                                me.closeModal();
                                me.list();
                            }
                        }).catch( errors => {
                            console.log( errors );
                        });
                    }
                });
            },
            updated() {
                let me = this;
                me.$validator.validateAll().then((result) => {
                    if (result) {
                        me.$store.dispatch('updatebrand').then( response => {
                            if( response.status ) {
                                me.closeModal();
                                me.list();
                            }
                        }).catch( errors => {
                            console.log( errors );
                        });
                    }
                });
            },
            closeModal() {
                this.LOAD_BRAND({
                    id: 0,
                    name: '',
                    description: ''
                })
                this.action = '';
                this.$nextTick(() => {
                    this.$refs.modal.hide();
                })
            },
            deleteBrand( id ){
                swal({
                    title: "Eliminar!",
                    text: "Esta seguro de eliminar esta Marca?",
                    icon: "error",
                    button: "Eliminar"
                }).then((result) => {
                    if (result) {
                        let me = this;
                        me.CHANGE_BRAND_ID( id );
                        me.$store.dispatch( 'deleteBrand' ).then( response => {
                            if( response.status ) {
                                me.list();
                                swal(
                                    'Eliminado!',
                                    'El registro ha sido eliminado con éxito.',
                                    'success'
                                );
                            }
                        });
                    }
                })
            },
            activar(id){
                swal({
                    title: "Activar marca",
                    text: "Esta seguro de activar esta Marca?",
                    icon: "success",
                    button: "Activar"
                }).then((result) => {
                    if (result) {
                        let me = this;
                        me.CHANGE_BRAND_ID( id );
                        me.CHANGE_ACTIVATE( true );
                        me.$store.dispatch( 'activateBrand' ).then( response => {
                            if( response.status ) {
                                me.list();
                                swal(
                                    'Activado!',
                                    'El registro ha sido activado con éxito.',
                                    'success'
                                )
                            }
                        });
                    }
                })
            },
            desactivar(id){
                swal({
                    title: "Desactivar marca",
                    text: "Esta seguro de desactivar esta Marca?",
                    icon: "warning",
                    button: "Desactivar",
                }).then((result) => {
                    if (result) {
                        let me = this;
                        me.CHANGE_BRAND_ID( id );
                        me.CHANGE_ACTIVATE( false );
                        me.$store.dispatch( 'activateBrand' ).then( response => {
                            if( response.status ) {
                                me.list();
                                swal(
                                    'Desactivado!',
                                    'El registro ha sido desactivado con éxito.',
                                    'success'
                                )
                            }
                        });
                    }
                })
            },
        }
    }
</script>

<style scoped>

</style>
