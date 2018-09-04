import * as types from './types';
import Mock from '../mocks/Parecer.json';

export const state = {
    dadosTabela: [],
    registroAtivo: {},
    consolidacao: {},
    mock: Mock,
    destinatarios: {}
};

export const mutations = {
    [types.MOCK_AVALIACAO_RESULTADOS](state){
        state.mock = Mock;
    },
    [types.GET_CONSOLIDACAO_PARECER](state, consolidacao){
        state.consolidacao = consolidacao;
    },
    [types.SET_REGISTROS_TABELA](state, dadosTabela) {
        state.dadosTabela = dadosTabela;
    },
    [types.SET_REGISTRO_ATIVO](state, registro) {
        state.registroAtivo = registro;
    },
    [types.SET_REGISTRO_TABELA](state, registro) {
        state.dadosTabela.push(registro);
    },
    [types.ATUALIZAR_REGISTRO_TABELA](state, registro) {
        const dadosTabela = state.dadosTabela;

        dadosTabela.forEach((value, index) => {
            if (registro.Codigo === value.Codigo) {
                state.dadosTabela.splice(index, 1, registro);
            }
        });
    },
    [types.REMOVER_REGISTRO](state, registro) {
        const dadosTabela = state.dadosTabela;

        dadosTabela.forEach((value, index) => {
            if (registro.Codigo === value.Codigo) {
                state.dadosTabela.splice(index, 1);
            }
        });
    },
    [types.DESTINATARIOS_ENCAMINHAMENTO](state, destinatarios){
        state.destinatarios = destinatarios;
    }
};
