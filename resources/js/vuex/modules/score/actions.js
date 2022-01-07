import axios from 'axios';
import paths from '../../../api';

const namespace = 'score';

export default {
    fetch({ commit }, params) {
        return axios.get(paths.score, {params: params})
            .then(response => commit('FETCH', response.data))
            .catch();
    },
    show({ commit }, id) {
        return axios.get(`${paths.score}/${id}`)
            .then(response => commit('SHOW', response.data))
            .catch();
    },
    delete({}, id) {
        axios.delete(`${paths.score}/${id}`)
            .then(() => this.dispatch(`${namespace}/fetch`))
            .catch();
    },
    edit({ commit }, rehearsal) {
        return axios.put(`${paths.score}/${rehearsal.id}`, rehearsal)
            .then(response => {
                commit('SHOW', response.data);
            });
    },
    add({ commit }, rehearsal) {
        return axios.post(`${paths.score}`, rehearsal)
            .then(response => {
                commit('SHOW', response.data);
            });
    },
}
