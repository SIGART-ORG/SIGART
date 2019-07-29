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
                                <button type="submit" class="btn btn-primary mb-2" @click="list(1, search)">
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
                                    <th>Stock</th>
                                    <th>Prec. referencial</th>
                                    <th>Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="arrList.length > 0" v-for="( row, idx ) in arrList" :key="row.id">
                                    <td>{{ idx + 1 }}</td>
                                    <td v-text="row.sku"></td>
                                    <td v-text="row.name"></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <a href="#" aria-expanded="false" data-toggle="dropdown" class="btn btn-link dropdown-toggle btn-icon-dropdown">
                                                    <span class="feather-icon">
                                                        <i data-feather="settings"></i>
                                                    </span> <span class="caret"></span> Opciones
                                                </a>
                                                <div role="menu" class="dropdown-menu">
<!--                                                    <a class="dropdown-item" :title="'Ver producto - ' + dato.name" href="#" @click="viewDetail( row )">-->
<!--                                                        <i class="fa fa-eye"></i>&nbsp;Ver detalles-->
<!--                                                    </a>-->
                                                    <a class="dropdown-item" :title="'Galería - ' + row.name" href="#" @click.prevent="openModal( 'gallery', row )">
                                                        <i class="fa fa-image"></i>&nbsp;Galería
                                                    </a>
                                                    <div class="dropdown-divider"></div>
<!--                                                    <a class="dropdown-item" href="#" :title="'Editar presentación - ' + row.name"  @click.prevent="openModal('actualizar', row)">-->
<!--                                                        <i class="fa fa-edit"></i> Editar-->
<!--                                                    </a>-->
                                                    <a class="dropdown-item" href="#" :title="'Subir presentación - ' + row.name"  @click.prevent="openModal('uploadImage', row)">
                                                        <i class="fa fa-upload"></i> Subir Imagen
                                                    </a>
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
        <b-modal id="gallery" size="lg" ref="gallery" :title="titleModal" @ok="processForm" @hidden="closeModal">
            <Gallery ref="galleryComponent" :relId="id" rel="presentations" v-if="id > 0"></Gallery>
        </b-modal>
        <b-modal id="uploadImage" size="lg" ref="uploadImage" title="Subir Imagen" @ok="processForm" @hidden="closeModal">
            <ProductsImage ref="formUploadImage" :product="id" post_url="presentations" v-if="id > 0"></ProductsImage>
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
                arrList:    [],
                action:     '',
                /*Start Modal*/
                titleModal: '',
                /*End Modal*/
                /* Start Pagination */
                offset:     3,
                pagination:         {
                    'total':        0,
                    'current_page': 0,
                    'per_page':     0,
                    'last_page':    0,
                    'from':         0,
                    'to':           0,
                },
                /* End Pagination */
                /* Start Register */
                id:         0
                /* End Register */
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
            }
        },
        mounted() {
            this.list( 1, this.search );
        }
    }
</script>

<style scoped>

</style>
