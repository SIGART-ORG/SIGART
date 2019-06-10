<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Productos</h3>
                    <div class="tile-body">
                        <form class="row">
                            <div class="form-group col-md-6">
                                <input class="form-control" v-model="search" type="text" placeholder="Buscar" @keyup="listar(1, search)">
                            </div>
                            <div class="form-group col-md-3 align-self-end">
                                <button class="btn btn-primary" type="button" @click="listar(1, search)">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                            <div class="form-group col-md-3 align-self-end">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-success" title="Nuevo producto" @click.prevent="openModal('registrar')">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger" title="Descargar formato excel" @click.prevent="downloadExcel">
                                        <i class="fa fa-download"></i>
                                    </button>
                                    <button type="button" class="btn btn-info" title="Subida multiple" @click="openModal('upload')">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <template v-if="arrData.length > 0">
                <div class="col-12">
                    <div class="tile">
                        <h3 class="tile-title">Listado de productos</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>SKU</th>
                                        <th>Categoría</th>
                                        <th>Producto</th>
                                        <th>Presentación</th>
                                        <th>Stock</th>
                                        <th>Precio</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="dato in arrData" :key="dato.id">
                                        <td>
                                            <div class="btn-group">
                                                <div class="dropdown">
                                                    <button @click="toggleShow(dato.id)" class="btn btn-success dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Acciones
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" :class="showMenu == dato.id ? 'show' : ''">
                                                        <a href="#" class="dropdown-item" @click="viewDetail( dato )">
                                                            <i class="fa fa-eye"></i>&nbsp;Ver detalles
                                                        </a>
                                                        <a href="#" class="dropdown-item" @click.prevent="openModalGalery( dato.product )">
                                                            <i class="fa fa-image"></i>&nbsp;Galería
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="#" class="dropdown-item" @click.prevent="openModal('actualizar', dato)">
                                                            <i class="fa fa-edit"></i> Editar
                                                        </a>
                                                        <a href="#" class="dropdown-item" @click.prevent="eliminar(dato.id)">
                                                            <i class="fa fa-trash"></i> Eliminar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><b v-text="dato.sku"></b></td>
                                        <td v-text="dato.category"></td>
                                        <td v-text="dato.name"></td>
                                        <td v-text="dato.presentations"></td>
                                        <td v-text="dato.stock + ' ' + dato.unitName"></td>
                                        <td v-text="dato.pricetag_purchase"></td>
                                        <td v-text="dato.description"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="col-md-12" >
                    <div class="tile">
                        <div class="tile-title-w-btn">
                            <h3 class="title">0 Productos registrados</h3>
                            <div class="btn-group">
                                <a class="btn btn-primary" href="#" @click="openModal('registrar')">
                                    <i class="fa fa-lg fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="tile-body">
                            <b>Registre un nuevo producto </b><br>
                            No se encuentran ningun registro en nuestra base de datos, registre un producto nuevo. :)
                        </div>
                    </div>
                </div>
            </template>
        </div>
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
        <b-modal id="modalPrevent" size="lg" ref="modal" :title="modalTitulo" @ok="processForm">
            <template v-if="arrCategories.length == 0 || arrUnity.length == 0">
                <div class="col-md-12" v-show="arrCategories.length == 0">
                    <div class="tile">
                        <div class="tile-title-w-btn">
                            <h3 class="title">Registrar Categorías</h3>
                            <div class="btn-group">
                                <a class="btn btn-primary" href="#" @click="redirectDasboard('categories')">
                                    <i class="fa fa-lg fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="tile-body">
                            <i class="fa fa-warning"></i> Deben de regstrar primeramente las <b>categorías de productos</b>.
                        </div>
                    </div>
                </div>
                <div class="col-md-12" v-show="arrUnity.length == 0">
                    <div class="tile">
                        <div class="tile-title-w-btn">
                            <h3 class="title">Registrar Unidades de medida</h3>
                            <div class="btn-group">
                                <a class="btn btn-primary" href="#" @click="redirectDasboard('unity')">
                                    <i class="fa fa-lg fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="tile-body">
                            <i class="fa fa-warning"></i> Deben de regstrar primeramente las <b>Unidades de medida</b>.
                        </div>
                    </div>
                </div>
            </template>
            <form v-else>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#product" role="tab" aria-controls="home">Producto</a>
                    </li>
                    <li class="nav-item" v-show="action == 'actualizar'">
                        <a class="nav-link" data-toggle="tab" href="#galery" role="tab" aria-controls="profile">Galería</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#presentation" role="tab" aria-controls="profile">Presentaciones</a>
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
                    <div class="tab-pane" id="galery" role="tabpanel" v-show="action == 'actualizar'">
                        <div class="form-group row" >
                            <div class="col-12">
                                <div class="tile">

                                    <div class="tile-title-w-btn">
                                        <h3 class="title" v-text="'Subir Imagenés'"></h3>
                                    </div>
                                    <div class="tile-body products-body">
                                        <croppa v-model="myCroppa"
                                                :width="400"
                                                :height="400"
                                                placeholder="Seleccionar imagen"
                                                :file-size-limit="3036000"
                                                initial-size="natural"
                                                initial-position="center"
                                                @image-remove="removeImage"
                                                @new-image-drawn="newImage"
                                                :zoom-speed="6"
                                                :prevent-white-space="true"
                                                @file-type-mismatch="onFileTypeMismatch"
                                                @file-size-exceed="onFileSizeExceed">
                                            <img slot="placeholder" :src="urlProject+'/images/placeholder-upload.png'">
                                        </croppa>
                                        <span v-show="errorUpload != '' " class="text-danger">{{ errorUpload }}</span>
                                    </div>
                                    <div class="tile-footer">
                                        <div class="btn-group">
                                            <button class="btn btn-primary" @click.prevent="myCroppa.chooseFile()" :alt="'Elige un archivo'">
                                                <i class="fa fa-exchange"></i>
                                            </button>
                                            <button class="btn" :class="[isActiveImage ? 'btn-info' : 'btn-secondary']" :disabled="!isActiveImage" @click.prevent="myCroppa.rotate()" alt="Rotar a la derecha">
                                                <i class="fa fa-repeat"></i>
                                            </button>
                                            <button class="btn" :class="[isActiveImage ? 'btn-info' : 'btn-secondary']" :disabled="!isActiveImage" @click.prevent="myCroppa.rotate(-1)" alt="Rotar a la izquierda">
                                                <i class="fa fa-undo"></i>
                                            </button>
                                            <button class="btn" :class="[isActiveImage ? 'btn-info' : 'btn-secondary']" :disabled="!isActiveImage" @click.prevent="myCroppa.flipX()" alt="Voltear horizontalmente">
                                                <i class="fa fa-arrows-h"></i>
                                            </button>
                                            <button class="btn" :class="[isActiveImage ? 'btn-info' : 'btn-secondary']" :disabled="!isActiveImage" @click.prevent="myCroppa.flipY()" alt="Voltear verticalmente">
                                                <i class="fa fa-arrows-v"></i>
                                            </button>
                                            <button class="btn" :class="[isActiveImage ? ' btn-success' : 'btn-secondary']" :disabled="!isActiveImage" @click.prevent="upload()" alt="Subir Imagen">
                                                <i class="fa fa-upload"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="presentation" role="tabpanel">
                        <div class="margin-top-2-por">
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="tile-title-w-btn">
                                    <h3 class="title" v-text="'Presentaciones - ' + name"></h3>
                                    <button title="Nueva fila" class="btn btn-primary btn-sm" @click.prevent="addInputPresentation"><i class="fa fa-plus"></i></button>
                                    <button v-show="action == 'actualizar'" title="Guardar presentaciones" class="btn btn-success btn-sm" @click.prevent="savePresentation"><i class="fa fa-save"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" v-for="pre in arrPresentation" :key="pre.id" v-if="pre.delete == 0">
                            <div class="col-md-4">
                                <input type="text" :name="'descripcion_' + pre.id" v-model="pre.description" class="form-control"
                                       v-validate="{ required: true }"
                                       :class="{'is-invalid': errors.has('descripcion_'+pre.id)}"
                                       placeholder="Ej. 12 piezas"
                                >
                                <span v-show="errors.has('descripcion_' + pre.id)" class="text-danger">{{ errors.first('descripcion_' + pre.id) }}</span>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" :name="'unidad_' + pre.id" v-model="pre.unity"
                                        v-validate="pre.description !== '' ? 'required' : ''"
                                        :class="{'is-invalid': errors.has('unidad_'+pre.id)}"
                                >
                                    <option value="" disabled selected hidden >Unidad de medida</option>
                                    <option v-for="um in arrUnity" :key="um.id" v-bind:value="um.id" v-text="um.name"></option>
                                </select>
                                <span v-show="errors.has('unidad_' + pre.id)" class="text-danger">{{ errors.first('unidad_' + pre.id) }}</span>
                            </div>
                            <div class="col-md-1">
                                <input type="text" v-model="pre.pricetag" :name="'prec_ref' + pre.id" 
                                v-validate="{decimal: 2,  min_value: 0}" class="form-control" 
                                :class="{'is-invalid': errors.has( 'prec_ref' + pre.id )}">
                                <span v-show="errors.has( 'prec_ref' + pre.id )" class="text-danger">{{ errors.first( 'prec_ref' + pre.id ) }}</span>
                            </div>
                            <div class="col-md-1">
                                <input type="text" :name="'equivalencia_' + pre.id" v-model="pre.equivalence" class="form-control"
                                       v-validate="pre.description !== '' ? { required:true, regex: /^[0-9]+$/, min:1}: ''"
                                       :class="{'is-invalid': errors.has('equivalencia_'+pre.id)}"
                                       placeholder="Ej. 12"
                                >
                                <span v-show="errors.has('equivalencia_' + pre.id)" class="text-danger">{{ errors.first('equivalencia_' + pre.id) }}</span>
                            </div>
                            <div class="col-md-2 align-self-end">
                                <div class="btn-group">
                                    <button class="btn btn-danger btn-sm" type="button" @click.prevent="delInputsPresentation(pre.id)">
                                        <i class="fa fa-fw fa-lg fa-close"></i>
                                    </button>
                                    <button class="btn btn-success btn-sm" type="button" @click.prevent="addInputPresentation()" v-show="pre.id == ( arrPresentation.length - 1 )">
                                        <i class="fa fa-fw fa-lg fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </b-modal>
        <b-modal id="modalGalery" size="lg" ref="modalGalery" title="Galería de imagenés">
            <div class="tab-content">
                <div class="row">
                    <div class="col-12">
                        <b-carousel
                                id="carousel-1"
                                v-model="slide"
                                controls
                                indicators
                                img-width="100px"
                                img-height="100px"
                                background="#ababab"
                                style="text-shadow: 1px 1px 2px #333;"
                                @sliding-start="onSlideStart"
                                @sliding-end="onSlideEnd"
                        >
                            <b-carousel-slide
                                    v-for="galery in arrImage" :key="galery.id"
                                    img-width="100px"
                                    img-height="100px"
                                    :img-src="urlProject + '/products/' + galery.image_admin"
                            >
                                <a
                                        v-if="galery.image_default == 0"
                                        class="a-title-gallery-inactive"
                                        @click.prevent="defaultImage(galery.id, galery.products_id)"
                                        href="#"
                                >
                                    <i class="fa fa-heart"></i> Principal
                                </a>
                                <a v-else class="a-title-gallery" href="#"><i class="fa fa-heart"></i> Principal</a>
                            </b-carousel-slide>
                        </b-carousel>
                    </div>
                </div>
            </div>
        </b-modal>
        <b-modal id="modalUpload" size="lg" ref="upload" title="Subir registros multiples" @ok="processForm">
            <form id="formUpload" data-vv-scope="formUpload">
                <div class="form-group">
                    <label for="ip-upload">Example file input</label>
                    <input type="file" class="form-control-file" id="ip-upload" name="ip-upload" @change="processFile($event)">
                    <span v-show="errorUpload" class="text-danger">{{ errorUpload }}</span>
                    <small id="msgUpload" class="form-text text-info text-muted">Solo archivos .xls, xlsx</small>
                </div>
            </form>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p class="bg-danger text-white text-center">ERROR</p>
                        <p class="bg-success text-white text-center">EXITO</p>
                        <p class="bg-info text-white text-center">Info</p>
                    </div>
                </div>
            </div>

        </b-modal>
    </div>
