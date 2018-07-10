import ProjetoHelperAPI from '@/helpers/api/Projeto';

import * as types from './types';

const projetoAPI = new ProjetoHelperAPI('projeto');

export const buscaProjeto = ({commit}, idPronac) => {
    projetoAPI.buscaProjeto(idPronac)
        .then((response) => {
            const data = response.data;
            const projeto = data.data;
            commit(types.SET_PROJETO, projeto);
        });
};