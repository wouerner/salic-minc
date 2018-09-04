import * as avaliacaoResultadosHelperAPI from '@/helpers/api/AvaliacaoResultados';
import * as types from './types';

export const dadosMenu = ({ commit }) => {
    avaliacaoResultadosHelperAPI.dadosMenu()
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

export const setRegistroAtivo = ({ commit }, registro) => {
    commit(types.SET_REGISTRO_ATIVO, registro);
};

export const removerRegistro = ({ commit }, registro) => {
    avaliacaoResultadosHelperAPI.removerRegistro(registro)
        .then(() => {
            commit(types.REMOVER_REGISTRO, registro);
        });
};

export const getIndex = ({ commit }) => { };

export const getComconsolidacaoParecer = ({ commit }, param) => {
    return new Promise((resolve, reject) => {
        avaliacaoResultadosHelperAPI.parecerConsolidacao(param)
            .then((response) => {
                commit(types.GET_CONSOLIDACAO_PARECER, response.data.data);
                resolve();
            }).catch(error => console.info(error));
    });
};

export const mockAvaliacaDesempenho = ({ commit }) => {
    commit(types.MOCK_AVALIACAO_RESULTADOS, Mock);
};

export const getDestinatariosEncaminhamento = ({ commit }, params) => {
   // var  params = {
   //      "idorgao" : 303,
   //      "idPerfilDestino" : 125,
   //      "verifica" : "a",
   //  };

    avaliacaoResultadosHelperAPI.getTeste(params)
        .then((response) => {
           // const data = response.data;
           // const dadosTabela = data.data;
            commit(types.DESTINATARIOS_ENCAMINHAMENTO, response.data);
        });
    // console.log('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
    // console.log(params);
    // avaliacaoResultadosHelperAPI.buscarDestinatariosParaEncaminhamento(param)
    //     .then((destinatarios) => {
    //         console.log(destinatarios)
    //         commit(types.DESTINATARIOS_ENCAMINHAMENTO, destinatarios);
    //     });
};
