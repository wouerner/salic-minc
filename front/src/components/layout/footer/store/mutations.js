import * as types from './types';

export const state = {
    versao: {},
};

export const mutations = {
    [types.SET_VERSAO](state, dados) {
        state.versao = dados;
    },
};
