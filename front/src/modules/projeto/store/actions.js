import * as projetoHelperAPI from '@/helpers/api/Projeto';

import * as types from './types';

export const buscaProjeto = ({ commit }, idPronac) => {
    projetoHelperAPI.buscaProjeto(idPronac)
        .then((response) => {
            console.log('vendo a resposta da api');
            console.log(response);
            const data = response.data;
            const projeto = data.data;
            commit(types.SET_PROJETO, projeto);
        });
};
