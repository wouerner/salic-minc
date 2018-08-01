import * as fooHelperAPI from '@/helpers/api/Foo';
import * as types from './types';
import router from './../router';

export const obterDadosTabela = ({ commit }) => {
    fooHelperAPI.obterDadosTabela()
        .then((response) => {
            const data = response.data;
            const dadosTabela = data.data;
            commit(types.SET_REGISTROS_TABELA, dadosTabela);
        });
};

export const criarRegistro = ({ commit }, params) => {
    fooHelperAPI.criarRegistro(params)
        .then((response) => {
            const registro = response.data;
            commit(types.SET_REGISTROS_TABELA, registro);
            router.push('/');
        });
};
