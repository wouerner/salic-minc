import * as api from './base';

export const buscaProjeto = (idPronac) => {
    const module = '/projeto';
    const controller = '/incentivo';
    const action = '/obter-projeto-ajax';
    const queryParams = `?idPronac=${idPronac}`;
    return api.getRequest(`${module}${controller}${action}`, queryParams);
};

export const buscarTransferenciaRecursos = (idPronac) => {
    const module = '/readequacao';
    const controller = '/transferencia-recursos-rest';
    const action = '/index';
    const queryParams = `?idPronac=${idPronac}`;
    return api.getRequest(`${module}${controller}${action}`, queryParams);
};
