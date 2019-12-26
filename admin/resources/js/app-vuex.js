require( './bootstrap' );

import store from './vuex/store';

window.Vue = require( 'vue' );

import VeeValidate from 'vee-validate';
import BootstrapVue from 'bootstrap-vue';

const VueValidationEs = require('vee-validate/dist/locale/es');
Vue.use(VeeValidate, {
    locale: 'es',
    dictionary: {
        es: VueValidationEs
    }
});

import Service from './vuex/components/Service';
import ServiceDetails from './vuex/components/ServiceDetails';
import ServiceRequirements from './vuex/components/ServiceRequirements';
import ServiceStages from "./vuex/components/ServiceStages";

Vue.use(BootstrapVue);

Vue.component( 'servicevue', Service );
Vue.component( 'service-details', ServiceDetails );
Vue.component( 'service-requirements', ServiceRequirements );
Vue.component( 'service-stages', ServiceStages );

const app = new Vue({
    store,
    el: '#app'
});
