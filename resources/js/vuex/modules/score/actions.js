import axios from 'axios';
import paths from '../../../api';

const namespace = 'score';

export default {
    fetch({ commit }, params) {
        return axios.get(paths.score, {params: params})
            .then(response => commit('FETCH', response.data))
            .catch();
    },
    filter({ commit }, params) {
        return axios.post(paths.score, params)
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
    edit({ commit }, score) {
        console.log(score);
        return axios.put(`${paths.score}/${score.id}`, score)
            .then(response => {
                commit('SHOW', response.data);
            });
    },
    add({ commit }, score) {
        return axios.post(`${paths.score}/add`, score)
            .then(response => {
                commit('SHOW', response.data);
            });
    },
}
