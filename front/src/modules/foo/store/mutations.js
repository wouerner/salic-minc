import * as types from './types';

export const state = {
    dadosTabela: [],
};

export const mutations = {
    [types.SET_DADOS_TABELA](state, dadosTabela) {
        state.dadosTabela = dadosTabela;
    },
};
