require( '../app' );

import tool from '../components/tool/index.vue';
import toolStock from '../components/tool/stock';

const app = new Vue({
    el: '#app',
    components: {
        tool,
        toolStock
    },
});
