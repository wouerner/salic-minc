import * as api from './base';

export const buscarVersao = () => {
    const module = '/navegacao';
    const controller = '/footer-rest';
    const action = '/index';

    return api.getRequest(`${module}${controller}${action}`);
};
