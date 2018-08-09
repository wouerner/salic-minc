import API from './base';

const api = () => new API('/foo/foo-rest');

export const obterDadosTabela = () => api().get();

const buildData = (params) => {
    const bodyFormData = new FormData();

    Object.keys(params).forEach((key) => {
        bodyFormData.append(key, params[key]);
    });

    return bodyFormData;
};

export const criarRegistro = (params) => {
    return api().post(buildData(params));
};

export const atualizarRegistro = (params) => {
    const bodyFormData = new FormData();
    const id = params.Codigo;

    Object.keys(params).forEach((key) => {
        bodyFormData.append(key, params[key]);
    });

    return api().put(bodyFormData, id);
};

export const removerRegistro = (params) => {
    const id = params.Codigo;
    return api().delete(id);
};
