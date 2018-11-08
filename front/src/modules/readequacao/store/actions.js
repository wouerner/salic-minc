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

export const excluirReadequacao = ({ commit }, params) => {
    readequacaoHelperAPI.excluirReadequacao(params)
        .then(() => {
            commit(types.EXCLUIR_READEQUACAO);
        });
};

export const disponivelEdicaoReadequacaoPlanilha = ({ commit }, idPronac) => {
    readequacaoHelperAPI.disponivelEdicaoReadequacaoPlanilha(idPronac)
        .then((response) => {
            const data = response.data.disponivelParaEdicaoReadequacaoPlanilha;
            commit(types.DISPONIVEL_EDICAO_READEQUACAO_PLANILHA, data);
        });
};

export const adicionarDocumento = ({ commit }, params) => {
    readequacaoHelperAPI.adicionarDocumento(params)
        .then((response) => {
            const documento = response.data.documento;
            commit(types.ADICIONAR_DOCUMENTO, documento);
        });
};

export const excluirDocumento = ({ commit }, params) => {
    readequacaoHelperAPI.excluirDocumento(params)
        .then((response) => {
            commit(types.EXCLUIR_DOCUMENTO);
        });
};
