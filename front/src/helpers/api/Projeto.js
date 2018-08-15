import * as api from './base';

const path = '/projeto/incentivo/obter-projeto-ajax';

export const buscaProjeto = (idPronac) => {
    const queryParams = `?idPronac=${idPronac}`;
    return api.getRequest(path, queryParams);
};
