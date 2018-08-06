import API from './base';

const api = () => new API('/foo/foo-rest');

export const obterDadosTabela = () => api().get();

export const criarRegistro = (params) => {
    const bodyFormData = new FormData();

    Object.keys(params).forEach((key) => {
        bodyFormData.set(key, params[key]);
    });

    return api().post(bodyFormData);
};

export const updateRecord = (params) => {
    const bodyFormData = new FormData();
    const id = params.Codigo;

    Object.keys(params).forEach((key) => {
        bodyFormData.set(key, params[key]);
    });

    return api().put(bodyFormData, id);
};

export const removeRecord = (params) => {
    const id = params.Codigo;
    const apiResponse = api().delete(id);
    console.log('VENDO OQ CHEGA DA API');
    console.log(apiResponse);
    return apiResponse;
};
