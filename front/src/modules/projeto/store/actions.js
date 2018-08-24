import * as projetoHelperAPI from '@/helpers/api/Projeto';

import * as types from './types';

export const buscaProjeto = ({ commit }, idPronac) => {
    projetoHelperAPI.buscaProjeto(idPronac)
        .then((response) => {
            const data = response.data;
            const projeto = data.data;
            commit(types.SET_PROJETO, projeto);
        });
};

export const buscaProponente = ({ commit }, idPronac) => {
    projetoHelperAPI.buscaProponente(idPronac)
        .then((response) => {
            const data = response.data;
            const proponente = data.data;
            commit(types.SET_PROPONENTE, proponente);
        });
};

export const buscaPlanilhaHomologada = ({ commit }, idPronac) => {
    console.log('chega na action 1');
    projetoHelperAPI.buscaPlanilhaHomologada(idPronac)
        .then((response) => {
            const data = response.data;
            const planilhaHomologada = data.data;
            commit(types.SET_PLANILHA_HOMOLOGADA, planilhaHomologada);
        });
};
