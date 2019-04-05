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
                                <button class="btn btn-success" type="button" @click="openModal('registrar')">
                                    <i class="fa fa-fw fa-lg fa-plus"></i>Nuevo módulo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <template v-if="arrData.length > 0">
                <div class="col-sm-6 col-md-4"v-for="dato in arrData" :key="dato.id">
                    <div class="tile">
                        <img src="http://admin.dpintart.devel/user/1/profile-image-wyng3.jpeg" :title="dato.name" />
                        <div class="tile-title-w-btn">
                            <h3 class="title" v-text="dato.name"></h3>
                        </div>
                        <div class="tile-body">
                            <b v-text="dato.name"></b><br>
                            <span v-text="dato.description"></span>
                            <br>
                            <b>Compartir:</b>&nbsp;&nbsp;
                            <div class="btn-group">
                                <a class="btn btn-info" href="#">
                                    <i class="fa fa-lg fa-facebook"></i>
                                </a>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <div class="btn-group">
                                <a class="btn btn-primary" href="#">
                                    <i class="fa fa-lg fa-building"></i>
                                </a>
                                <a class="btn btn-primary" href="#">
                                    <i class="fa fa-lg fa-image"></i>
                                </a>
                                <a class="btn btn-primary" href="#">
                                    <i class="fa fa-lg fa-eye"></i>
                                </a>
                                <a class="btn btn-primary" href="#" @click.prevent="openModal('actualizar', dato)">
                                    <i class="fa fa-lg fa-edit"></i>
                                </a>
                                <a class="btn btn-primary" href="#" @click.prevent="eliminar(dato.id)">
                                    <i class="fa fa-lg fa-trash"></i>
                                </a>
                            </div>
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
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Categoría <span class="text-danger">(*)</span></label>
                    <div class="col-md-4">
                        <select class="form-control" v-model="categoryId" name="categoria" v-validate="{is_not: 0}" :class="{'is-invalid': errors.has('categoria')}">
                            <option value="0" disabled>Seleccione</option>
                            <option v-for="cat in arrCategories" :key="cat.id" :value="cat.id" v-text="cat.name"></option>
                        </select>
                        <span v-show="errors.has('categoria')" class="text-danger">{{ errors.first('categoria') }}</span>
                    </div>
                    <label class="col-md-2 form-control-label">Unidad de medida</label>
                    <div class="col-md-4">
                        <select class="form-control" v-model="unityId" name="unidad" v-validate="{is_not: 0}" :class="{'is-invalid': errors.has('unidad')}">
                            <option value="0" disabled>Seleccione</option>
                            <option v-for="unity in arrUnity" :key="unity.id" :value="unity.id" v-text="unity.name"></option>
                        </select>
                        <span v-show="errors.has('unidad')" class="text-danger">{{ errors.first('unidad') }}</span>
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
                <div class="form-group row" >
                    <label class="col-md-3 form-control-label">Precio referencial</label>
                    <div class="col-md-9">
                        <input type="number" v-model="pricetag" name="precio_referencial" v-validate="{regex: /^([0-9]+)$/, min_value: 0}" class="form-control" :class="{'is-invalid': errors.has('precio_referencial')}">
                        <span v-show="errors.has('precio_referencial')" class="text-danger">{{ errors.first('precio_referencial') }}</span>
                    </div>
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
    export default {
        name: "Products",
        data() {
            return {
                urlController: '/products/',
                action: '',
                arrData: [],
                arrUnity: [],
                arrCategories: [],
                id: '',
                unityId: 0,
                categoryId: 0,
                name: '',
                description: '',
                pricetag: 0,
                modalTitulo: '',
                search: '',
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
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

                this.loadCategory();
                this.loadUnity();

                switch(action){
                    case 'registrar':
                        this.id = 0;
                        this.categoryId = 0;
                        this.unityId = 0;
                        this.name = '';
                        this.description = '';
                        this.pricetag = '';
                        this.modalTitulo = 'Registrar Producto';
                        this.action = action;
                        this.$refs.modal.show();
                        break;
                    case 'actualizar':
                        this.id = data.id;
                        this.categoryId = data.category_id;
                        this.unityId = data.unity_id;
                        this.name = data.name;
                        this.description = data.description;
                        this.pricetag = data.pricetag;
                        this.modalTitulo = 'Actualizar Producto - '+data.name;
                        this.action = action;
                        this.$refs.modal.show();
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
                }
            },
            closeModal(){
                this.modalTitulo = '';
                this.id = '';
                this.categoryId =  0;
                this.unityId = 0;
                this.name = '';
                this.description = '';
                this.pricetag = 0;
                this.action = 'registrar';
                this.arrCategories = [];
                this.arrUnity = [];
                this.$nextTick(() => {
                    this.$refs.modal.hide();
                })
            },
            registrar(){
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let me = this;
                        axios.post( me.urlController + 'register',{
                            'nombre': this.name,
                            'category_id': this.categoryId,
                            'unity_id': this.unityId,
                            'description': this.description,
                            'pricetag': this.pricetag
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
                            'nombre': this.name,
                            'category_id': this.categoryId,
                            'unity_id': this.unityId,
                            'description': this.description,
                            'pricetag': this.pricetag
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
            }
        },
        mounted() {
            this.listar(1, this.search);
        }
    }
</script>

<style scoped>

</style>