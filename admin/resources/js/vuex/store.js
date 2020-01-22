import Vue from 'vue';
import Vuex from 'vuex';

import Settings from './modules/settings';
import Service from './modules/service';
import ServiceStages from "./modules/service-stage";
import ServiceTask from './modules/service-task';
import ServiceBoard from "./modules/service-board";
import Referenceterm from './modules/reference-term';

Vue.use( Vuex );

export default new Vuex.Store({
    modules: {
        Settings,
        Service,
        ServiceStages,
        ServiceTask,
        ServiceBoard,
        Referenceterm
    }
});
