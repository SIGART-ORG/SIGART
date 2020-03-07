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
                                <button type="submit" class="btn btn-info mb-2" @click="list( 1, search )">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="openModal('registrar')">
                                    <i class="fa fa-fw fa-lg fa-plus-circle"></i> Herramienta
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
                                    <th>Stock - {{ site }}</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="arrList.length > 0" v-for="( row, idx ) in arrList" :key="row.id">
                                    <td>{{ idx + 1 }}</td>
                                    <td v-text="row.sku"></td>
                                    <td v-text="row.description"></td>
                                    <td v-text="row.stock"></td>
                                    <td>
                                        <span v-if="row.status === 1" class="badge badge-success">Activo</span>
                                        <span v-else class="badge badge-danger">Desactivado</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-outline-info" title="Editar" @click.prevent="openModal( 'actualizar', row )">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button v-if="row.status === 1" class="btn btn-xs btn-outline-warning" title="Desactivar" @click.prevent="deactivate( row )">
                                            <i class="fa fa-ban"></i>
                                        </button>
                                        <button v-else class="btn btn-xs btn-outline-success" title="Activar" @click.prevent="activate( row )">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="btn btn-xs btn-outline-danger" title="ELiminar" @click.prevent="deleteTool( row )">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                        <button class="btn btn-xs btn-outline-gold" title="stock" @click="stockDetail( row.id )">
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
        <b-modal ref="modalForm" size="lg" @ok="proccess" @cancel="closeModal">
            <form>
                <div class="tab-content">
                    <div class="tab-pane active" id="product" role="tabpanel">
                        <div class="clearfix"></div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label">Nombre <span class="text-danger">(*)</span></label>
                            <div class="col-md-9">
                                <input type="text" v-model="form.name" name="nombre" v-validate="'required'" class="form-control" placeholder="Nombre" :class="{'is-invalid': errors.has('nombre')}">
                                <span v-show="errors.has('nombre')" class="text-danger">{{ errors.first('nombre') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label">Stock</label>
                            <div class="col-md-9">
                                <input type="text" v-model="form.stock" name="stock" v-validate="'decimal:3|min_value:0'" class="form-control" placeholder="Stock" :class="{'is-invalid': errors.has('stock')}">
                                <span v-show="errors.has('stock')" class="text-danger">{{ errors.first('stock') }}</span>
                                <small class="italic text-muted">Solo se actualizará al stock de la sede loggeada.</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Leyenda:</h6>
                                <p><strong class="text-danger">(*)</strong><span class="font-italic"> Campos obligatorios.</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
    export default {
        name: "toolindex",
        data() {
            return {
                search: '',
                site: '',
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
                form: {
                    id: 0,
                    name: '',
                    stock: 0,
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
                    me.arrList = result.records;
                    me.site = result.site;
                    me.pagination = result.pagination;

                }).catch( function( error ) {
                    console.log( error );
                });
            },
            openModal( action, data = [] ) {
                this.modal.action = action;

                switch ( action ) {
                    case 'registrar':
                        this.modal.title = 'Formulario de registro';
                        this.$refs.modalForm.show();
                        break;
                    case 'actualizar':
                        this.modal.title = 'Formulario de edición - ' + data.description;
                        this.form = {
                            id: data.id,
                            name: data.description,
                            stock: data.stock
                        };
                        this.$refs.modalForm.show();
                        break;
                }

            },
            proccess() {
                switch ( this.modal.action ) {
                    case 'registrar':
                        this.registrar();
                        break;
                    case 'actualizar':
                        this.actualizar();
                        break;
                }
            },
            registrar() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let me = this;
                        axios.post( '/tool/register',{
                            'name': me.form.name,
                            'stock': me.form.stock,
                        }).then(function (response) {
                            let result2 = response.data;
                            if( result2.status ) {
                                me.closeModal();
                                me.list(1, me.search);
                                swal(
                                    'Registro!',
                                    'Se realizó correctamente el registro',
                                    'success'
                                )
                            }
                        }).catch(function (error) {
                            swal(
                                'Error!',
                                'Ocurrio un error al realizar la operación',
                                'error'
                            )
                        });
                    }
                });
            },
            actualizar() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let me = this;
                        axios.put( '/tool/update',{
                            'id': me.form.id,
                            'name': me.form.name,
                            'stock': me.form.stock,
                        }).then(function (response) {
                            let result2 = response.data;
                            if( result2.status ) {
                                me.closeModal();
                                me.list(1, me.search);
                                swal(
                                    'Registro!',
                                    'Se realizó correctamente el registro',
                                    'success'
                                )
                            }
                        }).catch(function (error) {
                            swal(
                                'Error!',
                                'Ocurrio un error al realizar la operación',
                                'error'
                            )
                        });
                    }
                });
            },
            closeModal() {
                this.modal.title = '';
                this.modal.action = '';
                this.form.id = 0;
                this.form.name = '';
                this.form.stock = 0;
            },
            activate( data ) {
                swal({
                    title: "Activar Herramienta - " + data.description,
                    text: "Esta seguro de activar esta herramienta?",
                    icon: "success",
                    button: "Activar"
                }).then((result) => {
                    if (result) {
                        let me = this;

                        axios.put('/tool/activate',{
                            'id': data.id
                        }).then(function (response) {
                            me.list(1, me.search );
                            swal(
                                'Activado!',
                                'El registro ha sido activado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            swal(
                                'Error! :(',
                                'No se pudo realizar la operación',
                                'error'
                            )
                        });


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {

                    }
                })
            },
            deactivate( data ) {
                swal({
                    title: "Desactivar herremienta - " + data.description,
                    text: "Esta seguro de desactivar esta herramienta?",
                    icon: "warning",
                    button: "Desactivar"
                }).then((result) => {
                    if (result) {
                        let me = this;

                        axios.put('/tool/deactivate',{
                            'id': data.id
                        }).then(function (response) {
                            me.list(1, me.search );
                            swal(
                                'Desactivado!',
                                'El registro ha sido desactivado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            swal(
                                'Error! :(',
                                'No se pudo realizar la operación',
                                'error'
                            )
                        });


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {

                    }
                })
            },
            deleteTool( data ) {
                swal({
                    title: "Eliminar herramienta - " + data.description,
                    text: "Esta seguro de eliminar esta Página?",
                    icon: "error",
                    button: "Eliminar"
                }).then((result) => {
                    if (result) {
                        let me = this;

                        axios.put('/tool/delete',{
                            'id': data.id
                        }).then(function (response) {
                            me.list(1, me.search );
                            swal(
                                'Eliminado!',
                                'El registro ha sido eliminado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            swal(
                                'Error! :(',
                                'No se pudo realizar la operación',
                                'error'
                            )
                        });


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {

                    }
                })
            },
            stockDetail( id ) {
                window.location = URL_PROJECT + '/tool/' + id + '/stock/dashboard';
            }
        },
        mounted() {
            this.list( 1, '' );
        }
    }
</script>

<style scoped>

</style>
