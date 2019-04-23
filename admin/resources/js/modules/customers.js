require('../app');

import customers from '../components/Customers.vue';

const app = new Vue({
    el: '#app',
    components: {
        customers
    },
});