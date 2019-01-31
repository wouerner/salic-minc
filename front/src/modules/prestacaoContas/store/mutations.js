import * as types from './types';

export const state = {
    pagamentosConsolidados: [],
};

export const mutations = {
    [types.SET_PAGAMENTOS_CONSOLIDADOS](state, dados) {
        state.pagamentosConsolidados = dados;
    },
};
