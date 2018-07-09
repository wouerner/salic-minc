import PrestacaoDeContasAPI from '@/helpers/api/PrestacaoDeContas';

import * as types from './types';

const prestacaoDeContasAPI = new PrestacaoDeContasAPI('projeto');

export const buscaProjeto = ({ commit }) => {
  prestacaoDeContasAPI.buscaProjeto()
    .then((response) => {
      const data = response.data;
      const projeto = data.data;
      commit(types.SET_PROJETO, projeto);
    });
};