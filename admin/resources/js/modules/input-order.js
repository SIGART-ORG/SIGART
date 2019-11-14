require('../app');

import InputOrder from '../components/input-order/list';

const app = new Vue({
    el: '#app',
    components: {
        'inputorder': InputOrder
    },
});
