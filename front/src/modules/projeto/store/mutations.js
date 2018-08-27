import * as types from './types';

export const state = {
    projeto: {},
    proponente: {},
    planilhaHomologada: {},
    planilhaOriginal: {},
    planilhaAutorizada: {},
    planilhaAdequada: {},
};

export const mutations = {
    [types.SET_PROJETO](state, projeto) {
        state.projeto = projeto;
    },

    [types.SET_PROPONENTE](state, proponente) {
        state.proponente = proponente;
    },
    [types.SET_PLANILHA_HOMOLOGADA](state, planilhaHomologada) {
        state.planilhaHomologada = planilhaHomologada;
    },
    [types.SET_PLANILHA_ORIGINAL](state, planilhaOriginal) {
        state.planilhaOriginal = planilhaOriginal;
    },
    [types.SET_PLANILHA_AUTORIZADA](state, planilhaAutorizada) {
        state.planilhaAutorizada = planilhaAutorizada;
    },
    [types.SET_PLANILHA_ADEQUADA](state, planilhaAdequada) {
        state.planilhaAdequada = planilhaAdequada;
    },
};
