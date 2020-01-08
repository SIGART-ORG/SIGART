require('../app');

import purchaseRequest from '../components/purchase-request.vue';
import prDetail from '../components/purchase-request/pr-detail';

const app = new Vue({
    el: '#app',
    components: {
        purchaseRequest,
        prDetail
    },
});
