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

export const buscaReadequacaoPronacTipo = ({ commit }, params) => {
    readequacaoHelperAPI.buscaReadequacaoPronacTipo(params)
        .then((response) => {
            const data = response.data;
            const readequacao = data.data;
            commit(types.SET_READEQUACAO, readequacao);
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
        .then(() => {
            commit(types.EXCLUIR_DOCUMENTO);
        });
};

export const excluirReadequacao = ({ commit }, params) => {
    readequacaoHelperAPI.excluirReadequacao(params)
        .then(() => {
            commit(types.EXCLUIR_READEQUACAO);
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

export const updateReadequacaoDsSolicitacao = ( { commit }, params) => {
    commit(types.UPDATE_READEQUACAO_DS_SOLICITACAO, params);
};

export const updateReadequacaoSaldoAplicacao = ({ commit }, params) => {
    readequacaoHelperAPI.updateReadequacaoSaldoAplicacao(params)
        .then((response) => {
            const data = response.data;
            const readequacao = data.data;
            commit(types.UPDATE_READEQUACAO_SALDO_APLICACAO, readequacao);
        });
};

export const updateReadequacaoSaldoAplicacaoDsSolicitacao = ({ commit }, dsSolicitacao) => {
    commit(types.UPDATE_READEQUACAO_SALDO_APLICACAO_DS_SOLICITACAO, dsSolicitacao);
};

export const obterDisponivelEdicaoItemSaldoAplicacao = ({ commit }, params) => {
    readequacaoHelperAPI.obterDisponivelEdicaoItemSaldoAplicacao(params)
        .then((response) => {
            const data = response.data.disponivelParaEdicao;
            commit(types.OBTER_DISPONIVEL_EDICAO_ITEM_SALDO_APLICACAO, data);
        });
};

