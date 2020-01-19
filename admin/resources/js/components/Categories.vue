<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Categorias</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input type="text" v-model="buscar" @keyup="listar(1, buscar)" class="form-control mb-2" id="inlineFormInput" placeholder="Buscar...">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="listar(1, buscar)">
                                    <i class="fa fa-fw fa-lg fa-search"></i>Buscar
                                </button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-info mb-2" @click.prevent="abrirModal('registrar')">
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
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="dato in arreglo" :key="dato.id">
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" @click="abrirModal('actualizar', dato)">
                                            <i class="fa fa-edit"></i>
                                        </button> &nbsp;
                                        <button type="button" class="btn btn-danger btn-sm" @click="eliminar(dato.id)">
                                            <i class="fa fa-trash-o"></i>
                                        </button> &nbsp;
                                        <template v-if="dato.status == 1">
                                            <button type="button" class="btn btn-success btn-sm" @click="desactivar(dato.id)">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-warning btn-sm" @click="activar(dato.id)">
                                                <i class="fa fa-ban"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="dato.name"></td>
                                    <td>
                                        <div v-if="dato.status">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
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
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page-1, buscar)">Ant.</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="changePage(page, buscar)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page+1, buscar)">Sig.</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>

        <b-modal id="modalPrevent" size="lg" ref="modal" title="Registro de Categorias" @ok="processForm">
            <form @submit.stop.prevent="cerrarModal">
                <div class="form-group row">
                    <label class="col-md-3 form-control-label" for="text-input">Nombre <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <input type="text" v-model="nombre" name="nombre" v-validate="'required'" class="form-control" placeholder="Nombre de categoría" :class="{'is-invalid': errors.has('nombre')}">
                        <span v-show="errors.has('nombre')" class="text-danger">{{ errors.first('nombre') }}</span>
                    </div>
                </div>
            </form>
        </b-modal>
    </div>
</template>
<script>
export default {
    name: 'categories-adm',
    data(){
        return{
            id: 0,
            nombre: "",
            arreglo: [],
            action: 'registrar',
            modalTitulo: '',
            modal: 0,
            tipoAccion: 0,
            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
            },
            offset : 3,
            criterio : 'nombre',
            buscar : ''
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
    methods:{
        listar(page,buscar,criterio){
            var me = this;
            var url= '/categories?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
            axios.get(url).then(function (response) {
                var respuesta= response.data;
                me.arreglo = respuesta.records.data;
                me.pagination= respuesta.pagination;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        cambiarPagina(page,buscar,criterio){
            let me = this;
            //Actualiza la página actual
            me.pagination.current_page = page;
            //Envia la petición para visualizar la data de esa página
            me.listar(page,buscar,criterio);
        },
        abrirModal(action, data=[]){
            switch(action){
                case 'registrar':
                    this.modal = 1;
                    this.tipoAccion = 1;
                    this.id = 0;
                    this.modalTitulo = 'Registrar';
                    this.nombre = '';
                    this.$refs.modal.show();
                break;
                case 'actualizar':
                    this.modal = 1;
                    this.tipoAccion = 2;
                    this.id = data.id;
                    this.modalTitulo = 'Actualizar - '+data.name;
                    this.nombre = data.name;
                    this.action = 'actualizar';
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
        cerrarModal(){
            this.modal = 0;
            this.modalTitulo = '';
            this.nombre = '';
            this.$nextTick(() => {
                // Wrapped in $nextTick to ensure DOM is rendered before closing
                this.$refs.modal.hide();
            })
        },
        registrar(){
            this.$validator.validateAll().then((result) => {
                if (result) {
                    let me = this;
                    axios.post('/categories/register',{
                        'nombre': this.nombre
                    }).then(function (response) {
                        me.cerrarModal();
                        me.listar(1,'','nombre');
                    }).catch(function (error) {
                         console.log(error);
                    });
                }
            });
        },
        actualizar(){
            this.$validator.validateAll().then((result) => {
                if (result) {
                    let me = this;
                    axios.put('/categories/update',{
                        'id': this.id,
                        'nombre': this.nombre
                    }).then(function (response) {
                        me.cerrarModal();
                        me.listar(1,'','nombre');
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            });
        },
        activar(id){
            swal({
                title: "Activar Categoria!",
                text: "Esta seguro de activar esta categoria?",
                icon: "success",
                button: "Activar"
            }).then((result) => {
                if (result) {
                    let me = this;

                    axios.put('/categories/activate',{
                        'id': id
                    }).then(function (response) {
                        me.listar(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });


                }
            })
        },
        desactivar(id){
            swal({
                title: "Desactivar Categoria!",
                text: "Esta seguro de desactivar este Categoria?",
                icon: "warning",
                button: "Desactivar",
            }).then((result) => {
                if (result) {
                    let me = this;

                    axios.put('/categories/deactivate',{
                        'id': id
                    }).then(function (response) {
                        me.listar(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });


                }
            })
        },
        eliminar(id){
            swal({
                title: "Eliminar!",
                text: "Esta seguro de eliminar este Categoria?",
                icon: "danger",
                button: "Eliminar"
            }).then((result) => {
                if (result) {
                    let me = this;

                    axios.put('/categories/delete',{
                        'id': id
                    }).then(function (response) {
                        me.listar(1,'','nombre');
                        swal(
                        'Eliminado!',
                        'El registro ha sido eliminado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });


                }
            })
        }
    },
    mounted() {
        this.listar(1,this.buscar,this.criterio);
    }
}
</script>
