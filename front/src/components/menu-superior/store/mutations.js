import * as types from './types';

export const state = {
    perfisDisponiveis: [],
    usuarioAtivo:{},
    grupoAtivo: {},
};

export const mutations = {
    [types.SET_PERFIS_DISPONIVEIS](state, dados) {
        state.perfisDisponiveis = dados;
    },
    [types.SET_USUARIO_ATIVO](state, dados) {
        state.usuarioAtivo = dados;
    },
    [types.SET_GRUPO_ATIVO](state, dados) {
        state.grupoAtivo = dados;
    },
};
