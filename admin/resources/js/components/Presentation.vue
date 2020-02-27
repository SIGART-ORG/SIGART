<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Presntaciones</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input type="text" v-model="search" @keyup="list(1, search)" class="form-control mb-2" id="inlineFormInput" placeholder="Buscar...">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-info mb-2" @click="list(1, search)">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click="openModal('registrar')">
                                    <i class="fa fa-fw fa-lg fa-plus-circle"></i> Presentación
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
<!--                                    <th>Stock</th>-->
<!--                                    <th>Prec. referencial</th>-->
                                    <th>Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="arrList.length > 0" v-for="( row, idx ) in arrList" :key="row.id">
                                    <td>{{ idx + 1 }}</td>
                                    <td v-text="row.sku"></td>
                                    <td v-text="row.name"></td>
<!--                                    <td></td>-->
<!--                                    <td></td>-->
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <a href="#" aria-expanded="false" data-toggle="dropdown" class="btn btn-link dropdown-toggle btn-icon-dropdown">
                                                    <span class="feather-icon">
                                                        <i data-feather="settings"></i>
                                                    </span> <span class="caret"></span> Opciones
                                                </a>
                                                <div role="menu" class="dropdown-menu">
                                                    <a class="dropdown-item" :title="'Ver presentación - ' + row.name" href="#" @click="viewDetail( row.id )">
                                                        <i class="fa fa-eye"></i>&nbsp;Ver detalles
                                                    </a>
<!--                                                    <a class="dropdown-item" :title="'Galería - ' + row.name" href="#" @click.prevent="openModal( 'gallery', row )">-->
<!--                                                        <i class="fa fa-image"></i>&nbsp;Galería-->
<!--                                                    </a>-->
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#" :title="'Editar presentación - ' + row.name"  @click.prevent="openModal('actualizar', row)">
                                                        <i class="fa fa-edit"></i> Editar
                                                    </a>
