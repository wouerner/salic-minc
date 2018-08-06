import * as fooHelperAPI from '@/helpers/api/Foo';
import * as types from './types';

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
            const data = response.data;
            const registro = data.data;
            commit(types.SET_REGISTRO_TABELA, registro);
        });
};

export const updateRecord = ({ commit }, params) => {
    fooHelperAPI.updateRecord(params)
        .then((response) => {
            const data = response.data;
            const record = data.data;
            commit(types.UPDATE_REGISTRO_TABELA, record);
        });
};

export const setActiveRecord = ({ commit }, record) => {
    commit(types.SET_ACTIVE_RECORD, record);
};

export const removeRecord = ({ commit }, record) => {
    console.log('MA OIIIIIII 1');
    fooHelperAPI.removeRecord(record)
        .then((response) => {
            console.log('MA OIIIIIII 2' + response);
            commit(types.DELETE_RECORD, record);
        });
};
