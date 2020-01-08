<template>
    <div>
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Galería</h5>
                    <div class="row">
                        <div class="col-sm">
                            <figure v-for="row in listData" :key="row.id" class="figure mb-15">
                                <img :src="row.image" class="figure-img w-150p h-150p mr-20 img-fluid rounded" :alt="row.image_admin">
                                <figcaption class="figure-caption">
                                    <a class="text-danger" href="#" @click.prevent="deleteImage( row.id )">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </a>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Gallery',
        props: [
            'rel',
            'relId'
        ],
        data () {
            return {
                urlProject: URL_PROJECT,
                listData:   []
            }
        },
        methods: {
            listGallery() {
                var me = this;
                var url= '/gallery/' + me.relId + '/' + me.rel;

                axios.get( url ).then(function (response) {

                    var respuesta= response.data;

                    if( respuesta.gallery.length > 0 ){
                        me.listData = respuesta.gallery;
                    }

                }).catch(function (error) {
                    swal(
                        'Error! :(',
                        'No se pudo pudo mostrar la galería.',
                        'error'
                    )
                });
            },
            deleteImage( id ) {
                let me  = this,
                    url = '/gallery/' + id + '/delete';
                axios.put( url, {
                    rel: me.rel
                })
                    .then( function ( result ) {
                        let response = result.data;
                        if ( response.status ) {
                            me.listGallery();
                        }

                    }).catch( function ( error ) {

                });
            }
        },
        mounted() {
            this.listGallery();
        }
    }
</script>
