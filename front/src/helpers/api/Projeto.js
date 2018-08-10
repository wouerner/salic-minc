import * as api from './base';

const path = '/projeto/incentivo/obter-projeto-ajaxfoo/foo-rest';

export const buscaProjeto = (idPronac) => {
    const queryParams = `?idPronac=${idPronac}`;
    return api.getRequest(path, queryParams);
};

export const buscaProponente = (idPronac) => {
    const url = `/projeto/proponente-rest/?idPronac=${idPronac}`;
    return api().get(url);
};
