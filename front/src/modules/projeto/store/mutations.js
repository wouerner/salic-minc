import * as types from './types';

export const state = {
    projeto: {},
    valoresTransferidos: [],
};

export const mutations = {
    [types.SET_PROJETO](state, projeto) {
        state.projeto = projeto;
    },
    [types.SET_VALORES_TRANSFERIDOS](state, valoresTransferidos) {
        state.valoresTransferidos = valoresTransferidos;
    },
};
