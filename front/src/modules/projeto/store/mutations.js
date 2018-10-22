import * as types from './types';

export const state = {
    projeto: {},
    proponente: {},
    planilhaHomologada: {},
    planilhaOriginal: {},
    planilhaReadequada: {},
    planilhaAutorizada: {},
    planilhaAdequada: {},
    transferenciaRecursos: [],
    certidoesNegativas: {},
    documentosAssinados: {},
    dadosComplementares: {},
    localRealizacaoDeslocamento: {},
    providenciaTomada: {},
};

export const mutations = {
    [types.SET_PROJETO](state, projeto) {
        state.projeto = projeto;
    },
    [types.SET_TRANSFERENCIA_RECURSOS](state, transferenciaRecursos) {
        state.transferenciaRecursos = transferenciaRecursos;
    },
    [types.SET_PROPONENTE](state, proponente) {
        state.proponente = proponente;
    },
    [types.SET_PLANILHA_HOMOLOGADA](state, planilhaHomologada) {
        state.planilhaHomologada = planilhaHomologada;
    },
    [types.SET_PLANILHA_ORIGINAL](state, planilhaOriginal) {
        state.planilhaOriginal = planilhaOriginal;
    },
    [types.SET_PLANILHA_READEQUADA](state, planilhaReadequada) {
        state.planilhaReadequada = planilhaReadequada;
    },
    [types.SET_PLANILHA_AUTORIZADA](state, planilhaAutorizada) {
        state.planilhaAutorizada = planilhaAutorizada;
    },
    [types.SET_PLANILHA_ADEQUADA](state, planilhaAdequada) {
        state.planilhaAdequada = planilhaAdequada;
    },
    [types.SET_CERTIDOES_NEGATIVAS](state, certidoesNegativas) {
        state.certidoesNegativas = certidoesNegativas;
    },
    [types.SET_DOCUMENTOS_ASSINADOS](state, documentosAssinados) {
        state.documentosAssinados = documentosAssinados;
    },
    [types.SET_DADOS_COMPLEMENTARES](state, dadosComplementares) {
        state.dadosComplementares = dadosComplementares;
    },
    [types.SET_LOCAL_REALIZACAO_DESLOCAMENTO](state, localRealizacaoDeslocamento) {
        state.localRealizacaoDeslocamento = localRealizacaoDeslocamento;
    },
    [types.SET_PROVIDENCIA_TOMADA](state, providenciaTomada) {
        state.providenciaTomada = providenciaTomada;
    },
};
