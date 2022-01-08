import Vue from 'vue';
import Vuex from 'vuex';
import score from './modules/score/store';
import filters from './modules/filters/store';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        score,
        filters
    }
})
