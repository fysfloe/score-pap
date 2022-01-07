require('./bootstrap');
import routes from './routes';
import store from './vuex/store.js';
import VueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes
});

const app = new Vue({
    el: '#app',
    router,
    store
});
