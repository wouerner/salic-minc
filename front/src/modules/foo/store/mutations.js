import * as types from './types';

export const state = {
    dadosTabela: [],
    activeRecord: {},
};

export const mutations = {
    [types.SET_REGISTROS_TABELA](state, dadosTabela) {
        state.dadosTabela = dadosTabela;
    },
    [types.SET_ACTIVE_RECORD](state, record) {
        state.activeRecord = record;
    },
    [types.UPDATE_REGISTRO_TABELA](state, record) {
        const dadosTabela = state.dadosTabela;

        dadosTabela.forEach((value, index) => {
            if (record.Codigo === value.Codigo) {
                state.dadosTabela[index] = record;
            }
        });
    },
};
