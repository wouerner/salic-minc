import * as api from './base';

export const buscarPagamentosConsolidados = (idPronac) => {
    const modulo = '/prestacao-contas';
    const controller = '/pagamento-consolidados-rest';
    const metodo = '/index';
    const path = `${modulo}${controller}${metodo}`;
    const queryParams = `?idPronac=${idPronac}`;
    return api.getRequest(path, queryParams);
};
