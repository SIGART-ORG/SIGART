
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// import jQuery from 'jquery'
// global.jQuery = jQuery
// global.$ = jQuery

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
import Croppa from 'vue-croppa';

Vue.use(Croppa);
import 'vue-croppa/dist/vue-croppa.css';

