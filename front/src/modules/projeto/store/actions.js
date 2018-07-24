import * as projetoHelperAPI from '@/helpers/api/Projeto';

import * as types from './types';

export const buscaProjeto = ({ commit }, idPronac) => {
  projetoHelperAPI.buscaProjeto(idPronac)
    .then((response) => {
      const data = response.data;
      const projeto = data.data;
      commit(types.SET_PROJETO, projeto);
    });
};
