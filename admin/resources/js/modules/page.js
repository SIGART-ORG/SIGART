require('../app');

import pages from '../components/Pages.vue';

const app = new Vue({
    el: '#app',
    components: {
        pages
    },
});