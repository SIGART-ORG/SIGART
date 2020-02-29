require('../app');

import InputOrder from '../components/input-order/list';
import IODetail from '../components/input-order/detail';

const app = new Vue({
    el: '#app',
    components: {
        'inputorder': InputOrder,
        'inputorderdetail': IODetail
    },
});
