<template>
    <div>
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Image Shapes</h5>
                    <p class="mb-25">Change the shape of an image using <code>.rounded</code> or <code>.circle</code> modifier classes. In addition use <code>.img-thumbnail</code> to give an image 1px border appearance.</p>
                    <div class="row">
                        <div class="col-sm">
                            <figure v-for="row in listData" :key="row.id" class="figure mb-15">
                                <img :img-src="row.image" class="figure-img w-200p mr-40 img-fluid rounded" :alt="row.image_admin">
                                <figcaption class="figure-caption">Left Aligned Caption</figcaption>
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
                var url= '/productGalery/' + me.relId;

                axios.get(url).then(function (response) {

                    var respuesta= response.data;

                    if( respuesta.galery.length > 0 ){
                        me.listData = respuesta.galery;
                    }

                }).catch(function (error) {
                    swal(
                        'Error! :(',
                        'No se pudo pudo mostrar la galería.',
                        'error'
                    )
                });
            }
        },
        mounted() {
            this.listGallery();
        }
    }
</script>