</template>

<script>

    export default {
        name: "Products",
        data() {
            return {
                urlProject:         URL_PROJECT,
                urlController:      '/products/',
                action:             '',
                arrData:            [],
                arrUnity:           [],
                arrCategories:      [],
                arrPresentation:    [],
                id:                 '',
                categoryId:         0,
                name:               '',
                description:        '',
                pricetag:           0,
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
                myCroppa:           {},
                errorUpload:        '',
                isActiveImage:      false,
                arrImage:           [],
                slide:              0,
                sliding:            null,
                showMenu:           0,
                show:               false,
                someData:           '',
                errorUpload:        ''
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

        },
        methods:{
            toggleShow( id ){
                if( this.showMenu === 0){
                    this.showMenu = id;
                }else{
                    if( id === this.showMenu ){
                        this.showMenu = 0;
                    }else{
                        this.showMenu = id;
                    }
                }
            },
            toggleHidden(){
                this.showMenu = 0;
            },
            /*gallery*/
            onSlideStart(slide) {
                this.sliding = true
            },
            onSlideEnd(slide) {
                this.sliding = false
            },
            defaultImage( id, product ){
                let me = this;
                axios.put( '/productGalery/image-default/',{
                    'id': id,
                    'product': product,
                }).then(function (response) {
                    me.loadGalery(product);
                }).catch(function (error) {
                    swal(
                        'Error!',
                        'Ocurrio un error al realizar la operación',
                        'error'
                    )
                });
            },

            /*upload Image*/
            newImage(){
                this.isActiveImage = true;
            },
            removeImage(){
                this.isActiveImage = false;
            },
            onFileTypeMismatch (file) {
                this.errorUpload = 'Invalid file type. Please choose a jpeg or png file.';
                this.isActiveImage = false;
            },
            onFileSizeExceed (file) {
                this.errorUpload = 'File size exceeds. Please choose a file smaller than 3MB.';
                this.isActiveImage = false;
            },
            upload() {
                if (!this.myCroppa.hasImage()) {
                    this.errorUpload = 'No image to upload';
                    return
                }

                this.myCroppa.generateBlob((blob) => {
                    var self = this;

                    var fd = new FormData();
                    fd.append('id', this.id);
                    fd.append('file', blob, 'filename.png');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        error: function( jqXHR, textStatus, errorThrown ) {

                            if (jqXHR.status === 0) {
                                this.errorUpload = 'Not connect: Verify Network.';
                            } else if (jqXHR.status == 404) {
                                this.errorUpload = 'Requested page not found [404].';
                            } else if (jqXHR.status == 500) {
                                this.errorUpload = 'Internal Server Error [500].';
                            } else if (textStatus === 'parsererror') {
                                this.errorUpload = 'Requested JSON parse failed.';
                            } else if (textStatus === 'timeout') {
                                this.errorUpload = 'Time out error.';
                            } else if (textStatus === 'abort') {
                                this.errorUpload = 'Ajax request aborted.';
                            } else {
                                this.errorUpload = 'Uncaught Error: ' + jqXHR.responseText;
                            }

                        }
                    });

                    $.ajax({
                        url: this.urlController + 'upload',
                        data: fd,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if( data.status == 200 ){
                                self.myCroppa.refresh();
                                self.errorUpload = '';
                                self.isActiveImage = false;
                                swal(
                                    'Upload!',
                                    'Se subió correctamente la imagen',
                                    'success'
                                )
                            }else{
                                self.errorUpload = 'Ocurrio un error al subir la imagen.';
                            }
                        }
                    });
                })
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
                this.loadUnity();
                this.toggleHidden();

                switch(action){
                    case 'registrar':
                        this.id = 0;
                        this.categoryId = 0;
                        this.name = '';
                        this.description = '';
                        this.pricetag = '';
                        this.modalTitulo = 'Registrar Producto';
                        this.arrPresentation = [];
                        this.addInputPresentation();
                        this.$refs.modal.show();
                        break;
                    case 'actualizar':
                        this.id = data.id;
                        this.categoryId = data.category_id;
                        this.name = data.name;
                        this.description = data.description;
                        this.pricetag = data.pricetag;
                        this.arrPresentation = [];
                        this.loadPresentation(data.id);
                        this.modalTitulo = 'Actualizar Producto - '+data.name;
                        this.$refs.modal.show();
                        break;
                    case 'upload':
                        this.errorUpload = '';
                        this.$refs.upload.show();
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
                }
            },
            closeModal(){
                this.modalTitulo = '';
                this.id = '';
                this.categoryId =  0;
                this.name = '';
                this.description = '';
                this.pricetag = 0;
                this.action = 'registrar';
                this.arrCategories = [];
                this.arrUnity = [];
                this.myCroppa.refresh();
                this.errorUpload = '';
                this.isActiveImage = false;
                this.arrPresentation = [];
                this.$nextTick(() => {
                    this.$refs.modal.hide();
                })
            },
            registrar(){
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let me = this;
                        axios.post( me.urlController + 'register',{
                            'name': this.name,
                            'category_id': this.categoryId,
                            'description': this.description,
                            'pricetag': this.pricetag,
                            'presentation': this.arrPresentation
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
                            'unity_id': this.unityId,
                            'description': this.description,
                            'pricetag': this.pricetag,
                            'presentation': this.arrPresentation
                        }).then(function (response) {
                            me.closeModal();
                            me.listar(1,'','nombre');
                            swal(
                                'Actualización!',
                                'Se realizó correctamente la actualización del registro',
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
            eliminar(id){
                swal({
                    title: "Eliminar!",
                    text: "Esta seguro de eliminar este Producto?",
                    icon: "error",
                    button: "Eliminar"
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


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {

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
            loadUnity(){
                let me = this;
                var url = '/unity/select';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrUnity = respuesta.unitis;
                }).catch(function(error){
                    console.log(error);
                });
            },
            openModalGalery( id ){
                var me = this;
                var url= '/productGalery/' + id;

                axios.get(url).then(function (response) {

                    var respuesta= response.data;

                    if( respuesta.galery.length > 0 ){
                        me.arrImage= respuesta.galery;
                        me.$refs.modalGalery.show();
                    }

                }).catch(function (error) {
                    swal(
                        'Error! :(',
                        'No se pudo pudo mostrar la galería.',
                        'error'
                    )
                });
            },
            loadGalery( id ){
                var me = this;
                var url= '/productGalery/' + id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrImage= respuesta.galery;
                }).catch(function (error) {
                    swal(
                        'Error! :(',
                        'No se pudo pudo mostrar la galería.',
                        'error'
                    )
                });
                return 0;
            },
            addInputPresentation(){
                var num = this.arrPresentation.length;
                this.arrPresentation.push(
                    {
                        'id': num,
                        'description': '',
                        'unity': 0,
                        'equivalence': 1,
                        'delete': 0,
                        'idTable': 0
                    }
                );
            },
            delInputsPresentation( id ){
                this.arrPresentation[id].delete = 1;
            },
            savePresentation(){
                let me = this;
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let me = this;
                        axios.put( me.urlController + 'presentation/',{
                            'id': this.id,
                            'presentation': this.arrPresentation
                        }).then(function (response) {
                            me.loadPresentation( me.id );
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
            loadPresentation(id){
                let me = this;
                var url = '/presentation/select/' + id;
                me.arrPresentation = [];
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrPresentation = respuesta.presentation;
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
                        const link  = document.createElement('a')
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
            }
        },
        mounted() {
            this.listar(1, this.search);
        }
    }
</script>

<style scoped>

</style>