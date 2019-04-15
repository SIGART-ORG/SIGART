require('../app');

import dashboard from '../components/Dashboard.vue';

const app = new Vue({
    el: '#app',
    components: {
        dashboard,
    },
});