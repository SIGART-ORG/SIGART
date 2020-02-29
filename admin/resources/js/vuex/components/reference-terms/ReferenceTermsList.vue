<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Referencias</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input @keyup="list( 1 )" class="form-control mb-2" id="inlineFormInput" placeholder="Buscar..."
                                       type="text" v-model="search">
                            </div>
                            <div class="col-auto">
                                <button @click.prevent="list( 1 )" class="btn btn-primary mb-2" type="submit">
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
                                    <th>Solicitud de servicio</th>
                                    <th>Cotización</th>
                                    <th>Clientes</th>
                                    <th>Requerimientos</th>
                                    <th>Orden de servicio</th>
                                    <th>Documentos</th>
                                    <th>Adjuntos</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr :key="dato.id" v-for="dato in references">
                                    <td class="text-center">
                                        <strong v-text="dato.serviceRequest.document"></strong>
                                        <br>
                                        <span class="badge badge-info mb-10" v-text="dato.serviceRequest.name"></span>
                                        <br/>
                                        <small v-text="dato.serviceRequest.send"></small>
                                    </td>
                                    <td class="text-center">
                                        <strong v-text="dato.saleQuotation.document"></strong>
                                    </td>
                                    <td>
                                        <strong v-text="dato.customer.name"></strong>
                                        <br>
                                        <span class="badge badge-info" v-text="dato.customer.document"></span>
                                    </td>
                                    <td>
                                        <div class="mw-100">
                                            <strong>Administración:</strong>
                                            <br>
                                            <span
                                                :class="dato.classAprAdmSr">
                                                <i class="fa fa-check-circle"
                                                   v-if="dato.serviceRequirement.administration.type !== 'Desaprobado'"></i>
                                                <i class="fa fa-close" v-else></i>
                                            </span> {{ dato.serviceRequirement.administration.user }}
                                            <br/>
                                            <div class="mw-100 text-center mb-10"
                                                 v-if="dato.serviceRequirement.administration.id === 0 && dato.serviceRequirement.administration.show">
                                                <button @click.prevent="action( dato.id, 'approved', 'sr', 'adm' )"
                                                        class="btn btn-outline-success btn-xs">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button @click.prevent="action( dato.id, 'disapproved', 'sr', 'adm' )"
                                                        class="btn btn-outline-danger btn-xs">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mw-100">
                                            <strong>Dirección General:</strong>
                                            <br>
                                            <span
                                                :class="dato.classAprGDSr">
                                                <i class="fa fa-check-circle"
                                                   v-if="dato.serviceRequirement.generalDirection.type !== 'Desaprobado'"></i>
                                                <i class="fa fa-close" v-else></i>
                                            </span> {{ dato.serviceRequirement.generalDirection.user }}
                                            <br>
                                            <div class="mw-100 text-center"
                                                 v-if="dato.serviceRequirement.generalDirection.id === 0 && dato.serviceRequirement.generalDirection.show">
                                                <button @click.prevent="action( dato.id, 'approved', 'sr', 'gd' )"
                                                        :disabled="dato.disabledbtnAprovedSRAdm"
                                                        class="btn btn-outline-success btn-xs">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button @click.prevent="action( dato.id, 'disapproved', 'sr', 'gd' )"
                                                        :disabled="dato.disabledbtnAprovedSRAdm"
                                                        class="btn btn-outline-danger btn-xs">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mw-100">
                                            <strong>Dirección General:</strong>
                                            <br>
                                            <span
                                                :class="dato.classAprGDSo">
                                                <i class="fa fa-check-circle"
                                                   v-if="dato.serviceOrder.generalDirection.type !== 'Desaprobado'"></i>
                                                <i class="fa fa-close" v-else></i>
                                            </span> {{ dato.serviceOrder.generalDirection.user }}
                                            <br>
                                            <div class="mw-100 text-center"
                                                 v-if="dato.serviceOrder.generalDirection.id === 0 && dato.serviceOrder.generalDirection.show">
                                                <button @click.prevent="action( dato.id, 'approved', 'so', 'gd' )"
                                                        :disabled="dato.disabledbtnAprovedSO"
                                                        class="btn btn-outline-success btn-xs">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button @click.prevent="action( dato.id, 'disapproved', 'so', 'gd' )"
                                                        :disabled="dato.disabledbtnAprovedSO"
                                                        class="btn btn-outline-danger btn-xs">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mw-100">
                                            <strong>Cliente:</strong>
                                            <br>
                                            <span
                                                :class="dato.classAprCustomerSo">
                                                <i class="fa fa-check-circle"
                                                   v-if="dato.serviceOrder.customer.type !== 'Desaprobado'"></i>
                                                <i class="fa fa-close" v-else></i>
                                            </span> {{ dato.serviceOrder.customer.user }}
                                            <br v-if="dato.serviceOrder.customer.id > 0 && dato.serviceOrder.customer.isCustomerLogin"/>
                                            <span
                                                v-if="dato.serviceOrder.customer.id > 0 && dato.serviceOrder.customer.isCustomerLogin">Cliente Loggeado</span>
                                            <br>
                                            <div class="mw-100 text-center" v-if="dato.serviceOrder.customer.id === 0 && dato.serviceOrder.customer.show">
                                                <button @click.prevent="action( dato.id, 'approved', 'so', 'customer' )"
                                                        :disabled="dato.disabledbtnAprovedSOCutomer"
                                                        class="btn btn-outline-success btn-xs">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button @click.prevent="action( dato.customer.id, 'disapproved', 'so', 'customer' )"
                                                        :disabled="dato.disabledbtnAprovedSOCutomer"
                                                        class="btn btn-outline-danger btn-xs">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mw-100 mb-20">
                                            <a class="btn btn-xs btn-outline-danger" :href="dato.documents.pdfReferenceTerm" target="_blank">
                                                <i class="fa fa-file-pdf-o"></i>&nbsp;Término de Referencia
                                            </a>
                                        </div>
                                        <div class="mw-100 mb-20">
                                            <a v-if="dato.documents.pdfServiceRequirement !== ''" class="btn btn-xs btn-outline-danger" :href="dato.documents.pdfServiceRequirement" target="_blank">
                                                <i class="fa fa-file-pdf-o"></i>&nbsp;Req. Servicio
                                            </a>
                                        </div>
                                        <div class="mw-100 mb-20">
                                            <a v-if="dato.documents.pdfServiceOrder !== ''" class="btn btn-xs btn-outline-danger" :href="dato.documents.pdfServiceOrder" target="_blank">
                                                <i class="fa fa-file-pdf-o"></i>&nbsp;Orden de Servicio
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mw-100 mb-20">
                                            <button class="btn btn-xs btn-outline-info">
                                                <i class="fa fa-upload"></i>&nbsp;Req. Servicio
                                            </button>
                                        </div>
                                        <span>Orden de servicio</span>
                                        <div class="mw-100">
                                            <button class="btn btn-xs btn-outline-info">
                                                <i class="fa fa-upload"></i>&nbsp;Dirección General
                                            </button>
                                            <button class="btn btn-xs btn-outline-info">
                                                <i class="fa fa-upload"></i>&nbsp;Cliente
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-outline-primary"
                                                v-if="dato.serviceRequirement.administration.id > 0 && dato.serviceRequirement.administration.type === 'Aprobado'
                                                    && dato.serviceRequirement.generalDirection.id > 0 && dato.serviceRequirement.generalDirection.type === 'Aprobado'
                                                    && dato.serviceOrder.customer.id > 0 && dato.serviceOrder.customer.type === 'Aprobado'
                                                    && dato.serviceOrder.generalDirection.id > 0 && dato.serviceOrder.generalDirection.type === 'Aprobado'
                                                    && dato.service.id > 0 && dato.service.sendOrderPay === 0"
                                                @click.prevent="sendOrderPay( dato.service.id )"
                                        >
                                            <i class="fa fa-money"></i>&nbsp;Generar orden de pago
                                        </button>
                                        <span v-if="dato.service.id > 0 && dato.service.sendOrderPay === 1" class="badge badge-warning">Solicitud de orden de pago enviado</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "ReferenceTermsList",
        data() {
            return {
                search: ''
            }
        },
        methods: {
            list(page) {
                this.$store.dispatch('loadReferences');
            },
            action(id, action, type, typeAdm) {
                let me = this;
                this.$store.dispatch({
                    type: 'action',
                    data: {
                        id: id,
                        action: action,
                        type: type,
                        typeAdm: typeAdm
                    }
                }).then(response => {
                    let result = response.data;
                    if (result.status) {
                        me.list(1);
                    }
                }).catch(errors => {
                    console.log(errors);
                });
            },
            sendOrderPay( service ) {
                let me = this;
                me.$store.dispatch({
                    type: 'sendOrderPay',
                    data: {
                        service: service
                    }
                }).then( response => {
                    let result = response.data;
                    if( result.status ) {
                        me.list( 1 );
                    }
                }).catch( errors => {
                    console.log( errors );
                });
            },
        },
        watch: {
            references: {
                handler: function (newVal, oldval) {
                    this.references.forEach(p => {
                        let classAprAdmSr = 'text-secondary';
                        let classAprGDSr = 'text-secondary';
                        let classAprGDSo = 'text-secondary';
                        let classAprCustomerSo = 'text-secondary';
                        if (p.serviceRequirement.administration.type === 'Aprobado') {
                            classAprAdmSr = 'text-primary';
                        }
                        if (p.serviceRequirement.administration.type === 'Desaprobado') {
                            classAprAdmSr = 'text-danger';
                        }
                        if (p.serviceRequirement.generalDirection.type === 'Aprobado') {
                            classAprGDSr = 'text-primary';
                        }
                        if (p.serviceRequirement.generalDirection.type === 'Desaprobado') {
                            classAprGDSr = 'text-danger';
                        }
                        if (p.serviceOrder.generalDirection.type === 'Aprobado') {
                            classAprGDSo = 'text-primary';
                        }
                        if (p.serviceOrder.generalDirection.type === 'Desaprobado') {
                            classAprGDSo = 'text-danger';
                        }
                        if (p.serviceOrder.customer.type === 'Aprobado') {
                            classAprCustomerSo = 'text-primary';
                        }
                        if (p.serviceOrder.customer.type === 'Desaprobado') {
                            classAprCustomerSo = 'text-danger';
                        }
                        p.classAprAdmSr = classAprAdmSr;
                        p.classAprGDSr = classAprGDSr;
                        p.classAprGDSo = classAprGDSo;
                        p.classAprCustomerSo = classAprCustomerSo;

                        p.disabledbtnAprovedSRAdm= !( p.serviceRequirement.administration.type === 'Aprobado' );
                        p.disabledbtnAprovedSO= !( p.serviceRequirement.administration.type === 'Aprobado' && p.serviceRequirement.generalDirection.type === 'Aprobado' );
                        p.disabledbtnAprovedSOCutomer= ! ( p.serviceOrder.generalDirection.type === 'Aprobado' );
                    })
                }, deep: true
            }
        },
        computed: {
            references: {
                get: function () {
                    return this.$store.state.Referenceterm.referenceTerms;
                },
                set: function (newVal) {
                    this.$store.state.Referenceterm.referenceTerms = newVal;
                }
            },
        },
        created() {
            this.$store.dispatch('loadReferences');
        }
    }
</script>

<style scoped>

</style>
