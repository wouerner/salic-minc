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
};
