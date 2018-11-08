import * as api from './base';

const buildData = (params) => {
    const bodyFormData = new FormData();

    Object.keys(params).forEach((key) => {
        bodyFormData.append(key, params[key]);
    });

    return bodyFormData;
};

export const buscaReadequacao = (params) => {
    const { idPronac, idTipoReadequacao } = params;
    const path = `/readequacao/readequacoes/obter-dados-readequacao/?idPronac=${idPronac}&idTipoReadequacao=${idTipoReadequacao}`;
    return api.getRequest(path);
};

export const updateReadequacao = (params) => {
    const path = '/readequacao/saldo-aplicacao/salvar-readequacao';
    return api.putRequest(path, buildData(params), params.idReadequacao);
};

export const excluirReadequacao = (params) => {
    const path = '/readequacao/saldo-aplicacao/excluir-readequacao';
    return api.postRequest(path, buildData(params));
};

export const obterDisponivelEdicaoReadequacaoPlanilha = (idPronac) => {
    const path = '/readequacao/saldo-aplicacao/verificar-disponivel-para-edicao-readequacao-planilha/?idPronac=';
    return api.getRequest(path, idPronac);
};

export const adicionarDocumento = (params) => {
    const path = '/readequacao/readequacoes/salvar-documento/';
    return api.postRequest(path, buildData(params));
};

export const excluirDocumento = (params) => {
    const path = '/readequacao/readequacoes/excluir-documento/';
    return api.postRequest(path, buildData(params));
};
