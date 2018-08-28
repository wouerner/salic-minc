import * as fooHelperAPI from '@/helpers/api/AvaliacaoResultados';
import * as types from './types';

export const dadosMenu = ({ commit }) => {
    fooHelperAPI.dadosMenu()
        .then((response) => {
            const data = response.data;
            const dadosTabela = data.data;
            commit(types.SET_REGISTROS_TABELA, dadosTabela);
            console.log('get dados', response);
        });
};

export const criarRegistro = ({ commit }, params) => {
    fooHelperAPI.criarRegistro(params)
        .then((response) => {
            const data = response.data;
            const registro = data.data;
            commit(types.SET_REGISTRO_TABELA, registro);
        });
};

export const setRegistroAtivo = ({ commit }, registro) => {
    commit(types.SET_REGISTRO_ATIVO, registro);
};

export const removerRegistro = ({ commit }, registro) => {
    fooHelperAPI.removerRegistro(registro)
        .then(() => {
            commit(types.REMOVER_REGISTRO, registro);
        });
};

export const getIndex = ({ commit }) => { };

export const getComParametro = ({ commit }, param) => {
    fooHelperAPI.getIndex(param).then((response) => {
        commit(types.GET_CONSOLIDACAO_PARECER, response);
    }).catch((error) => {
        console.log(error);
    });
};
