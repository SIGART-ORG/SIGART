import Vue from 'vue';
import Vuex from 'vuex';

import Notification from './modules/Notification.js';

Vue.use( Vuex );

export default new Vuex.Store({
    modules: {
        Notification
    }
});
