require( './bootstrap' );

import store from './vuex/store';

window.Vue = require( 'vue' );

import VeeValidate from 'vee-validate';
import BootstrapVue from 'bootstrap-vue';
import swal from 'sweetalert';

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
import ServiceTasks from "./vuex/components/ServiceTasks";
import ServiceBoards from "./vuex/components/ServiceBoard";
import ReferenceTerms from "./vuex/components/ReferenceTerms";
import Sales from './vuex/components/sales/sale-list';
import SalesNew from './vuex/components/sales/sale-new';

Vue.use(BootstrapVue);

Vue.component( 'servicevue', Service );
Vue.component( 'service-details', ServiceDetails );
Vue.component( 'service-requirements', ServiceRequirements );
Vue.component( 'service-stages', ServiceStages );
Vue.component( 'service-task', ServiceTasks );
Vue.component( 'service-board', ServiceBoards );
Vue.component( 'reference-terms', ReferenceTerms );
Vue.component( 'sales', Sales );
Vue.component( 'sales-new', SalesNew );

const app = new Vue({
    store,
    el: '#app'
});
