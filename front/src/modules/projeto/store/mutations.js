import * as types from './types';

export const state = {
    projeto: {},
    proponente: {},
};

export const mutations = {
    [types.SET_PROJETO](state, projeto) {
        state.projeto = projeto;
    },

    [types.SET_PROPONENTE](state, proponente) {
        state.proponente = proponente;
    },
};
