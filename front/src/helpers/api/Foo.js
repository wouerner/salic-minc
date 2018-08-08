import API from './base';

const api = () => new API('/foo/foo-rest');

export const obterDadosTabela = () => api().get();

export const criar = (params) => {
    const bodyFormData = new FormData();

    Object.keys(params).forEach((key) => {
        bodyFormData.append(key, params[key]);
    });

    return api().post(bodyFormData);
};

export const updateRecord = (params) => {
    const bodyFormData = new FormData();
    const id = params.Codigo;

    Object.keys(params).forEach((key) => {
        bodyFormData.append(key, params[key]);
    });

    return api().put(bodyFormData, id);
};

export const removeRecord = (params) => {
    const id = params.Codigo;
    return api().delete(id);
};
