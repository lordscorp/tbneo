
require('./bootstrap');

window.Vue = require('vue').default;

import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import App from './App.vue';
import {routes} from './routes';
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
// import 'bootstrap-icons/font/bootstrap-icons.css'


Vue.use(VueRouter);
Vue.use(VueAxios, axios);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App)
});
