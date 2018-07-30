import * as fooHelperAPI from '@/helpers/api/Foo';

import * as types from './types';

export const obterDadosTabela = ({ commit }) => {
    fooHelperAPI.obterDadosTabela()
        .then((response) => {
            const data = response.data;
            const dadosTabela = data.data;
            commit(types.SET_DADOS_TABELA, dadosTabela);
        });
};
