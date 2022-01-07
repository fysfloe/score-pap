import mutations from './mutations';
import actions from './actions';

export default {
    namespaced: true,
    state: {
        items: [],
        score: null
    },
    mutations: mutations,
    actions: actions
};
