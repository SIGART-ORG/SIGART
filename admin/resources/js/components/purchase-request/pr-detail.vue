<template>
    <section class="hk-sec-wrapper">
        <h5 class="hk-sec-title">Solicitud de compra - Detalle</h5>
        <div class="row">
            <div class="col-sm">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" :class="navtab === 'req' ? 'active' : ''" href="#req" @click="changeTab( 'req' )">Requerimientos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" :class="navtab === 'solc' ? 'active' : ''" href="#solc" @click="changeTab( 'solc' )">Solic. Enviadas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" :class="navtab === 'regQu' ? 'active' : ''" href="#regQu" @click="changeTab( 'regQu' )">Reg. Cotización</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" :class="navtab === 'quo' ? 'active' : ''" href="#" @click="changeTab( 'quo' )">Cotizaciones</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12"><hr/></div>
        </div>
        <div class="row" v-if="navtab === 'req'">
            <div class="col-sm">
                <div class="tile">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-center">Item</th>
                                <th class="text-center">Categoría</th>
                                <th class="text-center" colspan="2">Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Unidad</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="arrReq.length > 0" v-for="( rReq, idxReq ) in arrReq" :key="rReq.id">
                                <td class="text-center">{{ idxReq + 1 }}</td>
                                <td class="text-center">{{ rReq.category }}</td>
                                <td class="text-center" colspan="2">{{ rReq.products }} {{ rReq.description }}</td>
                                <td class="text-right">{{ rReq.quantity }}</td>
                                <td class="text-center">{{ rReq.unity }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="navtab === 'solc'">
            <div class="col-sm">
                <form class="form-inline" id="quoteForm" data-vv-scope="quoteForm">
                    <div class="form-row align-items-center" style="min-width: 100%">
                        <div class="col-auto" style="max-width: 50%;min-width: 50%;">
                            <label class="sr-only" for="inlineProv">Name</label>
                            <select class="form-control mb-2" name="proveedor" v-model="formIdProv" id="inlineProv"
                                    style="width: 100%"
                                    v-validate="{ required: true }"
                                    :class="{'is-invalid': errors.has('quoteForm.proveedor')}"
                            >
                                <option value="0" disabled selected hidden >Proveedor</option>
                                <option v-for="pro in arrProviderCbo" v-bind:value="pro.id" v-text="pro.name" :key="pro.id"></option>
                            </select>
                            <span v-show="errors.has('quoteForm.proveedor')" class="text-danger">{{ errors.first('quoteForm.proveedor') }}</span>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary mb-2" @click="sendQuotation( $event )">
                                <i class="fa fa-plus"></i>&nbsp;Enviar Cotización
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row" v-if="navtab === 'solc'">
            <div class="col-sm">
                <div class="tile">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-center">Item</th>
                                <th class="text-center">Proveedor</th>
                                <th class="text-center">N° Doc.</th>
                                <th class="text-center">Fec. Envio</th>
                                <th class="text-center">Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="arrProviderSel.length > 0" v-for="( rProv, iProv) in arrProviderSel" :key="iProv">
                                <td v-text="iProv + 1"></td>
                                <td>
                                    {{ rProv.name }}<br>
                                    <small v-if="rProv.typePerson === 2">{{ rProv.businessName }}</small>
                                    <br v-if="rProv.typePerson === 2">
                                    <span v-if="rProv.status === 1" class="badge badge-success">Estado: Activo</span>
                                    <span v-if="rProv.status === 0" class="badge badge-warning">Estado: Desactivado</span>
                                    <span v-if="rProv.status === 2" class="badge badge-danger">Estado: Dado de baja</span>
                                </td>
                                <td>{{ rProv.document}}</td>
                                <td>{{ rProv.reg}}</td>
                                <td>
                                    <span v-if="rProv.statusReq === 1" class="badge badge-info">Enviado</span>
                                    <span v-if="rProv.statusReq === 0" class="badge badge-warning">Cancelado</span>
                                    <span v-if="rProv.statusReq === 2" class="badge badge-danger">Eliminado</span>
                                    <span v-if="rProv.statusReq === 3" class="badge badge-success">Cotizado</span>
                                    <span v-if="rProv.statusReq === 4" class="badge badge-success">Seleccionado</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <QuotationReg v-if="navtab === 'regQu'" :pr="pr"></QuotationReg>
        <div class="row" v-if="navtab === 'quo'">
            <div class="col-sm">
                <form class="form-inline" id="quoteSelect" data-vv-scope="quoteSelect">
                    <div class="form-row align-items-center" style="min-width: 100%">
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary mb-2" @click="selectQuote( $event )">
                                <i class="fa fa-cubes"></i>&nbsp;Seleccionar Cotización
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row" v-if="navtab === 'quo'">
            <div class="col-sm">
                <div class="tile">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr v-for="( row, idx ) in contentQuote" :key="row.id">
                                <template v-if="idx == 0">
                                    <th class="sorting_1" colspan="2">{{ row.product }}</th>
                                    <th>{{ row.quantity }}</th>
                                    <th v-for="det in row.quotation" :key="det.id">
                                        <a href="#" :title="det.pvname">{{ det.pvCode }}</a>
                                    </th>
                                </template>
                                <template v-else>
                                    <td class="sorting_1">
                                        <div class="input-group input-group-sm w-100p">
                                            <input type="checkbox" v-model="row.checkedProduct" class="form-control" style="flex: unset" :checked="true">
                                        </div>
                                    </td>
                                    <td class="font-weight-bold sorting_1" :class="row.checkedProduct ? 'text-success' : 'text-danger'">{{ row.name }}</td>
                                    <td>
                                        <input v-model="row.quantity" class="form-control form-control-sm"/>
                                        <label>{{ row.unity}}</label>
                                    </td>
                                    <td v-for="detBody in row.quotation" :key="detBody.id"
                                        :class="( row.lowerPrice > 0 && row.lowerPrice == detBody.priceUnit ) ? 'bg-success text-white' : ''" >
                                        <div class="input-group input-group-sm w-100p">
                                            <input type="checkbox" v-model="detBody.selected" class="form-control form-check-label"
                                                   style="flex: unset"
                                                   :id="'checkbox-' + detBody.id" :disabled="!detBody.isDisabled">
                                            <label class="form-check-label" :for="'checkbox-' + detBody.id" :class="!detBody.isDisabled ? 'text-danger' : '' ">
                                                {{ detBody.priceUnit }}
                                            </label>
                                        </div>
                                    </td>
                                </template>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import QuotationReg from '../quotation/register';
    export default {
        name: "pr-detail",
        data() {
            return {
                navtab:         'req',
                arrReq:         [],
                arrProvider:    [],
                arrProviderSel: [],
                arrProviderCbo: [],
                formIdProv:     0,
                contentQuote:   []
            }
        },
        components: {
            QuotationReg
        },
        props: [
            'pr'
        ],
        methods: {
            list() {
                let me = this,
                    url = '/purchase-request/details/' + this.pr + '/data/';

                axios.get( url ).then( function ( response ) {
                    let result  = response.data;
                    me.arrReq   = result.reqDetails;
                    me.arrProviderSel   = result.providers;

                }).catch( function ( errors ) {
                    console.log( errors );
                });
            },
            loadProvider() {
                if( this.arrProvider.length === 0 ) {
                    let me = this;
                    var url = '/get-providers/';
                    axios.get(url).then(function (response) {
                        var respuesta = response.data;
                        me.arrProvider = respuesta.response;
                    }).catch(function (error) {
                        swal(
                            'Error! :(',
                            'Ocurrio un error al intentar traer los datos.',
                            'error'
                        )
                    });
                }
            },
            changeTab( tab ) {
                this.navtab = tab;
                switch( tab ) {
                    case 'solc':
                        this.list();
                        this.providerCbo();
                        break;
                    case 'quo':
                        this.selectedQuotes();
                        break;
                }
            },
            sendQuotation( e ) {
                e.preventDefault();
                this.$validator.validateAll('quoteForm').then((result) => {
                    if (result) {
                        let me = this,
                            dataQuote =  {
                                'idPR': me.pr,
                                'idProvider':   me.formIdProv
                            };
                        axios.post('/quotation',{
                            'quotation': dataQuote
                        }).then(function (response) {
                            let result = response.data;
                            if( result.status ) {
                                me.refresh();
                            }
                        }).catch(function (error) {
                            console.log(error);
                        });
                    }
                });
            },
            providerCbo() {
                let me = this,
                    arrProv = me.arrProvider,
                    arrProvCbo = [];

                arrProv.map( function( e ) {
                    if( ! me.existProvider( e.id ) ) {
                        arrProvCbo.push({
                            id: e.id,
                            name: e.name
                        });
                    }
                });

                if( arrProvCbo.length > 0 ) {
                    me.arrProviderCbo = arrProvCbo.filter( (valor, indiceActual, arreglo) => arreglo.indexOf(valor) === indiceActual );
                } else {
                    me.arrProviderCbo = arrProvCbo;
                }
            },
            existProvider( id ) {
                let response = false;
                for( var i = 0; i < this.arrProviderSel.length; i++ ) {
                    if( id === this.arrProviderSel[i].id ) {
                        response = true;
                        break;
                    }
                }
                return response;
            },
            refresh(){
                let me = this;
                this.arrProviderCbo = [];
                this.arrReq         = [];
                this.arrProviderSel = [];
                this.formIdProv     = 0;
                this.list();
                setTimeout( function() { me.providerCbo(); }, 1500);
            },
            selectedQuotes(){
                let me = this,
                    url = '/purchase-request/' + me.pr + '/quote/';
                axios.get( url ).then( function( output ) {
                    var response   = output.data;
                    if( response.status ){
                        // me.modalTitle = 'Cotizaciones - ' + response.code;
                        me.contentQuote = response.content;
                    }
                }).catch( function( error ) {
                    console.log( error )
                });
            },
            selectQuote( e ) {
                e.preventDefault();
                let me = this,
                    url     = '/quotation/select/';
                axios.post( url, {
                    'pr': me.pr,
                    'arData': me.contentQuote
                }).then( function( result ) {
                    let response = result.data;
                }).catch( function( errors ) {
                    console.log( errors );
                });
            }
        },
        mounted() {
            this.loadProvider();
            this.list();
        }
    }
</script>

<style scoped>

</style>
