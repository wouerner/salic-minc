import * as api from './base';

export const buscaProjeto = (idPronac) => {
    const path = '/projeto/incentivo/obter-projeto-ajax';
    const queryParams = `?idPronac=${idPronac}`;
    return api.getRequest(path, queryParams);
};

export const buscaProponente = (idPronac) => {
    const path = '/projeto/proponente-rest';
    const queryParams = `/idPronac/${idPronac}`;
    return api.getRequest(path, queryParams);
};

export const buscaPlanilhaHomologada = (idPronac) => {
    const path = '/projeto/orcamento/obter-planilha-homologada-ajax';
    const queryParams = `?idPronac=${idPronac}`;
    return api.getRequest(path, queryParams);
};

export const buscaPlanilhaOriginal = (idPreProjeto) => {
    const path = '/proposta/visualizar/obter-planilha-proposta-original-ajax/';
    const queryParams = `?idPreProjeto=${idPreProjeto}`;
    return api.getRequest(path, queryParams);
};

export const buscaPlanilhaAutorizada = (idPreProjeto) => {
    const path = '/proposta/visualizar/obter-planilha-proposta-original-ajax/';
    const queryParams = `?idPreProjeto=${idPreProjeto}`;
    return api.getRequest(path, queryParams);
};

export const buscaPlanilhaAdequada = (idPreProjeto) => {
    const path = '/proposta/visualizar/obter-planilha-proposta-adequada-ajax/';
    const queryParams = `?idPreProjeto=${idPreProjeto}`;
    return api.getRequest(path, queryParams);
};
