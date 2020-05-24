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

import vSelect from 'vue-select';
Vue.component('v-select', vSelect);

import Service from './vuex/components/Service';
import ServiceData from './vuex/components/ServiceData';
import ServiceDetails from './vuex/components/ServiceDetails';
import ServiceRequirements from './vuex/components/ServiceRequirements';
import ServiceStages from "./vuex/components/ServiceStages";
import ServiceTasks from "./vuex/components/ServiceTasks";
import ServiceBoards from "./vuex/components/ServiceBoard";
import ServiceBoardV2 from "./vuex/components/ServiceBoardV2";
import ReferenceTerms from "./vuex/components/ReferenceTerms";
import Sales from './vuex/components/sales/sale-list';
import SalesNew from './vuex/components/sales/sale-new';
import Tool from './vuex/components/ServiceTool';
import Worker from './vuex/components/ServiceWorker';
import Observed from './vuex/components/ServiceObserved';
import Voucher from './vuex/components/ServiceVoucher';
import Output from './vuex/components/Output';
import Mail from './vuex/components/Mail';
import Notification from './vuex/components/Notification';

require( './src/helpers' );

Vue.use(BootstrapVue);

Vue.component( 'servicevue', Service );
Vue.component( 'service-data', ServiceData );
Vue.component( 'service-details', ServiceDetails );
Vue.component( 'service-requirements', ServiceRequirements );
Vue.component( 'service-stages', ServiceStages );
Vue.component( 'service-task', ServiceTasks );
Vue.component( 'service-board', ServiceBoards );
Vue.component( 'service-board-v2', ServiceBoardV2 );
Vue.component( 'service-tool', Tool );
Vue.component( 'reference-terms', ReferenceTerms );
Vue.component( 'sales', Sales );
Vue.component( 'sales-new', SalesNew );
Vue.component( 'service-worker', Worker );
Vue.component( 'service-observed', Observed );
Vue.component( 'service-voucher', Voucher );
Vue.component( 'output-order', Output );
Vue.component( 'mail', Mail );
Vue.component( 'notification', Notification );

const app = new Vue({
    store,
    el: '#app'
});