<!--                                                    <a class="dropdown-item" href="#" :title="'Subir presentación - ' + row.name"  @click.prevent="openModal('uploadImage', row)">-->
<!--                                                        <i class="fa fa-upload"></i> Subir Imagen-->
<!--                                                    </a>-->
                                                    <a class="dropdown-item" href="#" :title="'Eliminar presentación - ' + row.name" @click.prevent="remove(row.id)">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
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
        <b-modal id="modalPrevent" size="lg" ref="modal" :title="modalTitulo" @ok="processForm">
            <form>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#product" role="tab" aria-controls="home">Presentación</a>
                    </li>
                </ul>
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
                        <div class="form-group row margin-top-2-por">
                            <label class="col-md-3 form-control-label">Unidad de Medida <span class="text-danger">(*)</span></label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="form.unity" name="unidad de medida" v-validate="{is_not: 0}" :class="{'is-invalid': errors.has('unidad de medida')}">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="unity in unities" :key="unity.id" :value="unity.id" v-text="unity.name"></option>
                                </select>
                                <span v-show="errors.has('unidad de medida')" class="text-danger">{{ errors.first('unidad de medida') }}</span>
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
        <b-modal id="gallery" size="lg" ref="gallery" :title="titleModal" @ok="processForm" @hidden="closeModal">
            <Gallery ref="galleryComponent" :relId="id" rel="presentations" v-if="id > 0"></Gallery>
        </b-modal>
        <b-modal id="uploadImage" size="lg" ref="uploadImage" title="Subir Imagen" @ok="processForm" @hidden="closeModal">
            <ProductsImage ref="formUploadImage" :product="id" post_url="presentations" v-if="id > 0"></ProductsImage>
        </b-modal>
        <b-modal id="detailModal" size="lg" ref="detailModal" :title="view.title" @cancel="closeModalDetail">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-header card-header-action">
                            <div class="media align-items-center">
                                <div class="media-img-wrap d-flex mr-10">
                                    <div class="avatar avatar-sm">
                                        <img :src="view.image" :alt="view.name" class="avatar-img rounded-circle">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="text-capitalize font-weight-500 text-dark">{{ view.name }}</div>
                                    <div class="font-13">{{ view.product }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-4 border-right pr-0">
                                <div class="pa-15">
                                    <span class="d-block display-6 text-dark mb-5">{{ view.sku }}</span>
                                    <span class="d-block text-capitalize font-14">SKU</span>
                                </div>
                            </div>
                            <div class="col-md-4 border-right pr-0">
                                <div class="pa-15">
                                    <span class="d-block display-6 text-dark mb-5">{{ view.category }}</span>
                                    <span class="d-block text-capitalize font-14">Categoría</span>
                                </div>
                            </div>
                            <div class="col-md-4 px-0">
                                <div class="pa-15">
                                    <span class="d-block display-6 text-dark mb-5"><i class="fa fa-link"></i></span>
                                    <span class="d-block text-capitalize font-14">
                                        <a v-if="view.url !== ''" :href="view.url" target="_blank">
                                            Ver Presentación
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pa-15">
                            <div class="media-body">
                                <div class="text-capitalize font-weight-500 text-dark">Stock</div>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush" v-if="view.stocks.length > 0">
                            <li class="list-group-item" v-for="stock in view.stocks" :key="stock.id">
                                <span>
                                    <i class="ion ion-md-cube font-18 text-light-20 mr-10"></i>
                                    <span>{{ stock.site }}</span>
                                </span>
                                <span class="ml-5 text-dark">{{ stock.stock }} {{ view.unity }}</span> |
                                <span>
                                    <i class="ion ion-md-wallet font-18 text-light-20 mr-10"></i>
                                    <span>Precio Compra</span>
                                </span>
                                <span class="ml-5 text-dark">{{ stock.price | formatPrice }}</span> |
                                <span>
                                    <i class="ion ion-md-wallet font-18 text-light-20 mr-10"></i>
                                    <span>Precio Venta</span>
                                </span>
                                <span class="ml-5 text-dark">{{ stock.priceBuy | formatPrice }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import ProductsImage from './general/UploadImages';
    import Gallery from './general/Gallery';
    export default {
        name: "Presentation.vue",
        data() {
            return {
                search:     '',
                modalTitulo: '',
                arrList:    [],
                action:     '',
                titleModal: '',
                offset:     3,
                pagination:         {
                    'total':        0,
                    'current_page': 0,
                    'per_page':     0,
                    'last_page':    0,
                    'from':         0,
                    'to':           0,
                },
                id:         0,
                unities: [],
                form: {
                    name: '',
                    unity: 0,
                },
                view: {
                    title: '',
                    image: '',
                    sku: '',
                    product: '',
                    category: '',
                    name: '',
                    status: '',
                    url: '',
                    stocks: []
                }
            }
        },
        components:{
            ProductsImage,
            Gallery
        },
        props: [
            'product'
        ],
        computed: {
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
                me.list( page,search );
            },
            list( page, search) {
                let me = this,
                    url = '/presentation/' + me.product + '/?page=' + page + '&search='+ search;
                axios.get( url ).then( function( response ) {
                    let result = response.data;
                    me.arrList = result.records.data;
                    me.pagination = result.pagination;
                }).catch( function( error ) {
                    console.log( error );
                });
            },
            openModal( action, data = [] ){
                this.action = action;
                switch ( action ) {
                    case 'registrar':
                        this.loadUnity();
                        this.modalTitulo = 'Formulario de registro';
                        this.$refs.modal.show();
                        break;
                    case 'actualizar':
                        this.loadUnity();
                        this.modalTitulo = 'Formulario de edición - ' + data.name;
                        this.form = {
                            name: data.description,
                            unity: data.unity_id,
                        };
                        this.$refs.modal.show();
                        break;
                    case 'gallery':
                        this.id = data.id;
                        this.titleModal = 'Galería de imagenes - ' + data.name;
                        this.$refs.gallery.show();
                        break;
                    case 'uploadImage':
                        this.id = data.id;
                        this.$refs.uploadImage.show();
                        break;
                }
            },
            processForm() {
                switch ( this.action ) {
                    case 'registrar':
                        this.registrar();
                        break;
                    case 'actualizar':
                        this.actualizar();
                        break;
                    case 'uploadImage':
                    case 'gallery':
                        this.closeModal();
                        break;
                }
            },
            closeModal() {
                let oldAction = this.action;
                this.action = '';
                switch ( oldAction ) {
                    case 'registrar':
                    case 'actualizar':
                        this.form = {
                            name: '',
                            unity: 0,
                        };
                        this.$nextTick(() => {
                            this.$refs.modal.hide();
                        });
                        break;
                    case 'uploadImage':
                        this.$refs.formUploadImage.clearFiles();
                        this.$nextTick(() => {
                            this.$refs.uploadImage.hide();
                        });
                        this.id = 0;
                        break;
                    case 'gallery':
                        this.$nextTick(() => {
                            this.$refs.gallery.hide();
                        });
                        this.id = 0;
                        break;
                }
            },
            remove( id ) {
                swal({
                    title: "Eliminar!",
                    text: "Esta seguro de eliminar esta Presentación?",
                    icon: "error",
                    button: "Eliminar",
                }).then((result) => {
                    if (result) {
                        let me = this;

                        axios.put( '/presentation/delete',{
                            'id': id
                        }).then(function (response) {
                            me.list(1, '');
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


                    }
                });
            },
            viewDetail( id ) {
                let me = this,
                    url = '/presentation/' + id + '/detail/';

                axios.get( url ).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        me.view = result.data;
                        me.openModalDetail();
                    }
                })
            },
            openModalDetail() {
                this.view.title = 'Detalle - ' + ( this.view.name ? this.view.name : '' );
                this.$refs.detailModal.show();
            },
            closeModalDetail() {
                this.view = {
                    title: '',
                    image: '',
                    sku: '',
                    product: '',
                    category: '',
                    name: '',
                    status: '',
                    url: '',
                    stocks: []
                };
                this.$nextTick(() => {
                    this.$refs.upload.hide();
                });
            },
            loadUnity(){
                let me = this;
                var url = '/unity/select/';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.unities = respuesta.unitis;
                }).catch(function(error){
                    console.log(error);
                });
            },
            registrar(){
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let me = this;
                        axios.post( '/presentation/register',{
                            'product': this.product,
                            'name': this.form.name,
                            'unity': this.form.unity,
                        }).then(function (response) {
                            me.closeModal();
                            me.list(1,me.search );
                            swal(
                                'Registro!',
                                'Se realizó correctamente el registro',
                                'success'
                            )
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
            actualizar(){
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let me = this;
                        axios.put( '/presentation/update',{
                            'id': this.id,
                            'name': this.form.name,
                            'unity': this.form.unity,
                        }).then(function (response) {
                            me.closeModal();
                            me.list(1,me.search );
                            swal(
                                'Actualización!',
                                'Se realizó correctamente la actualización del registro',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log( error );
                            swal(
                                'Error!',
                                'Ocurrio un error al realizar la operación',
                                'error'
                            )
                        });
                    }
                });
            },
        },
        mounted() {
            this.list( 1, this.search );
        }
    }
</script>

<style scoped>

</style>
