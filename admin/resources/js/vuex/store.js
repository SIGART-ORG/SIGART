import Vue from 'vue';
import Vuex from 'vuex';

import Settings from './modules/settings';
import Service from './modules/service';
import ServiceStages from "./modules/service-stage";

Vue.use( Vuex );

export default new Vuex.Store({
    modules: {
        Settings,
        Service,
        ServiceStages
    }
});
