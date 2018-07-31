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

export const createBar = ({ commit, dispatch }, params) => {
    fooHelperAPI.createBar(params)
        .then(() => {
            // console.log('CHEGANDO NO FIM DA REQUEST');
            // console.log(response.data);
            // console.log(dispatch);
            // console.log(commit);
            // const dadosTabela = response.data;
        });
};
