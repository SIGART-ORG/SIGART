require( './bootstrap' );
import store from './vuex/store';
window.Vue = require( 'vue' );
Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');

import Notification from './vuex/components/Notification.vue';
import NotificationList from './vuex/components/NotificationList.vue';

Vue.component( 'headerNotification', Notification );
Vue.component( 'headerNotificationList', NotificationList );

const app = new Vue({
    store,
    el: '#v-notification'
});
