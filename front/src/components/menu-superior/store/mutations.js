import * as types from './types';

export const state = {
    perfisDisponiveis: [],
};

export const mutations = {
    [types.SET_PERFIS_DISPONIVEIS](state, dados) {
        state.perfisDisponiveis = dados;
    },
};
