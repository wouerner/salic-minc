import * as types from './types';

export const state = {
    dadosTabela: [],
};

export const mutations = {
    [types.SET_REGISTROS_TABELA](state, dadosTabela) {
        state.dadosTabela = dadosTabela;
    },
};
