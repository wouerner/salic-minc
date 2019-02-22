import * as api from './base';

const buildData = (params) => {
    const bodyFormData = new FormData();

    Object.keys(params).forEach((key) => {
        bodyFormData.append(key, params[key]);
    });

    return bodyFormData;
};

const parseQueryParams = (params) => {
    let queryParams = '';
    Object.keys(params).forEach((key) => {
        queryParams += (queryParams === '') ? '?' : '&';
        queryParams += key + '=' + params[key];
    });
    return queryParams;
};

export const getReadequacoes = (idPronac) => {
    const path = `/readequacao?idPronac=${idPronac}`;
    return api.getRequest(path);
};

export const dadosReadequacao = (params) => {
    const { idReadequacao } = params;
    const path = `/readequacao/dados-readequacao/${idReadequacao}`;
    return api.getRequest(path);
};

export const buscaReadequacaoPronacTipo = (params) => {
    const path = `/readequacao`;
    return api.getRequest(path + parseQueryParams(params));
};

export const updateReadequacao = (params) => {
    const path = `/readequacao/dados-readequacao/`;
    return api.putRequest(path, buildData(params), params.idReadequacao);
};

export const updateReadequacaoSaldoAplicacao = (params) => {
    const path = `/readequacao/saldo-aplicacao/salvar-readequacao`;
    return api.putRequest(path, buildData(params), params.idReadequacao);
};

export const excluirReadequacaoSaldoAplicacao = (params) => {
    const path = `/readequacao/saldo-aplicacao/excluir-readequacao`;
    return api.postRequest(path, buildData(params));
};

export const obterDisponivelEdicaoItemSaldoAplicacao = (idPronac) => {
    const path = `/readequacao/saldo-disponivel-edicao-item/${idPronac}`;
    return api.getRequest(path);
};

export const adicionarDocumento = (params) => {
    const path = `/readequacao/dados-readequacao`;
    return api.postRequest(path, parseQueryParams(params));
};

export const excluirDocumento = (idDocumento) => {
    const path = `/readequacao/${idReadequacao}/documento/${idDocumento}`;
    return api.deleteRequest(path);
};
