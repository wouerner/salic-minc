import * as api from './base';

export const buscarPagamentosConsolidados = (idPronac) => {
    const modulo = '/prestacao-contas';
    const controller = '/pagamento-consolidados-rest';
    const metodo = '/index';
    const path = `${modulo}${controller}${metodo}`;
    const queryParams = `?idPronac=${idPronac}`;
    return api.getRequest(path, queryParams);
};

export const buscarPagamentosUfMunicipio = (idPronac) => {
    const modulo = '/prestacao-contas';
    const controller = '/pagamento-uf-municipio-rest';
    const metodo = '/index';
    const path = `${modulo}${controller}${metodo}`;
    const queryParams = `?idPronac=${idPronac}`;
    return api.getRequest(path, queryParams);
};

export const buscarRelatoriosTrimestrais = (idPronac) => {
    const modulo = '/prestacao-contas';
    const controller = '/relatorios-trimestrais-rest';
    const metodo = '/index';
    const path = `${modulo}${controller}${metodo}`;
    const queryParams = `?idPronac=${idPronac}`;
    return api.getRequest(path, queryParams);
};
