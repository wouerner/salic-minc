import * as types from './types';

export const state = {
    readequacao: {},
};

export const mutations = {
    [types.SET_READEQUACAO](state, readequacao) {
        state.readequacao = readequacao;
    },
    [types.UPDATE_READEQUACAO](state, readequacao) {
        state.readequacao = readequacao;
    },
    [types.UPDATE_READEQUACAO_DS_SOLICITACAO](state, dsSolicitacao) {
        state.readequacao.dsSolicitacao = dsSolicitacao;
    },
    [types.EXCLUIR_READEQUACAO](state) {
        state.readequacao = {};
    },
    [types.OBTER_DISPONIVEL_EDICAO_READEQUACAO_PLANILHA](state, disponivel) {
        state.readequacao.disponivelEdicaoReadequacaoPlanilha = disponivel;
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
};
