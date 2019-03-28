
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import VeeValidate from 'vee-validate';
import BootstrapVue from 'bootstrap-vue';

const VueValidationEs = require('vee-validate/dist/locale/es');
Vue.use(VeeValidate, {
    locale: 'es',
    dictionary: {
        es: VueValidationEs
    }
});
Vue.config.productionTip = false;
Vue.use(BootstrapVue);

import swal from 'sweetalert';

import roles from './components/Roles.vue';
import users from './components/Users.vue';
import modules from './components/Modules.vue';
import pages from './components/Pages.vue';
// import access from './components/Access.vue';
 import icons from './components/Icons.vue';
 import categories from './components/Categories.vue';
 import holidays from './components/Holidays.vue';
// import calendar from './components/Calendar.vue';
import sites from './components/Sites.vue';
// import unity from './components/Unity.vue';
import log from './components/Log.vue';
import perfil from './components/Perfil.vue';
import dashboard from './components/Dashboard.vue';

const app = new Vue({
    el: '#app',
    data: {
        menu: 0,
        modulo_filter: 0,
        page_filter: 0,
        role_filter: 0
    },
    components: {
        roles,
        users,
        modules,
        pages,
        // access,
         icons,
         categories,
         holidays,
        // calendar,
         sites,
        // unity,
        log,
        perfil,
        dashboard
    },
    methods:{
        update_side_bar: function(idSideBar, datos){
            let me = this;
            me.menu = idSideBar;
            var keyDatos = Object.keys(datos);
            if(keyDatos.length > 0){
                if(keyDatos.indexOf('modulo') >= 0){
                    me.modulo_filter = datos.modulo;
                }
                if(keyDatos.indexOf('page') >= 0){
                    me.page_filter = datos.page;
                }
                if(keyDatos.indexOf('role') >= 0){
                    me.role_filter = datos.role;
                }
            }
        },
        redirect_page: function (page){
            window.location = URL_PROJECT+'/'+page;
        }
    }
});
