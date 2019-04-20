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
                    <label class="col-md-3 form-control-label">Tipo de Persona</label>
                    <div class="form-check form-check-inline" v-for="tper in arrTypePerson" :key="tper.id">
                        <input type="radio" class="form-check-input" :id="'typedoc' + tper.id" :name="'typedoc' + tper.id" :value="tper.id" v-model="typePerson">
                        <label class="form-check-label" :for="'typedoc' + tper.id" v-text="tper.name"></label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">
                        <template v-if="typePerson == 0">Nombre</template>
                        <template v-else>Razón Social</template>
                        <span class="text-danger">(*)</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" v-model="name" name="nombre" v-validate="'required'" class="form-control" placeholder="Nombre o razón social" :class="{'is-invalid': errors.has('nombre')}">
                        <span v-show="errors.has('nombre')" class="text-danger">{{ errors.first('nombre') }}</span>
                    </div>
                </div>
                <div class="form-group row" v-show="typePerson == 1">
                    <label class="col-md-3 form-control-label">Nombre comercial</label>
                    <div class="col-md-9">
                        <input type="text" v-model="businessName" name="nombre_comercial" class="form-control" placeholder="Nombre comercial" :class="{'is-invalid': errors.has('nombre_comercial')}">
                        <span v-show="errors.has('nombre_comercial')" class="text-danger">{{ errors.first('nombre_comercial') }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Nro de doc.</label>
                    <div class="col-md-3">
                        <select class="form-control" v-model="typeDocument">
                            <option value="" disabled selected hidden >Tipo de doc</option>
                            <option v-for="td in arrTypeDocuments" v-bind:value="td.id" v-text="td.name"></option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" v-model="document" name="documento" v-validate="{ required: true, regex: /^[0-9]+$/, min:8, max:20 }" class="form-control" placeholder="Nro. de doc." :class="{'is-invalid': errors.has('documento')}">
                        <span v-show="errors.has('documento')" class="text-danger">{{ errors.first('documento') }}</span>
                    </div>
                </div>
                <div class="form-group row" v-show="typePerson == 1">
                    <label class="col-md-3 form-control-label">Representante Legal</label>
                    <div class="col-md-9">
                        <input type="text" v-model="legalRep" name="representante_legal" class="form-control" placeholder="Rep. Legal" :class="{'is-invalid': errors.has('representante_legal')}">
                        <span v-show="errors.has('representante_legal')" class="text-danger">{{ errors.first('representante_legal') }}</span>
                    </div>
                </div>
                <div class="form-group row" v-show="typePerson == 1">
                    <label class="col-md-3 form-control-label">Nro de doc.<span class="text-danger">(*)</span></label>
                    <div class="col-md-3">
                        <select class="form-control" v-model="typeDocumentLp">
                            <option value="" disabled selected hidden >Tipo de doc</option>
                            <option v-for="td in arrTypeDocuments" v-bind:value="td.id" v-text="td.name"></option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" v-model="documentLp" name="documento_rep_legal" v-validate="{ regex: /^[0-9]+$/, min:8, max:20 }" class="form-control" placeholder="Nro. de doc." :class="{'is-invalid': errors.has('documento_rep_legal+')}">
                        <span v-show="errors.has('documento_rep_legal')" class="text-danger">{{ errors.first('documento_rep_legal') }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Dirección <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <input type="tex" v-model="address" name="direccion" v-validate="'required'" class="form-control" placeholder="Dirección" :class="{'is-invalid': errors.has('direccion')}">
                        <span v-show="errors.has('direccion')" class="text-danger">{{ errors.first('direccion') }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">E-Mail</label>
                    <div class="col-md-9">
                        <input type="tex" v-model="email" name="correo" v-validate="'email'" class="form-control" placeholder="E-Mail" :class="{'is-invalid': errors.has('correo')}">
                        <span v-show="errors.has('correo')" class="text-danger">{{ errors.first('correo') }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Ubigeo<span class="text-danger">(*)</span></label>
                    <div class="col-md-3">
                        <select class="form-control" name="departamento" v-model="departamentId"
                                @change="loadProvince"
                                v-validate="{ required: true }"
                                :class="{'is-invalid': errors.has('departamento')}"
                        >
                            <option value="" disabled selected hidden >Departamento</option>
                            <option v-for="dep in arrDepartaments" v-bind:value="dep.id" v-text="dep.name"></option>
                        </select>
                        <span v-show="errors.has('departamento')" class="text-danger">{{ errors.first('departamento') }}</span>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="provincia" v-model="provinceId"
                                @change="loadDistrict"
                                v-validate="{ required: true }"
                                :class="{'is-invalid': errors.has('provincia')}"
                        >
                            <option value="" disabled selected hidden>Provincia</option>
                            <option v-for="prov in arrProvinces" v-bind:value="prov.id" v-text="prov.name"></option>
                        </select>
                        <span v-show="errors.has('provincia')" class="text-danger">{{ errors.first('departamento') }}</span>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="distrito" v-model="districtId"
                                v-validate="{ required: true }"
                                :class="{'is-invalid': errors.has('distrito')}"
                        >
                            <option value="" disabled selected hidden>Distrito</option>
                            <option v-for="dist in arrDistricts" v-bind:value="dist.id" v-text="dist.name"></option>
                        </select>
                        <span v-show="errors.has('distrito')" class="text-danger">{{ errors.first('departamento') }}</span>
                    </div>
                </div>
            </form>
        </b-modal>
    </div>
</template>
<script>
    export default {
        name: 'providers-admin',
        data(){
            return{
                action: 'registrar',
                modalTitulo: '',
                arreglo: [],
                id: 0,
                districtId: '',
                provinceId: '',
                departamentId: '',
                name: "",
                businessName: "",
                legalRep: "",
                document: "",
                typeDocument: "",
                address: "",
                typeDocumentLp: "",
                documentLp: '',
                email: "",
                typePerson: 0,
                arrDepartaments: [],
                arrProvinces: [],
                arrDistricts: [],
                arrTypePerson: [],
                arrTypeDocuments: [],
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
        },
        methods:{
            config(){
                let me = this;
                var url = '/providers/config/';
                axios.get( url ).then( function ( response ) {
                    var respuesta = response.data;
                    me.arrTypePerson = respuesta.typePerson;
                }).catch( function ( error ) {
                    console.log( error );
                });
            },
            changePage(page, search){
                let me = this;
                me.pagination.current_page = page;
                me.listar(page,search);
            },
            loadDepartament(){
                var me = this;
                this.provinceId = '';
                this.districtId = '';
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
                let me = this;
                this.provinceId = '';
                this.districtId = '';
                this.arrProvinces = [];
                this.arrDistricts = [];
                var url = '/provinces/' + this.departamentId;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrProvinces = respuesta.provinces;
                })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            loadDistrict() {
                let me = this;
                var url = '/districts/' + this.departamentId + '/' + this.provinceId;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrDistricts = respuesta.districts;
                })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            loadTypeDocuments() {
                let me = this;
                if( me.arrTypeDocuments.length == 0 ) {
                    var url = '/type-documents/';
                    axios.get(url).then(function (response) {
                        var respuesta = response.data;
                        me.arrTypeDocuments = respuesta.typeDocument;
                    })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
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
                this.loadTypeDocuments();
                switch( action ){
                    case 'registrar':
                        this.accion = action;
                        this.id = 0;
                        this.districtId = '';
                        this.provinceId = '';
                        this.departamentId= '';
                        this.name = "";
                        this.businessName = "";
                        this.legalRep = "";
                        this.document = "";
                        this.typeDocument = "";
                        this.address = "";
                        this.typeDocumentLp = "";
                        this.documentLp = "";
                        this.typePerson = 0;
                        this.email = "";
                        this.arrProvinces = [];
                        this.arrDistricts = [];
                        this.modalTitulo = 'Registrar proveedor';
                        this.$refs.modal.show();
                        break;
                    case 'actualizar':
                        this.action = action;
                        this.id = data.id;
                        this.districtId = data.district_id;
                        this.provinceId = '';
                        this.departamentId= '';
                        this.name = data.name;
                        this.businessName = data.business_name
                        this.legalRep = data.legal_representative;
                        this.document = data.document;
                        this.typeDocument = data.type_document;
                        this.typePerson = data.type_person;
                        this.address = data.address;
                        this.typeDocumentLp = data.type_document_lp;
                        this.documentLp = data.document_lp;
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
                        this.register();
                        break;
                    case 'actualizar':
                        this.update();
                        break;
                }
            },
            register(){
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let me = this;
                        axios.post('/providers/register',{
                            'name': this.name,
                            'businessName': this.businessName,
                            'typePerson': this.typePerson,
                            'typeDocument': this.typeDocument,
                            'document': this.document,
                            'legalRepresentative': this.legalRep,
                            'typeDocumentLp': this.typeDocumentLp,
                            'documentLp': this.documentLp,
                            'email': this.email,
                            'address': this.address,
                            'districtId': this.districtId
                        }).then(function (response) {
                            me.closeModal();
                            me.list(1, '');
                        }).catch(function (error) {
                            console.log(error);
                        });
                    }
                });
            },
            closeModal(){
                this.accion = 'registrar';
                this.id = 0;
                this.districtId = '';
                this.provinceId = '';
                this.departamentId= '';
                this.name = "";
                this.legalRep = "";
                this.document = "";
                this.typeDocument = "";
                this.address = "";
                this.typeDocumentLp = "";
                this.email = "";
                this.arrProvinces = [];
                this.arrDistricts = [];
                this.modalTitulo = 'Registrar proveedor';
                this.$nextTick(() => {
                    // Wrapped in $nextTick to ensure DOM is rendered before closing
                    this.$refs.modal.hide();
                })
            }
        },
        mounted() {
            this.config();
            this.list(1, this.search);
        }
    }
</script>
<style scoped>
    select:invalid { color: gray; }
</style>