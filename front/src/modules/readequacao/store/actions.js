import _ from 'lodash';
import * as readequacaoHelperAPI from '@/helpers/api/Readequacao';
import * as types from './types';

export const obterListaDeReadequacoes = async ({ commit }, params) => {
    const resultado = await readequacaoHelperAPI.getReadequacoes(params)
        .then((response) => {
            const { data } = response.data;
            switch (params.stStatusAtual) {
            case 'proponente':
                commit(types.GET_READEQUACOES_PROPONENTE, data);
                break;
            case 'analise':
                commit(types.GET_READEQUACOES_ANALISE, data);
                break;
            case 'finalizadas':
                commit(types.GET_READEQUACOES_FINALIZADAS, data);
                break;
            default:
                break;
            }
            return data;
        });
    return resultado;
};

export const buscaReadequacaoPronacTipo = ({ commit }, params) => {
    readequacaoHelperAPI.buscaReadequacaoPronacTipo(params)
        .then((response) => {
            const { data } = response.data;
            let readequacao = {};
            if (data.items.length > 1) {
                readequacao = { items: data.items };
            } else if (data.items.length === 1
                       && !_.isEmpty(data.items)) {
                [readequacao] = data.items;
            }
            commit(types.SET_READEQUACAO, readequacao);
        });
};

export const obterDocumento = async ({ commit }, params) => {
    const resultado = await readequacaoHelperAPI.obterDocumentoReadequacao(params)
        .then((response) => {
            if (response.data) {
                const documento = response.data.data.items;
                commit(types.GET_DOCUMENTO, {
                    documento: documento.content,
                    idDocumento: documento.idDocumento,
                });
                commit(types.GET_READEQUACAO, {
                    documento: documento.content,
                    idDocumento: documento.idDocumento,
                });
            } else {
                commit(types.GET_DOCUMENTO, {});
            }
            return response.data;
        });
    return resultado;
};

export const adicionarDocumento = ({ commit }, params) => {
    readequacaoHelperAPI.adicionarDocumento(params)
        .then((response) => {
            const { documento } = response.data.documento;
            commit(types.ADICIONAR_DOCUMENTO, documento);
        });
};

export const excluirDocumento = ({ commit }, params) => {
    readequacaoHelperAPI.excluirDocumento(params)
        .then(() => {
            commit(types.EXCLUIR_DOCUMENTO);
            return '';
        });
};

export const excluirReadequacao = async ({ commit, dispatch }, params) => {
    const resultado = await readequacaoHelperAPI.excluirReadequacao(params)
        .then(() => {
            commit(types.EXCLUIR_READEQUACAO);
            if (params.origem === 'painel') {
                dispatch('obterListaDeReadequacoes', {
                    idPronac: params.idPronac,
                    stStatusAtual: 'proponente',
                });
                dispatch('obterTiposDisponiveis', {
                    idPronac: params.idPronac,
                });
            }
            return true;
        });
    return resultado;
};

export const obterReadequacao = ({ commit }, data) => {
    if (typeof data.idReadequacao !== 'undefined') {
        commit(types.GET_READEQUACAO, data);
    }
};

export const updateReadequacao = ({ commit }, params) => {
    readequacaoHelperAPI.updateReadequacao(params)
        .then((response) => {
            commit(types.UPDATE_READEQUACAO, response.data.data.items);
            commit(types.GET_READEQUACAO, response.data.data.items);
        });
};

export const obterDisponivelEdicaoItemSaldoAplicacao = ({ commit }, params) => {
    readequacaoHelperAPI.obterDisponivelEdicaoItemSaldoAplicacao(params)
        .then((response) => {
            const { data } = response.data.disponivelParaEdicao;
            commit(types.OBTER_DISPONIVEL_EDICAO_ITEM_SALDO_APLICACAO, data);
        });
};

export const obterCampoAtual = async ({ commit }, params) => {
    const resultado = await readequacaoHelperAPI.obterCampoAtual(params)
        .then((response) => {
            const { data } = response.data;
            commit(types.SET_CAMPO_ATUAL, data.items[0]);
        });
    return resultado;
};

export const obterTiposDisponiveis = ({ commit }, params) => {
    readequacaoHelperAPI.obterTiposDisponiveis(params)
        .then((response) => {
            commit(types.SET_TIPOS_DISPONIVEIS, response.data.data.items);
        });
};

export const inserirReadequacao = async ({ commit, dispatch }, params) => {
    const resultado = await readequacaoHelperAPI.inserirReadequacao(params)
        .then((response) => {
            const { data } = response.data;
            commit(types.SET_READEQUACAO, data);
            commit(types.SET_READEQUACOES_PROPONENTE, data);
            dispatch('obterListaDeReadequacoes', {
                idPronac: params.idPronac,
                stStatusAtual: 'proponente',
            });
            dispatch('obterTiposDisponiveis', {
                idPronac: params.idPronac,
            });
            dispatch('obterCampoAtual', {
                idPronac: params.idPronac,
                idTipoReadequacao: params.idTipoReadequacao,
            });
            return data;
        });
    return resultado;
};

export const finalizarReadequacao = async ({ dispatch }, params) => {
    const resultado = await readequacaoHelperAPI.finalizarReadequacao(params)
        .then(() => {
            dispatch('obterListaDeReadequacoes', {
                idPronac: params.idPronac,
                stStatusAtual: 'proponente',
            });
            dispatch('obterListaDeReadequacoes', {
                idPronac: params.idPronac,
                stStatusAtual: 'analise',
            });
        });
    return resultado;
};

export const solicitarUsoSaldo = ({ commit }, params) => {
    readequacaoHelperAPI.solicitarUsoSaldo(params)
        .then((response) => {
            commit(types.SET_READEQUACAO, response.data.data.items);
        });
};

export const obterPlanilha = ({ commit }, params) => {
    readequacaoHelperAPI.obterPlanilha(params)
        .then((response) => {
            commit(types.SET_PLANILHA, response.data.data.items);
        });
};
