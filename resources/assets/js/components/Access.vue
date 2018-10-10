<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item"><a href="#" @click.prevent="update_side_bar(3)">Roles</a></li>
            <li class="breadcrumb-item active" v-text="'Accesos - '+role_name"></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Módulos del sistema -
                            <small v-text="role_name"></small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="list-group" id="list-tab" role="tablist">
                                        <template v-for="dato in arreglo">
                                            <a :key="dato.id" class="list-group-item list-group-item-action" :class="{'active': minimo==dato.id}" v-bind="{ id: 'list-'+dato.id+'-list', 'aria-controls': 'list-'+dato.id, 'href': '#list-'+dato.id }" data-toggle="tab" role="tab">
                                                <i class="fa-lg fa" :class="[dato.icon]"></i> {{dato.name}}
                                            </a>
                                        </template>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="tab-content" id="nav-tabContent">
                                        <template v-for="(mod, index) in arregloCompleto">
                                            <div :key="mod.module" class="tab-pane fade" :class="{'active show': minimo==index}" v-bind="{id: 'list-'+index, 'aria-labelledby': 'list-'+index+'-list'}" role="tabpanel">
                                                <div v-for="page in mod.pages" :key="page.id" class="alert" :class="[{'alert-success': page.access > 0}, {'alert-secondary': page.access == null}]" role="alert" v-text="page.name" @click="permiso(page.id)"></div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
    </main>
</template>
<script>

export default {
    name: 'access-adm',
    data(){
        return{
            id: this.$parent.role_filter,
            arreglo: [],
            arregloCompleto: [],
            minimo: 0,
            role_name: '',
            modal: 0,
            tipoAccion: 0
        }
    },
    methods:{
        update_side_bar(idSideBar, datos = {}){
            this.$emit('update_side_bar', idSideBar, datos);
        },
        permiso(page){
            let me = this;
            axios.post('/access',{
                'role_id': this.id,
                'page_id': page
            }).then(function (response) {
                me.listar();
            }).catch(function (error) {
                console.log(error);
            });
        },
        listar(){
            var me = this;
            var url= '/access?role_id='+this.id;
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arreglo = respuesta.datos;
                me.arregloCompleto = respuesta.pages;
                me.minimo = respuesta.minimo;

            })
            .catch(function (error) {
                console.log(error);
            });
        },
        getRole(){
            var me = this;
            var url= '/role/show?id='+this.id;
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.role_name = respuesta.name;
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    },
    mounted() {
        this.listar();
        this.getRole();
    }
}
</script>