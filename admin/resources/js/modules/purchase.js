import '../app';
import Purchase from '../components/purchase/purchase-index';
import PurchaseFrom from '../components/purchase/purchase-form';

const app = new Vue({
    el: '#app',
    components: {
        Purchase,
        'purchase-form': PurchaseFrom
    }
});
