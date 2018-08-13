import * as api from './base';

export const buscaProjeto = (idPronac) => {
    const path = '/projeto/incentivo/obter-projeto-ajax/foo-rest';
    const queryParams = `?idPronac=${idPronac}`;
    return api.getRequest(path, queryParams);
};

export const buscaProponente = (idPronac) => {
    const path = '/projeto/proponente-rest';
    const queryParams = `?idPronac=${idPronac}`;
    return api.getRequest(path, queryParams);
};
