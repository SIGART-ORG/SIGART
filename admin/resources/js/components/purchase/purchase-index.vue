<template>
    <div>
        <section class="hk-sec-wrapper">
            <h5 class="hk-sec-title">Compras</h5>
            <div class="row">
                <div class="col-sm">
                    <form class="form-inline">
                        <div class="form-row align-items-left">
                            <div class="col-auto">
                                <label class="sr-only" for="searchForm"></label>
                                <input type="text" id="searchForm" class="form-control mb-2" placeholder="Buscar"
                                       v-model="search" @keyup="list( 1, search )">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2" @click.prevent="list( 1, search )">
                                    <i class="fa fa-fw fa-lg fa-search"></i> Buscar
                                </button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success mb-2"
                                        @click.prevent="redirectPage( 'new' )">
                                    <i class="fa fa-fw fa-lg fa-plus"></i> Registrar compra
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
                                    <th>Opciones</th>
                                    <th>Comprobante</th>
                                    <th>Proveedor</th>
                                    <th>Total</th>
                                    <th>Adjunto</th>
                                    <th>Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="( row, idx ) in arrData" :key="row.id">
                                    <td v-text="idx + 1"></td>
                                    <td>
                                        <button class="btn btn-outline-info btn-sm" title="Completar información"
                                                type="button"
                                                v-if="row.status === 1"
                                                @click="completeInfo( row.id )"
                                        >
                                            <i class="fa fa-file-archive-o"></i> Completar inf.
                                        </button>
                                        <button v-if="row.status === 3" type="button"
                                                class="btn btn-outline-success btn-sm"
                                                title="Pagar Compra"
                                                @click="pay( row.id )"
                                        >
                                            <i class="fa fa-fw fa-lg fa-google-wallet"></i> Pagar Compra
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                                title="Detalle - Compra">
                                            <i class="fa fa-fw fa-lg fa-search"></i> Detalle
                                        </button>
                                        <button v-if="row.status === 1" type="button"
                                                class="btn btn-outline-danger btn-sm" title="Cancelar Compra">
                                            <i class="fa fa-fw fa-lg fa-close"></i> Cancelar
                                        </button>
                                        <button v-if="row.status !== 2" type="button"
                                                class="btn btn-outline-info btn-sm" title="Generar PDF"
                                                @click.prevent="generatePDF( row.id )"
                                        >
                                            <i class="fa fa-fw fa-lg fa-file-pdf-o"></i> Generar PDF
                                        </button>
                                        <a v-if="row.status !== 2 && row.pdf"
                                           :href="asset + '/' + row.pdf" target="_blank"
                                           class="btn btn-outline-danger btn-sm" title="Ver PDF">
                                            <i class="fa fa-fw fa-lg fa-file-pdf-o"></i> PDF
                                        </a>
                                    </td>
                                    <td>
                                        {{ row.typeVouchersName }}<br/>
                                        {{ row.serial_doc }}-{{ row.number_doc }}
                                    </td>
                                    <td>
                                        {{ row.providerName }}
                                        <span
                                            class="badge badge-secondary">{{ row.typeDocuments }}: {{ row.document }}</span>
                                    </td>
                                    <td>{{ row.total }}</td>
                                    <td>
                                        <a v-if="row.attach" :href="urlImage + row.attach" target="_blank"
                                           :title="row.typeVouchersName + ': ' + row.serial_doc + '-' + row.number_doc">
                                            <img class="w-100p" :src="urlImage + row.attach" :alt="row.typeVouchersName + ': ' + row.serial_doc + '-' + row.number_doc"/>
                                        </a>
                                        <br/>
                                        <button class="btn btn-outline-success btn-sm" title="Adjuntar comprobante"
                                                v-if="row.status !== 1" @click="openModalGalery( row )"
                                        >
                                            <i class="fa fa-upload"></i> Adjuntar
                                        </button>
                                    </td>
                                    <td>
                                        <span v-if="row.status === 0" class="badge badge-warning"><i
                                            class="fa fa-ban"></i>Desactivado</span>
                                        <span v-if="row.status === 1" class="badge badge-info"><i
                                            class="fa fa-shopping-bag fa-fw"></i>Falta inf.</span>
                                        <span v-if="row.status === 2" class="badge badge-danger"><i
                                            class="fa fa-close fa-fw"></i>Anulado</span>
                                        <span v-if="row.status === 3" class="badge badge-success"><i
                                            class="fa fa-check-circle fa-fw"></i>Inf. Completa</span>
                                        <span v-if="row.status === 4" class="badge badge-primary"><i
                                            class="fa fa-money fa-fw"></i>Pagado</span>
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
                                <a class="page-link" href="#"
                                   @click.prevent="changePage(pagination.current_page-1, search)">Ant.</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page"
                                :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="changePage(page, search)"
                                   v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#"
                                   @click.prevent="changePage(pagination.current_page+1, search)">Sig.</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
        <b-modal id="modalUpload" size="lg" ref="modalUpload" :title="form.voucher" @ok="uploadVoucher" @cancel="cancelUpload">
            <form @submit.stop.prevent="cancelUpload">
                <div class="row" v-if="form.attachCurrent !== ''">
                    <div class="col-md-12">
                        <p class="font-italic text-info">
                            <i class="fa fa-info"></i> Sí en caso ya tenga un comprobante asociado a esta compra, la imagen
                            que suba reemplazará a la existente.
                        </p>
                    </div>
                </div>
                <div class="form-group row" v-if="form.attachCurrent !== ''">
                    <div class="col-sm-12 text-center">
                        <a :href="urlImage + form.attachCurrent" target="_blank" :title="form.voucher">
                            <img class="w-150p" :src="urlImage + form.attachCurrent" :alt="form.voucher"/>
                        </a>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Comprobante <span class="text-danger">(*)</span></label>
                    <div class="col-md-9">
                        <input type="file" class="form-control-file" @change="changeFile( $event )"
                               name="comprobante"
                               v-validate="'required|image'" accept="image/jpeg, image/jpg, image/png"
                        >
                        <span v-show="errors.has('comprobante')" class="text-danger">{{ errors.first('comprobante') }}</span>
                    </div>
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
    const typePermits     = [
        'image/gif',
        'image/jpeg',
        'image/jpg',
        'image/png'
    ];

    export default {
        name: "purchase-index",
        data() {
            return {
                urlProject: URL_PROJECT,
                urlImage: URL_PROJECT + '/uploads/purchases/',
                search: '',
                arrData: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                form: {
                    id: 0,
                    voucher: '',
                    attach: '',
                    attachCurrent: ''
                },
                asset: URL_PROJECT + '/pdf/purchases/'
            }
        },
        computed: {
            isActived: function () {
                return this.pagination.current_page;
            },
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

            }
        },
        methods: {
            changePage(page, search) {
                let me = this;
                me.pagination.current_page = page;
                me.list(page, search);
            },
            list(page, search) {
                let me = this,
                    url = '/purchases/';

                axios.get(url, {
                    params: {
                        page: page,
                        search: search
                    }
                }).then(function (result) {
                    let response = result.data;
                    me.arrData = response.records.data;
                    me.pagination = response.pagination;
                }).catch(function (errors) {
                    console.log(errors);
                });
            },
            completeInfo(id) {

                let url = this.urlProject + '/purchases/' + id + '/complete-inf';
                document.location.href = url;

            },
            pay(id) {
                let me = this,
                    url = '/purchases/' + id + '/pay';
                axios.put(url).then(function (result) {
                    let response = result.data;
                    if (response.status) {
                        me.list(1, me.search);
                        swal(
                            'Pagado!',
                            'La operación se realizó correctamente.',
                            'success'
                        );
                    } else {
                        swal(
                            'Error! :(',
                            'No se pudo realizar la operación',
                            'error'
                        );
                    }
                }).catch(function (errors) {
                    swal(
                        'Error! :(',
                        'No se pudo realizar la operación',
                        'error'
                    );
                });
            },
            openModalGalery( data ) {
                let me = this;
                me.form.id = data.id;
                me.form.voucher = data.typeVouchersName + ': ' + data.serial_doc + '-' + data.number_doc;
                me.form.attach = '';
                if( data.attach ) {
                    me.form.attachCurrent = data.attach;
                }
                this.$refs.modalUpload.show();
            },
            uploadVoucher( event ) {
                event.preventDefault();
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let me = this;
                        let url = '/purchases/' + me.form.id + '/upload/';
                        let formData = new FormData();
                        formData.append('fileVoucher', me.form.attach );

                        axios.post( url, formData ).then(function ( response ) {
                            let resp = response.data;
                            me.cancelUpload();
                            if( resp.status ) {
                                me.list(1, me.search );
                            } else {
                                swal(
                                    'Error! :(',
                                    'No se pudo subir el comprobante.',
                                    'error'
                                );
                            }
                        }).catch(function (error) {
                            console.log(error);
                            swal(
                                'Error! :(',
                                'No se pudo realizar la operación.',
                                'error'
                            );
                        });
                    }
                });
            },
            cancelUpload() {
                let me = this;
                me.form.id = 0;
                me.form.voucher = '';
                me.form.attach = '';
                me.form.attachCurrent = '';
                this.$refs.modalUpload.hide();
            },
            changeFile( event ) {
                let fileName        = event.target.files[0];
                if( typePermits.includes( fileName.type ) ){
                    this.form.attach = fileName;
                }
            },
            generatePDF( id ) {
                let me = this;
                let url = '/purchases/' + id + '/generatePDF/';
                axios.get( url ).then( function( response ) {
                    let result = response.data;
                    if( result.status ) {
                        me.list( 1, me.search );
                    }
                }).catch( function ( errors ) {
                    console.log( errors );
                });
            }
        },
        mounted() {
            this.list(1, '');
        }
    }
</script>

<style scoped>

</style>
