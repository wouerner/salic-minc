import * as api from './base';

const module = '/projeto';
const controller = '/incentivo';

export const buscaProjeto = (idPronac) => {
    const action = '/obter-projeto-ajax';
    const queryParams = `?idPronac=${idPronac}`;
    return api.getRequest(`${module}${controller}${action}`, queryParams);
};

export const buscarValoresTransferidos = (idPronac) => {
    const action = '/buscar-valores-transferidos';
    const queryParams = `?idPronac=${idPronac}`;
    return api.getRequest(`${module}${controller}${action}`, queryParams);
};
