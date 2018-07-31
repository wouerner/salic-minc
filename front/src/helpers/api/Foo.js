import API from './base';

const api = () => new API('/foo/foo-rest');

export const obterDadosTabela = () => api().get();

export const createBar = (params) => {
    const bodyFormData = new FormData();

    Object.keys(params).forEach((key) => {
        bodyFormData.set(key, params[key]);
    });

    return api().post(bodyFormData);
};
