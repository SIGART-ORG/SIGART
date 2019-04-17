<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Proveedores</h3>
                    <div class="tile-body">
                        <form class="row">
                            <div class="form-group col-md-6">
                                <input class="form-control" v-model="search" type="text" placeholder="Buscar" @keyup="list(1, search)">
                            </div>
                            <div class="form-group col-md-3 align-self-end">
                                <button class="btn btn-primary" type="button" @click="list(1, search)">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                            <div class="form-group col-md-3 align-self-end">
                                <button class="btn btn-success" type="button" @click="openModal('registrar')">
                                    <i class="fa fa-fw fa-lg fa-plus"></i>Nuevo proveedor
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Proveedor</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Ícono</th>
                                    <th>Páginas</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="arreglo.length > 0">
                                    <tr v-for="dato in arreglo" :key="dato.id">
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" @click="abrirModal('actualizar', dato)">
                                                <i class="fa fa-edit"></i>
                                            </button> &nbsp;
                                            <button type="button" class="btn btn-danger btn-sm" @click="eliminar(dato.id)">
                                                <i class="fa fa-trash-o"></i>
                                            </button> &nbsp;
                                            <template v-if="dato.status == 1">
                                                <button type="button" class="btn btn-warning btn-sm" @click="desactivar(dato.id)">
                                                    <i class="fa fa-ban"></i>
                                                </button>
                                            </template>
                                            <template v-else>
                                                <button type="button" class="btn btn-success btn-sm" @click="activar(dato.id)">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </template>
                                        </td>
                                        <td v-text="dato.name"></td>
                                        <td>
                                            <i class="fa fa-lg" :class="dato.icon"></i>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-primary btn-sm" @click="redirect(dato.id)">
                                                <i class="fa fa-bookmark"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <div v-if="dato.status">
                                                <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-else>
                                                <span class="badge badge-danger">Desactivado</span>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                                <tr v-else>
                                    <td colspan="6" class="text-center">No se encontraron registros en nuestra base de datos.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
        </div>
        <b-modal id="modalPrevent" size="lg" ref="modal" :title="modalTitulo" @ok="processForm">
            <form @submit.stop.prevent="cerrarModal">
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Nombre o Razón Social<span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <input type="text" v-model="name" name="nombre" v-validate="'required'" class="form-control" placeholder="Nombre" :class="{'is-invalid': errors.has('nombre')}">
                        <span v-show="errors.has('nombre')" class="text-danger">{{ errors.first('nombre') }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 form-control-label">Tipo de doc.<span class="text-danger">(*)</span></label>
                    <div class="col-md-3">

                    </div>
                    <label class="col-md-2 form-control-label">Nro de doc. <span class="text-danger">(*)</span></label>
                    <div class="col-md-6">
                        <input type="text" v-model="document" name="documento" v-validate="'required'" class="form-control" placeholder="Nro. de doc." :class="{'is-invalid': errors.has('documento')}">
                        <span v-show="errors.has('documento')" class="text-danger">{{ errors.first('documento') }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Ubigeo<span class="text-danger">(*)</span></label>
                    <div class="col-md-3">
                        <select2 :options="arrDepartaments" v-model="departamentId" @input="loadProvince"></select2>
                    </div>
                    <div class="col-md-3">

                    </div>
                </div>
            </form>
        </b-modal>
    </div>
</template>
<script>
    import Select2  from 'select2';
    export default {
        name: 'providers-admin',
        data(){
            return{
                action: 'registrar',
                modalTitulo: '',
                arreglo: [],
                id: 0,
                districtId: 0,
                provinceId: 0,
                departamentId: 0,
                name: "",
                legalRep: "",
                document: "",
                typeDocument: "",
                address: "",
                typeDocumentLp: "",
                email: "",
                arrDepartaments: [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                search : ''
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
            Select2
        },
        methods:{
            changePage(page, search){
                let me = this;
                me.pagination.current_page = page;
                me.listar(page,search);
            },
            loadDepartament(){
                var me = this;
                if( me.arrDepartaments.length == 0 ) {
                    var url = '/departaments/';
                    axios.get(url).then(function (response) {
                        var respuesta = response.data;
                        me.arrDepartaments = respuesta.departaments;
                    })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            loadProvince(){
                var me = this;
                console.log(me.departamentId);
            },
            list( page, search ){
                var me = this;
                var url= '/providers/?page=' + page + '&search='+ search;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arreglo = respuesta.records.data;
                    me.pagination= respuesta.pagination;
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            openModal( action, data = [] ) {
                this.loadDepartament();
                switch( action ){
                    case 'registrar':
                        this.accion = action;
                        this.id = 0;
                        this.districtId = 0;
                        this.name = "";
                        this.legalRep = "";
                        this.document = "";
                        this.typeDocument = "";
                        this.address = "";
                        this.typeDocumentLp = "";
                        this.email = "";
                        this.modalTitulo = 'Registrar proveedor';
                        this.$refs.modal.show();
                        break;
                    case 'actualizar':
                        this.action = action;
                        this.id = data.id;
                        this.districtId = data.district_id;
                        this.name = data.name;
                        this.legalRep = data.legal_representative;
                        this.document = data.document;
                        this.typeDocument = data.type_document;
                        this.address = data.address;
                        this.typeDocumentLp = data.type_document_lp;
                        this.email = data.email;
                        this.modalTitulo = 'Modificar datos de proveedor';
                        this.$refs.modal.show();
                        break;
                }
            },
            processForm(evt) {
                evt.preventDefault();
                switch(this.action){
                    case 'registrar':
                        this.registrar();
                        break;
                    case 'actualizar':
                        this.actualizar();
                        break;
                }
            }
        },
        mounted() {
            this.list(1, this.search);
        }
    }
</script>