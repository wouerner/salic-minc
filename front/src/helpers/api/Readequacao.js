import * as api from './base';

const buildData = (params) => {
    const bodyFormData = new FormData();

    Object.keys(params).forEach((key) => {
        bodyFormData.append(key, params[key]);
    });

    return bodyFormData;
};

export const buscaReadequacao = (params) => {
    const { idTipoReadequacao } = params;
    const path = `/readequacao/dados-readequacao/`;
    return api.getRequest(path, buildData(params));
};

export const buscaReadequacaoPronacTipo = (params) => {
    const { idPronac, idTipoReadequacao } = params;
    const path = `/readequacao/filtrar-pronac-tipo/idPronac/${idPronac}/idTipoReadequacao/${idTipoReadequacao}`;
    return api.getRequest(path);
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
    const path = `/readequacao/saldo-aplicacao/disponivel-edicao-item/idPronac/${idPronac}`;
    return api.getRequest(path);
};

export const adicionarDocumento = (params) => {
    const path = `/readequacao/readequacoes/salvar-documento/`;
    return api.postRequest(path, buildData(params));
};

export const excluirDocumento = (params) => {
    const path = `/readequacao/readequacoes/excluir-documento/`;
    return api.postRequest(path, buildData(params));
};
