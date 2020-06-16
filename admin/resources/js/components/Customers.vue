<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Clientes</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input type="text" v-model="search" @keyup="list(1, search)" class="form-control mb-2" id="inlineFormInput" placeholder="Buscar...">
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary mb-2" @click.prevent="list(1, search)">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                            <div class="col-auto">
<!--                                <button type="submit" class="btn btn-success mb-2" @click.prevent="openModal('registrar')" title="Nuevo cliente">-->
<!--                                    <i class="fa fa-fw fa-lg fa-plus"></i>Nuevo cliente-->
<!--                                </button>-->
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
                            <table class="table table-hover mb-0 table__sales">
                                <thead>
                                <tr>
                                    <th>Nombre o Razón Social</th>
                                    <th>Nro de Doc</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(dato, idx) in arreglo" :key="dato.id">
                                    <td>
                                        {{ dato.name }}
                                        <br v-show="dato.type_person == 1">
                                        <small v-show="dato.type_person == 1">{{ dato.business_name }}</small>
                                    </td>
                                    <td>
                                        <span v-for="atd in arrTypeDocuments" :key="atd.id" v-if="atd.id == dato.type_document">
                                            {{ atd.name }}
                                        </span> {{ dato.document }}
                                    </td>
                                    <td class="text-center" v-text="dato.email"></td>
                                    <td class="text-center"></td>
                                    <td>
                                        <div v-if="dato.status === 1">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-if="dato.status === 3">
                                            <span class="badge badge-warning">Proceso de registro</span>
                                        </div>
                                        <div v-if="dato.status === 0">
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                    <td>
<!--                                        <button type="button" class="btn btn-outline-info btn-xs" :disabled="dato.existUser > 0" title="Agregar cuenta" @click.prevent="SingInCustomer(dato.id, idx)">-->
<!--                                            <i class="fa fa-fw fa-lg fa-key"></i> Agregar Cuenta-->
<!--                                        </button>-->
<!--                                        <button type="button" class="btn btn-outline-danger btn-xs" title="Generar PDF" @click.prevent="pdf(dato)">-->
<!--                                            <i class="fa fa-fw fa-lg fa-file-pdf-o"></i> PDF-->
<!--                                        </button>-->
                                        <button type="button" class="btn btn-outline-info btn-xs" title="Editar" @click.prevent="openModal('actualizar', dato)">
                                            <i class="fa fa-fw fa-lg fa-edit"></i> Editar
                                        </button>
                                        <button v-if="dato.status === 1" type="button" class="btn btn-outline-warning btn-xs" title="Desactivar Cliente" @click.prevent="desactivar(dato.id)">
                                            <i class="fa fa-fw fa-lg fa-ban"></i> Desactivar
                                        </button>
                                        <button v-if="dato.status === 0" type="button" class="btn btn-outline-success btn-xs" title="Activar Cliente" @click.prevent="activar(dato.id)">
                                            <i class="fa fa-fw fa-lg fa-check"></i> Activar
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-xs" title="Eliminar Cliente" @click.prevent="eliminar(dato.id)">
                                            <i class="fa fa-fw fa-lg fa-trash-o"></i> Eliminar
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
        <b-modal id="modalPrevent" size="lg" ref="modal" :title="modalTitulo" @ok="processForm">
            <form @submit.stop.prevent="cerrarModal">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#info" role="tab" aria-controls="info">Información</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#telephone" role="tab" aria-controls="telephone">Telefonos</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="info" role="tabpanel">
                        <div class="form-group row margin-top-2-por">
                            <label class="col-md-3 form-control-label">Tipo de Persona</label>
                            <div class="form-check form-check-inline" v-for="tper in arrTypePerson" :key="tper.id">
                                <input type="radio" class="form-check-input" :id="'typedoc' + tper.id" :name="'typedoc' + tper.id" :value="tper.id" v-model="typePerson">
                                <label class="form-check-label" :for="'typedoc' + tper.id" v-text="tper.name"></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label">
                                <template v-if="typePerson == 1">Nombre</template>
                                <template v-else>Razón Social</template>
                                <span class="text-danger">(*)</span>
                            </label>
                            <div :class="typePerson == 1 ? 'col-md-4' : 'col-md-9'">
                                <input type="text" v-model="name" name="nombre" v-validate="'required'" class="form-control"
                                       :placeholder="typePerson == 1 ? 'Nombre' : 'Razón social'"
                                       :class="{'is-invalid': errors.has('nombre')}">
                                <span v-show="errors.has('nombre')" class="text-danger">{{ errors.first('nombre') }}</span>
                            </div>
                            <div class="col-md-5" v-show="typePerson == 1">
                                <input type="text" v-model="lastname" name="apellidos" class="form-control"
                                       v-validate="typePerson == 1 ? 'required' : ''"
                                       placeholder="Apellidos"
                                       :class="{'is-invalid': errors.has('apellidos')}">
                                <span v-show="errors.has('apellidos')" class="text-danger">{{ errors.first('apellidos') }}</span>
                            </div>
                        </div>
                        <div class="form-group row" v-show="typePerson == 2">
                            <label class="col-md-3 form-control-label">Nombre comercial</label>
                            <div class="col-md-9">
                                <input type="text" v-model="businessName" name="nombre_comercial" class="form-control" placeholder="Nombre comercial" :class="{'is-invalid': errors.has('nombre_comercial')}">
                                <span v-show="errors.has('nombre_comercial')" class="text-danger">{{ errors.first('nombre_comercial') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label">Nro de doc. <span class="text-danger">(*)</span></label>
                            <div class="col-md-3">
                                <select class="form-control" name="type_document" v-model="typeDocument"
                                        v-validate="{ required: true }"
                                        :class="{'is-invalid': errors.has('type_document')}"
                                >
                                    <option value="" disabled selected hidden >Tipo de doc</option>
                                    <option v-for="td in arrTypeDocuments" v-bind:value="td.id" v-text="td.name"></option>
                                </select>
                                <span v-show="errors.has('type_document')" class="text-danger">{{ errors.first('type_document') }}</span>
                            </div>
                            <div class="col-md-6">
                                <input type="text" v-model="document" name="documento" v-validate="{ required: true, regex: /^[0-9]+$/, min:8, max:20 }" class="form-control" placeholder="Nro. de doc." :class="{'is-invalid': errors.has('documento')}">
                                <span v-show="errors.has('documento')" class="text-danger">{{ errors.first('documento') }}</span>
                            </div>
                        </div>
                        <div class="form-group row" v-show="typePerson == 2">
                            <label class="col-md-3 form-control-label">Representante Legal</label>
                            <div class="col-md-9">
                                <input type="text" v-model="legalRep" name="representante_legal" class="form-control" placeholder="Rep. Legal" :class="{'is-invalid': errors.has('representante_legal')}">
                                <span v-show="errors.has('representante_legal')" class="text-danger">{{ errors.first('representante_legal') }}</span>
                            </div>
                        </div>
                        <div class="form-group row" v-show="typePerson == 2">
                            <label class="col-md-3 form-control-label">Nro de doc.</label>
                            <div class="col-md-3">
                                <select class="form-control" name="tipo_doc_rep_legal" v-model="typeDocumentLp" v-validate="`${documentLp.length > 0 ? 'required' : ''}`" :class="{'is-invalid': errors.has('tipo_doc_rep_legal')}">
                                    <option value="" disabled selected hidden >Tipo de doc</option>
                                    <option v-for="td in arrTypeDocuments" v-bind:value="td.id" v-text="td.name"></option>
                                </select>
                                <span v-show="errors.has('tipo_doc_rep_legal')" class="text-danger">{{ errors.first('tipo_doc_rep_legal') }}</span>
                            </div>
                            <div class="col-md-6">
                                <input type="text" v-model="documentLp" name="documento_rep_legal" v-validate="{ regex: /^[0-9]+$/, min:8, max:20 }" class="form-control" placeholder="Nro. de doc. rep. legal" :class="{'is-invalid': errors.has('documento_rep_legal+')}">
                                <span v-show="errors.has('documento_rep_legal')" class="text-danger">{{ errors.first('documento_rep_legal') }}</span>
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
                            <label class="col-md-3 form-control-label">Dirección <span class="text-danger">(*)</span></label>
                            <div class="col-md-9">
                                <input type="tex" v-model="address" name="direccion" v-validate="'required'" class="form-control" placeholder="Dirección" :class="{'is-invalid': errors.has('direccion')}">
                                <span v-show="errors.has('direccion')" class="text-danger">{{ errors.first('direccion') }}</span>
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
                    </div>
                    <div class="tab-pane" id="telephone" role="tabpanel">
                        <div class="form-group row margin-top-2-por">
                            <div class="col-md-12">
                                <div class="tile">
                                    <h3 class="tile-title">Telefonos</h3>
                                    <div class="tile-body">
                                        <div class="btn-group">
                                            <button class="btn btn-success btn-sm" type="button" @click="addInputsTelf">
                                                <i class="fa fa-fw fa-lg fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" v-for="telf in arrTelephones" :key="telf.id" v-if="telf.delete == 0">
                            <div class="col-md-2">
                                <select class="form-control" :name="'typeTelf' + telf.id" v-model="telf.typeTelf"
                                        v-validate="telf.number !== '' ? 'required' : ''"
                                        :class="{'is-invalid': errors.has('typeTelf'+telf.id)}"
                                >
                                    <option value="" disabled selected hidden >Tipo telf.</option>
                                    <option v-for="ttelf in arrTypeTelephones" v-bind:value="ttelf.id" v-text="ttelf.name"></option>
                                </select>
                                <span v-show="errors.has('typeTelf' + telf.id)" class="text-danger">{{ errors.first('typeTelf' + telf.id) }}</span>
                            </div>
                            <div class="col-md-6">
                                <input type="text" :name="'telf' + telf.id" v-model="telf.number" class="form-control"
                                       v-validate="{ regex: /^[0-9]+$/, min:6, max:9 }"
                                       :class="{'is-invalid': errors.has('telf'+telf.id)}"
                                >
                                <span v-show="errors.has('telf' + telf.id)" class="text-danger">{{ errors.first('telf' + telf.id) }}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="predetermined" :value="telf.id" v-model="telfPredetermined" >Predeterminado
                                </label>
                            </div>
                            <div class="col-md-2 align-self-end">
                                <div class="btn-group">
                                    <button class="btn btn-danger btn-sm" type="button" @click="delInputsTelf(telf.id)">
                                        <i class="fa fa-fw fa-lg fa-close"></i>
                                    </button>
                                    <button class="btn btn-success btn-sm" type="button" @click="addInputsTelf" v-show="telf.id == ( arrTelephones.length - 1 )">
                                        <i class="fa fa-fw fa-lg fa-plus"></i>
                                    </button>
                                </div>
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
                lastname: "",
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
                arrTypeTelephones: [],
                arrTelephones: [],
                telfPredetermined: 0,
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
            addInputsTelf() {
                var numTelefones = this.arrTelephones.length;
                this.arrTelephones.push({
                    'id': numTelefones,
                    'typeTelf': '',
                    'number': '',
                    'idTable': 0,
                    'delete': 0
                });
            },
            delInputsTelf(id){
                this.arrTelephones[id].delete = 1;
            },
            config(){
                let me = this;
                var url = '/customers/config/';
                axios.get( url ).then( function ( response ) {
                    var respuesta = response.data;
                    me.arrTypePerson = respuesta.typePerson;
                    me.arrTypeTelephones = respuesta.typeTelephone;
                }).catch( function ( error ) {
                    console.log( error );
                });
            },
            changePage(page, search){
                let me = this;
                me.pagination.current_page = page;
                me.list(page,search);
            },
            loadDataEdit(){
                let me = this;
                var url = '/get-data-customer/';
                axios.get( url,{
                    params: {
                        'id': me.id,
                        'district': me.districtId
                    }
                }).then( function ( response ) {

                    var respuesta = response.data;

                    if(respuesta.telephone.length > 0){
                        me.arrTelephones = respuesta.telephone;
                        me.telfPredetermined = respuesta.predetermined;
                    }else{
                        me.addInputsTelf();
                        me.telfPredetermined = 0;
                    }

                    if(respuesta.ubigeo['departament_id'] != ""){
                        me.departamentId = respuesta.ubigeo['departament_id'];
                        me.loadProvince();
                    }

                    if(respuesta.ubigeo['province_id'] != ""){
                        me.provinceId = respuesta.ubigeo['province_id'];
                        me.loadDistrict();
                    }

                    if(respuesta.ubigeo['district_id'] != ""){
                        me.districtId = respuesta.ubigeo['district_id'];
                    }

                }).catch( function ( error ) {
                    console.log( error );
                });
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
                var url= '/customers/?page=' + page + '&search='+ search;
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
                        this.action = action;
                        this.id = 0;
                        this.districtId = '';
                        this.provinceId = '';
                        this.departamentId= '';
                        this.name = "";
                        this.lastname = "";
                        this.businessName = "";
                        this.legalRep = "";
                        this.document = "";
                        this.typeDocument = "";
                        this.address = "";
                        this.typeDocumentLp = "";
                        this.documentLp = "";
                        this.typePerson = 1;
                        this.email = "";
                        this.arrProvinces = [];
                        this.arrDistricts = [];
                        this.arrTelephones = [];
                        this.telfPredetermined = 0;
                        this.addInputsTelf();
                        this.modalTitulo = 'Registrar Cliente';
                        this.$refs.modal.show();
                        break;
                    case 'actualizar':
                        this.action = action;
                        this.id = data.id;
                        this.districtId = data.district_id;
                        this.arrTelephones = [];
                        this.telfPredetermined = 0;
                        this.loadDataEdit();
                        this.name = data.name;
                        this.lastname = ( data.lastname ? data.lastname : '' );
                        this.businessName = ( data.business_name ? data.business_name : '' );
                        this.legalRep = ( data.legal_representative ? data.legal_representative : '' );
                        this.document = data.document;
                        this.typeDocument = data.type_document;
                        this.typePerson = data.type_person;
                        this.address = data.address;
                        this.typeDocumentLp = data.type_document_lp;
                        this.documentLp = ( data.document_lp ? data.document_lp : '' );
                        this.email = data.email;
                        this.modalTitulo = 'Modificar datos del cliente';
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
                        axios.post('/customers/register',{
                            'name': this.name,
                            'lastname': this.lastname,
                            'businessName': this.businessName,
                            'typePerson': this.typePerson,
                            'typeDocument': this.typeDocument,
                            'document': this.document,
                            'legalRepresentative': this.legalRep,
                            'typeDocumentLp': this.typeDocumentLp,
                            'documentLp': this.documentLp,
                            'email': this.email,
                            'address': this.address,
                            'districtId': this.districtId,
                            'telephones': this.arrTelephones,
                            'telfPredetermined': this.telfPredetermined,
                        }).then(function (response) {
                            me.closeModal();
                            me.list(1, '');
                        }).catch(function (error) {
                            console.log(error);
                        });
                    }
                });
            },
            update() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let me = this;
                        axios.put('/customers/update/',{
                            'id': this.id,
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
                            'districtId': this.districtId,
                            'telephones': this.arrTelephones,
                            'telfPredetermined': this.telfPredetermined,
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
                this.arrTelephones = [];
                this.telfPredetermined = 0;
                this.modalTitulo = 'Registrar cliente';
                this.$nextTick(() => {
                    // Wrapped in $nextTick to ensure DOM is rendered before closing
                    this.$refs.modal.hide();
                })
            },
            pdf( data ){
                let me = this;
                var url = '/customers/' + data.id + '/pdf';
                var fileName = data.name.replace(/ /g, '-') + '.pdf';

                axios({
                    url: url,
                    method: 'GET',
                    responseType: 'blob',
                }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', fileName); //or any other extension
                    document.body.appendChild(link);
                    link.click();
                });
            },
            activar(id){
                swal({
                    title: "Activar cliente",
                    text: "Esta seguro de activar a este cliente?",
                    icon: "success",
                    button: "Activar"
                }).then((result) => {
                    if (result) {
                        let me = this;

                        axios.put('/customers/activate',{
                            'id': id
                        }).then(function (response) {
                            me.list(1, '');
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
            desactivar(id){
                swal({
                    title: "Desactivar cliente",
                    text: "Esta seguro de desactivar a este cliente?",
                    icon: "warning",
                    button: "Desactivar",
                }).then((result) => {
                    if (result) {
                        let me = this;

                        axios.put('/customers/deactivate',{
                            'id': id
                        }).then(function (response) {
                            me.list(1, '');
                            swal(
                                'Desactivado!',
                                'El registro ha sido desactivado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {

                    }
                })
            },
            eliminar(id){
                swal({
                    title: "Eliminar!",
                    text: "Esta seguro de eliminar a este cliente?",
                    icon: "error",
                    button: "Eliminar"
                }).then((result) => {
                    if (result) {
                        let me = this;

                        axios.put( '/customers/delete',{
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


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {

                    }
                })
            },
            SingInCustomer( id, index ) {
                this.arreglo[index].existUser++;
                window.location = URL_PROJECT + '/customers/generate-user/' + id;
            }
        },
        mounted() {
            this.config();
            this.loadTypeDocuments();
            this.list(1, this.search);
        }
    }
</script>
<style scoped>
    select:invalid { color: gray; }
</style>
