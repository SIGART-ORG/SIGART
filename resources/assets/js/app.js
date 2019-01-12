
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import VeeValidate from 'vee-validate';
const VueValidationEs = require('vee-validate/dist/locale/es');
Vue.use(VeeValidate, {
    locale: 'es',
    dictionary: {
      es: VueValidationEs
    }
});
Vue.config.productionTip = false;
Vue.component('roles', require('./components/Roles.vue'));
Vue.component('users', require('./components/Users.vue'));
Vue.component('modules', require('./components/Modules.vue'));
Vue.component('pages', require('./components/Pages.vue'));
Vue.component('access', require('./components/Access.vue'));
Vue.component('icons', require('./components/Icons.vue'));
Vue.component('categories', require('./components/Categories.vue'));
Vue.component('holidays', require('./components/Holidays.vue'));
Vue.component('calendar', require('./components/Calendar.vue'));
Vue.component('sites', require('./components/Sites.vue'));

/*Perfil*/
Vue.component('perfil', require('./components/Perfil.vue'));

const app = new Vue({
    el: '#app',
    data: {
        menu: 0,
        modulo_filter: 0,
        page_filter: 0,
        role_filter: 0
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
