import axios from 'axios';
import paths from '../../../api';

export default {
    fetch({ commit }, params) {
        return axios.get(paths.filters, {params: params})
            .then(response => commit('FETCH', response.data))
            .catch();
    }
}
