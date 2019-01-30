import * as types from './types';

export const state = {
    aprovacao: {},
};

export const mutations = {
    [types.SET_APROVACAO](state, dados) {
        state.aprovacao = dados;
    },
};
