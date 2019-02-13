import * as types from './types';

export const state = {
    readequacao: {},
    saldoAplicacao: {},
    saldoAplicacaoDisponivelEdicaoItem: {},
};

export const mutations = {
    [types.SET_READEQUACAO](state, readequacao) {
        state.readequacao = readequacao;
    },
    [types.UPDATE_READEQUACAO](state, readequacao) {
        state.readequacao = readequacao;
    },
    [types.EXCLUIR_READEQUACAO](state) {
        state.readequacao = {};
    },
    [types.ADICIONAR_DOCUMENTO](state, data) {
        const idDocumento = data.idDocumento;
        const nomeArquivo = data.nomeArquivo;
        state.readequacao.idDocumento = idDocumento;
        state.readequacao.nomeArquivo = nomeArquivo;
    },
    [types.EXCLUIR_DOCUMENTO](state) {
        state.readequacao.idDocumento = '';
        state.readequacao.nomeArquivo = '';
    },
    [types.UPDATE_READEQUACAO_DS_SOLICITACAO](state, dsSolicitacao) {
        state.readequacao.items.dsSolicitacao = dsSolicitacao;
    },    
    [types.UPDATE_READEQUACAO_SALDO_APLICACAO_DS_SOLICITACAO](state, dsSolicitacao) {
        state.readequacao.saldoAplicacaoDsSolicitacao = dsSolicitacao;
    },
    [types.OBTER_DISPONIVEL_EDICAO_ITEM_SALDO_APLICACAO](state, disponivel) {
        state.readequacao.saldoAplicacaoDisponivelEdicaoItem = disponivel;
    },
};
