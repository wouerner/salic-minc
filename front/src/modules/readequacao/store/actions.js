import * as readequacaoHelperAPI from '@/helpers/api/Readequacao';

import * as types from './types';

export const buscaReadequacao = ({ commit }, params) => {
    readequacaoHelperAPI.buscaReadequacao(params)
        .then((response) => {
            const data = response.data;
            const readequacao = data.data;
            commit(types.SET_READEQUACAO, readequacao);
        });
};

export const updateReadequacao = ({ commit }, params) => {
    readequacaoHelperAPI.updateReadequacao(params)
        .then((response) => {
            const data = response.data;
            const readequacao = data.data;
            commit(types.UPDATE_READEQUACAO, readequacao);
        });
};

export const updateReadequacaoDsSolicitacao = ({ commit }, dsSolicitacao) => {
    commit(types.UPDATE_READEQUACAO_DS_SOLICITACAO, dsSolicitacao);
};
