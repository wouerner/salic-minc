import * as types from './types';

export const state = {
    localRealizacaoDeslocamento: {},
};

export const mutations = {
    [types.SET_LOCAL_REALIZACAO_DESLOCAMENTO](state, localRealizacaoDeslocamento) {
        state.localRealizacaoDeslocamento = localRealizacaoDeslocamento;
    },
};
