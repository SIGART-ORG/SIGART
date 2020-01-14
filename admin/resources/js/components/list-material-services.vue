<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title" v-text="name_service"></h5>
        </section>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Listado</h5>

            <div class="row">
                <div class="col-md-3">
                    <div style="border: 1px solid #CFCFCF; padding: 10px;">
                        <h6 class="hk-sec-title">Operaciones</h6>
                        <div class="list-group">
                            <a href="#" class="list-group-item  list-group-item-action"
                               :class="sidebar === 'summary' ? 'active': ''"
                               @click.prevent="changeSideBar( 'summary' )">Resumen</a>
                            <a href="#" class="list-group-item  list-group-item-action"
                               :class="sidebar === 'list-materials' ? 'active': ''"
                               @click.prevent="changeSideBar( 'list-materials' )">Generar Listado</a>
                        </div>
                    </div>
                </div>
                <sr-summary v-if="sidebar === 'summary'" service="service"></sr-summary>
                <div class="col-md-9" v-if="sidebar === 'list-materials'">
                    <div style="border: 1px solid #CFCFCF; padding: 10px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div style="border: 1px solid #CFCFCF; padding: 10px;">
                                    <h6 class="hk-sec-title">Requerimientos</h6>
                                    <ul class="list-group">
                                        <template v-for="dato in list_requerimientos">
                                            <li :key="dato.id" class="list-group-item list-group-item-info ">
                                                {{dato.name}}
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="border: 1px solid #CFCFCF; padding: 10px;">
                                    <h6 class="hk-sec-title">Materiales</h6>
                                    <div class="row">
                                        <div class="col-sm">
                                            <form class="form-inline">
                                                <div class="form-row align-items-left">
                                                    <div class="col-auto">
                                                        <label class="sr-only" for="inlineFormInput">Buscar</label>
                                                        <input type="text" v-model="search"
                                                               @keyup="listproduc( 1, search, typeProduct )"
                                                               id="inlineFormInput" placeholder="Buscar..."
                                                               class="form-control mb-2">
                                                    </div>
                                                    <div class="col-auto">
                                                        <label class="sr-only" for="inlineFormInput2">Tipo de
                                                            producto</label>
                                                        <select class="form-control mb-2" id="inlineFormInput2"
                                                                v-model="typeProduct"
                                                                @change="listproduc( 1, search, typeProduct )">
                                                            <option value="0">Tipo de Producto</option>
                                                            <option value="1">Pintura</option>
                                                            <option value="2">Carpintería</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="submit" class="btn btn-primary mb-2"
                                                                @click="listproduc( 1, search, typeProduct )">
                                                            <i class="fa fa-fw fa-lg fa-search"></i> Buscar
                                                        </button>
                                                    </div>
                                                    <div v-show="request.length > 0" class="col-auto">
                                                        <button class="btn btn-success mb-2" type="button"
                                                                @click="generateRequest">
                                                            <i class="fa fa-fw fa-lg fa-plus"></i> Generar Materiales
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <h6 class="hk-sec-title">Stock</h6>
                                    <div class="row">

                                        <div class="table-wrap">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>Producto</th>

                                                        <th>Cantidad</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="dato in arreglo" :key="dato.presentation_id">
                                                        <td><b>{{ dato.name }}</b><br>{{ dato.presentation }}<br>
                                                            <small>{{ dato.category }}</small></td>
                                                        <td>
                                                            <input class="form-control" name="cantidad" type="number"
                                                                   v-validate="{  numeric: true, regex: /^[0-9]+$/, min_value: 1}"

                                                                   v-model="dato.value"
                                                            >
                                                        </td>
                                                        <td>
                                                            <input
                                                                :title="'Seleccionar ' + dato.name + ' ' + dato.presentation"
                                                                type="checkbox"
                                                                v-model="selected"
                                                                :value="dato.presentation_id"
                                                                @change="selectProduct(dato, $event)">
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import srSummary from "./service_request/sr_summary";

    export default {
        name: "list-material-services",
        props: ['service'],
        data() {
            return {
                sidebar: 'summary',
                urlProject: URL_PROJECT,
                urlController: '/stock/',
                url: '/service_request/list-materials/load/',
                list_requerimientos: [],
                arreglo: [],
                selected: [],
                search: '',
                name_service: '',
                typeProduct: 0,
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                request: [],
                offset: 3,
            }
        },
        components: {
            srSummary
        },
        computed: {
            isActived: function () {
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;

            },
            totalpirce: function () {
                return this.request.reduce((total, item) => {
                    return total + (parseInt(item.quantity) * parseInt(item.price));
                }, 0);
            }
        },
        methods: {
            changeSideBar(newSideBar) {
                if (newSideBar !== this.sidebar) {
                    this.sidebar = newSideBar;
                }
            },
            changePage(page, search, typeProduct) {
                let me = this;
                me.pagination.current_page = page;
                me.list(page, search, typeProduct);
            },
            /*redirectDasboard(page){
                var redirect = URL_PROJECT + '/' + page + '/dashboard/';
                window.open( redirect, '_blank' );
            },*/
            list(page, search, service) {
                let me = this;

                let url = me.url + service + '?page=' + page + '&search=' + search;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.list_requerimientos = respuesta.records.data;
                    me.name_service = respuesta.name_service;

                    //me.pagination= respuesta.pagination;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            listproduc(page, search, typeProduct) {
                let me = this;
                let type = (me.page === '27' ? '&stock=tool' : '');
                let url = me.urlController + '?page=' + page + '&search=' + search + '&typeproduct=' + typeProduct + type;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arreglo = respuesta.records.data;
                    me.pagination = respuesta.pagination;
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            selectProduct(data, event) {
                var resultado = this.request.find(row => row.id === data.presentation_id);
                if (event.target.checked) {
                    if (typeof (resultado) === 'undefined') {
                        this.request.push({
                            'id': data.presentation_id,
                            'name': data.name,
                            'presentation': data.presentation,
                            'category': data.category,
                            'unity': data.unity_id,
                            'unityName': data.unity,
                            'quantity': data.value,
                            'stock': parseInt(data.stock),
                            'price': data.price
                        });

                        console.log(this.request);
                        console.log(this.totalpirce);
                    }
                } else {
                    this.deleteChecked(data.presentation_id);
                }
            },
            deleteChecked(idRow) {
                let me = this;
                const clone = me.request;
                const filter = (data = [], id) => {
                    return clone.filter(c => c.id !== id);
                };
                me.request = filter(clone, idRow);
            },
            searchElementRequest(row, value) {
                return row.id === value;
            },
            deleteRequest(index) {
                var pres = this.request[index].id;
                var idxPress = this.selected.indexOf(pres);
                this.selected.splice(idxPress, 1);
                this.request.splice(index, 1);
            },
            generateRequest() {
                if (this.request.length > 0) {
                    this.$validator.validateAll().then((result) => {
                        if (result) {
                            let me = this;
                            axios.post('/service_request/list-materials/store/', {
                                'id_service': this.service,
                                'listmatariales': this.request,
                                'price_total': parseFloat(this.totalpirce)
                            }).then(function (response) {
                                me.request = [];
                                me.selected = [];
                                swal(
                                    'Exito! :)',
                                    'Se registro correctamente la solicitud de compra.',
                                    'success'
                                )
                            }).catch(function (error) {
                                swal(
                                    'Error! :(',
                                    'Ocurrio un error al intentar realizar la operación.',
                                    'error'
                                )
                            });
                        }
                    });
                } else {
                    swal(
                        'Error! :(',
                        'Debe seleccionar al menos un producto, para poder generar un requerimiento',
                        'error'
                    )
                }
            }
        },
        mounted() {
            this.list(1, this.search, this.service);
            this.listproduc(1, this.search, this.typeProduct);
        }
    }
</script>

<style scoped>

</style>
