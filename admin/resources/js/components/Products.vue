<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Materiales</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input type="text" v-model="search" @keyup="listar(1, search)" class="form-control mb-2" id="inlineFormInput" placeholder="Buscar...">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click="listar(1, search)">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group">
                                    <div class="dropdown">
                                        <a href="#" aria-expanded="false" data-toggle="dropdown" class="btn btn-link dropdown-toggle btn-icon-dropdown">
                                            <span class="feather-icon">
                                                <i data-feather="settings"></i>
                                            </span> <span class="caret"></span>
                                        </a>
                                        <div role="menu" class="dropdown-menu">
                                            <a class="dropdown-item" title="Nuevo producto" href="#" @click.prevent="openModal('registrar')">
                                                <i class="fa fa-plus"></i> Nuevo producto
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#" title="Descargar formato excel" @click.prevent="downloadExcel">
                                                <i class="fa fa-download"></i> Descargar excel
                                            </a>
                                            <a class="dropdown-item" href="#" title="Subida multiple" @click="openModal('upload')">
                                                <i class="fa fa-upload"></i> Carga multiple
                                            </a>
                                        </div>
                                    </div>
                                </div>
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
                                    <th>Categoría</th>
                                    <th>Producto</th>
                                    <th>Presentación</th>
                                    <th>Descripción</th>
                                    <th>Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(dato, idx) in arrData" :key="dato.id">
                                    <th scope="row">{{ idx + 1 }}</th>
                                    <td v-text="dato.category"></td>
                                    <td v-text="dato.name"></td>
                                    <td>
                                        <a href="#" @click="redirectPage( dato.id, 'presentation' )">
                                            <i class="fa fa-cubes"></i> ({{ dato.presentation }})
                                        </a>
                                    </td>
                                    <td v-text="dato.description"></td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <a href="#" aria-expanded="false" data-toggle="dropdown" class="btn btn-link dropdown-toggle btn-icon-dropdown">
                                                    <span class="feather-icon">
                                                        <i data-feather="settings"></i>
                                                    </span> <span class="caret"></span> Opciones
                                                </a>
                                                <div role="menu" class="dropdown-menu">
                                                    <a class="dropdown-item" :title="'Ver producto - ' + dato.name" href="#" @click="viewDetail( dato.id )">
                                                        <i class="fa fa-eye"></i>&nbsp;Ver detalles
                                                    </a>
                                                    <a class="dropdown-item" :title="'Galería - ' + dato.name" href="#" @click.prevent="openModal( 'gallery', dato )">
                                                        <i class="fa fa-image"></i>&nbsp;Galería
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#" :title="'Editar producto - ' + dato.name"  @click.prevent="openModal('actualizar', dato)">
                                                        <i class="fa fa-edit"></i> Editar
                                                    </a>
                                                    <a class="dropdown-item" href="#" :title="'Editar producto - ' + dato.name"  @click.prevent="openModal('uploadImage', dato)">
                                                        <i class="fa fa-upload"></i> Subir Imagen
                                                    </a>
                                                    <a class="dropdown-item" href="#" :title="'Eliminar producto - ' + dato.name" @click.prevent="eliminar(dato.id)">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="arrData.length == 0">
                                    <td colspan="6">No se encuentra ningun registro en nuestra base de datos, registre un producto nuevo. :)</td>
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
                        <a class="nav-link active" data-toggle="tab" href="#product" role="tab" aria-controls="home">Producto</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="product" role="tabpanel">
                        <div class="clearfix"></div>
                        <div class="form-group row margin-top-2-por">
                            <label class="col-md-3 form-control-label">Categoría <span class="text-danger">(*)</span></label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="categoryId" name="categoria" v-validate="{is_not: 0}" :class="{'is-invalid': errors.has('categoria')}">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="cat in arrCategories" :key="cat.id" :value="cat.id" v-text="cat.name"></option>
                                </select>
                                <span v-show="errors.has('categoria')" class="text-danger">{{ errors.first('categoria') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label">Nombre <span class="text-danger">(*)</span></label>
                            <div class="col-md-9">
                                <input type="text" v-model="name" name="nombre" v-validate="'required'" class="form-control" placeholder="Nombre" :class="{'is-invalid': errors.has('nombre')}">
                                <span v-show="errors.has('nombre')" class="text-danger">{{ errors.first('nombre') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label">Descripción <span class="text-danger">(*)</span></label>
                            <div class="col-md-9">
                                <textarea v-model="description" name="descripcion" v-validate="'required'" class="form-control" :class="{'is-invalid': errors.has('descripcion')}"></textarea>
                                <span v-show="errors.has('descripcion')" class="text-danger">{{ errors.first('descripcion') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </b-modal>
        <b-modal id="uploadImage" size="lg" ref="uploadImage" title="Subir Imagen" @ok="processForm" @hidden="closeModal">
            <ProductsImage ref="formUploadImage" :product="id" post_url="products" v-if="id > 0"></ProductsImage>
        </b-modal>
        <b-modal id="gallery" size="lg" ref="gallery" :title="modalTitulo" @ok="processForm" @hidden="closeModal">
            <Gallery ref="galleryComponent" :relId="id" rel="products" v-if="id > 0"></Gallery>
        </b-modal>
        <b-modal id="modalUpload" size="lg" ref="upload" title="Subir registros multiples" @ok="processForm">
            <form id="formUpload" data-vv-scope="formUpload" v-if="! responseUpload.closeForm">
                <div class="form-group">
                    <label for="ip-upload">Example file input</label>
                    <input type="file" class="form-control-file"
                        id="ip-upload" name="ip-upload"
                        accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                        @change="processFile($event)">
                    <span v-show="errorUpload" class="text-danger">{{ errorUpload }}</span>
                    <small id="msgUpload" class="form-text text-info text-muted">Solo archivos .xls, xlsx</small>
                </div>
            </form>
            <div class="container" v-else>
                <div class="row">
                    <div class="col-12">
                        <h3 v-if="responseUpload.saved > 0" class="bg-success text-white text-center">Registros Guardados: {{ responseUpload.saved }} </h3>
                        <h3 v-if="responseUpload.info.length > 0" class="bg-info text-white text-center"><i class="fa fa-info"></i> Info </h3>
                        <p class="text-info text-center" v-for="inf in responseUpload.info" :key="inf">{{ inf }}</p>
                        <h3 v-if="responseUpload.error.length > 0" class="bg-danger text-white text-center">Alertas</h3>
                        <p class="text-danger text-center" v-for="er in responseUpload.error" :key="er">Linea {{ er.row }}: {{ er.msg }}</p>
                    </div>
                </div>
            </div>

        </b-modal>
        <b-modal id="detailModal" size="lg" ref="detailModal" :title="view.title" @cancel="closeModalDetail">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <label> Producto </label>&nbsp;&nbsp;<strong v-text="view.name"></strong>
                        <div class="mw-100">
                            <a :href="view.url" target="_blank">
                                <i class="fa fa-link"></i> &nbsp; Ver Producto
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label> URL </label>&nbsp;&nbsp;<strong v-text="view.url"></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label> Descripción </label>&nbsp;&nbsp;<strong v-text="view.description"></strong>
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
        name: "Products",
        data() {
            return {
                urlProject:         URL_PROJECT,
                urlController:      '/products/',
                action:             '',
                arrData:            [],
                arrCategories:      [],
                id:                 '',
                categoryId:         0,
                name:               '',
                description:        '',
                modalTitulo:        '',
                search:             '',
                pagination:         {
                    'total':        0,
                    'current_page': 0,
                    'per_page':     0,
                    'last_page':    0,
                    'from':         0,
                    'to':           0,
                },
                offset:             3,
                slide:              0,
                sliding:            null,
                show:               false,
                someData:           '',
                errorUpload:        '',
                responseUpload      : {
                    'closeForm' : false,
                    'status'    : false,
                    'error'     : [],
                    'info'      : [],
                    'saved'     : 0
                },
                view: {
                    title: '',
                    name: '',
                    url: '',
                    description: ''
                }
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
        components:{
            ProductsImage,
            Gallery
        },
        methods:{
            /*gallery*/
            onSlideStart(slide) {
                this.sliding = true
            },
            onSlideEnd(slide) {
                this.sliding = false
            },
            changePage( page, search ){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listar( page, search );
            },
            redirectDasboard(page){
                var redirect = URL_PROJECT + '/' + page + '/dashboard/';
                window.open( redirect, '_blank' );
            },
            listar(page,search){
                var me = this;
                var url= me.urlController + '?page=' + page + '&search='+ search;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrData = respuesta.records.data;
                    me.pagination= respuesta.pagination;
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            openModal(action, data=[]){

                this.action = action;
                this.loadCategory();

                switch(action){
                    case 'registrar':
                        this.id = 0;
                        this.categoryId = 0;
                        this.name = '';
                        this.description = '';
                        this.modalTitulo = 'Registrar Producto';
                        this.$refs.modal.show();
                        break;
                    case 'actualizar':
                        this.id = data.id;
                        this.categoryId = data.category_id;
                        this.name = data.name;
                        this.description = data.description;
                        this.modalTitulo = 'Actualizar Producto - '+data.name;
                        this.$refs.modal.show();
                        break;
                    case 'upload':
                        this.errorUpload = '';
                        this.$refs.upload.show();
                        break;
                    case 'uploadImage':
                        this.id = data.id;
                        this.$refs.uploadImage.show();
                        break;
                    case 'gallery':
                        this.id = data.id;
                        this.modalTitulo = 'Galería de imagenes - ' + data.name;
                        this.$refs.gallery.show();
                        break;
                }
            },
            processForm(evt){
                evt.preventDefault();
                switch(this.action){
                    case 'registrar':
                        this.registrar();
                        break;
                    case 'actualizar':
                        this.actualizar();
                        break;
                    case 'upload':
                        this.upload();
                        break;
                    case 'infoUpload':
                    case 'uploadImage':
                    case 'gallery':
                        this.closeModal();
                        break;
                }
            },
            closeModal(){
                let oldAction           = this.action;
                this.modalTitulo        = '';
                this.id                 = '';
                this.categoryId         =  0;
                this.name               = '';
                this.description        = '';
                this.action             = 'registrar';
                this.arrCategories      = [];
                this.someData           = '';
                this.errorUpload        = '';
                this.responseUpload     = {
                    'closeForm' : false,
                    'status'    : false,
                    'error'     : [],
                    'info'      : [],
                    'saved'     : 0
                };
                if( oldAction !== 'infoUpload' ){
                    this.$nextTick(() => {
                        this.$refs.modal.hide();
                    });
                }else{
                    this.$nextTick(() => {
                        this.$refs.upload.hide();
                    });
                }
                switch ( oldAction ) {
                    case 'uploadImage':
                        this.$refs.formUploadImage.clearFiles();
                        this.$nextTick(() => {
                            this.$refs.uploadImage.hide();
                        });
                        break;
                    case 'gallery':
                        this.$nextTick(() => {
                            this.$refs.gallery.hide();
                        });
                        break;
                }
            },
            registrar(){
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let me = this;
                        axios.post( me.urlController + 'register',{
                            'name': this.name,
                            'category_id': this.categoryId,
                            'description': this.description,
                        }).then(function (response) {
                            me.closeModal();
                            me.listar(1,'');
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
                        axios.put( me.urlController + 'update',{
                            'id': this.id,
                            'name': this.name,
                            'category_id': this.categoryId,
                            'description': this.description,
                        }).then(function (response) {
                            me.closeModal();
                            me.listar(1,'','nombre');
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
            eliminar(id){
                swal({
                    title: "Eliminar!",
                    text: "Esta seguro de eliminar este Producto?",
                    icon: "error",
                    button: "Eliminar",
                }).then((result) => {
                    if (result) {
                        let me = this;

                        axios.put( me.urlController + 'delete',{
                            'id': id
                        }).then(function (response) {
                            me.listar(1, '');
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
                })
            },
            loadCategory(){
                let me = this;
                var url = '/categories/select';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrCategories = respuesta.categories;
                }).catch(function(error){
                    console.log(error);
                });
            },
            downloadExcel(){
                let me = this;
                var url = me.urlController + 'download-excel/';

                axios.get( url ).then( function ( response ) {
                    let resp = response.data;
                    if( resp.status ) {
                        const url   = resp.file;
                        const link  = document.createElement('a');
                        link.href   = url;
                        link.setAttribute('download', 'productos.xlsx');
                        document.body.appendChild(link);
                        link.click();
                    }
                })
            },
            upload(){
                if( this.someData === '' && this.errorUpload === '' ){
                    this.errorUpload = 'Por favor seleccione un archivo(.xls, xlsx).'
                }
                if( this.errorUpload === '' ){
                    var self        = this;
                    let me          = this,
                        url         = me.urlController + 'upload-excel/',
                        formData    = new FormData();
                    formData.append( 'file-upload', this.someData );

                    axios.post( url, formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then( function( response ) {
                        let resp    = response.data;
                        if( resp.status ){
                            self.listar( 1, '' );
                        }
                        self.action                     = 'infoUpload';
                        self.responseUpload.closeForm   = true;
                        self.responseUpload.error       = resp.errors;
                        self.responseUpload.info        = resp.info;
                        self.responseUpload.saved       = resp.saved;

                    }).catch( function ( error ) {
                        console.log( error )
                    });
                }
            },
            processFile( event ){
                this.errorUpload    = '';
                let typePermits     = [
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-excel'
                ];
                let fileName        = event.target.files[0];
                if( typePermits.includes( fileName.type ) ){
                    this.someData = fileName;
                }else{
                    this.errorUpload = 'El tipo de archivo no es permitido.';
                }
            },
            redirectPage( id, action ) {
                let me = this,
                    url = me.urlProject + '/' + action + '/' + id + '/dashboard/';
                location.href = url;
            },
            viewDetail( id ) {
                let me = this,
                    url = '/products/' + id + '/detail/';

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
                };
                this.$nextTick(() => {
                    this.$refs.upload.hide();
                });
            }
        },
        mounted() {
            this.listar(1, this.search);
        }
    }
</script>

<style scoped>

</style>
