<template>
    <main class="main">
        <div class="container">
            <!-- Encabezado -->
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">Perfil de usuario <small>Editando datos</small></h1>
                </div>
            </div>
            <!-- Fin de Encabezado -->
            <div class="row">
                <div class="col-md-3">
                    <div class="col-md-12" align="center">
                        <img src="dist/img/avatars/6.jpg" class="img-responsive img-portafolio img-hover">
                    </div>
                    <div class="col-md-12">
                        <p class="text-center"><strong>Julio Salsavilca</strong></p>
                        <p class="text-center"><em>ROOT</em></p>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <ul class="list-group list-primary">
                            <a href="#" class="list-group-item" @click="section = 'profile'">Editar Perfil</a>
                            <a href="#" class="list-group-item" @click="section = 'social'">Cambiar foto de Perfil</a>
                            <a href="#" class="list-group-item">Sedes</a>
                        </ul>
                    </div>
                </div>
                <!-- Parte central -->
                <div class="col-md-9">
                    <div class="col-md-12" style="border-width: 1px 1px 0px 1px; border-style: solid; border-color: lightgrey;">
                        <h3 style="text-align: center">Mi perfil <p><small>Añade información personal para compartir tu perfil</small></p></h3>
                    </div>
                    <!-- Se inicia el form (ojo todos los elementos de formulario deben ir dentro de esta etiqueta-->
                    <form name="modifyProfile" id="profileForm" novalidate>
                        <!-- Inicio del div central parte de formulario información básica -->
                        <div class="col-md-12 section-profile" v-bind:class="[section == 'profile' ? 'show-section' : 'hide-section']">
                            <div class="col-md-8 col-md-offset-2">

                                <div class="control-group form-group">
                                    <div class="controls">
                                        <br >
                                        <label>Información básica</label>
                                        <span id="alertName" data-toggle="popover" data-trigger="hover" data-placement="right" title="" data-content="">
    	                            	<input type="text" v-model="name" class="form-control" id="txtName" placeholder="Introduzca su nombre" required data-validation-required-message="Por favor introduzca su nomnbre.">
    	                            </span>
                                        <br >
                                        <span id="alertSurname" data-toggle="popover" data-trigger="hover" data-placement="right" title="" data-content="">
    	                            	<input type="text" class="form-control" id="txtSurname" placeholder="Introduzca sus apellidos" required data-validation-required-message="Por favor introduzca sus apellidos.">
    	                            </span>
                                        <br >
                                        <span id="alertQualification" data-toggle="popover" data-trigger="hover" data-placement="right" title="" data-content="">
    	                            	<input type="text" class="form-control" id="txtQualification" placeholder="Introduzca su título" required data-validation-required-message="Por favor introduzca su título.">
    	                            </span>
                                        <br >
                                        <span id="alertEmail" data-toggle="popover" data-trigger="hover" data-placement="right" title="" data-content="">
    	                            	<input type="email" class="form-control" id="txtEmail" placeholder="Introduzca su email" required data-validation-required-message="Por favor introduzca su email.">
    	                            </span>
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="control-group form-group">
                                    <div class="controls">
                                        <label>Biografía:</label>
                                        <span id="alertBiography" data-toggle="popover" data-trigger="hover" data-placement="auto" title="" data-content="">
    		                            <textarea rows="6" cols="30" class="form-control" id="txtBiography" required maxlength="999" style="resize:none"
                                                  data-validation-required-message="Por favor introduzca su biografía deseada."></textarea>
    		                        </span>
                                        <br >
                                        <span id="alertSelectLanguage" data-toggle="popover" data-trigger="hover" data-placement="auto" title="" data-content="">
    		                            <select class="form-control" id="selectLanguage" title="Seleccione su idioma">
    		                            	<option class="bs-title-option" value="" disabled selected>Elija un idioma</option>
    		                            	<option>Alemán</option>
    		                            	<option>Castellano</option>
    		                            	<option>Catalán</option>
		                            	   	<option>Francés</option>
    		                            	<option>Inglés</option>
    		                            	<option>Portugués</option>
    		                            </select>
    		                        </span>
                                        <br >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin del div central parte de formulario información básica -->

                        <!-- Parte central - enlaces -->
                        <div class="col-md-12 section-profile" v-bind:class="[section == 'social' ? 'show-section' : 'hide-section']">
                            <!-- Parte de redes sociales en el alta de perfil -->
                            <div class="col-md-8 col-md-offset-2">
                                <div class="control-group form-group">
                                    <div class="controls">
                                        <br >
                                        <label>Enlaces:</label>
                                        <input type="text" class="form-control" id="txtMyWeb" placeholder="Introduzca su web personal o profesional">
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">https://plus.google.com</span><input type="text" class="form-control" id="txtPlus" placeholder="Introduzca su usuario de Google+">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">http://twitter.com</span><input type="text" class="form-control" id="txtTwitter" placeholder="Introduzca su usuario de Twitter">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">https://www.facebook.com</span><input type="text" class="form-control" id="txtFacebook" placeholder="Introduzca su usuario de Facebook">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon">https://www.linkedin.com</span><input type="text" class="form-control" id="txtLinkedin" placeholder="Introduzca su usuario de Linkedin">
                                        </div>
                                        <br >
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Parte de redes sociales en el alta de perfil -->

                            <!-- Botones formulario -->
                            <div class="col-md-12 container allFormButtons">
                                <br >
                                <div class="col-md-2 col-md-offset-2">
                                    <div class="form-group">
                                        <button type="button" id="btnCancel" class="btn btn-danger">Cancelar</button>
                                    </div>
                                </div>
                                <div class="col-md-5 col-md-offset-3">
                                    <div class="form-group">
                                        <button type="button" id="btnClean" class="btn btn-warning">Limpiar</button>
                                        <button type="submit" id="btnEnviar" class="btn btn-primary">Actualizar</button>
                                    </div>
                                </div>
                                &nbsp;
                            </div>
                            <!-- Fin botones formulario -->
                        </div>
                        <!-- Fin Parte central - enlaces -->
                    </form>
                    <!-- Fin del form -->
                </div>
                <!-- Fin del div de parte central -->
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        name: "perfil",
        data(){
            return{
                url: '/profile',
                id: '',
                name: '',
                lastname: '',
                section: 'profile'
            }
        },
        methods: {
            loadData(){
                let me = this;
                var url = me.url + '/data';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.name = respuesta.name;
                    me.lastname = respuesta.last_name;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.loadData();
        }
    }
</script>

<style scoped>
    .section-profile{
        border-width: 1px 1px 0px 1px;
        border-style: solid;
        border-color: lightgrey;
        background: #f1f3f6;
    }

    .img-portfolio {
        border-radius: 5%;
        margin-bottom: 30px;
        border: 1px solid lightgrey !important;
        height: 250px;
        width: auto;
    }

    .img-hover:hover {
        opacity: 0.7;
        box-shadow: 2px 6px 25px 0px rgba(0,0,0,0.75);
    }

    .hide-section{
        display: none;
    }

    .show-section{
        display: block;
    }
</style>