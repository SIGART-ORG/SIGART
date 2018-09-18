
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

const app = new Vue({
    el: '#app',
    data: {
        menu: 0
    },
    methods:{
        actualizar_principal: function(){
            let me = this;
            me.menu = 4;
        }
    }
});
