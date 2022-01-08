import mutations from './mutations';
import actions from './actions';

export default {
    namespaced: true,
    state: {
        filters: [],
        selectedFilters: {},
    },
    mutations: mutations,
    actions: actions
};
