import * as types from './types';

export const state = {
  isVisible: false,
};

export const mutations = {
  [types.MODAL_OPEN](state, modal) {
    state.isVisible = modal;
  },
  [types.MODAL_CLOSE](state) {
    state.isVisible = '';
  },
};
