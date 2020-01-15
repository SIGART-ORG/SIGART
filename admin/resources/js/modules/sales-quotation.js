require('../app');

import salesQuotationsList from '../components/sales-quotation/Sales-quotation-list';

const app = new Vue({
    el: '#app',
    components: {
        salesQuotationsList
    },
});
