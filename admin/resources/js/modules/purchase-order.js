require('../app');

import PurchaseOrder from '../components/purchase-order/purchase-order';

const app = new Vue({
    el: '#app',
    components:{
        'purchase-order': PurchaseOrder
    }
});
