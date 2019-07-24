<template>
    <div class="container">
        <div class="col-12">
            <div class="large-12 medium-12 small-12 filezone">
                <input type="file" id="files" ref="files" multiple v-on:change="handleFiles()" accept="image/png, image/jpeg, image/gif"/>
                <p>
                    Deja tus archivos aquí <br>o haz clic para buscar.
                </p>
            </div>
        </div>
        <div class="row" v-if="files.length > 0">
            <div class="col-sm-12 text-center">
                <a href="#" class="btn btn-success" v-on:click="submitFiles()" v-show="files.length > 0">
                    <i class="fa fa-upload"></i> Cargar Imagnes
                </a>
                <a href="#" class="btn btn-danger" @click.prevent="clearFiles" v-show="files.length > 0">
                    <i class="fa fa-trash-o"></i> Limpiar Lista</a>
            </div>
        </div>
        <div class="row" v-if="files.length > 0">
            <div class="col-12">
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th>Archivo</th>
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(file, key) in files">
                                <td>{{ key + 1 }}</td>
                                <td><img class="w-80p" v-bind:ref="'preview'+parseInt(key)" alt="icon" /></td>
                                <th scope="row">
                                    {{ file.name }}
                                    <div class="alert alert-success alert-dismissible" role="alert" v-if="file.id > 0">
                                        Imagen subida.
                                    </div>
                                    <div class="alert alert-dark alert-dismissible" role="alert" v-if="file.locked == 1">
                                        Este tipo de archivos <strong>no están permitidos</strong>.
                                    </div>
                                </th>
                                <td>
                                    <a href="#" class="btn btn-danger btn-sm" v-if="! file.id" v-on:click="removeFile(key)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="files.length > 0">
            <div class="col-sm-12 text-center">
                <a href="#" class="btn btn-success" v-on:click="submitFiles()" v-show="files.length > 0">
                    <i class="fa fa-upload"></i> Cargar Imagnes
                </a>
                <a href="#" class="btn btn-danger" @click.prevent="clearFiles" v-show="files.length > 0">
                    <i class="fa fa-trash-o"></i> Limpiar Lista</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UploadImages",
        props: [
            'product',
            'post_url'
        ],
        data() {
            return {
                files: []
            }
        },
        methods: {
            clearFiles() {
                this.files = [];
                console.log( 'ffff' );
            },
            handleFiles() {
                let uploadedFiles = this.$refs.files.files;

                for(var i = 0; i < uploadedFiles.length; i++) {
                    this.files.push(uploadedFiles[i]);
                }
                this.getImagePreviews();
            },
            getImagePreviews(){
                for( let i = 0; i < this.files.length; i++ ){
                    if ( /\.(jpe?g|png|gif)$/i.test( this.files[i].name ) ) {
                        let reader = new FileReader();
                        reader.addEventListener("load", function(){
                            this.$refs['preview'+parseInt(i)][0].src = reader.result;
                        }.bind(this), false);
                        this.files[parseInt(i)].locked = 0;
                        reader.readAsDataURL( this.files[i] );
                    }else{
                        this.$nextTick(function(){
                            this.$refs['preview'+parseInt(i)][0].src = '/images/generic.png';
                        });
                        this.files[parseInt(i)].locked = 1;
                    }
                    console.log( this.files );
                }
            },
            removeFile( key ){
                this.files.splice( key, 1 );
                this.getImagePreviews();
            },
            submitFiles() {
                for( let i = 0; i < this.files.length; i++ ){
                    if(this.files[i].id) {
                        continue;
                    }
                    let formData = new FormData();
                    formData.append('relId', this.product);
                    formData.append('rel', this.post_url);
                    formData.append('file', this.files[i]);

                    axios.post('/uploadFile',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function(data) {
                        this.files[i].id = data['data']['id'];
                        this.files.splice(i, 1, this.files[i]);
                        console.log('success');
                    }.bind(this)).catch(function(data) {
                        console.log('error');
                    });
                }
            }
        },
        beforeCreate () {
            console.log('1 - beforeCreate')
        },
        created () {
            console.log('2 - created')
        },
        beforeMount () {
            console.log('3 - beforeMount')
        },
        mounted () {
            console.log('4 - mounted');
            this.clearFiles();
        },
        beforeUpdate () {
            console.log('5 - beforeUpdate')
        },
        updated () {
            console.log('6 - updated')
        },
        beforeDestroy () {
            console.log('7 - beforeDestroy')
        },
        destroyed () {
            console.log('8 - destroyed')
        }
    }
</script>

<style scoped>
    input[type="file"]{
        opacity: 0;
        width: 100%;
        height: 200px;
        position: absolute;
        cursor: pointer;
    }
    .filezone {
        outline: 2px dashed grey;
        outline-offset: -10px;
        background: #ccc;
        color: dimgray;
        padding: 10px 10px;
        min-height: 200px;
        position: relative;
        cursor: pointer;
    }
    .filezone:hover {
        background: #c0c0c0;
    }

    .filezone p {
        font-size: 1.2em;
        text-align: center;
        padding: 50px 50px 50px 50px;
    }
    div.file-listing img{
        max-width: 90%;
    }

    div.file-listing{
        margin: auto;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    div.file-listing img{
        height: 100px;
    }
    div.success-container{
        text-align: center;
        color: green;
    }

    div.remove-container{
        text-align: center;
    }

    div.remove-container a{
        color: red;
        cursor: pointer;
    }

    a.submit-button{
        display: block;
        margin: auto;
        text-align: center;
        width: 200px;
        padding: 10px;
        text-transform: uppercase;
        background-color: #CCC;
        color: white;
        font-weight: bold;
        margin-top: 20px;
    }
</style>