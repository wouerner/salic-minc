import * as types from './types';

export const state = {
    localRealizacaoDeslocamento: {},
    fontesDeRecursos: {},
};

export const mutations = {
    [types.SET_LOCAL_REALIZACAO_DESLOCAMENTO](state, localRealizacaoDeslocamento) {
        state.localRealizacaoDeslocamento = localRealizacaoDeslocamento;
    },
    [types.SET_FONTES_DE_RECURSOS](state, fontesDeRecursos) {
        state.fontesDeRecursos = fontesDeRecursos;
    },
};
