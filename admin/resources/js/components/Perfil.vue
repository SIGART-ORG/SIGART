<template>
    <div>
        <div class="row user">
            <div class="col-md-12">
                <div class="profile">
                    <div class="info"><img class="user-img" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/128.jpg">
                        <h4 v-text="name"></h4>
                        <p v-text="lastName"></p>
                    </div>
                    <div class="cover-image"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="tile p-0">
                    <ul class="nav flex-column nav-tabs user-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#user-timeline" data-toggle="tab">Biografía</a></li>
                        <li class="nav-item"><a class="nav-link" href="#user-settings" data-toggle="tab">Editar Perfil</a></li>
                        <li class="nav-item"><a class="nav-link" href="#user-change-password" data-toggle="tab">Cambiar Contraseña</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane active" id="user-timeline">
                        <div class="timeline-post">
                            <div class="post-media"><a href="#"><img src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg"></a>
                                <div class="content">
                                    <h5><a href="#" v-text="name+' '+lastName"></a></h5>
                                    <p class="text-muted"><small>2 January at 9:30</small></p>
                                </div>
                            </div>
                            <div class="post-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,	quis tion ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                            <ul class="post-utility">
                                <li class="likes"><a href="#"><i class="fa fa-fw fa-lg fa-thumbs-o-up"></i>Like</a></li>
                                <li class="shares"><a href="#"><i class="fa fa-fw fa-lg fa-share"></i>Share</a></li>
                                <li class="comments"><i class="fa fa-fw fa-lg fa-comment-o"></i> 5 Comments</li>
                            </ul>
                        </div>
                        <div class="timeline-post">
                            <div class="post-media"><a href="#"><img src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg"></a>
                                <div class="content">
                                    <h5><a href="#">John Doe</a></h5>
                                    <p class="text-muted"><small>2 January at 9:30</small></p>
                                </div>
                            </div>
                            <div class="post-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,	quis tion ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                            <ul class="post-utility">
                                <li class="likes"><a href="#"><i class="fa fa-fw fa-lg fa-thumbs-o-up"></i>Like</a></li>
                                <li class="shares"><a href="#"><i class="fa fa-fw fa-lg fa-share"></i>Share</a></li>
                                <li class="comments"><i class="fa fa-fw fa-lg fa-comment-o"></i> 5 Comments</li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="user-settings">
                        <div class="tile user-settings">
                            <h4 class="line-head">Editar Perfil</h4>
                            <form id="changeData" data-vv-scope="changeData">
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label>First Name</label>
                                        <input type="text" v-model="name" name="name" v-validate="'required'" class="form-control" placeholder="Introduzca su nombre" :class="{'is-invalid': errors.has('changeData.name')}">
                                        <span v-show="errors.has('changeData.name')" class="text-danger">{{ errors.first('changeData.name') }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Last Name</label>
                                        <input type="text" v-model="lastName" name="lastName" v-validate="'required'" class="form-control" placeholder="Introduzca sus apellidos" :class="{'is-invalid': errors.has('changeData.lastName')}">
                                        <span v-show="errors.has('changeData.lastName')" class="text-danger">{{ errors.first('changeData.lastName') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb-4">
                                        <label>Email</label>
                                        <input type="email" v-model="email" name="email" v-validate="{ required: true, email: true}" class="form-control" placeholder="Introduzca su correo" :class="{'is-invalid': errors.has('changeData.email')}">
                                        <span v-show="errors.has('changeData.email')" class="text-danger">{{ errors.first('changeData.email') }}</span>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-8 mb-4">
                                        <label>DNI</label>
                                        <input type="text" v-model="document" name="document" v-validate="{ required: true, regex: /^([0-9]+)$/, min:8, max:8 }" class="form-control" placeholder="Introduzca su DNI" :class="{'is-invalid': errors.has('changeData.document')}">
                                        <span v-show="errors.has('changeData.document')" class="text-danger">{{ errors.first('changeData.document') }}</span>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-8 mb-4">
                                        <label>Dirección</label>
                                        <input type="text" v-model="address" name="address" v-validate="'required'" class="form-control" placeholder="Introduzca su dirección" :class="{'is-invalid': errors.has('changeData.address')}">
                                        <span v-show="errors.has('changeData.address')" class="text-danger">{{ errors.first('changeData.address') }}</span>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-8 mb-4">
                                        <label>N° Celular</label>
                                        <input type="text" v-model="phone" name="phone" v-validate="{ required: true, regex: /^([0-9]+)$/}" class="form-control" placeholder="Introduzca su N° Celular" :class="{'is-invalid': errors.has('changeData.phone')}">
                                        <span v-show="errors.has('changeData.phone')" class="text-danger">{{ errors.first('changeData.phone') }}</span>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-8 mb-4">
                                        <label>Cumpleaños</label>
                                        <datepicker v-model="birthday" name="birthday" :config="options" :input-class="['form-control']" :input-placeholder="['Introduzca su fecha de cumpleaños']" v-validate="{ required: true, date_format:'YYYY-MM-DD'}" :class="{'is-invalid': errors.has('changeData.birthday')}"></datepicker>
                                        <span v-show="errors.has('changeData.birthday')" class="text-danger">{{ errors.first('changeData.birthday') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb-4">
                                        <label>Foto de perfil</label>
                                        <input type="file" name="profile" ref="profile" v-validate="'image|dimensions:940,788|size:2048'" class="form-control" :class="{'is-invalid': errors.has('changeData.profile')}" accept="image/jpeg, image/png, image/gif">
                                        <span v-show="errors.has('changeData.profile')" class="text-danger">{{ errors.first('changeData.profile') }}</span>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-8 mb-4">
                                        <label>Foto de Portada</label>
                                        <input type="file" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-10">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="button" @click.prevent="saveData">
                                            <i class="fa fa-fw fa-lg fa-check-circle"></i> Actualizar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="user-change-password">
                        <div class="tile user-settings">
                            <h4 class="line-head">Cambiar Contraseña</h4>
                            <form id="formChangePassword" data-vv-scope="formChangePassword">
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label>Nueva contraseña</label>
                                        <input type="password" v-model="password" name="password" v-validate="{ required: true, regex: /^([0-9]+)$/, min:8}" class="form-control" placeholder="Introduzca su nueva contraseña" :class="{'is-invalid': errors.has('formChangePassword.password')}" ref="password">
                                        <span v-show="errors.has('formChangePassword.password')" class="text-danger">{{ errors.first('formChangePassword.password') }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Repetir contraseña</label>
                                        <input v-validate="'required|confirmed:password'" class="form-control" name="againPassword" type="password" :class="{'is-danger': errors.has('formChangePassword.againPassword')}" placeholder="Confirmar contraseña" data-vv-as="password">
                                        <span v-show="errors.has('formChangePassword.againPassword')" class="text-danger">{{ errors.first('formChangePassword.againPassword') }}</span>
                                    </div>
                                </div>
                                <div class="row mb-10">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="button" @click.prevent="changePassword">
                                            <i class="fa fa-fw fa-lg fa-key"></i> Cambiar contraseña
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import datepicker from 'vue-bootstrap-datetimepicker';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';

    export default {
        name: "perfil",
        data(){
            return{
                url: '/profile',
                id: '',
                name: '',
                lastName: '',
                email: '',
                document: '',
                address: '',
                phone: '',
                birthday: '',
                password: '',
                againPassword: '',
                profile: '',
                coverPage: '',
                options: {
                    format: 'YYYY-MM-DD',
                    useCurrent: false,
                    showClear: true,
                    showClose: true,
                }
            }
        },
        components: {
            datepicker
        },
        methods: {
            loadData(){
                let me = this;
                var url = me.url + '/data';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.id = respuesta.id;
                    me.name = respuesta.name;
                    me.lastName = respuesta.last_name;
                    me.email = respuesta.email;
                    me.document = respuesta.document;
                    me.address = respuesta.address;
                    me.birthday = respuesta.birthday;
                    me.phone = respuesta.phone;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            saveData(){
                this.$validator.validateAll('changeData').then((result) => {
                    if (result) {
                        this.profile = this.$refs.profile.files[0];
                        let formData = new FormData();
                        formData.append('id', this.id);
                        formData.append('name', this.name);
                        formData.append('lastName', this.lastName);
                        formData.append('email', this.email);
                        formData.append('document', this.document);
                        formData.append('address', this.address);
                        formData.append('birthday', this.birthday);
                        formData.append('phone', this.phone);
                        formData.append('profile', this.profile);
                        axios.post( this.url + '/saveData',
                            formData,
                            {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            }
                        ).then(function(){
                            console.log('SUCCESS!!');
                        })
                            .catch(function(){
                                console.log('FAILURE!!');
                            });
                    }
                });
            },
            changePassword(){
                this.$validator.validateAll('formChangePassword').then((result) => {
                    if (result) {
                        console.log('cambio de contraseña');
                    }
                });
            }
        },
        mounted() {
            this.loadData();
        }
    }
</script>
