require('../app');

import products from '../components/Products.vue';

const app = new Vue({
    el: '#app',
    components: {
        products
    },
});