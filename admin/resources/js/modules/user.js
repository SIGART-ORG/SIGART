require('../app');

import users from '../components/Users.vue';

const app = new Vue({
    el: '#app',
    components: {
        users
    },
});