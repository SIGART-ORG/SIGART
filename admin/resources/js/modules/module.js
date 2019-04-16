require('../app');

import modules from '../components/Modules.vue';

const app = new Vue({
    el: '#app',
    components: {
        modules
    },
});