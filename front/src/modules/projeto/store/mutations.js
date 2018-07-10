import * as types from './types';

export const state = {
  projeto: {},
};

export const mutations = {
  [types.SET_PROJETO](state, projeto) {
    state.projeto = projeto;
  },
};
