import * as types from './types';

export const state = {
    pagamentosConsolidados: [],
    pagamentosUfMunicipio: [],
};

export const mutations = {
    [types.SET_PAGAMENTOS_CONSOLIDADOS](state, dados) {
        state.pagamentosConsolidados = dados;
    },
    [types.SET_PAGAMENTOS_UF_MUNICIPIO](state, dados) {
        state.pagamentosUfMunicipio = dados;
    },
};
