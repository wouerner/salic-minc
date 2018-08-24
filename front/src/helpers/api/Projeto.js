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
