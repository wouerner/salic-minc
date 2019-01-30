import * as analiseHelperAPI from '@/helpers/api/Analise';
import * as types from './types';

export const buscarAprovacao = ({ commit }, idPronac) => {
    analiseHelperAPI.buscarAprovacao(idPronac)
        .then((response) => {
            const data = response.data.data.items;
            commit(types.SET_APROVACAO, data);
        });
};
